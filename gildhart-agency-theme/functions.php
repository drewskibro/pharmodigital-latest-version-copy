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
