<?php
/**
 * Service: The Proof section (Playbook).
 *
 * Light cream section centred around a single Google AI Overview
 * screenshot — Ealing Travel Clinic ranked #1 above Boots and
 * Superdrug. Replaces the previous "Three Practices. Same Result."
 * dark-navy three-case grid.
 *
 * Layout:
 *   1. Gold caps label → big navy headline → grey subhead.
 *   2. Gold caps "Live Google AI Overview" mini-label → featured
 *      screenshot with rounded corners, 1px gold border, and a soft
 *      drop shadow so it floats on the cream backdrop.
 *   3. Three-stat strip below the image (6 weeks / #1 / £0), each
 *      stat = gold 36px figure + small grey caption, divided by
 *      thin vertical gold rules.
 *   4. Closing line below the stat strip.
 *
 * Reads from per-section ACF group `Service · Three Proof Cases`
 * (kept the existing group key so historical metabox menu order
 * stays intact). Returns early when the show toggle is off.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_proof_cases_show', 1 ) ) {
    return;
}

$label    = gh_field( 'service_proof_cases_eyebrow',     'The Proof' );
$headline = gh_field( 'service_proof_cases_headline',    'Not Just AI Platforms. Google Too.' );
$subhead  = gh_field( 'service_proof_cases_subheadline', 'Ealing Travel Clinic ranked #1 in Google AI Overviews for HPV vaccinations. Above Boots. Above Superdrug. In six weeks. Zero ad spend.' );

$image_id    = (int) get_field( 'service_proof_cases_featured_image' );
$image_label = gh_field( 'service_proof_cases_featured_image_label', 'Live Google AI Overview — Ealing Travel Clinic' );

$stats = get_field( 'service_proof_cases_stats' );
if ( empty( $stats ) ) {
    $stats = array(
        array( 'figure' => '6 weeks', 'label' => 'From zero visibility to #1 in Google AI Overviews' ),
        array( 'figure' => '#1',      'label' => 'Above Boots and Superdrug for HPV vaccinations' ),
        array( 'figure' => '£0',      'label' => 'Ad spend behind the ranking' ),
    );
}

$closing = gh_field( 'service_proof_cases_closing', 'This is what the Pillar Domination Framework™ produces. Not paid rankings. Not temporary visibility. Permanent authority on every platform patients now use to make decisions.' );
?>

<section class="svc-proof">
    <div class="svc-proof-inner">
        <?php if ( $label ) : ?>
            <span class="svc-proof-label"><?php echo esc_html( $label ); ?></span>
        <?php endif; ?>
        <?php if ( $headline ) : ?>
            <h2 class="svc-proof-headline"><?php echo esc_html( $headline ); ?></h2>
        <?php endif; ?>
        <?php if ( $subhead ) : ?>
            <p class="svc-proof-subhead"><?php echo esc_html( $subhead ); ?></p>
        <?php endif; ?>

        <?php if ( $image_id ) : ?>
            <div class="svc-proof-image-wrap">
                <?php if ( $image_label ) : ?>
                    <span class="svc-proof-image-label"><?php echo esc_html( $image_label ); ?></span>
                <?php endif; ?>
                <figure class="svc-proof-image">
                    <?php echo wp_get_attachment_image( $image_id, 'full', false, array(
                        'alt'     => esc_attr( $headline ),
                        'loading' => 'lazy',
                    ) ); ?>
                </figure>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $stats ) ) : ?>
            <div class="svc-proof-stats">
                <?php foreach ( $stats as $i => $stat ) :
                    $figure = $stat['figure'] ?? '';
                    $sl     = $stat['label']  ?? '';
                    if ( ! $figure && ! $sl ) continue; ?>
                    <?php if ( $i > 0 ) : ?>
                        <span class="svc-proof-stat-divider" aria-hidden="true"></span>
                    <?php endif; ?>
                    <div class="svc-proof-stat">
                        <?php if ( $figure ) : ?>
                            <span class="svc-proof-stat-figure"><?php echo esc_html( $figure ); ?></span>
                        <?php endif; ?>
                        <?php if ( $sl ) : ?>
                            <span class="svc-proof-stat-label"><?php echo esc_html( $sl ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $closing ) : ?>
            <p class="svc-proof-closing"><?php echo esc_html( $closing ); ?></p>
        <?php endif; ?>
    </div>
</section>
