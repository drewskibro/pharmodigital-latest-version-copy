<?php
/**
 * Service: WebPro Elite — Intro / Positioning section.
 *
 * Two-column editorial block on warm cream: positioning copy on the
 * left (eyebrow, headline, multi-paragraph body, emphasis line, CTA),
 * three client proof cards stacked on the right. Collapses to a single
 * column at <960px. Soft forest-green + gold radial halos wash the
 * background so the cream reads as a deliberate brand surface.
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

$eyebrow  = gh_field( 'service_wpe_intro_eyebrow',  'What WebPro Elite Is' );
$headline = gh_field( 'service_wpe_intro_headline', "Every Other Agency Builds You a Website.\nWe Build You a Patient Acquisition Engine." );
$body     = gh_field( 'service_wpe_intro_body', "Most healthcare websites were built to exist, not to perform. They look acceptable, they load, they have a contact form. And they bring in almost nothing. Not because the practice isn't good enough. Because the website was never built to do what AI search now demands.\n\nWebPro Elite is built differently — on Claude Code, the same AI infrastructure that powers the most advanced content systems in the world. That's not a technology choice for the sake of it. It's the reason our sites get found by AI platforms that other agency builds never will.\n\nEvery site below is currently ranking on Google, featured in ChatGPT, and generating revenue. Built once. Compounding every month." );
$emphasis = gh_field( 'service_wpe_intro_emphasis', 'The website is the foundation. The framework is what generates revenue. You get both.' );
$cta_label = gh_field( 'service_wpe_intro_cta_label', 'See The Builds Behind The Results' );
$cta_url   = gh_field( 'service_wpe_intro_cta_url',   '#portfolio' );

$cards = get_field( 'service_wpe_intro_cards' );
if ( empty( $cards ) ) {
    $cards = array(
        array(
            'client' => 'Ealing Travel Clinic',
            'stat'   => '300% Revenue Growth',
            'desc'   => 'Zero AI visibility to #1 in Google AI Overviews for travel vaccinations. Six weeks. Zero ad spend. Now generating £100k from HPV vaccinations alone.',
        ),
        array(
            'client' => 'Superior Pharmacy',
            'stat'   => 'On Track For £500k This Year',
            'desc'   => 'Built on WebPro Elite. First ChatGPT sale within 48 hours of launch. Now 50% of all revenue comes from AI search. Two-person team. No ad spend.',
        ),
        array(
            'client' => 'Puri Pharmacy',
            'stat'   => '#1 UK Mounjaro Provider',
            'desc'   => 'Independent pharmacy outranking national chains for their most valuable search terms. Built from scratch on WebPro Elite. Now taking that presence national.',
        ),
    );
}

// Split body on blank lines into paragraphs.
$body_paras = array_filter( array_map( 'trim', preg_split( '/\r\n\r\n|\r\r|\n\n/', $body ) ) );

// Split headline on newlines for the <br> stack.
$headline_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $headline ) ) );
?>

<section class="svc-wpe-intro" id="about">
    <div class="svc-wpe-intro-inner">

        <div class="svc-wpe-intro-copy">
            <?php if ( $eyebrow ) : ?>
                <span class="svc-wpe-intro-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>

            <?php if ( ! empty( $headline_lines ) ) : ?>
                <h2 class="svc-wpe-intro-headline">
                    <?php echo esc_html( implode( ' ', $headline_lines ) ); ?>
                </h2>
            <?php endif; ?>

            <?php foreach ( $body_paras as $para ) : ?>
                <p class="svc-wpe-intro-body"><?php echo esc_html( $para ); ?></p>
            <?php endforeach; ?>

            <?php if ( $emphasis ) : ?>
                <p class="svc-wpe-intro-emphasis"><?php echo esc_html( $emphasis ); ?></p>
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
                $client = $card['client'] ?? '';
                $stat   = $card['stat']   ?? '';
                $desc   = $card['desc']   ?? '';
                if ( ! $client && ! $stat && ! $desc ) {
                    continue;
                } ?>
                <div class="svc-wpe-intro-card">
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
