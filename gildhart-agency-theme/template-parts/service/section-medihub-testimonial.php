<?php
/**
 * Service: Medihub LinkedIn testimonial block (Playbook).
 *
 * Dark navy section between The System and Sub-case Proof. Single
 * verified LinkedIn recommendation screenshot, centred, with a
 * gold "FROM THE FIELD" eyebrow and a small caps date / source
 * line beneath. Acts as a "social proof breather" between the
 * system explainer and the proof cases.
 *
 * Reads from per-section ACF group `Service · Medihub Testimonial`.
 * Returns early when the show toggle is off OR when no screenshot
 * has been uploaded — there's no graceful empty state for a single-
 * image testimonial, so we just skip the section entirely.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_medihub_testimonial_show', 1 ) ) {
    return;
}

$eyebrow       = gh_field( 'service_medihub_testimonial_eyebrow', 'From the Field' );
$caption       = gh_field( 'service_medihub_testimonial_caption', 'Verified LinkedIn recommendation · May 2026' );
$screenshot_id = (int) get_field( 'medihub_linkedin_screenshot' );

if ( ! $screenshot_id ) {
    return;
}
?>

<section class="svc-medihub" id="medihub-testimonial">
    <div class="svc-medihub-inner">
        <?php if ( $eyebrow ) : ?>
            <p class="svc-medihub-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
        <?php endif; ?>

        <figure class="svc-medihub-figure">
            <?php echo wp_get_attachment_image( $screenshot_id, 'full', false, array(
                'class'   => 'svc-medihub-image',
                'alt'     => esc_attr( $caption ),
                'loading' => 'lazy',
            ) ); ?>
        </figure>

        <?php if ( $caption ) : ?>
            <p class="svc-medihub-caption"><?php echo esc_html( $caption ); ?></p>
        <?php endif; ?>
    </div>
</section>
