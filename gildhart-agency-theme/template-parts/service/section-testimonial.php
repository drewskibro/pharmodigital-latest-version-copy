<?php
/**
 * Service: Testimonial section.
 *
 * Cream-warm two-column section with a portrait photo on the left
 * (with a gold-pulse "client kind" badge below it) and the quote on
 * the right — gold quotation mark, body quote with inline <strong> +
 * <em> accents (em renders forest-green), gold gradient divider, and
 * name + role meta.
 *
 * Reads from per-section ACF group `Service · Testimonial`. Returns
 * early when the show toggle is off. Falls back to the Rahul Puri /
 * Puri Pharmacy testimonial from the static spec.
 *
 * Generic enough that other services can reuse it for their own
 * testimonials — the badge text, photo, quote, and meta are all ACF-
 * controlled.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_testimonial_show', 1 ) ) {
    return;
}

$photo_id = get_field( 'service_testimonial_photo' );
$badge    = gh_field( 'service_testimonial_badge', 'Pharmacy Client' );
$quote    = gh_field( 'service_testimonial_quote', "<strong>We're now outranking Boots and major chains in our area.</strong> But what changed everything was the AI sales agent. It handles patient inquiries around the clock, converts the traffic we're driving, and books appointments without us lifting a finger.\n\nWe're now <em>taking that national.</em>\n\nDrew builds pharmacy growth engines. <strong>I trust him because he understands both pharmacy and digital, that's rare to find.</strong>" );
$name     = gh_field( 'service_testimonial_name', 'Rahul Puri' );
$role     = gh_field( 'service_testimonial_role', 'Owner, Puri Pharmacy' );

// Quote can be authored with blank lines as paragraph breaks; render
// each chunk as its own block separated by <br><br> so inline
// <strong> + <em> pass through wp_kses_post intact.
$quote_html = '';
if ( $quote ) {
    $paragraphs = preg_split( '/\r\n\r\n|\r\r|\n\n/', $quote );
    $paragraphs = array_filter( array_map( 'trim', $paragraphs ) );
    $quote_html = implode( '<br /><br />', array_map( 'wp_kses_post', $paragraphs ) );
}
?>

<section class="svc-testimonial">
    <div class="svc-testimonial-inner">
        <?php if ( $photo_id || $badge ) : ?>
            <div class="svc-testimonial-photo-col">
                <?php if ( $photo_id ) : ?>
                    <div class="svc-testimonial-photo-wrap">
                        <?php echo wp_get_attachment_image( $photo_id, 'medium_large', false, array(
                            'alt'     => esc_attr( $name ),
                            'loading' => 'lazy',
                        ) ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( $badge ) : ?>
                    <div class="svc-testimonial-badge">
                        <span class="svc-testimonial-badge-dot" aria-hidden="true"></span>
                        <?php echo esc_html( $badge ); ?>
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
