<?php
/**
 * Service: Interstitial CTA strip.
 *
 * A compact, repeatable call-to-action band placed at conviction peaks
 * between sections (after the Sachin narrative, after the Levelling
 * section, after the FAQ). Forest-green band so it stands out against
 * both the navy and cream sections it sits between; cream button scrolls
 * to the Your Turn checkout (#your-turn).
 *
 * Rendered multiple times — the slug 'cta' appears at each desired
 * position in the Playbook roster. All instances share this one ACF
 * group, so editing the copy updates every strip at once (the CTAs are
 * intentionally identical).
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_cta_show', 1 ) ) {
    return;
}

$prompt    = gh_field( 'service_cta_prompt', 'Ready to get on the shortlist?' );
$cta_label = gh_field( 'service_cta_label',  'Get The Playbook — £1,995' );
$cta_url   = gh_field( 'service_cta_url',    '#your-turn' );

if ( ! $cta_label ) {
    return;
}
?>

<section class="svc-cta-strip">
    <div class="svc-cta-strip-inner">
        <?php if ( $prompt ) : ?>
            <p class="svc-cta-strip-prompt"><?php echo esc_html( $prompt ); ?></p>
        <?php endif; ?>
        <a class="svc-cta-strip-btn" href="<?php echo esc_url( $cta_url ); ?>">
            <?php echo esc_html( $cta_label ); ?>
            <span class="svc-cta-strip-arrow" aria-hidden="true">→</span>
        </a>
    </div>
</section>
