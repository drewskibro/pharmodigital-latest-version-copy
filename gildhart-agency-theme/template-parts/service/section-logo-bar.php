<?php
/**
 * Service: Logo Bar section.
 *
 * Cream-warm strip directly below the hero. Optional caption above an
 * infinite horizontal scroll of client logos. The logo list is
 * duplicated inline so the CSS animation translates -50% for a
 * seamless loop. Soft cream gradients fade the left/right edges.
 *
 * Reads from per-section ACF group `Service · Logo Bar`. Returns
 * early when the show toggle is off. Falls back to The Agent copy
 * from the static spec when ACF fields are empty. Logos are an ACF
 * gallery — empty = section renders nothing.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_logo_bar_show', 1 ) ) {
    return;
}

$label = gh_field( 'service_logo_bar_label', 'Every practice live is generating enquiries they never had before' );
$logos = get_field( 'service_logo_bar_logos' );

if ( empty( $logos ) ) {
    return; // No logos = no section
}
?>

<section class="svc-logo-bar">
    <?php if ( $label ) : ?>
        <p class="svc-logo-bar-label"><?php echo esc_html( $label ); ?></p>
    <?php endif; ?>
    <div class="svc-logo-bar-track" aria-hidden="false">
        <div class="svc-logo-bar-scroller">
            <?php foreach ( $logos as $logo ) :
                if ( empty( $logo['ID'] ) ) continue; ?>
                <?php echo wp_get_attachment_image( $logo['ID'], 'medium', false, array(
                    'alt'     => esc_attr( $logo['alt'] ?: $logo['title'] ),
                    'loading' => 'lazy',
                ) ); ?>
            <?php endforeach; ?>
            <?php // Duplicate set so the -50% translate loops seamlessly. ?>
            <?php foreach ( $logos as $logo ) :
                if ( empty( $logo['ID'] ) ) continue; ?>
                <?php echo wp_get_attachment_image( $logo['ID'], 'medium', false, array(
                    'alt'     => '',
                    'aria-hidden' => 'true',
                    'loading' => 'lazy',
                ) ); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
