<?php
/**
 * Service: FAQ section.
 *
 * Dark navy section with an accordion list of question/answer pairs.
 * Each .svc-faq-item carries a numbered gold pill (hidden on mobile),
 * a question line, and a [+] icon that rotates to a gold ✕ when the
 * item opens. service.js wires the click toggle on .svc-faq-question.
 *
 * Below the list, an optional bottom-CTA strip with a tag line and
 * green button echoing the buy-now anchor.
 *
 * Reads from per-section ACF group `Service · FAQ`. Returns early
 * when the show toggle is off. The eyebrow / headline / items / CTA
 * defaults are slug-aware via gildhart_service_faq_defaults() so the
 * Playbook and Agent share the same template + ACF group but each
 * surfaces its own copy. Saved ACF values still win — the slug
 * defaults are only the fallback when fields are empty.
 *
 * Answers accept inline <strong> via wp_kses_post.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_faq_show', 1 ) ) {
    return;
}

$slug     = get_post_field( 'post_name', get_the_ID() );
$defaults = gildhart_service_faq_defaults( $slug );

$eyebrow  = gh_field( 'service_faq_eyebrow',  $defaults['eyebrow'] );
$headline = gh_field( 'service_faq_headline', $defaults['headline'] );

$items = get_field( 'service_faq_items' );
if ( empty( $items ) ) {
    $items = $defaults['items'];
}

$cta_show  = gh_field( 'service_faq_cta_show',  $defaults['cta_show'] );
$cta_text  = gh_field( 'service_faq_cta_text',  $defaults['cta_text'] );
$cta_label = gh_field( 'service_faq_cta_label', $defaults['cta_label'] );
$cta_url   = gh_field( 'service_faq_cta_url',   $defaults['cta_url'] );

// Neither the Agent nor the Playbook shows the FAQ's own built-in CTA.
// The Agent has its Closing Offer checkout; the Playbook now carries
// dedicated interstitial CTA strips (after the Shift, the Levelling,
// and the FAQ) plus the Your Turn form, so the in-FAQ button is
// redundant. Force off regardless of ACF state so a stale saved
// cta_show=1 can't resurrect it.
if ( 'the-agent' === $slug || 'the-playbook' === $slug ) {
    $cta_show = 0;
}
?>

<section class="svc-faq">
    <div class="svc-faq-inner">
        <div class="svc-faq-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-faq-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-faq-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $items ) ) : ?>
            <div class="svc-faq-list">
                <?php foreach ( $items as $i => $item ) :
                    $q = $item['question'] ?? '';
                    $a = $item['answer']   ?? '';
                    if ( ! $q && ! $a ) continue;
                    $num = sprintf( '%02d', $i + 1 );
                    ?>
                    <div class="svc-faq-item">
                        <button class="svc-faq-question" type="button" aria-expanded="false">
                            <span class="svc-faq-question-left">
                                <span class="svc-faq-question-num" aria-hidden="true"><?php echo esc_html( $num ); ?></span>
                                <span class="svc-faq-question-text"><?php echo esc_html( $q ); ?></span>
                            </span>
                            <span class="svc-faq-icon" aria-hidden="true">+</span>
                        </button>
                        <div class="svc-faq-answer">
                            <p class="svc-faq-answer-inner"><?php echo wp_kses_post( $a ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $cta_show && ( $cta_text || $cta_label ) ) : ?>
            <div class="svc-faq-bottom-cta">
                <?php if ( $cta_text ) : ?>
                    <p><?php echo wp_kses_post( $cta_text ); ?></p>
                <?php endif; ?>
                <?php if ( $cta_label ) : ?>
                    <a href="<?php echo esc_url( $cta_url ); ?>">
                        <?php echo esc_html( $cta_label ); ?>
                        <span class="svc-btn-arrow" aria-hidden="true">→</span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
