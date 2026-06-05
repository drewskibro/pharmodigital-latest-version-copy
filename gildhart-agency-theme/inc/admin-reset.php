<?php
/**
 * Gildhart — Admin "Reset Content" tool.
 *
 * Emergency-recovery admin page that wipes stale ACF saved values so
 * the theme's PHP defaults can finally render. Built for the specific
 * scenario where a fresh theme deploy lands on a database holding
 * pre-existing ACF content that overrides every new default — saved
 * ACF values always beat default_value / gh_field fallbacks.
 *
 * Three independent resets:
 *   1. Homepage content   — every group_gh_home_* field on the Home
 *      page (the page assigned the page-home.php template).
 *   2. Service pages      — every group_gh_service_* field across all
 *      Service CPT entries.
 *   3. Site settings      — every group_gh_* field stored in
 *      wp_options (branding, contact, social, navigation, footer).
 *
 * Each reset runs via admin-post.php with a nonce + capability check.
 * After a reset, the corresponding sections render purely from the
 * PHP defaults baked into the section template files.
 *
 * To remove this tool entirely: delete this file and the require_once
 * line in functions.php that loads it.
 *
 * @package Gildhart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the Reset Content admin submenu under "Gildhart Settings".
 * Runs after ACF has registered the parent menu (priority 30).
 */
add_action( 'admin_menu', function () {
    add_submenu_page(
        'gildhart-settings',
        'Reset Content',
        'Reset Content',
        'manage_options',
        'gildhart-reset-content',
        'gildhart_render_reset_page'
    );
}, 30 );

/**
 * Render the admin page with three reset forms.
 */
function gildhart_render_reset_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Insufficient permissions.' );
    }

    $notice = isset( $_GET['gh_reset_done'] ) ? sanitize_key( wp_unslash( $_GET['gh_reset_done'] ) ) : '';
    $count  = isset( $_GET['gh_reset_count'] ) ? (int) $_GET['gh_reset_count'] : 0;
    ?>
    <div class="wrap">
        <h1>Reset Content</h1>

        <?php if ( $notice ) : ?>
            <div class="notice notice-success is-dismissible" style="margin-top: 1rem;">
                <p><strong>Reset complete.</strong>
                    <?php
                    switch ( $notice ) {
                        case 'home':     echo esc_html( sprintf( 'Cleared %d homepage field values. Reload the homepage to see the defaults.', $count ) ); break;
                        case 'service':  echo esc_html( sprintf( 'Cleared %d service-page field values across every Service post. Reload any service page to see the defaults.', $count ) ); break;
                        case 'settings': echo esc_html( sprintf( 'Cleared %d site-settings field values (branding, contact, social, navigation, footer). Reload the site to see the defaults.', $count ) ); break;
                        case 'pages':    echo esc_html( sprintf( 'Cleared %d field values on About + Privacy pages. Reload those pages to see the defaults.', $count ) ); break;
                    }
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <p style="font-size: 14px; max-width: 760px;">
            <strong>What this does:</strong> Each button deletes the saved ACF field values for a section of the site, allowing the latest PHP defaults baked into the theme code to render. This is a one-way reset — any content you've explicitly typed into the affected ACF fields will be erased. Media library uploads are untouched.
        </p>

        <hr>

        <h2 style="margin-top: 2rem;">Reset Homepage Content</h2>
        <p>Clears every saved ACF value on the Home page (hero, logo bar, featured case study, split, shift, two-paths, case studies, founder, revenue). Sections will re-render from the theme defaults.</p>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" onsubmit="return confirm('This will erase all saved homepage ACF content. The Home page will then render from theme defaults. Continue?');">
            <input type="hidden" name="action" value="gildhart_reset_home" />
            <?php wp_nonce_field( 'gildhart_reset_home', '_gh_reset_nonce' ); ?>
            <?php submit_button( 'Reset Homepage Content', 'delete', 'submit', false ); ?>
        </form>

        <hr>

        <h2 style="margin-top: 2rem;">Reset Service Pages Content</h2>
        <p>Clears every saved ACF value across all Service posts (Agent, Playbook, The Build — and any others). Every section on every service page will re-render from the theme defaults.</p>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" onsubmit="return confirm('This will erase all saved ACF content across every Service post. Continue?');">
            <input type="hidden" name="action" value="gildhart_reset_service" />
            <?php wp_nonce_field( 'gildhart_reset_service', '_gh_reset_nonce' ); ?>
            <?php submit_button( 'Reset Service Pages Content', 'delete', 'submit', false ); ?>
        </form>

        <hr>

        <h2 style="margin-top: 2rem;">Reset About + Privacy Pages</h2>
        <p>Clears every saved ACF value on the About and Privacy pages. They will re-render from the theme defaults.</p>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" onsubmit="return confirm('This will erase the saved ACF content on the About + Privacy pages. Continue?');">
            <input type="hidden" name="action" value="gildhart_reset_pages" />
            <?php wp_nonce_field( 'gildhart_reset_pages', '_gh_reset_nonce' ); ?>
            <?php submit_button( 'Reset About + Privacy Content', 'delete', 'submit', false ); ?>
        </form>

        <hr>

        <h2 style="margin-top: 2rem;">Reset Site Settings (Footer / Branding / Social)</h2>
        <p>Clears the saved values in Gildhart Settings → Branding / Contact / Social / Navigation / Footer. Defaults defined in code will then render. Useful for the footer copyright + tagline which often carry stale stored values.</p>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" onsubmit="return confirm('This will erase saved values in Branding / Contact / Social / Navigation / Footer. Continue?');">
            <input type="hidden" name="action" value="gildhart_reset_settings" />
            <?php wp_nonce_field( 'gildhart_reset_settings', '_gh_reset_nonce' ); ?>
            <?php submit_button( 'Reset Site Settings', 'delete', 'submit', false ); ?>
        </form>

    </div>
    <?php
}

/**
 * Shared helper — wipe every postmeta row on $post_id whose meta_key
 * starts with any of the given prefixes (or matches their _ partner).
 * ACF stores values as `field_name` and a sibling key reference as
 * `_field_name`; both need to go.
 *
 * @return int Number of postmeta rows deleted.
 */
function gildhart_reset_wipe_postmeta_by_prefix( $post_id, array $prefixes ) {
    global $wpdb;
    $deleted = 0;
    foreach ( $prefixes as $prefix ) {
        $like   = $wpdb->esc_like( $prefix ) . '%';
        $like_u = $wpdb->esc_like( '_' . $prefix ) . '%';
        $rows = $wpdb->query( $wpdb->prepare(
            "DELETE FROM {$wpdb->postmeta} WHERE post_id = %d AND ( meta_key LIKE %s OR meta_key LIKE %s )",
            $post_id, $like, $like_u
        ) );
        $deleted += (int) $rows;
    }
    return $deleted;
}

/**
 * Reset handler — Homepage content.
 * Targets the Home page (any page assigned the page-home.php template).
 */
add_action( 'admin_post_gildhart_reset_home', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Insufficient permissions.' );
    }
    check_admin_referer( 'gildhart_reset_home', '_gh_reset_nonce' );

    $home_pages = get_pages( array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-templates/page-home.php',
        'post_type'  => 'page',
    ) );

    // All known homepage field-name prefixes — covers the hero, logo
    // bar, featured case study, split, shift, two paths, case studies,
    // founder, revenue, plus the close-block on revenue.
    $prefixes = array(
        'hero_', 'logo_bar_', 'featured_case_',
        'split_', 'shift_', 'two_paths_',
        'home_case_', 'case_studies_', 'founder_',
        'revenue_',
    );

    $count = 0;
    foreach ( $home_pages as $page ) {
        $count += gildhart_reset_wipe_postmeta_by_prefix( $page->ID, $prefixes );
    }

    wp_safe_redirect( add_query_arg( array(
        'page'           => 'gildhart-reset-content',
        'gh_reset_done'  => 'home',
        'gh_reset_count' => $count,
    ), admin_url( 'admin.php' ) ) );
    exit;
} );

/**
 * Reset handler — Service pages content.
 * Targets every published Service CPT post.
 */
add_action( 'admin_post_gildhart_reset_service', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Insufficient permissions.' );
    }
    check_admin_referer( 'gildhart_reset_service', '_gh_reset_nonce' );

    $services = get_posts( array(
        'post_type'   => 'service',
        'numberposts' => -1,
        'post_status' => 'any',
        'fields'      => 'ids',
    ) );

    $prefixes = array( 'service_' );

    $count = 0;
    foreach ( $services as $service_id ) {
        $count += gildhart_reset_wipe_postmeta_by_prefix( $service_id, $prefixes );
    }

    wp_safe_redirect( add_query_arg( array(
        'page'           => 'gildhart-reset-content',
        'gh_reset_done'  => 'service',
        'gh_reset_count' => $count,
    ), admin_url( 'admin.php' ) ) );
    exit;
} );

/**
 * Reset handler — About + Privacy pages.
 */
add_action( 'admin_post_gildhart_reset_pages', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Insufficient permissions.' );
    }
    check_admin_referer( 'gildhart_reset_pages', '_gh_reset_nonce' );

    $templates = array( 'page-templates/page-about.php', 'page-templates/page-privacy.php' );
    $prefixes  = array( 'about_', 'privacy_' );

    $count = 0;
    foreach ( $templates as $template ) {
        $pages = get_pages( array(
            'meta_key'   => '_wp_page_template',
            'meta_value' => $template,
            'post_type'  => 'page',
        ) );
        foreach ( $pages as $page ) {
            $count += gildhart_reset_wipe_postmeta_by_prefix( $page->ID, $prefixes );
        }
    }

    wp_safe_redirect( add_query_arg( array(
        'page'           => 'gildhart-reset-content',
        'gh_reset_done'  => 'pages',
        'gh_reset_count' => $count,
    ), admin_url( 'admin.php' ) ) );
    exit;
} );

/**
 * Reset handler — Site settings (options-page ACF values).
 * Targets wp_options entries that ACF writes for option-page fields.
 */
add_action( 'admin_post_gildhart_reset_settings', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Insufficient permissions.' );
    }
    check_admin_referer( 'gildhart_reset_settings', '_gh_reset_nonce' );

    global $wpdb;

    // ACF options-page values are stored as wp_options rows named
    // `options_<fieldname>` plus a `_options_<fieldname>` partner. The
    // theme's option fields cover branding/contact/social/nav/footer.
    $prefixes = array(
        'agency_', 'footer_', 'social_', 'who_we_help_',
        'waitlist_', 'nav_',
    );

    $count = 0;
    foreach ( $prefixes as $prefix ) {
        $like   = 'options_' . $wpdb->esc_like( $prefix ) . '%';
        $like_u = '_options_' . $wpdb->esc_like( $prefix ) . '%';
        $rows = $wpdb->query( $wpdb->prepare(
            "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
            $like, $like_u
        ) );
        $count += (int) $rows;
    }

    wp_safe_redirect( add_query_arg( array(
        'page'           => 'gildhart-reset-content',
        'gh_reset_done'  => 'settings',
        'gh_reset_count' => $count,
    ), admin_url( 'admin.php' ) ) );
    exit;
} );
