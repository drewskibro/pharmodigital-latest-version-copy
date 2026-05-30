<?php
/**
 * WebPro Elite — Waitlist form REST endpoint.
 *
 * Single POST endpoint `/wp-json/gildhart/v1/wpe-waitlist` that
 * validates the form payload server-side, runs a honeypot check, and
 * forwards a clean JSON envelope to a Make.com webhook URL configured
 * via the GILDHART_MAKE_WEBHOOK_WPE_WAITLIST constant in wp-config.php.
 *
 * The endpoint never exposes the Make URL to the browser. If the
 * constant is missing the route returns a 503 with a clear message
 * so the configuration gap is obvious during setup. Validation
 * errors return 400 with a per-field message map.
 *
 * Mirrors the architecture used by the Agent + Playbook Stripe flows
 * (gildhart/v1/* routes, JSON envelopes, no client-side trust).
 *
 * @package Gildhart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * True when the Make webhook URL is configured.
 */
function gildhart_wpe_waitlist_is_configured() {
    return defined( 'GILDHART_MAKE_WEBHOOK_WPE_WAITLIST' )
        && is_string( GILDHART_MAKE_WEBHOOK_WPE_WAITLIST )
        && '' !== trim( GILDHART_MAKE_WEBHOOK_WPE_WAITLIST );
}

/**
 * Whitelist of accepted Practice Type values. Matches the <option>
 * values in section-wpe-closing.php; submissions with any other
 * value get rejected before they reach Make.
 */
function gildhart_wpe_waitlist_practice_types() {
    return array(
        'pharmacy'      => 'Independent Pharmacy',
        'travel-clinic' => 'Travel Clinic',
        'weight-loss'   => 'Weight Loss Clinic',
        'gp'            => 'Private GP / GP Practice',
        'aesthetics'    => 'Aesthetics Clinic',
        'other'         => 'Other Healthcare Practice',
    );
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'gildhart/v1', '/wpe-waitlist', array(
        'methods'             => 'POST',
        'callback'            => 'gildhart_wpe_waitlist_submit',
        'permission_callback' => '__return_true',
    ) );
} );

/**
 * Handle a waitlist submission.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function gildhart_wpe_waitlist_submit( WP_REST_Request $request ) {
    // Honeypot — bot-filled hidden field. Reject silently with a 200
    // so scrapers can't probe for validation gaps.
    $honeypot = trim( (string) $request->get_param( 'company_role' ) );
    if ( '' !== $honeypot ) {
        return new WP_REST_Response( array( 'ok' => true ), 200 );
    }

    if ( ! gildhart_wpe_waitlist_is_configured() ) {
        return new WP_REST_Response( array(
            'ok'    => false,
            'error' => 'The waitlist is not currently accepting submissions. Please email hello@gildhart.co.uk.',
        ), 503 );
    }

    // Pull + trim every field. Treat everything as a string at this
    // stage; per-field validation runs below.
    $fields = array(
        'practice_name' => trim( (string) $request->get_param( 'practice_name' ) ),
        'first_name'    => trim( (string) $request->get_param( 'first_name' ) ),
        'last_name'     => trim( (string) $request->get_param( 'last_name' ) ),
        'email'         => trim( (string) $request->get_param( 'email' ) ),
        'phone'         => trim( (string) $request->get_param( 'phone' ) ),
        'website'       => trim( (string) $request->get_param( 'website' ) ),
        'practice_type' => trim( (string) $request->get_param( 'practice_type' ) ),
    );

    $errors = array();

    // Required fields. Phone + website are optional, practice_type
    // is required so Kartra can route by clinic category.
    $required = array(
        'practice_name' => 'Practice name is required.',
        'first_name'    => 'First name is required.',
        'last_name'     => 'Last name is required.',
        'email'         => 'Email is required.',
        'practice_type' => 'Please select your practice type.',
    );
    foreach ( $required as $key => $message ) {
        if ( '' === $fields[ $key ] ) {
            $errors[ $key ] = $message;
        }
    }

    // Length caps prevent a malicious payload from stuffing 50KB
    // into a field. Generous enough for any legitimate value.
    foreach ( $fields as $key => $value ) {
        if ( strlen( $value ) > 500 ) {
            $errors[ $key ] = 'This value is too long.';
        }
    }

    // Email shape.
    if ( '' !== $fields['email'] && ! is_email( $fields['email'] ) ) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    // Practice type whitelist — reject anything not in the dropdown.
    $practice_types = gildhart_wpe_waitlist_practice_types();
    if ( '' !== $fields['practice_type'] && ! isset( $practice_types[ $fields['practice_type'] ] ) ) {
        $errors['practice_type'] = 'Please select a valid practice type.';
    }

    if ( ! empty( $errors ) ) {
        return new WP_REST_Response( array(
            'ok'     => false,
            'errors' => $errors,
            'error'  => 'Please fix the highlighted fields and try again.',
        ), 400 );
    }

    // Build the clean payload Make will receive. Practice type is
    // sent as both the slug (for routing) and the human label (for
    // Kartra custom-field display).
    $payload = array(
        'source'              => 'webpro-elite-waitlist',
        'submitted_at'        => current_time( 'mysql', true ),
        'practice_name'       => $fields['practice_name'],
        'first_name'          => $fields['first_name'],
        'last_name'           => $fields['last_name'],
        'email'               => $fields['email'],
        'phone'               => $fields['phone'],
        'website'             => $fields['website'],
        'practice_type'       => $fields['practice_type'],
        'practice_type_label' => $practice_types[ $fields['practice_type'] ],
        'site_url'            => home_url( '/' ),
        'page_url'            => esc_url_raw( (string) $request->get_param( 'page_url' ) ),
        'user_agent'          => isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '',
    );

    $response = wp_remote_post( GILDHART_MAKE_WEBHOOK_WPE_WAITLIST, array(
        'timeout' => 12,
        'headers' => array( 'Content-Type' => 'application/json' ),
        'body'    => wp_json_encode( $payload ),
    ) );

    if ( is_wp_error( $response ) ) {
        error_log( '[wpe-waitlist] Make webhook failed: ' . $response->get_error_message() );
        return new WP_REST_Response( array(
            'ok'    => false,
            'error' => 'We couldn\'t submit your details right now. Please try again in a moment, or email hello@gildhart.co.uk.',
        ), 502 );
    }

    $code = (int) wp_remote_retrieve_response_code( $response );
    if ( $code < 200 || $code >= 300 ) {
        error_log( '[wpe-waitlist] Make webhook returned HTTP ' . $code . ': ' . wp_remote_retrieve_body( $response ) );
        return new WP_REST_Response( array(
            'ok'    => false,
            'error' => 'We couldn\'t submit your details right now. Please try again in a moment, or email hello@gildhart.co.uk.',
        ), 502 );
    }

    return new WP_REST_Response( array( 'ok' => true ), 200 );
}
