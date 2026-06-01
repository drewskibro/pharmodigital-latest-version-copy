<?php
/**
 * Gildhart Agency Theme Functions
 *
 * @package Gildhart
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Cache-bust off the CSS file's mtime so editing globals.css invalidates the
// browser/CDN cache. Using __FILE__ would not work — see Easy Pharmacy lesson.
define( 'GILDHART_VERSION', filemtime( get_theme_file_path( 'assets/css/globals.css' ) ) );
define( 'GILDHART_DIR', get_template_directory() );
define( 'GILDHART_URI', get_template_directory_uri() );

/**
 * Per-asset cache buster. Returns the mtime of a theme-relative file so that
 * editing one CSS/JS file invalidates ONLY that file's URL (instead of every
 * asset sharing the same version because they were all keyed off globals.css).
 *
 * Falls back to GILDHART_VERSION if the file does not exist.
 */
function gh_asset_ver( $relative_path ) {
    $full = get_theme_file_path( $relative_path );
    return file_exists( $full ) ? filemtime( $full ) : GILDHART_VERSION;
}

/**
 * Theme Setup
 */
function gildhart_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    register_nav_menus( array(
        'primary'         => __( 'Primary Menu', 'gildhart' ),
        'footer-services' => __( 'Footer Services', 'gildhart' ),
        'footer-links'    => __( 'Footer Quick Links', 'gildhart' ),
    ) );

    add_image_size( 'medium-large', 720, 9999, false );
    add_image_size( 'case-study-card', 800, 600, true );
    add_image_size( 'case-study-hero', 1600, 900, true );
    add_image_size( 'service-card', 600, 400, true );
    add_image_size( 'team-photo', 600, 750, true );
}
add_action( 'after_setup_theme', 'gildhart_setup' );

/**
 * Add custom "Medium Large" image size to the editor dropdown.
 */
function gildhart_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'medium-large' => __( 'Medium Large (720px)', 'gildhart' ),
    ) );
}
add_filter( 'image_size_names_choose', 'gildhart_custom_image_sizes' );

/**
 * Enqueue Global Styles & Scripts
 */
function gildhart_scripts() {
    // Google Fonts (Inter + Outfit + Space Mono per the static designs)
    wp_enqueue_style(
        'gildhart-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap',
        array(),
        null
    );

    // Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );

    // Global CSS
    wp_enqueue_style(
        'gildhart-globals',
        GILDHART_URI . '/assets/css/globals.css',
        array( 'font-awesome' ),
        gh_asset_ver( 'assets/css/globals.css' )
    );

    // Theme stylesheet (style.css — metadata only, but WP convention to enqueue)
    wp_enqueue_style(
        'gildhart-style',
        get_stylesheet_uri(),
        array( 'gildhart-globals' ),
        gh_asset_ver( 'style.css' )
    );

    // Navigation (loaded on every page)
    wp_enqueue_style(
        'gildhart-nav',
        GILDHART_URI . '/assets/css/nav.css',
        array( 'gildhart-globals' ),
        gh_asset_ver( 'assets/css/nav.css' )
    );

    wp_enqueue_script(
        'gildhart-nav',
        GILDHART_URI . '/assets/js/nav.js',
        array(),
        gh_asset_ver( 'assets/js/nav.js' ),
        true
    );

    // Footer (loaded on every page)
    wp_enqueue_style(
        'gildhart-footer',
        GILDHART_URI . '/assets/css/footer.css',
        array( 'gildhart-globals' ),
        gh_asset_ver( 'assets/css/footer.css' )
    );

    // ── Per-page assets ───────────────────────────────────────────────
    // About page — shares globals + nav + footer; its own scoped styles.
    if ( is_page_template( 'page-templates/page-about.php' ) ) {
        wp_enqueue_style(
            'gildhart-about',
            GILDHART_URI . '/assets/css/about.css',
            array( 'gildhart-globals' ),
            gh_asset_ver( 'assets/css/about.css' )
        );
    }

    // Privacy Policy page — long-form legal content with scoped styles.
    if ( is_page_template( 'page-templates/page-privacy.php' ) ) {
        wp_enqueue_style(
            'gildhart-privacy',
            GILDHART_URI . '/assets/css/privacy.css',
            array( 'gildhart-globals' ),
            gh_asset_ver( 'assets/css/privacy.css' )
        );
    }

    // Homepage
    if ( is_page_template( 'page-templates/page-home.php' ) ) {
        wp_enqueue_style(
            'gildhart-home',
            GILDHART_URI . '/assets/css/home.css',
            array( 'gildhart-globals' ),
            gh_asset_ver( 'assets/css/home.css' )
        );

        wp_enqueue_script(
            'gildhart-home',
            GILDHART_URI . '/assets/js/home.js',
            array(),
            gh_asset_ver( 'assets/js/home.js' ),
            true
        );
    }

    // Single Service (Flexible Content composed page)
    if ( is_singular( 'service' ) ) {
        wp_enqueue_style(
            'gildhart-service',
            GILDHART_URI . '/assets/css/service.css',
            array( 'gildhart-globals' ),
            gh_asset_ver( 'assets/css/service.css' )
        );

        wp_enqueue_script(
            'gildhart-service',
            GILDHART_URI . '/assets/js/service.js',
            array(),
            gh_asset_ver( 'assets/js/service.js' ),
            true
        );

        // Stripe checkout flow — only enqueue when wp-config.php has
        // the four required constants. If Stripe isn't configured, the
        // form's <button type="submit"> just no-ops gracefully (no JS,
        // no console errors), and the placeholder copy in
        // #svcClosingPaymentEmpty stays visible.
        if ( function_exists( 'gildhart_stripe_is_configured' ) && gildhart_stripe_is_configured() ) {
            wp_enqueue_script(
                'stripe-js',
                'https://js.stripe.com/v3/',
                array(),
                null, // No version pin — Stripe maintains the v3 endpoint indefinitely.
                true
            );
            wp_enqueue_script(
                'gildhart-closing-checkout',
                GILDHART_URI . '/assets/js/closing-checkout.js',
                array( 'stripe-js' ),
                gh_asset_ver( 'assets/js/closing-checkout.js' ),
                true
            );
            wp_localize_script( 'gildhart-closing-checkout', 'GildhartCheckout', array(
                'restUrl'     => esc_url_raw( rest_url( 'gildhart/v1/' ) ),
                'thankYouUrl' => esc_url_raw( home_url( '/agent-thank-you/' ) ),
            ) );
        }

        // WebPro Elite waitlist form — no Stripe, no payment. Just a
        // validated submission that forwards to a Make.com webhook.
        // Enqueued on every single-service page; the JS exits if the
        // form isn't on the page so it's safe to load broadly.
        wp_enqueue_script(
            'gildhart-wpe-waitlist',
            GILDHART_URI . '/assets/js/wpe-waitlist.js',
            array(),
            gh_asset_ver( 'assets/js/wpe-waitlist.js' ),
            true
        );
        wp_localize_script( 'gildhart-wpe-waitlist', 'GildhartWpeWaitlist', array(
            'restUrl' => esc_url_raw( rest_url( 'gildhart/v1/' ) ),
        ) );

        // Playbook one-time checkout flow — enqueued independently of the
        // agent flow, gated on the playbook keys + amount constant. Stripe.js
        // is shared (wp_enqueue_script is idempotent on the same handle).
        if ( function_exists( 'gildhart_stripe_playbook_is_configured' ) && gildhart_stripe_playbook_is_configured() ) {
            wp_enqueue_script(
                'stripe-js',
                'https://js.stripe.com/v3/',
                array(),
                null,
                true
            );
            wp_enqueue_script(
                'gildhart-playbook-checkout',
                GILDHART_URI . '/assets/js/playbook-checkout.js',
                array( 'stripe-js' ),
                gh_asset_ver( 'assets/js/playbook-checkout.js' ),
                true
            );
            wp_localize_script( 'gildhart-playbook-checkout', 'GildhartPlaybookCheckout', array(
                'restUrl'     => esc_url_raw( rest_url( 'gildhart/v1/' ) ),
                'thankYouUrl' => esc_url_raw( home_url( '/playbook-thank-you/' ) ),
            ) );
        }
    }

    // Agent thank-you page template — shares the service.css design
    // system (cream backdrop + halos + brand typography) plus its own
    // small JS for personalising email + plan from the redirect URL.
    if ( is_page_template( 'page-templates/page-agent-thank-you.php' ) ) {
        wp_enqueue_style(
            'gildhart-service',
            GILDHART_URI . '/assets/css/service.css',
            array( 'gildhart-globals' ),
            gh_asset_ver( 'assets/css/service.css' )
        );
        wp_enqueue_script(
            'gildhart-agent-thank-you',
            GILDHART_URI . '/assets/js/agent-thank-you.js',
            array(),
            gh_asset_ver( 'assets/js/agent-thank-you.js' ),
            true
        );
        wp_localize_script( 'gildhart-agent-thank-you', 'GildhartThankYou', array(
            'restUrl' => esc_url_raw( rest_url( 'gildhart/v1/' ) ),
        ) );
    }

    // Playbook thank-you page template — same service.css design system,
    // its own personalisation JS (generic PI-summary reader). Reuses the
    // GildhartThankYou global since the two thank-you templates are
    // mutually exclusive (only one renders per request).
    if ( is_page_template( 'page-templates/page-playbook-thank-you.php' ) ) {
        wp_enqueue_style(
            'gildhart-service',
            GILDHART_URI . '/assets/css/service.css',
            array( 'gildhart-globals' ),
            gh_asset_ver( 'assets/css/service.css' )
        );
        wp_enqueue_script(
            'gildhart-playbook-thank-you',
            GILDHART_URI . '/assets/js/playbook-thank-you.js',
            array(),
            gh_asset_ver( 'assets/js/playbook-thank-you.js' ),
            true
        );
        wp_localize_script( 'gildhart-playbook-thank-you', 'GildhartThankYou', array(
            'restUrl' => esc_url_raw( rest_url( 'gildhart/v1/' ) ),
        ) );
        // The Agent upsell embeds the Live Clients carousel, whose
        // arrows / dots / drag-scroll / lightbox live in service.js —
        // enqueue it here so the carousel behaves as it does on the
        // Agent page.
        wp_enqueue_script(
            'gildhart-service',
            GILDHART_URI . '/assets/js/service.js',
            array(),
            gh_asset_ver( 'assets/js/service.js' ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'gildhart_scripts' );

/**
 * ACF Includes (added in Phase 1)
 */
if ( file_exists( GILDHART_DIR . '/inc/acf-options.php' ) ) {
    require_once GILDHART_DIR . '/inc/acf-options.php';
}

if ( file_exists( GILDHART_DIR . '/inc/acf-fields.php' ) ) {
    require_once GILDHART_DIR . '/inc/acf-fields.php';
}

/**
 * Post type & taxonomy registration (added in Phase 2)
 */
if ( file_exists( GILDHART_DIR . '/inc/post-types.php' ) ) {
    require_once GILDHART_DIR . '/inc/post-types.php';
}

/**
 * Stripe integration — config, SDK loader, helpers, REST endpoints.
 * Reads keys + price IDs from wp-config.php constants. Loads the
 * official Stripe PHP SDK from vendor/stripe-php/ on demand. If the
 * required constants aren't defined the file loads but all helpers
 * no-op gracefully — REST endpoints respond with a 503 instead of
 * fataling.
 */
if ( file_exists( GILDHART_DIR . '/inc/stripe.php' ) ) {
    require_once GILDHART_DIR . '/inc/stripe.php';
}

/**
 * WebPro Elite waitlist — REST endpoint that validates the form and
 * forwards to a Make.com webhook URL set via wp-config. No Stripe.
 */
if ( file_exists( GILDHART_DIR . '/inc/wpe-waitlist.php' ) ) {
    require_once GILDHART_DIR . '/inc/wpe-waitlist.php';
}

/**
 * Admin Reset Content tool — emergency-recovery admin page under
 * Gildhart Settings that wipes stale ACF saved values so PHP defaults
 * can render. To remove the tool entirely, delete this require and
 * the inc/admin-reset.php file.
 */
if ( is_admin() && file_exists( GILDHART_DIR . '/inc/admin-reset.php' ) ) {
    require_once GILDHART_DIR . '/inc/admin-reset.php';
}

/**
 * Helper: Get ACF option field with fallback.
 *
 * Strict null/empty-string check so true_false fields (which return 0 for "No")
 * do not get clobbered by the default. Never change this to empty() or !$value.
 */
function gh_option( $field_name, $default = '' ) {
    if ( function_exists( 'get_field' ) ) {
        $value = get_field( $field_name, 'option' );
        if ( $value === null || $value === '' ) {
            return $default;
        }
        return $value;
    }
    return $default;
}

/**
 * Helper: Get ACF page/post field with fallback.
 */
function gh_field( $field_name, $default = '' ) {
    if ( function_exists( 'get_field' ) ) {
        $value = get_field( $field_name );
        if ( $value === null || $value === '' ) {
            return $default;
        }
        return $value;
    }
    return $default;
}

/**
 * Helper: Get ACF sub-field (inside a Flexible Content row or repeater)
 * with strict null-or-empty default. Use inside have_rows() / the_row().
 */
function gh_sub_field( $field_name, $default = '' ) {
    if ( function_exists( 'get_sub_field' ) ) {
        $value = get_sub_field( $field_name );
        if ( $value === null || $value === '' ) {
            return $default;
        }
        return $value;
    }
    return $default;
}

/**
 * Helper: Auto-prefix a Font Awesome icon class with "fas " when no style
 * prefix is present. ACF users often enter just "fa-arrow-right".
 */
function gh_fa_class( $icon_class ) {
    $icon_class = trim( $icon_class );
    if ( empty( $icon_class ) ) {
        return '';
    }
    if ( preg_match( '/^(fas|far|fab|fal|fad|fat|fass|fasr|fasl|fa-solid|fa-regular|fa-brands|fa-light|fa-duotone|fa-thin|fa-sharp)\s/', $icon_class ) ) {
        return $icon_class;
    }
    if ( strpos( $icon_class, 'fa-' ) === 0 ) {
        return 'fas ' . $icon_class;
    }
    return $icon_class;
}

/**
 * Helper: Logo URL. Falls back: ACF option → custom_logo → SVG default.
 */
function gh_logo_url() {
    $logo_id = gh_option( 'agency_logo' );
    if ( $logo_id ) {
        return wp_get_attachment_image_url( $logo_id, 'full' );
    }
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    if ( $custom_logo_id ) {
        return wp_get_attachment_image_url( $custom_logo_id, 'full' );
    }
    return GILDHART_URI . '/assets/images/logo.svg';
}

/**
 * Helper: Whether a real logo has been uploaded (vs. relying on the SVG fallback).
 * Used so the footer can avoid duplicating "Gildhart" image + text when the
 * fallback SVG (which includes the word "Gildhart") is in use.
 */
function gh_has_uploaded_logo() {
    return (bool) ( gh_option( 'agency_logo' ) || get_theme_mod( 'custom_logo' ) );
}

/**
 * Helper: Agency name.
 */
function gh_agency_name() {
    return gh_option( 'agency_name', 'Gildhart' );
}

/**
 * Helper: Phone number.
 */
function gh_phone() {
    return gh_option( 'agency_phone', '' );
}

/**
 * Helper: Phone link (digits-only) for tel: hrefs.
 */
function gh_phone_link() {
    return preg_replace( '/[^0-9+]/', '', gh_phone() );
}

/**
 * Helper: Email.
 */
function gh_email() {
    return gh_option( 'agency_email', '' );
}

/**
 * Helper: Waitlist URL. Defaults to the local /waitlist/ page.
 */
function gh_waitlist_url() {
    $page = gh_option( 'waitlist_page' );
    if ( $page ) {
        return get_permalink( $page );
    }
    return home_url( '/waitlist/' );
}

/**
 * Helper: default Privacy Policy body HTML.
 *
 * Returned as the fallback for the privacy_content WYSIWYG field so
 * the page renders complete the moment its template is assigned —
 * the admin can then edit any section in the rich-text editor and
 * the saved value will replace this default. Markup uses h2 for the
 * major sections, h3 for sub-headers, p for body, and ul/li for
 * bullets; privacy.css styles each natively.
 */
function gildhart_privacy_default_content() {
    return <<<HTML
<h2>Who We Are</h2>
<p>Gildhart is a trading name of PharmoDigital Ltd, registered in England and Wales.</p>
<p>Company Registration Number: 15341513<br>
VAT Number: 456877926<br>
Registered Office: 1 Richmond Road, Lytham St. Annes on Sea, Lancashire, FY8 1PE<br>
Data Controller: Drew Clayton, Founder<br>
Contact: <a href="mailto:bookings@gildhart.com">bookings@gildhart.com</a></p>

<h2>Your Privacy. Our Responsibility.</h2>
<p>Gildhart is an AI infrastructure company. We build systems for healthcare practices across the UK and beyond. We take data seriously — not because we have to, but because the practices we work with hold their patients to the same standard. This policy explains exactly what we collect, why we collect it, and what we do with it.</p>
<p>This policy applies to gildhart.com and all associated pages, forms, and communications.</p>

<h2>What We Collect And Why</h2>
<h3>When you join the waitlist or purchase a product</h3>
<p>Name, email address, practice name, website URL, and practice type. We use this to process your enquiry or purchase, deliver your product or service, and communicate with you about your engagement with Gildhart. Lawful basis: contract and legitimate interests.</p>
<h3>When you visit our website</h3>
<p>We use cookies and analytics tools including Google Analytics to understand how visitors interact with our site. This may include your IP address, browser type, pages visited, and time on site. Lawful basis: consent, collected via our cookie banner.</p>
<h3>When you sign up to our email list</h3>
<p>Name and email address. We use this to send you information about AI search strategy for healthcare practices. You can unsubscribe at any time using the link in every email. Lawful basis: consent.</p>
<h3>When you contact us directly</h3>
<p>Any information you choose to share by email or contact form. We use this solely to respond to your enquiry. Lawful basis: legitimate interests.</p>

<h2>Who We Share Your Data With</h2>
<p>We do not sell your data. We do not share it with third parties for their own marketing purposes. We use the following third-party processors to operate our business:</p>
<ul>
    <li>Kartra — email marketing and sequence delivery</li>
    <li>Google Analytics — website analytics</li>
    <li>Stripe — payment processing</li>
    <li>Skool — community platform</li>
    <li>Cloudflare — website security and performance</li>
</ul>
<p>Each processor operates under their own privacy policy and data processing terms. We have reviewed each to ensure they meet UK GDPR standards.</p>

<h2>Advertising Platforms</h2>
<p>We run advertising campaigns on LinkedIn and Meta (Facebook and Instagram). These platforms may use cookies or pixels on our website to measure ad performance. We do not pass sensitive health data to these platforms. Our advertising is directed at healthcare business owners and practitioners — not patients. If you have visited our site via an ad, the relevant platform's privacy policy also applies.</p>

<h2>How Long We Keep Your Data</h2>
<ul>
    <li>Waitlist and enquiry data — 24 months from last contact unless an engagement begins</li>
    <li>Customer data — 7 years from the end of the engagement in line with UK financial record-keeping requirements</li>
    <li>Email list — until you unsubscribe or request deletion</li>
    <li>Analytics data — as per Google Analytics default retention settings (26 months)</li>
</ul>

<h2>Your Rights Under UK GDPR</h2>
<p>You have the right to:</p>
<ul>
    <li>Access the personal data we hold about you</li>
    <li>Request correction of inaccurate data</li>
    <li>Request deletion of your data</li>
    <li>Object to processing based on legitimate interests</li>
    <li>Withdraw consent at any time where consent is the lawful basis</li>
    <li>Request restriction of processing</li>
    <li>Data portability where technically feasible</li>
</ul>
<p>To exercise any of these rights contact <a href="mailto:bookings@gildhart.com">bookings@gildhart.com</a>. We will respond within 30 days.</p>
<p>If you are not satisfied with our response you have the right to lodge a complaint with the Information Commissioner's Office at <a href="https://ico.org.uk" target="_blank" rel="noopener noreferrer">ico.org.uk</a>.</p>

<h2>Cookies</h2>
<p>We use the following categories of cookies:</p>
<ul>
    <li>Strictly necessary — required for the site to function. No consent required.</li>
    <li>Analytics — help us understand how visitors use the site. Consent required.</li>
    <li>Marketing — used by advertising platforms to measure campaign performance. Consent required.</li>
</ul>
<p>You can manage your cookie preferences at any time via the cookie banner on our site.</p>

<h2>Data Security</h2>
<p>We use industry-standard security measures to protect your data including SSL encryption, secure hosting via Cloudflare, and restricted internal access. In the event of a data breach we will notify the ICO within 72 hours and affected individuals without undue delay where required.</p>

<h2>Medical Disclaimer</h2>
<p>PharmoDigital Ltd does not provide medical advice of any nature. Nothing on this website constitutes medical, clinical, or regulatory advice. All content produced by Gildhart is for marketing and informational purposes only. PharmoDigital Ltd is not associated with any medical boards or regulatory bodies.</p>

<h2>Changes To This Policy</h2>
<p>We review this policy regularly. The current version is always published at gildhart.com/privacy. Material changes will be communicated to active customers by email.</p>
<p>Last updated: May 2026</p>
HTML;
}

/**
 * Custom excerpt length / more.
 */
function gildhart_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'gildhart_excerpt_length' );

function gildhart_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'gildhart_excerpt_more' );

/**
 * Add page slug as body class for easier per-page CSS overrides.
 */
function gildhart_body_classes( $classes ) {
    if ( is_page() ) {
        global $post;
        $classes[] = 'page-' . $post->post_name;
    }
    if ( is_singular( 'case_study' ) ) {
        $classes[] = 'single-case-study';
    }
    if ( is_singular( 'service' ) ) {
        $classes[] = 'single-service';
        global $post;
        if ( $post ) {
            $classes[] = 'service-' . $post->post_name;
        }
    }
    return $classes;
}
add_filter( 'body_class', 'gildhart_body_classes' );

/**
 * Disable Gutenberg for pages using one of our custom page templates.
 * ACF-only editing experience for template-driven pages.
 */
function gildhart_disable_gutenberg_for_templates( $use_block_editor, $post ) {
    if ( empty( $post->ID ) ) {
        return $use_block_editor;
    }
    $template = get_page_template_slug( $post->ID );
    if ( $template && strpos( $template, 'page-templates/' ) === 0 ) {
        return false;
    }
    return $use_block_editor;
}
add_filter( 'use_block_editor_for_post', 'gildhart_disable_gutenberg_for_templates', 10, 2 );

/**
 * Theme activation: set permalink structure.
 *
 * Standard /%postname%/ is right for an agency site. CPT slugs handle their own
 * prefixes (case-studies/, services/).
 */
function gildhart_activation() {
    update_option( 'permalink_structure', '/%postname%/' );
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'gildhart_activation' );

/**
 * Ensure permalink rules survive plugin updates / Kinsta deployments.
 * Hourly transient prevents re-flushing on every page load.
 */
function gildhart_ensure_permalinks() {
    $desired = '/%postname%/';

    if ( get_option( 'permalink_structure' ) !== $desired ) {
        update_option( 'permalink_structure', $desired );
        flush_rewrite_rules();
        return;
    }

    if ( false === get_transient( 'gh_rewrite_rules_ok' ) ) {
        $rules = get_option( 'rewrite_rules' );
        if ( empty( $rules ) ) {
            flush_rewrite_rules();
        }
        set_transient( 'gh_rewrite_rules_ok', 1, HOUR_IN_SECONDS );
    }
}
add_action( 'init', 'gildhart_ensure_permalinks' );

/**
 * Lossless image handling for premium product visuals.
 *
 * 1. Bump JPEG re-encode quality from WordPress's default 82 → 100. WP
 *    re-saves any uploaded image larger than the big_image_size_threshold
 *    (2560px) AND every generated intermediate size (medium, large, …).
 *    The default 82% strips visible quality on UI mockups — text inside
 *    phone screens picks up mosquito-noise around the edges and cream
 *    backgrounds get faint banding. 100% keeps the bits we asked for.
 *
 * 2. Disable the big_image_size_threshold entirely. By default WP
 *    silently shrinks anything over 2560px on its longest side and
 *    re-saves at the JPEG quality above. For our hero / product visuals
 *    we'd rather serve the original at whatever the editor uploaded —
 *    srcset still emits smaller variants for responsive selection, but
 *    the "full" size really is the original.
 *
 * Together: editors can upload a 4000×3000 PNG mockup and the page
 * serves that exact file when the layout renders the largest variant.
 */
add_filter( 'jpeg_quality',          function () { return 100; } );
add_filter( 'wp_editor_set_quality', function () { return 100; } );
add_filter( 'big_image_size_threshold', '__return_false' );

/**
 * Strip WordPress 6.7's `sizes="auto, …"` prefix from all image output.
 *
 * For lazy-loaded images, WP 6.7 prepends `auto` to the sizes attribute,
 * intending to let the browser pick a srcset variant matching the actual
 * rendered width. In practice, when the image is below the fold at first
 * paint the rendered width evaluates to zero, so the browser picks the
 * smallest srcset entry (300w) and upscales it — producing visible blur.
 *
 * Stripping the `auto,` token returns the browser to the explicit sizes
 * value (or WP's default), which selects the correct variant from the
 * srcset and renders crisply.
 */
add_filter( 'wp_get_attachment_image', function ( $html ) {
    return preg_replace( '/(\bsizes=")auto,\s*/', '$1', $html );
}, 99 );
add_filter( 'wp_content_img_tag', function ( $img ) {
    return preg_replace( '/(\bsizes=")auto,\s*/', '$1', $img );
}, 99 );
