<?php
/**
 * Header — Gildhart Agency.
 *
 * Renders the fixed top navigation:
 *  - Logo (ACF option → custom_logo → SVG fallback)
 *  - "Who We Help" dropdown (ACF repeater of audience segments)
 *  - "Our Work" dropdown (auto-populated from `service` CPT — Phase 2)
 *  - "The Proof" dropdown (auto-populated from `case_study` CPT — Phase 2)
 *  - About link
 *  - Waitlist CTA
 *  - Mobile hamburger drawer mirroring the same structure
 *
 * @package Gildhart
 */

$logo_url       = gh_logo_url();
$agency_name    = gh_agency_name();
$home_url       = esc_url( home_url( '/' ) );
$about_url      = esc_url( home_url( '/about/' ) );
$waitlist_label = gh_option( 'waitlist_label', 'Join The Waitlist' );
$waitlist_page  = gh_option( 'waitlist_page' );
$waitlist_url   = $waitlist_page ? esc_url( get_permalink( $waitlist_page ) ) : esc_url( gh_waitlist_url() );

$who_we_help    = gh_option( 'who_we_help_items', array() );

// "Our Work" — services CPT (will return empty until Phase 2 + content is added)
$services_query = new WP_Query( array(
    'post_type'      => 'service',
    'posts_per_page' => 8,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
) );

// "The Proof" — case studies CPT
$case_studies_query = new WP_Query( array(
    'post_type'      => 'case_study',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish',
) );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'gildhart' ); ?></a>

<nav class="nav" id="mainNav">
    <div class="nav-inner">
        <a href="<?php echo $home_url; ?>" class="nav-brand" aria-label="<?php echo esc_attr( $agency_name ); ?>">
            <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $agency_name ); ?>" width="80" height="80" loading="eager" decoding="async" fetchpriority="high">
        </a>

        <div class="nav-links">
            <?php if ( ! empty( $who_we_help ) ) : ?>
            <div class="nav-dropdown">
                <button class="nav-dropdown-trigger" type="button">Who We Help <span class="dd-arrow">▼</span></button>
                <div class="nav-dropdown-menu">
                    <?php foreach ( $who_we_help as $item ) : ?>
                        <a href="<?php echo esc_url( $item['url'] ); ?>" class="dd-item">
                            <span class="dd-item-name"><?php echo esc_html( $item['label'] ); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ( $services_query->have_posts() ) : ?>
            <div class="nav-dropdown">
                <button class="nav-dropdown-trigger" type="button">Our Work <span class="dd-arrow">▼</span></button>
                <div class="nav-dropdown-menu">
                    <?php while ( $services_query->have_posts() ) : $services_query->the_post();
                        $sub = gh_field( 'service_nav_subtitle' );
                        ?>
                        <a href="<?php the_permalink(); ?>" class="dd-item">
                            <span class="dd-item-name"><?php the_title(); ?></span>
                            <?php if ( $sub ) : ?>
                                <span class="dd-item-sub"><?php echo esc_html( $sub ); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="nav-links-right">
            <?php if ( $case_studies_query->have_posts() ) : ?>
            <div class="nav-dropdown">
                <button class="nav-dropdown-trigger" type="button">The Proof <span class="dd-arrow">▼</span></button>
                <div class="nav-dropdown-menu">
                    <span class="dd-section-label">Client Results</span>
                    <?php while ( $case_studies_query->have_posts() ) : $case_studies_query->the_post();
                        $sub = gh_field( 'case_study_nav_subtitle' );
                        ?>
                        <a href="<?php the_permalink(); ?>" class="dd-item">
                            <span class="dd-item-name"><?php the_title(); ?></span>
                            <?php if ( $sub ) : ?>
                                <span class="dd-item-sub"><?php echo esc_html( $sub ); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
            <?php endif; ?>

            <a href="<?php echo $about_url; ?>">About</a>
            <a href="<?php echo $waitlist_url; ?>" class="nav-cta"><?php echo esc_html( $waitlist_label ); ?></a>
        </div>

        <button class="nav-hamburger" aria-label="Open navigation menu" aria-expanded="false">
            <svg class="ham-open" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg class="ham-close" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>
</nav>

<div class="nav-spacer" id="navSpacer"></div>

<div class="nav-mobile-overlay" id="mobileNavOverlay">
    <div class="mobile-menu-content">

        <?php if ( ! empty( $who_we_help ) ) : ?>
        <button class="mobile-nav-section-trigger" data-accordion type="button">
            Who We Help <span class="mobile-dd-arrow">▾</span>
        </button>
        <div class="mobile-dd-panel">
            <?php foreach ( $who_we_help as $item ) : ?>
                <a href="<?php echo esc_url( $item['url'] ); ?>" class="mobile-dd-item">
                    <span class="mobile-dd-item-name"><?php echo esc_html( $item['label'] ); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php
        // Re-run service query for the mobile drawer
        $services_query_m = new WP_Query( array(
            'post_type'      => 'service',
            'posts_per_page' => 8,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'post_status'    => 'publish',
        ) );
        if ( $services_query_m->have_posts() ) :
        ?>
        <button class="mobile-nav-section-trigger" data-accordion type="button">
            Our Work <span class="mobile-dd-arrow">▾</span>
        </button>
        <div class="mobile-dd-panel">
            <?php while ( $services_query_m->have_posts() ) : $services_query_m->the_post();
                $sub = gh_field( 'service_nav_subtitle' );
                ?>
                <a href="<?php the_permalink(); ?>" class="mobile-dd-item">
                    <span class="mobile-dd-item-name"><?php the_title(); ?></span>
                    <?php if ( $sub ) : ?>
                        <span class="mobile-dd-item-sub"><?php echo esc_html( $sub ); ?></span>
                    <?php endif; ?>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>

        <?php
        // Re-run case-study query for the mobile drawer
        $case_studies_query_m = new WP_Query( array(
            'post_type'      => 'case_study',
            'posts_per_page' => 8,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_status'    => 'publish',
        ) );
        if ( $case_studies_query_m->have_posts() ) :
        ?>
        <button class="mobile-nav-section-trigger" data-accordion type="button">
            The Proof <span class="mobile-dd-arrow">▾</span>
        </button>
        <div class="mobile-dd-panel">
            <span class="mobile-dd-category-label">Client Results</span>
            <?php while ( $case_studies_query_m->have_posts() ) : $case_studies_query_m->the_post();
                $sub = gh_field( 'case_study_nav_subtitle' );
                ?>
                <a href="<?php the_permalink(); ?>" class="mobile-dd-item">
                    <span class="mobile-dd-item-name"><?php the_title(); ?></span>
                    <?php if ( $sub ) : ?>
                        <span class="mobile-dd-item-sub"><?php echo esc_html( $sub ); ?></span>
                    <?php endif; ?>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>

        <a href="<?php echo $about_url; ?>" class="mobile-nav-plain-link">About</a>

        <div class="mobile-menu-spacer"></div>
    </div>

    <div class="mobile-menu-cta-wrapper">
        <a href="<?php echo $waitlist_url; ?>" class="mobile-nav-cta"><?php echo esc_html( $waitlist_label ); ?></a>
    </div>
</div>
