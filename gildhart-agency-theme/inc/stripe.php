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
        'publishable'     => defined( 'GILDHART_STRIPE_PUBLISHABLE_KEY' )     ? GILDHART_STRIPE_PUBLISHABLE_KEY     : '',
        'secret'          => defined( 'GILDHART_STRIPE_SECRET_KEY' )          ? GILDHART_STRIPE_SECRET_KEY          : '',
        'price_monthly'   => defined( 'GILDHART_STRIPE_PRICE_AGENT_MONTHLY' ) ? GILDHART_STRIPE_PRICE_AGENT_MONTHLY : '',
        'price_annual'    => defined( 'GILDHART_STRIPE_PRICE_AGENT_ANNUAL' )  ? GILDHART_STRIPE_PRICE_AGENT_ANNUAL  : '',
        // Playbook is a one-time charge. Amount is a VAT-inclusive integer
        // in pence (e.g. 99500 = £995). No Stripe Tax — the displayed price
        // is the final price.
        'playbook_amount' => defined( 'GILDHART_STRIPE_PLAYBOOK_AMOUNT' )     ? (int) GILDHART_STRIPE_PLAYBOOK_AMOUNT : 0,
    );
}

/** Returns true iff all four agent subscription constants are defined. */
function gildhart_stripe_is_configured() {
    $cfg = gildhart_stripe_config();
    return ! empty( $cfg['publishable'] ) && ! empty( $cfg['secret'] )
        && ! empty( $cfg['price_monthly'] ) && ! empty( $cfg['price_annual'] );
}

/**
 * Minimum config to talk to Stripe at all (publishable + secret). Enough
 * to retrieve a PaymentIntent for the thank-you page summary, regardless
 * of which checkout flow (agent or playbook) created it.
 */
function gildhart_stripe_keys_configured() {
    $cfg = gildhart_stripe_config();
    return ! empty( $cfg['publishable'] ) && ! empty( $cfg['secret'] );
}

/** True iff the Playbook one-time checkout is configured (keys + amount). */
function gildhart_stripe_playbook_is_configured() {
    $cfg = gildhart_stripe_config();
    return ! empty( $cfg['publishable'] ) && ! empty( $cfg['secret'] )
        && ! empty( $cfg['playbook_amount'] );
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
    // Only the secret key is needed to boot the SDK — not the price
    // constants. Gating on keys-only lets both the agent (subscription)
    // and playbook (one-time) flows boot independently.
    if ( ! gildhart_stripe_keys_configured() ) return false;

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
 * Lead metadata is mirrored across four Stripe objects so Make.com
 * picks it up regardless of which webhook event their scenario triggers
 * on:
 *   - Customer.metadata        (persists for the lifetime of the customer)
 *   - Subscription.metadata    (read on subscription.* events)
 *   - Invoice.metadata         (read on invoice.payment_succeeded — the
 *                               canonical event for subscription billing.
 *                               Stripe doesn't auto-inherit metadata from
 *                               the parent Subscription onto auto-
 *                               generated invoices, so we write it onto
 *                               the first invoice explicitly.)
 *   - PaymentIntent.metadata   (read by the thank-you page)
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

    // Customer.
    //
    // address.country is required by Stripe Tax (automatic_tax) so the
    // VAT jurisdiction can be determined at invoice creation — without
    // it the subscription create call rejects with "The customer's
    // location isn't recognized." We hardcode 'GB' because the product
    // is UK-targeted; if/when we sell internationally we'll add a
    // country picker to the lead form and pass the user-selected value
    // here instead. The Payment Element collects a full billing
    // address from the card during confirmation, but that arrives too
    // late for Stripe Tax to lock VAT onto the first invoice.
    $customer = \Stripe\Customer::create( array(
        'email'    => $email,
        'name'     => trim( $first_name . ' ' . $last_name ),
        'address'  => array( 'country' => 'GB' ),
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
        // Expand the invoice so we can read confirmation_secret + amount_due
        // from a single call without a second round-trip.
        'expand'        => array( 'latest_invoice' ),
    ) );

    $invoice = $subscription->latest_invoice;
    if ( ! is_object( $invoice ) ) {
        throw new \Exception( 'Stripe subscription created but no invoice was returned.' );
    }

    // Stripe SDK v17 (and the matching API version) returns the first
    // payment's client_secret on Invoice.confirmation_secret; older API
    // versions had Invoice.payment_intent as a nested PaymentIntent
    // object. Try the new shape first, fall back to the old shape so
    // accounts on either API version both work.
    $client_secret = null;
    if ( ! empty( $invoice->confirmation_secret->client_secret ) ) {
        $client_secret = $invoice->confirmation_secret->client_secret;
    } elseif ( ! empty( $invoice->payment_intent->client_secret ) ) {
        $client_secret = $invoice->payment_intent->client_secret;
    } elseif ( is_string( $invoice->payment_intent ?? null ) ) {
        // Older API: payment_intent is a string ID. Retrieve the PI
        // directly to fetch its client_secret.
        try {
            $pi_lookup = \Stripe\PaymentIntent::retrieve( $invoice->payment_intent );
            if ( $pi_lookup && ! empty( $pi_lookup->client_secret ) ) {
                $client_secret = $pi_lookup->client_secret;
            }
        } catch ( \Exception $e ) { /* fall through to diagnostic */ }
    }

    // Last-resort fallback: re-retrieve the invoice with explicit
    // expand. Sometimes the original Subscription::create response
    // omits confirmation_secret (account-specific API quirk) but a
    // direct Invoice::retrieve with expansion populates it.
    if ( ! $client_secret && ! empty( $invoice->id ) ) {
        try {
            $invoice_fresh = \Stripe\Invoice::retrieve( array(
                'id'     => $invoice->id,
                'expand' => array( 'confirmation_secret', 'payments.data.payment.payment_intent' ),
            ) );
            if ( ! empty( $invoice_fresh->confirmation_secret->client_secret ) ) {
                $client_secret = $invoice_fresh->confirmation_secret->client_secret;
            } elseif ( ! empty( $invoice_fresh->payments->data[0]->payment->payment_intent->client_secret ) ) {
                $client_secret = $invoice_fresh->payments->data[0]->payment->payment_intent->client_secret;
            }
            // Update $invoice so subsequent diagnostic + amount reads use the fresh data.
            $invoice = $invoice_fresh;
        } catch ( \Exception $e ) { /* fall through to diagnostic */ }
    }

    if ( ! $client_secret ) {
        // Capture diagnostic context so we can see why both the new
        // and old shapes came back empty. Most common causes:
        //   - Invoice failed to finalize (last_finalization_error has the reason)
        //   - Subscription status is 'incomplete_expired' (took too long, recreated)
        //   - Stripe Tax silently rejected the customer location (despite address.country)
        //   - Account on an unusual API version with different field names
        $invoice_keys = '';
        if ( is_object( $invoice ) && method_exists( $invoice, 'toArray' ) ) {
            $arr = $invoice->toArray();
            if ( is_array( $arr ) ) {
                $invoice_keys = substr( implode( ',', array_keys( $arr ) ), 0, 600 );
            }
        }
        $diag = sprintf(
            'sub_status=%s, invoice_status=%s, invoice_id=%s, confirmation_secret=%s, payment_intent=%s, invoice_keys=[%s]',
            isset( $subscription->status ) ? $subscription->status : 'null',
            isset( $invoice->status ) ? $invoice->status : 'null',
            isset( $invoice->id ) ? $invoice->id : 'null',
            isset( $invoice->confirmation_secret ) ? ( ! empty( $invoice->confirmation_secret->client_secret ) ? 'with_secret' : 'no_secret' ) : 'absent',
            isset( $invoice->payment_intent ) ? ( is_string( $invoice->payment_intent ) ? 'string_id' : ( ! empty( $invoice->payment_intent->client_secret ) ? 'with_secret' : 'object_no_secret' ) ) : 'absent',
            $invoice_keys
        );
        if ( ! empty( $invoice->last_finalization_error->message ) ) {
            $diag .= ', finalization_error=' . $invoice->last_finalization_error->message;
        }
        throw new \Exception( 'Stripe did not return a client_secret for the new subscription. (' . $diag . ')' );
    }

    // Derive the PaymentIntent ID from the client_secret. Stripe's
    // format is pi_XXX_secret_YYY — the prefix before "_secret_" is
    // the PI ID. We need this ID to write metadata onto the
    // PaymentIntent (so the thank-you page can read it back) and so
    // Stripe sends a receipt email on payment success.
    $payment_intent_id = null;
    if ( preg_match( '/^(pi_[A-Za-z0-9]+)_secret_/', $client_secret, $m ) ) {
        $payment_intent_id = $m[1];
    }

    if ( $payment_intent_id ) {
        \Stripe\PaymentIntent::update( $payment_intent_id, array(
            'metadata'      => array_merge( $metadata, array( 'customer_email' => $email ) ),
            'receipt_email' => $email,
        ) );
    }

    // Mirror lead metadata onto the first invoice so Make.com receives
    // first_name / last_name / plan_label directly in the
    // invoice.payment_succeeded webhook payload — no extra Customer
    // lookup needed in the scenario. Renewal invoices (auto-generated
    // by Stripe at each billing cycle) won't carry this metadata; for
    // those, Make should read from Customer.metadata via a Stripe
    // lookup. The first invoice is the one that triggers Kartra
    // onboarding, so this covers the critical path.
    //
    // Wrapped in try/catch so a metadata write failure doesn't break
    // the checkout — the invoice is already created and the customer
    // can still pay; missing invoice metadata only degrades Make's
    // first-invoice convenience, not the transaction itself.
    if ( ! empty( $invoice->id ) ) {
        try {
            \Stripe\Invoice::update( $invoice->id, array(
                'metadata' => $metadata,
            ) );
        } catch ( \Exception $e ) {
            /* swallow — see comment above */
        }
    }

    $cfg = gildhart_stripe_config();

    // Read the computed total from the latest invoice. Stripe Tax has
    // already added VAT at this point so amount_due is the final
    // checkout figure (£1,194 for annual, £150 for monthly with UK 20%
    // VAT). amount_due is in pence; format for the Pay button label.
    $amount_due   = isset( $invoice->amount_due ) ? (int) $invoice->amount_due : 0;
    $currency     = isset( $invoice->currency )   ? strtoupper( $invoice->currency ) : 'GBP';
    $currency_sym = ( 'GBP' === $currency ) ? '£' : ( 'USD' === $currency ? '$' : ( 'EUR' === $currency ? '€' : '' ) );
    $amount_decimal = $amount_due / 100;
    $amount_formatted = $currency_sym . ( fmod( $amount_decimal, 1 ) === 0.0
        ? number_format( $amount_decimal, 0 )
        : number_format( $amount_decimal, 2 ) );

    return array(
        'client_secret'    => $client_secret,
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
 * during checkout (email, plan_label, first_name) plus the live
 * status, the formatted total paid, and the subscription's next
 * charge date — everything the receipt card on the thank-you page
 * needs to render.
 *
 * Subscription / next-charge resolution is best-effort: if the
 * invoice or subscription retrieve fails we return an empty
 * next_charge_date and the JS hides that row rather than the whole
 * page breaking.
 *
 * @param string $payment_intent_id
 * @return array { email, plan_label, first_name, amount_formatted, next_charge_date, status }
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

    // Format amount paid for display. amount_received is set once the
    // payment has succeeded; on a still-processing PI we fall back to
    // amount (the requested charge). Both are pence.
    $amount_pence = isset( $pi->amount_received ) && $pi->amount_received > 0
        ? (int) $pi->amount_received
        : (int) ( $pi->amount ?? 0 );
    $currency     = isset( $pi->currency ) ? strtoupper( $pi->currency ) : 'GBP';
    $currency_sym = ( 'GBP' === $currency ) ? '£' : ( 'USD' === $currency ? '$' : ( 'EUR' === $currency ? '€' : '' ) );
    $amount_decimal   = $amount_pence / 100;
    $amount_formatted = $currency_sym . ( fmod( $amount_decimal, 1 ) === 0.0
        ? number_format( $amount_decimal, 0 )
        : number_format( $amount_decimal, 2 ) );

    // Next charge date — best-effort hop PI → Invoice → Subscription.
    // SDK v17 puts current_period_end on the subscription item rather
    // than the subscription root, so we check both.
    $next_charge_date = '';
    try {
        $invoice_id = $pi->invoice ?? null;
        if ( $invoice_id ) {
            $invoice = \Stripe\Invoice::retrieve( $invoice_id );
            $sub_id  = null;
            if ( ! empty( $invoice->subscription ) && is_string( $invoice->subscription ) ) {
                $sub_id = $invoice->subscription;
            } elseif ( ! empty( $invoice->parent->subscription_details->subscription ) ) {
                $sub_id = $invoice->parent->subscription_details->subscription;
            }
            if ( $sub_id ) {
                $sub        = \Stripe\Subscription::retrieve( $sub_id );
                $period_end = isset( $sub->current_period_end ) ? (int) $sub->current_period_end : 0;
                if ( ! $period_end && ! empty( $sub->items->data[0]->current_period_end ) ) {
                    $period_end = (int) $sub->items->data[0]->current_period_end;
                }
                if ( $period_end > 0 ) {
                    $next_charge_date = date_i18n( 'j F Y', $period_end );
                }
            }
        }
    } catch ( \Exception $e ) {
        /* swallow — next_charge_date stays empty, JS hides the row */
    }

    return array(
        'email'            => $pi->metadata['customer_email'] ?? ( $pi->receipt_email ?? '' ),
        'plan_label'       => $pi->metadata['plan_label']     ?? '',
        'first_name'       => $pi->metadata['first_name']     ?? '',
        'amount_formatted' => $amount_formatted,
        'next_charge_date' => $next_charge_date,
        'status'           => $pi->status,
    );
}

/* ─────────────────────────────────────────────────────────────────
 * Playbook — one-time PaymentIntent
 * ───────────────────────────────────────────────────────────────── */

/**
 * Create a Stripe Customer + one-time PaymentIntent for a Playbook lead.
 *
 * Unlike the agent flow (a recurring Subscription), the Playbook is a
 * single £995 charge. The amount is read from
 * GILDHART_STRIPE_PLAYBOOK_AMOUNT and is treated as VAT-inclusive —
 * there is NO Stripe Tax on top, so the customer pays exactly the
 * displayed price (removes checkout friction / abandonment).
 *
 * A bare PaymentIntent takes a raw amount, not a Price ID, so no
 * Stripe Product/Price object is involved. Product attribution for
 * reporting + the Make.com → Kartra hand-off comes from the
 * description ("The AI Search Playbook") + metadata.product, mirrored
 * onto both the Customer and the PaymentIntent so Make picks it up on
 * the payment_intent.succeeded webhook.
 *
 * The Playbook form carries an extra field the agent didn't — the
 * `services` multi-select — captured here as a pipe-separated string
 * in metadata for Make to map onto the appropriate Kartra fields.
 *
 * @param array $lead {
 *   first_name    string  Required.
 *   last_name     string  Required.
 *   email         string  Required.
 *   practice_name string  Optional.
 *   website       string  Optional.
 *   services      string  Optional. Pipe-separated list from the form.
 * }
 * @return array {
 *   client_secret     string  PaymentIntent client_secret.
 *   payment_intent_id string  Stripe PaymentIntent ID.
 *   publishable_key   string  To init Stripe.js on the client.
 *   plan_label        string  Human-readable label for display.
 *   amount_total      int     Pence.
 *   amount_formatted  string  e.g. "£995".
 *   currency          string  e.g. "GBP".
 * }
 * @throws \Exception On invalid input or Stripe API error.
 */
function gildhart_stripe_create_payment_intent_for_lead( array $lead ) {
    if ( ! gildhart_stripe_boot() ) {
        throw new \Exception( 'Stripe is not configured on this site.' );
    }

    $cfg    = gildhart_stripe_config();
    $amount = (int) $cfg['playbook_amount'];
    if ( $amount < 1 ) {
        throw new \Exception( 'Playbook amount is not configured.' );
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
    // Services arrive pipe-separated from the multi-select hidden input.
    // Keep the raw string in metadata; Make splits on "|" for Kartra.
    $services      = sanitize_text_field( $lead['services'] ?? '' );

    $plan_label = 'The AI Search Playbook — £995 one-time';

    $metadata = array(
        'product'        => 'the-ai-search-playbook',
        'first_name'     => $first_name,
        'last_name'      => $last_name,
        'practice_name'  => $practice_name,
        'website'        => $website,
        'services'       => $services,
        'plan_label'     => $plan_label,
        'customer_email' => $email,
    );

    // Customer — address.country kept for parity with the agent flow and
    // so any future tax/reporting has a jurisdiction. No automatic_tax
    // here: the £995 is VAT-inclusive and charged as-is.
    $customer = \Stripe\Customer::create( array(
        'email'    => $email,
        'name'     => trim( $first_name . ' ' . $last_name ),
        'address'  => array( 'country' => 'GB' ),
        'metadata' => $metadata,
    ) );

    // Card only — which on the Payment Element automatically includes the
    // card-backed wallets (Apple Pay, Google Pay) and Link, while excluding
    // BNPL (Klarna, Clearpay) and Revolut Pay. Matches the agent flow's
    // payment_method_types and suits B2B healthcare buyers who won't use
    // instalment plans.
    $payment_intent = \Stripe\PaymentIntent::create( array(
        'amount'               => $amount,
        'currency'             => 'gbp',
        'customer'             => $customer->id,
        'description'          => 'The AI Search Playbook',
        'receipt_email'        => $email,
        'metadata'             => $metadata,
        'payment_method_types' => array( 'card' ),
    ) );

    if ( empty( $payment_intent->client_secret ) ) {
        throw new \Exception( 'Stripe did not return a client_secret for the PaymentIntent.' );
    }

    $currency_sym     = '£';
    $amount_decimal   = $amount / 100;
    $amount_formatted = $currency_sym . ( fmod( $amount_decimal, 1 ) === 0.0
        ? number_format( $amount_decimal, 0 )
        : number_format( $amount_decimal, 2 ) );

    return array(
        'client_secret'     => $payment_intent->client_secret,
        'payment_intent_id' => $payment_intent->id,
        'publishable_key'   => $cfg['publishable'],
        'plan_label'        => 'The AI Search Playbook',
        'amount_total'      => $amount,
        'amount_formatted'  => $amount_formatted,
        'currency'          => 'GBP',
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

    register_rest_route( 'gildhart/v1', '/playbook-checkout', array(
        'methods'             => 'POST',
        'callback'            => 'gildhart_rest_playbook_checkout',
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
 * POST /gildhart/v1/playbook-checkout
 *
 * JSON body: { first_name, last_name, email, practice_name, website, services }
 * Response on success: { client_secret, payment_intent_id, publishable_key, plan_label, amount_total, amount_formatted, currency }
 * Errors: 400 invalid_input, 502 stripe_api_error, 503 stripe_not_configured.
 */
function gildhart_rest_playbook_checkout( WP_REST_Request $request ) {
    if ( ! gildhart_stripe_playbook_is_configured() ) {
        return new WP_Error( 'stripe_not_configured', 'Playbook checkout is not configured on this site.', array( 'status' => 503 ) );
    }

    $body = $request->get_json_params();
    if ( ! is_array( $body ) ) {
        return new WP_Error( 'invalid_body', 'Invalid request body — JSON expected.', array( 'status' => 400 ) );
    }

    try {
        $result = gildhart_stripe_create_payment_intent_for_lead( array(
            'first_name'    => $body['first_name']    ?? '',
            'last_name'     => $body['last_name']     ?? '',
            'email'         => $body['email']         ?? '',
            'practice_name' => $body['practice_name'] ?? '',
            'website'       => $body['website']       ?? '',
            'services'      => $body['services']      ?? '',
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
 * Response: { email, plan_label, first_name, amount_formatted, next_charge_date, status }
 * Errors: 400 invalid_input, 502 stripe_api_error, 503 stripe_not_configured.
 *
 * Gated on keys-only config so it serves both the agent (subscription)
 * and playbook (one-time) thank-you pages. For a one-time PI the
 * next_charge_date best-effort lookup simply returns empty.
 */
function gildhart_rest_payment_intent( WP_REST_Request $request ) {
    if ( ! gildhart_stripe_keys_configured() ) {
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
