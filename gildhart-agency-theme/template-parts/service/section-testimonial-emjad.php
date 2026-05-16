<?php
/**
 * Service: Emjad Dubaissi testimonial section.
 *
 * Standalone second-feature testimonial that sits directly above the
 * closing offer on the Agent page. Mirrors section-testimonial.php
 * exactly — same two-column layout, same photo + metric card on the
 * left, same quote + divider + name/role on the right, same CSS
 * classes — so the visual treatment is identical to the Rahul Puri
 * block. Only the data source is different: this section reads from
 * its own ACF group (Service · Testimonial — Emjad) so it can coexist
 * with the Rahul Puri block without colliding on field names.
 *
 * Reads from per-section ACF group `Service · Testimonial — Emjad`.
 * Returns early when the show toggle is off. Falls back to the Emjad
 * copy from the spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_testimonial_emjad_show', 1 ) ) {
    return;
}

$photo_id     = get_field( 'service_testimonial_emjad_photo' );
$metric_value = gh_field( 'service_testimonial_emjad_metric_value', 'Two Sites' );
$metric_label = gh_field( 'service_testimonial_emjad_metric_label', 'Fully Automated' );
$quote        = gh_field( 'service_testimonial_emjad_quote', "We're on page one for Mounjaro in Swansea and the agent is converting that traffic into enquiries every day. Both sites, all the different services — it routes everything to the right place. We just deal with the enquiries." );
$name         = gh_field( 'service_testimonial_emjad_name', 'Emjad Dubaissi' );
$role         = gh_field( 'service_testimonial_emjad_role', 'Founder, Medihub Pharmacy Group' );

// Same paragraph-split treatment as section-testimonial.php so editors
// can author blank-line breaks and still pass inline <strong>/<em>
// through wp_kses_post.
$quote_html = '';
if ( $quote ) {
    $paragraphs = preg_split( '/\r\n\r\n|\r\r|\n\n/', $quote );
    $paragraphs = array_filter( array_map( 'trim', $paragraphs ) );
    $quote_html = implode( '<br /><br />', array_map( 'wp_kses_post', $paragraphs ) );
}
?>

<section class="svc-testimonial">
    <div class="svc-testimonial-inner">
        <?php if ( $photo_id || $metric_value ) : ?>
            <div class="svc-testimonial-photo-col">
                <?php if ( $photo_id ) : ?>
                    <div class="svc-testimonial-photo-wrap">
                        <?php echo wp_get_attachment_image( $photo_id, 'medium_large', false, array(
                            'alt'     => esc_attr( $name ),
                            'loading' => 'lazy',
                        ) ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( $metric_value || $metric_label ) : ?>
                    <div class="svc-testimonial-metric">
                        <?php if ( $metric_value ) : ?>
                            <span class="svc-testimonial-metric-value"><?php echo esc_html( $metric_value ); ?></span>
                        <?php endif; ?>
                        <?php if ( $metric_label ) : ?>
                            <span class="svc-testimonial-metric-label"><?php echo esc_html( $metric_label ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="svc-testimonial-content">
            <span class="svc-testimonial-quote-mark" aria-hidden="true">&ldquo;</span>
            <?php if ( $quote_html ) : ?>
                <p class="svc-testimonial-quote"><?php echo $quote_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — already filtered ?></p>
            <?php endif; ?>
            <div class="svc-testimonial-divider" aria-hidden="true"></div>
            <?php if ( $name || $role ) : ?>
                <div class="svc-testimonial-meta">
                    <?php if ( $name ) : ?>
                        <span class="svc-testimonial-name"><?php echo esc_html( $name ); ?></span>
                    <?php endif; ?>
                    <?php if ( $role ) : ?>
                        <span class="svc-testimonial-role"><?php echo esc_html( $role ); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
