<?php
/**
 * Section: Hero (homepage)
 *
 * Pulls all copy and image from the B1 ACF group registered against the
 * page-home template. The headline is split on line breaks into three
 * progressively-larger lines (with optional mobile override).
 *
 * @package Gildhart
 */

$eyebrow         = gh_field( 'hero_eyebrow', 'AI Search for Healthcare' );
$headline_d      = gh_field( 'hero_headline_desktop', "National Chains Spend Millions.\nStill Lose to Our\nClients." );
$headline_m      = gh_field( 'hero_headline_mobile' ); // optional override
$subtitle        = gh_field( 'hero_subtitle', "Superior Pharmacy is on track for £500k this year. Built on Claude Code, architected for AI search from day one. Zero ad spend." );
$primary_label   = gh_field( 'hero_primary_cta_label', 'Get The System' );
$primary_url     = gh_field( 'hero_primary_cta_url', '#get-started' );
$secondary_label = gh_field( 'hero_secondary_cta_label', 'See The Proof' );
$secondary_url   = gh_field( 'hero_secondary_cta_url', '#revenue-results' );
$trust_stats     = gh_field( 'hero_trust_stats', '£50M+ Revenue | 1000+ AI Rankings | 50+ Healthcare Clients' );
$image_id        = gh_field( 'hero_image' );

// Split headlines on line breaks, max 3 lines.
$lines_desktop = array_slice( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $headline_d ) ) ), 0, 3 );
$lines_mobile  = $headline_m
    ? array_slice( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $headline_m ) ) ), 0, 3 )
    : $lines_desktop;

// Split trust stats on |
$stats = array_filter( array_map( 'trim', explode( '|', $trust_stats ) ) );
?>

<section class="hero">
    <div class="hero-inner">
        <div class="hero-content">
            <?php if ( $eyebrow ) : ?>
                <p class="hero-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $lines_desktop ) ) : ?>
                <h1 class="hero-title">
                    <span class="desktop-only"><?php
                        foreach ( $lines_desktop as $i => $line ) {
                            $n = $i + 1;
                            echo '<span class="line-' . $n . '">' . esc_html( $line ) . '</span>';
                        }
                    ?></span>
                    <span class="mobile-only"><?php
                        foreach ( $lines_mobile as $i => $line ) {
                            $n = $i + 1;
                            echo '<span class="line-' . $n . '">' . esc_html( $line ) . '</span>';
                        }
                    ?></span>
                </h1>
            <?php endif; ?>

            <?php if ( $subtitle ) : ?>
                <p class="hero-subtitle"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>

            <?php if ( $primary_label || $secondary_label ) : ?>
                <div class="hero-cta">
                    <?php if ( $primary_label ) : ?>
                        <a href="<?php echo esc_url( $primary_url ); ?>" class="btn btn-primary"><?php echo esc_html( $primary_label ); ?></a>
                    <?php endif; ?>
                    <?php if ( $secondary_label ) : ?>
                        <a href="<?php echo esc_url( $secondary_url ); ?>" class="btn btn-outline"><?php echo esc_html( $secondary_label ); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $stats ) ) : ?>
                <p class="hero-trust-stats">
                    <?php
                    $last = count( $stats ) - 1;
                    foreach ( $stats as $i => $stat ) {
                        echo esc_html( $stat );
                        if ( $i < $last ) {
                            echo '<span>|</span>';
                        }
                    }
                    ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if ( $image_id ) : ?>
            <div class="hero-visual">
                <div class="hero-image-stack">
                    <?php
                    echo wp_get_attachment_image(
                        $image_id,
                        'large',
                        false,
                        array(
                            'class'         => 'active',
                            'data-index'    => '0',
                            'loading'       => 'eager',
                            'fetchpriority' => 'high',
                        )
                    );
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
