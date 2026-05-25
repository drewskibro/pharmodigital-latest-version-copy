<?php
/**
 * Service: FluClinic2You AI-search proof section (Playbook).
 *
 * Dark navy proof beat that sits immediately before the Your Turn
 * checkout. A fresh, different-vertical result — corporate flu,
 * FluClinic2You ranked above Bupa & Boots in Google AI Overviews /
 * ChatGPT / Claude — reinforcing "this works in ANY specialism"
 * right before the buy decision.
 *
 * Structure: eyebrow → H2 → body paragraph → "It took four weeks."
 * gut-punch line → AI Overview screenshot (ACF image, hides when
 * empty) → closing line → three-stat bar (gold dividers on desktop,
 * stacked on mobile).
 *
 * Reads from per-section ACF group `Service · FluClinic Proof`.
 * Returns early when the show toggle is off.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_fluclinic_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_fluclinic_eyebrow',  'Four Weeks. Three Platforms. One Independent Clinic.' );
$headline = gh_field( 'service_fluclinic_headline', 'FluClinic2You Now Outranks Bupa and Boots for Corporate Flu.' );
$body     = gh_field( 'service_fluclinic_body',     'Not in traditional search. In Google AI Overviews, ChatGPT, and Claude simultaneously. When a business searches "best corporate flu provider" — FluClinic2You is the answer AI gives them. Above Bupa. Above Boots. Above every corporate health conglomerate with a marketing budget that dwarfs anything an independent clinic could match.' );
$punch    = gh_field( 'service_fluclinic_punch',    'It took four weeks.' );
$closing  = gh_field( 'service_fluclinic_closing',  "This isn't a pharmacy story. This isn't a travel clinic story. This is what the system does — in any healthcare specialism, for any independent practice, against any competitor regardless of size." );

$screenshot_id = (int) get_field( 'fluclinic_gai_screenshot' );

$stats = get_field( 'service_fluclinic_stats' );
if ( empty( $stats ) ) {
    $stats = array(
        array( 'value' => '4',  'label' => 'Weeks to outrank Bupa and Boots' ),
        array( 'value' => '3',  'label' => 'AI platforms simultaneously' ),
        array( 'value' => '#1', 'label' => 'Google AI Overview' ),
    );
}
?>

<section class="svc-fcp" id="fluclinic-proof">
    <div class="svc-fcp-inner">
        <?php if ( $eyebrow ) : ?>
            <p class="svc-fcp-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
        <?php endif; ?>
        <?php if ( $headline ) : ?>
            <h2 class="svc-fcp-headline"><?php echo esc_html( $headline ); ?></h2>
        <?php endif; ?>
        <?php if ( $body ) : ?>
            <p class="svc-fcp-body"><?php echo esc_html( $body ); ?></p>
        <?php endif; ?>
        <?php if ( $punch ) : ?>
            <p class="svc-fcp-punch"><?php echo esc_html( $punch ); ?></p>
        <?php endif; ?>

        <?php if ( $screenshot_id ) : ?>
            <figure class="svc-fcp-figure">
                <?php echo wp_get_attachment_image( $screenshot_id, 'large', false, array(
                    'class'   => 'svc-fcp-image',
                    'alt'     => esc_attr( $headline ),
                    'loading' => 'lazy',
                ) ); ?>
            </figure>
        <?php endif; ?>

        <?php if ( $closing ) : ?>
            <p class="svc-fcp-closing"><?php echo esc_html( $closing ); ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $stats ) ) : ?>
            <div class="svc-fcp-stats">
                <?php foreach ( $stats as $stat ) :
                    $value = $stat['value'] ?? '';
                    $label = $stat['label'] ?? '';
                    if ( ! $value && ! $label ) continue; ?>
                    <div class="svc-fcp-stat">
                        <?php if ( $value ) : ?>
                            <span class="svc-fcp-stat-value"><?php echo esc_html( $value ); ?></span>
                        <?php endif; ?>
                        <?php if ( $label ) : ?>
                            <span class="svc-fcp-stat-label"><?php echo esc_html( $label ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
