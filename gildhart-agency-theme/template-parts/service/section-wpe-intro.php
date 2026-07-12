<?php
/**
 * Service: WebPro Elite — Intro / Positioning section.
 *
 * Two-column editorial block on warm cream: left column moves through
 * para_1 → interrupt statement (dark navy, sits big and disrupts the
 * flow) → para_2 → closing (three stacked one-line "blows"). Right
 * column carries three proof cards in a two-flankers + one-anchor
 * hierarchy: cards 1 and 3 keep the white + gold-left-accent treatment,
 * card 2 is the featured anchor (forest green ground, gold border,
 * larger padding, gold "Flagship Result" badge). Each card opens with
 * an oversized gold stat figure ("#1", "£500k", "#1 UK") before the
 * client name.
 *
 * Collapses to a single column at <960px; cards keep the same
 * hierarchy and the featured card stays visually heavier on mobile.
 *
 * Reads from per-section ACF group `Service · WPE Intro` (defaults
 * baked in here so the section renders complete with no data entry).
 * Returns early when the show toggle is off.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_wpe_intro_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_wpe_intro_eyebrow',  'What The Build Is' );
$headline = gh_field( 'service_wpe_intro_headline', 'Every Other Agency Builds You a Website. We Build You a Patient Acquisition Engine.' );

$para_1 = gh_field( 'service_wpe_intro_para_1', 'Most healthcare websites were built to exist. They look acceptable. They load. They have a contact form. They were built for a version of the internet that no longer works the way it did.' );

$interrupt = gh_field( 'service_wpe_intro_interrupt', 'Google still matters. But Google now surfaces AI answers before it surfaces websites. ChatGPT, Claude, and Perplexity are where patients go next. And most healthcare websites aren\'t built to appear in any of them.' );

$para_2 = gh_field( 'service_wpe_intro_para_2', 'The Build is built on Claude Code — the same AI infrastructure that powers the most advanced content systems in the world. Every page is structured to be cited by AI platforms. Every service is architected to answer the exact questions patients are asking right now.' );

$closing = gh_field( 'service_wpe_intro_closing', "The website is the foundation.\nThe framework is what generates revenue.\nYou get both." );

$cta_label = gh_field( 'service_wpe_intro_cta_label', 'See The Builds Behind The Results' );
$cta_url   = gh_field( 'service_wpe_intro_cta_url',   '#portfolio' );

$cards = get_field( 'service_wpe_intro_cards' );
if ( empty( $cards ) ) {
    $cards = array(
        array(
            'figure'         => '#1',
            'client'         => 'Ealing Travel Clinic',
            'stat'           => '300% Revenue Growth',
            'desc'           => 'Zero AI visibility to #1 in Google AI Overviews for travel vaccinations. Six weeks. Zero ad spend. Now generating £99k from HPV vaccinations alone.',
            'featured'       => 0,
            'flagship_label' => '',
        ),
        array(
            'figure'         => '£500k',
            'client'         => 'Superior Pharmacy',
            'stat'           => 'On Track For £500k This Year',
            'desc'           => 'Built on The Build. First ChatGPT sale within 48 hours of launch. Now 50% of all revenue comes from AI search. Two-person team. No ad spend.',
            'featured'       => 1,
            'flagship_label' => 'Flagship Result',
        ),
        array(
            'figure'         => '#1 UK',
            'client'         => 'Puri Pharmacy',
            'stat'           => '#1 UK Mounjaro Provider',
            'desc'           => 'Independent pharmacy outranking national chains for their most valuable search terms. Built from scratch on The Build. Now taking that presence national.',
            'featured'       => 0,
            'flagship_label' => '',
        ),
    );
}

// Closing lines render as a stacked sequence — one line per blow.
$closing_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $closing ) ) );

// Headline supports legacy newlines from the previous field; collapse to spaces.
$headline_clean = trim( preg_replace( '/\s+/', ' ', $headline ) );
?>

<section class="svc-wpe-intro" id="about">
    <div class="svc-wpe-intro-inner">

        <div class="svc-wpe-intro-copy">
            <?php if ( $eyebrow ) : ?>
                <span class="svc-wpe-intro-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>

            <?php if ( $headline_clean ) : ?>
                <h2 class="svc-wpe-intro-headline"><?php echo esc_html( $headline_clean ); ?></h2>
            <?php endif; ?>

            <?php if ( $para_1 ) : ?>
                <p class="svc-wpe-intro-body"><?php echo esc_html( $para_1 ); ?></p>
            <?php endif; ?>

            <?php if ( $interrupt ) : ?>
                <p class="svc-wpe-intro-interrupt"><?php echo esc_html( $interrupt ); ?></p>
            <?php endif; ?>

            <?php if ( $para_2 ) : ?>
                <p class="svc-wpe-intro-body"><?php echo esc_html( $para_2 ); ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $closing_lines ) ) : ?>
                <div class="svc-wpe-intro-closing">
                    <?php foreach ( $closing_lines as $line ) : ?>
                        <p class="svc-wpe-intro-closing-line"><?php echo esc_html( $line ); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( $cta_label ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="svc-btn svc-btn-primary svc-wpe-intro-cta">
                    <?php echo esc_html( $cta_label ); ?>
                    <span class="svc-btn-arrow" aria-hidden="true">→</span>
                </a>
            <?php endif; ?>
        </div>

        <div class="svc-wpe-intro-proof">
            <?php foreach ( $cards as $card ) :
                $figure         = $card['figure']         ?? '';
                $client         = $card['client']         ?? '';
                $stat           = $card['stat']           ?? '';
                $desc           = $card['desc']           ?? '';
                $featured       = ! empty( $card['featured'] );
                $flagship_label = $card['flagship_label'] ?? '';
                if ( ! $client && ! $stat && ! $desc && ! $figure ) {
                    continue;
                }
                $card_classes = 'svc-wpe-intro-card';
                if ( $featured ) {
                    $card_classes .= ' svc-wpe-intro-card--featured';
                }
                ?>
                <div class="<?php echo esc_attr( $card_classes ); ?>">
                    <?php if ( $featured && $flagship_label ) : ?>
                        <span class="svc-wpe-intro-card-flagship"><?php echo esc_html( $flagship_label ); ?></span>
                    <?php endif; ?>
                    <?php if ( $figure ) : ?>
                        <p class="svc-wpe-intro-card-figure"><?php echo esc_html( $figure ); ?></p>
                    <?php endif; ?>
                    <?php if ( $client ) : ?>
                        <p class="svc-wpe-intro-card-client"><?php echo esc_html( $client ); ?></p>
                    <?php endif; ?>
                    <?php if ( $stat ) : ?>
                        <p class="svc-wpe-intro-card-stat"><?php echo esc_html( $stat ); ?></p>
                    <?php endif; ?>
                    <?php if ( $desc ) : ?>
                        <p class="svc-wpe-intro-card-desc"><?php echo esc_html( $desc ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
