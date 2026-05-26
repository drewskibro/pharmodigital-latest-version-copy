<?php
/**
 * WebPro Elite — Waitlist lead capture.
 *
 * Backend for the WPE closing-section waitlist form. Flow:
 *
 *   JS  GET  /gildhart/v1/wpe-token     → fresh nonce (cache-safe)
 *   JS  POST /gildhart/v1/wpe-waitlist  → validate → store → notify → webhook
 *
 * Spam protection is three-layered and all server-side:
 *   1. Honeypot — a hidden field humans never fill. Any value = bot = 200
 *      OK silently discarded (so the bot believes it succeeded).
 *   2. Nonce — fetched fresh from /wpe-token at submit time so full-page
 *      caching can never serve a stale token.
 *   3. Rate limit — max GILDHART_WPE_RL_MAX submissions per IP per hour
 *      via a transient keyed on a salted IP hash (no raw IP stored).
 *
 * Storage is two-layer:
 *   - WordPress CPT `wpe_inquiry` (primary record, viewable in admin).
 *   - Make.com webhook → Kartra lead tagged `wpe-waitlist`, fired
 *     best-effort (a webhook failure never fails the user's submission).
 *
 * Make webhook URL comes from wp-config.php:
 *     define( 'GILDHART_WPE_WEBHOOK_URL', 'https://hook.eu1.make.com/…' );
 * When undefined the webhook step is skipped (WP storage + email still run).
 *
 * @package Gildhart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'GILDHART_WPE_RL_MAX' ) ) {
    define( 'GILDHART_WPE_RL_MAX', 3 ); // Submissions per IP per hour.
}

/* ─────────────────────────────────────────────────────────────────
 * CPT: wpe_inquiry — stores each waitlist lead as the primary record.
 * ───────────────────────────────────────────────────────────────── */

function gildhart_register_wpe_inquiry_cpt() {
    register_post_type( 'wpe_inquiry', array(
        'labels' => array(
            'name'          => 'WPE Enquiries',
            'singular_name' => 'WPE Enquiry',
            'menu_name'     => 'WPE Enquiries',
            'all_items'     => 'All Enquiries',
        ),
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-email-alt',
        'menu_position'       => 26,
        'capability_type'     => 'post',
        'capabilities'        => array(
            'create_posts' => 'do_not_allow', // Leads are created by the form, never by hand.
        ),
        'map_meta_cap'        => true,
        'supports'            => array( 'title' ),
        'has_archive'         => false,
        'rewrite'             => false,
        'exclude_from_search' => true,
    ) );
}
add_action( 'init', 'gildhart_register_wpe_inquiry_cpt' );

/* ─────────────────────────────────────────────────────────────────
 * REST endpoints
 * ───────────────────────────────────────────────────────────────── */

add_action( 'rest_api_init', function () {
    register_rest_route( 'gildhart/v1', '/wpe-token', array(
        'methods'             => 'GET',
        'callback'            => 'gildhart_rest_wpe_token',
        'permission_callback' => '__return_true',
    ) );

    register_rest_route( 'gildhart/v1', '/wpe-waitlist', array(
        'methods'             => 'POST',
        'callback'            => 'gildhart_rest_wpe_waitlist',
        'permission_callback' => '__return_true',
    ) );
} );

/**
 * GET /gildhart/v1/wpe-token
 *
 * Returns a freshly-minted nonce. Served dynamically (never page-cached),
 * so the token is always valid even when the WPE page itself is cached.
 */
function gildhart_rest_wpe_token() {
    return rest_ensure_response( array(
        'nonce' => wp_create_nonce( 'gildhart_wpe_waitlist' ),
    ) );
}

/**
 * POST /gildhart/v1/wpe-waitlist
 *
 * JSON body: { nonce, hp, practice_name, first_name, last_name, email,
 *              phone, website, practice_type }
 * `hp` is the honeypot — must be empty.
 *
 * Success: 200 { ok: true }
 * Errors:  400 invalid_input | 403 bad_nonce | 429 rate_limited
 */
function gildhart_rest_wpe_waitlist( WP_REST_Request $request ) {
    $body = $request->get_json_params();
    if ( ! is_array( $body ) ) {
        return new WP_Error( 'invalid_body', 'Invalid request body — JSON expected.', array( 'status' => 400 ) );
    }

    // Layer 1 — honeypot. Silently accept so the bot logs a success and
    // moves on, but discard everything.
    if ( ! empty( $body['hp'] ) ) {
        return rest_ensure_response( array( 'ok' => true ) );
    }

    // Layer 2 — nonce.
    $nonce = isset( $body['nonce'] ) ? sanitize_text_field( $body['nonce'] ) : '';
    if ( ! wp_verify_nonce( $nonce, 'gildhart_wpe_waitlist' ) ) {
        return new WP_Error( 'bad_nonce', 'Your session expired. Please refresh and try again.', array( 'status' => 403 ) );
    }

    // Layer 3 — rate limit by salted IP hash.
    $ip_hash = gildhart_wpe_client_ip_hash();
    if ( $ip_hash ) {
        $rl_key = 'gildhart_wpe_rl_' . $ip_hash;
        $count  = (int) get_transient( $rl_key );
        if ( $count >= GILDHART_WPE_RL_MAX ) {
            return new WP_Error( 'rate_limited', 'Too many submissions. Please try again later.', array( 'status' => 429 ) );
        }
        set_transient( $rl_key, $count + 1, HOUR_IN_SECONDS );
    }

    // Sanitise.
    $practice_name = sanitize_text_field( $body['practice_name'] ?? '' );
    $first_name    = sanitize_text_field( $body['first_name']    ?? '' );
    $last_name     = sanitize_text_field( $body['last_name']     ?? '' );
    $email         = sanitize_email( $body['email']              ?? '' );
    $phone         = sanitize_text_field( $body['phone']         ?? '' );
    $website       = esc_url_raw( $body['website']               ?? '' );
    $practice_type = sanitize_text_field( $body['practice_type'] ?? '' );

    // Validate the minimum viable lead.
    if ( ! $email || ! is_email( $email ) ) {
        return new WP_Error( 'invalid_input', 'A valid email address is required.', array( 'status' => 400 ) );
    }
    if ( ! $first_name && ! $last_name ) {
        return new WP_Error( 'invalid_input', 'Please tell us your name.', array( 'status' => 400 ) );
    }

    $full_name = trim( $first_name . ' ' . $last_name );
    $title     = $practice_name ? $practice_name . ' — ' . $full_name : $full_name;

    // Layer A storage — WordPress CPT.
    $post_id = wp_insert_post( array(
        'post_type'   => 'wpe_inquiry',
        'post_title'  => $title,
        'post_status' => 'publish',
        'meta_input'  => array(
            '_wpe_practice_name' => $practice_name,
            '_wpe_first_name'    => $first_name,
            '_wpe_last_name'     => $last_name,
            '_wpe_email'         => $email,
            '_wpe_phone'         => $phone,
            '_wpe_website'       => $website,
            '_wpe_practice_type' => $practice_type,
            '_wpe_ip_hash'       => $ip_hash,
            '_wpe_submitted_at'  => current_time( 'mysql' ),
        ),
    ), true );

    if ( is_wp_error( $post_id ) ) {
        return new WP_Error( 'storage_failed', 'We couldn\'t save your details. Please try again.', array( 'status' => 500 ) );
    }

    $lead = compact(
        'practice_name', 'first_name', 'last_name', 'email',
        'phone', 'website', 'practice_type'
    );

    // Notification email + Make webhook are best-effort: a failure here
    // must not surface to the user, whose lead is already safely stored.
    gildhart_wpe_send_notification( $lead, $post_id );
    gildhart_wpe_fire_webhook( $lead, $post_id );

    return rest_ensure_response( array( 'ok' => true ) );
}

/* ─────────────────────────────────────────────────────────────────
 * Helpers
 * ───────────────────────────────────────────────────────────────── */

/**
 * Salted SHA-256 of the client IP. We never store the raw IP (GDPR data
 * minimisation); the hash is enough to rate-limit and de-duplicate.
 * Returns '' when no IP can be determined.
 */
function gildhart_wpe_client_ip_hash() {
    $ip = '';
    // Kinsta / Cloudflare forward the visitor IP; fall back to REMOTE_ADDR.
    foreach ( array( 'HTTP_CF_CONNECTING_IP', 'HTTP_X_REAL_IP', 'REMOTE_ADDR' ) as $key ) {
        if ( ! empty( $_SERVER[ $key ] ) ) {
            $candidate = explode( ',', wp_unslash( $_SERVER[ $key ] ) )[0];
            $candidate = trim( $candidate );
            if ( filter_var( $candidate, FILTER_VALIDATE_IP ) ) {
                $ip = $candidate;
                break;
            }
        }
    }
    return $ip ? hash( 'sha256', $ip . wp_salt( 'nonce' ) ) : '';
}

/**
 * Emails the lead to the site admin. Reply-To is set to the lead so a
 * reply from the inbox goes straight back to them.
 */
function gildhart_wpe_send_notification( array $lead, $post_id ) {
    $to = defined( 'GILDHART_WPE_NOTIFY_EMAIL' ) ? GILDHART_WPE_NOTIFY_EMAIL : get_option( 'admin_email' );
    if ( ! $to ) {
        return;
    }

    $subject = sprintf( '[WebPro Elite] New waitlist enquiry — %s', $lead['practice_name'] ?: trim( $lead['first_name'] . ' ' . $lead['last_name'] ) );

    $lines = array(
        'A new WebPro Elite waitlist enquiry has come in.',
        '',
        'Practice:      ' . $lead['practice_name'],
        'Name:          ' . trim( $lead['first_name'] . ' ' . $lead['last_name'] ),
        'Email:         ' . $lead['email'],
        'Phone:         ' . $lead['phone'],
        'Website:       ' . $lead['website'],
        'Practice type: ' . $lead['practice_type'],
        '',
        'View in admin: ' . admin_url( 'post.php?post=' . (int) $post_id . '&action=edit' ),
    );

    $headers = array();
    if ( $lead['email'] ) {
        $headers[] = 'Reply-To: ' . $lead['email'];
    }

    wp_mail( $to, $subject, implode( "\n", $lines ), $headers );
}

/**
 * Posts the lead to the Make.com webhook (→ Kartra). Non-blocking, short
 * timeout — Make does the heavy lifting (create contact, tag wpe-waitlist,
 * fire confirmation sequence). Skipped entirely when no URL is configured.
 */
function gildhart_wpe_fire_webhook( array $lead, $post_id ) {
    if ( ! defined( 'GILDHART_WPE_WEBHOOK_URL' ) || ! GILDHART_WPE_WEBHOOK_URL ) {
        return;
    }

    $payload = array_merge( $lead, array(
        'source'        => 'web-pro-elite-waitlist',
        'tag'           => 'wpe-waitlist',
        'wp_post_id'    => (int) $post_id,
        'submitted_at'  => current_time( 'c' ),
    ) );

    wp_remote_post( GILDHART_WPE_WEBHOOK_URL, array(
        'timeout'  => 8,
        'blocking' => false,
        'headers'  => array( 'Content-Type' => 'application/json' ),
        'body'     => wp_json_encode( $payload ),
    ) );
}

/* ─────────────────────────────────────────────────────────────────
 * Admin — surface the lead's details as a read-only meta box.
 * ───────────────────────────────────────────────────────────────── */

add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'wpe_inquiry_details',
        'Enquiry Details',
        'gildhart_wpe_inquiry_metabox',
        'wpe_inquiry',
        'normal',
        'high'
    );
} );

function gildhart_wpe_inquiry_metabox( $post ) {
    $rows = array(
        'Practice'      => '_wpe_practice_name',
        'First name'    => '_wpe_first_name',
        'Last name'     => '_wpe_last_name',
        'Email'         => '_wpe_email',
        'Phone'         => '_wpe_phone',
        'Website'       => '_wpe_website',
        'Practice type' => '_wpe_practice_type',
        'Submitted'     => '_wpe_submitted_at',
    );
    echo '<table class="widefat striped"><tbody>';
    foreach ( $rows as $label => $key ) {
        $value = get_post_meta( $post->ID, $key, true );
        if ( 'Email' === $label && $value ) {
            $value = '<a href="mailto:' . esc_attr( $value ) . '">' . esc_html( $value ) . '</a>';
        } elseif ( 'Website' === $label && $value ) {
            $value = '<a href="' . esc_url( $value ) . '" target="_blank" rel="noopener">' . esc_html( $value ) . '</a>';
        } else {
            $value = esc_html( $value );
        }
        echo '<tr><th style="width:160px;text-align:left;">' . esc_html( $label ) . '</th><td>' . $value . '</td></tr>';
    }
    echo '</tbody></table>';
}
