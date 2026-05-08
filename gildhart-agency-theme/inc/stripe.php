<?php
/**
 * Stripe integration — config, SDK loader, helpers, REST endpoints.
 *
 * All Stripe API access for the agent checkout flow lives here. The
 * theme has no Composer setup; the official Stripe PHP SDK is dropped
 * in at vendor/stripe-php/ and loaded via require_once.
 *
 * Config is read from wp-config.php constants:
 *   - GILDHART_STRIPE_PUBLISHABLE_KEY
 *   - GILDHART_STRIPE_SECRET_KEY
 *   - GILDHART_STRIPE_PRICE_AGENT_MONTHLY
 *   - GILDHART_STRIPE_PRICE_AGENT_ANNUAL
 *
 * If any constant is missing, gildhart_stripe_is_configured() returns
 * false and the REST endpoints respond with 503 instead of fataling —
 * graceful degradation while the integration is being set up.
 *
 * REST endpoints:
 *   - POST /wp-json/gildhart/v1/agent-checkout
 *       Creates a Customer + Subscription with payment_behavior =
 *       default_incomplete + Stripe Tax enabled. Returns the
 *       PaymentIntent client_secret for the front-end Payment Element
 *       to confirm inline. All lead metadata (first_name, last_name,
 *       practice_name, website, plan, plan_label) is stored on the
 *       Subscription, the Customer, and the PaymentIntent so Make.com
 *       receives it on every webhook event regardless of which event
 *       type their scenario is configured to listen for.
 *
 *   - GET /wp-json/gildhart/v1/payment-intent?id={pi_id}
 *       Returns minimal data (email, plan_label, status) for the
 *       thank-you page to personalise the confirmation copy. Read-only,
 *       harmless to expose: someone with the unguessable pi_id can
 *       read the email + plan they themselves just signed up for.
 *
 * Make.com listens to Stripe webhooks directly via Stripe → Make's
 * Stripe app integration. NO webhook listener lives on this side —
 * see the Make.com → Kartra scenario for that flow.
 *
 * @package Gildhart
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ─────────────────────────────────────────────────────────────────
 * Config + SDK loader
 * ───────────────────────────────────────────────────────────────── */

/**
 * Read Stripe config from wp-config.php constants.
 *
 * @return array Keys: publishable, secret, price_monthly, price_annual.
 *               Empty strings if any constant is missing.
 */
function gildhart_stripe_config() {
    return array(
        'publishable'   => defined( 'GILDHART_STRIPE_PUBLISHABLE_KEY' )    ? GILDHART_STRIPE_PUBLISHABLE_KEY    : '',
        'secret'        => defined( 'GILDHART_STRIPE_SECRET_KEY' )         ? GILDHART_STRIPE_SECRET_KEY         : '',
        'price_monthly' => defined( 'GILDHART_STRIPE_PRICE_AGENT_MONTHLY' ) ? GILDHART_STRIPE_PRICE_AGENT_MONTHLY : '',
        'price_annual'  => defined( 'GILDHART_STRIPE_PRICE_AGENT_ANNUAL' )  ? GILDHART_STRIPE_PRICE_AGENT_ANNUAL  : '',
    );
}

/** Returns true iff all four constants are defined and non-empty. */
function gildhart_stripe_is_configured() {
    $cfg = gildhart_stripe_config();
    return ! empty( $cfg['publishable'] ) && ! empty( $cfg['secret'] )
        && ! empty( $cfg['price_monthly'] ) && ! empty( $cfg['price_annual'] );
}

/** True when the secret key starts with sk_test_ (used to label flows). */
function gildhart_stripe_is_test_mode() {
    $cfg = gildhart_stripe_config();
    return $cfg['secret'] && strpos( $cfg['secret'], 'sk_test_' ) === 0;
}

/**
 * Map a plan slug → Stripe price ID + display label + cycle suffix.
 * Returns null for unknown plans.
 */
function gildhart_stripe_plan_lookup( $plan ) {
    $cfg = gildhart_stripe_config();
    $plans = array(
        'monthly' => array(
            'price_id' => $cfg['price_monthly'],
            'label'    => 'Pay Monthly — £125/mo',
            'cycle'    => 'mo',
        ),
        'annual' => array(
            'price_id' => $cfg['price_annual'],
            'label'    => 'Pay Upfront — £995/yr',
            'cycle'    => 'yr',
        ),
    );
    return $plans[ $plan ] ?? null;
}

/**
 * Boot the Stripe SDK. Idempotent — subsequent calls no-op.
 *
 * @return bool True if the SDK is loaded and the API key is set.
 *              False if any required constant or the SDK file is missing.
 */
function gildhart_stripe_boot() {
    static $booted = false;
    if ( $booted ) return true;
    if ( ! gildhart_stripe_is_configured() ) return false;

    $sdk_init = get_template_directory() . '/vendor/stripe-php/init.php';
    if ( ! file_exists( $sdk_init ) ) return false;

    require_once $sdk_init;

    $cfg = gildhart_stripe_config();
    \Stripe\Stripe::setApiKey( $cfg['secret'] );
    \Stripe\Stripe::setAppInfo(
        'gildhart-agency-theme',
        wp_get_theme()->get( 'Version' ) ?: '1.0.0',
        home_url()
    );

    $booted = true;
    return true;
}

/* ─────────────────────────────────────────────────────────────────
 * Subscription creation
 * ───────────────────────────────────────────────────────────────── */

/**
 * Create a Stripe Customer + Subscription for a lead.
 *
 * Subscription is created with payment_behavior = default_incomplete,
 * which produces an attached invoice + PaymentIntent. The front-end
 * Payment Element confirms that PaymentIntent inline; on success the
 * subscription transitions from incomplete → active automatically.
 *
 * Stripe Tax is enabled (automatic_tax: { enabled: true }) — UK VAT
 * (20%) is added on top of the configured Price (which is VAT-exclusive
 * per the dashboard config). Customer sees £1,194 total at checkout
 * for the annual plan, £150 for monthly.
 *
 * Lead metadata is mirrored across three Stripe objects so Make.com
 * picks it up regardless of which webhook event their scenario triggers
 * on:
 *   - Customer.metadata
 *   - Subscription.metadata (lives on every recurring invoice)
 *   - PaymentIntent.metadata (read by the thank-you page)
 *
 * @param array $lead {
 *   plan          string  Required. 'monthly' | 'annual'.
 *   first_name    string  Required.
 *   last_name     string  Required.
 *   email         string  Required.
 *   practice_name string  Optional.
 *   website       string  Optional.
 * }
 * @return array {
 *   client_secret   string  PaymentIntent client_secret (for stripe.confirmPayment()).
 *   subscription_id string  Stripe Subscription ID.
 *   publishable_key string  Convenience — to init Stripe.js on the client.
 *   plan_label      string  Human-readable plan name for display.
 * }
 * @throws \Exception On invalid input or Stripe API error.
 */
function gildhart_stripe_create_subscription_for_lead( array $lead ) {
    if ( ! gildhart_stripe_boot() ) {
        throw new \Exception( 'Stripe is not configured on this site.' );
    }

    $plan_info = gildhart_stripe_plan_lookup( $lead['plan'] ?? '' );
    if ( ! $plan_info || empty( $plan_info['price_id'] ) ) {
        throw new \Exception( 'Invalid plan.' );
    }

    foreach ( array( 'first_name', 'last_name', 'email' ) as $req ) {
        if ( empty( $lead[ $req ] ) ) {
            throw new \Exception( 'Missing required field: ' . $req );
        }
    }

    $email = sanitize_email( $lead['email'] );
    if ( ! is_email( $email ) ) {
        throw new \Exception( 'Invalid email.' );
    }

    $first_name    = sanitize_text_field( $lead['first_name'] );
    $last_name     = sanitize_text_field( $lead['last_name'] );
    $practice_name = sanitize_text_field( $lead['practice_name'] ?? '' );
    $website       = esc_url_raw( $lead['website'] ?? '' );

    $metadata = array(
        'first_name'    => $first_name,
        'last_name'     => $last_name,
        'practice_name' => $practice_name,
        'website'       => $website,
        'plan'          => $lead['plan'],
        'plan_label'    => $plan_info['label'],
    );

    // Customer
    $customer = \Stripe\Customer::create( array(
        'email'    => $email,
        'name'     => trim( $first_name . ' ' . $last_name ),
        'metadata' => $metadata,
    ) );

    // Subscription with default_incomplete + Stripe Tax enabled.
    $subscription = \Stripe\Subscription::create( array(
        'customer' => $customer->id,
        'items'    => array(
            array( 'price' => $plan_info['price_id'] ),
        ),
        'payment_behavior' => 'default_incomplete',
        'payment_settings' => array(
            'save_default_payment_method' => 'on_subscription',
            'payment_method_types'        => array( 'card' ),
        ),
        'automatic_tax' => array( 'enabled' => true ),
        'metadata'      => $metadata,
        'expand'        => array( 'latest_invoice.payment_intent' ),
    ) );

    $payment_intent = $subscription->latest_invoice->payment_intent ?? null;
    if ( ! $payment_intent || empty( $payment_intent->client_secret ) ) {
        throw new \Exception( 'Stripe did not return a PaymentIntent client_secret.' );
    }

    // Mirror metadata onto the PaymentIntent + set receipt_email so the
    // thank-you page can read the customer email + plan label without a
    // second round-trip, and so Stripe sends the automatic email receipt
    // on payment success.
    \Stripe\PaymentIntent::update( $payment_intent->id, array(
        'metadata'      => array_merge( $metadata, array( 'customer_email' => $email ) ),
        'receipt_email' => $email,
    ) );

    $cfg = gildhart_stripe_config();

    // Read the computed total from the latest invoice. Stripe Tax has
    // already added VAT at this point so amount_due is the final
    // checkout figure (£1,194 for annual, £150 for monthly with UK 20%
    // VAT). amount_due is in pence; format for the Pay button label.
    $invoice      = $subscription->latest_invoice;
    $amount_due   = is_object( $invoice ) && isset( $invoice->amount_due ) ? (int) $invoice->amount_due : 0;
    $currency     = is_object( $invoice ) && isset( $invoice->currency )   ? strtoupper( $invoice->currency ) : 'GBP';
    $currency_sym = ( 'GBP' === $currency ) ? '£' : ( 'USD' === $currency ? '$' : ( 'EUR' === $currency ? '€' : '' ) );
    $amount_decimal = $amount_due / 100;
    $amount_formatted = $currency_sym . ( fmod( $amount_decimal, 1 ) === 0.0
        ? number_format( $amount_decimal, 0 )
        : number_format( $amount_decimal, 2 ) );

    return array(
        'client_secret'    => $payment_intent->client_secret,
        'subscription_id'  => $subscription->id,
        'publishable_key'  => $cfg['publishable'],
        'plan_label'       => $plan_info['label'],
        'amount_total'     => $amount_due,           // integer, pence
        'amount_formatted' => $amount_formatted,     // e.g. "£1,194" or "£150"
        'currency'         => $currency,             // e.g. "GBP"
    );
}

/**
 * Retrieve a PaymentIntent's display data for the thank-you page.
 *
 * Validates the ID format defensively before hitting Stripe (saves a
 * round-trip on garbage input). Returns the metadata fields we wrote
 * during checkout — email + plan_label — plus the live status string.
 *
 * @param string $payment_intent_id
 * @return array { email, plan_label, status }
 * @throws \Exception On invalid input or Stripe API error.
 */
function gildhart_stripe_get_payment_intent_summary( $payment_intent_id ) {
    if ( ! gildhart_stripe_boot() ) {
        throw new \Exception( 'Stripe is not configured.' );
    }

    if ( empty( $payment_intent_id ) || ! preg_match( '/^pi_[A-Za-z0-9_]+$/', $payment_intent_id ) ) {
        throw new \Exception( 'Invalid PaymentIntent ID.' );
    }

    $pi = \Stripe\PaymentIntent::retrieve( $payment_intent_id );

    return array(
        'email'      => $pi->metadata['customer_email'] ?? ( $pi->receipt_email ?? '' ),
        'plan_label' => $pi->metadata['plan_label']     ?? '',
        'status'     => $pi->status, // 'succeeded' | 'requires_action' | 'requires_payment_method' | etc.
    );
}

/* ─────────────────────────────────────────────────────────────────
 * REST endpoints
 * ───────────────────────────────────────────────────────────────── */

add_action( 'rest_api_init', function () {
    register_rest_route( 'gildhart/v1', '/agent-checkout', array(
        'methods'             => 'POST',
        'callback'            => 'gildhart_rest_agent_checkout',
        'permission_callback' => '__return_true',
    ) );

    register_rest_route( 'gildhart/v1', '/payment-intent', array(
        'methods'             => 'GET',
        'callback'            => 'gildhart_rest_payment_intent',
        'permission_callback' => '__return_true',
        'args' => array(
            'id' => array(
                'required'          => true,
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ),
        ),
    ) );
} );

/**
 * POST /gildhart/v1/agent-checkout
 *
 * JSON body: { plan, first_name, last_name, email, practice_name, website }
 * Response on success: { client_secret, subscription_id, publishable_key, plan_label }
 * Errors: 400 invalid_input, 502 stripe_api_error, 503 stripe_not_configured.
 */
function gildhart_rest_agent_checkout( WP_REST_Request $request ) {
    if ( ! gildhart_stripe_is_configured() ) {
        return new WP_Error( 'stripe_not_configured', 'Stripe is not configured on this site.', array( 'status' => 503 ) );
    }

    $body = $request->get_json_params();
    if ( ! is_array( $body ) ) {
        return new WP_Error( 'invalid_body', 'Invalid request body — JSON expected.', array( 'status' => 400 ) );
    }

    try {
        $result = gildhart_stripe_create_subscription_for_lead( array(
            'plan'          => $body['plan']          ?? '',
            'first_name'    => $body['first_name']    ?? '',
            'last_name'     => $body['last_name']     ?? '',
            'email'         => $body['email']         ?? '',
            'practice_name' => $body['practice_name'] ?? '',
            'website'       => $body['website']       ?? '',
        ) );
        return rest_ensure_response( $result );
    } catch ( \Stripe\Exception\ApiErrorException $e ) {
        return new WP_Error( 'stripe_api_error', $e->getMessage(), array( 'status' => 502 ) );
    } catch ( \Exception $e ) {
        return new WP_Error( 'invalid_input', $e->getMessage(), array( 'status' => 400 ) );
    }
}

/**
 * GET /gildhart/v1/payment-intent?id=pi_xxx
 *
 * Response: { email, plan_label, status }
 * Errors: 400 invalid_input, 502 stripe_api_error, 503 stripe_not_configured.
 */
function gildhart_rest_payment_intent( WP_REST_Request $request ) {
    if ( ! gildhart_stripe_is_configured() ) {
        return new WP_Error( 'stripe_not_configured', 'Stripe is not configured on this site.', array( 'status' => 503 ) );
    }

    try {
        $summary = gildhart_stripe_get_payment_intent_summary( $request->get_param( 'id' ) );
        return rest_ensure_response( $summary );
    } catch ( \Stripe\Exception\ApiErrorException $e ) {
        return new WP_Error( 'stripe_api_error', $e->getMessage(), array( 'status' => 502 ) );
    } catch ( \Exception $e ) {
        return new WP_Error( 'invalid_input', $e->getMessage(), array( 'status' => 400 ) );
    }
}
