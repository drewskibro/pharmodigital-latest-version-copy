<?php
/**
 * Service: Live Clients Carousel section.
 *
 * Dark navy section with a horizontal-scrolling carousel of client
 * websites — each card = a screenshot of the client's site with our
 * agent widget visible, plus a "Live" gold-pulse badge in the footer.
 * Click a screenshot to open a fullscreen lightbox preview.
 *
 * The carousel + lightbox JS lives in assets/js/service.js (wired up
 * by ID — `liveCarouselTrack`, `saLightbox`). Mobile collapses the
 * carousel to a stacked column and hides the arrow nav.
 *
 * The editorial "On Any Given Day" callout that uses the same ACF
 * field group (eyebrow + footnote) is rendered by its own template
 * — template-parts/service/section-live-callout.php — so the roster
 * can position it independently of the carousel (currently it sits
 * AFTER the testimonial, not directly under the carousel).
 *
 * Reads from per-section ACF group `Service · Live Clients`. Returns
 * early when the show toggle is off OR no cards are populated.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_live_clients_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_live_clients_eyebrow',  'Live Right Now' );
$headline = gh_field( 'service_live_clients_headline', 'The Practices That Saw Where Healthcare Was Going.' );
$sub      = gh_field( 'service_live_clients_sub',      'Seven from our global network, already operating with AI at the core of their patient acquisition. Not piloting it. Not planning it. Running it.' );

$cards = get_field( 'service_live_clients_cards' );
if ( empty( $cards ) ) {
    // Fallback: pull the Agent service post's carousel so this section
    // can be embedded on non-service pages (e.g. the Playbook thank-you
    // upsell) and still render the live-client cards. Header fields use
    // their defaults above, which match the Agent's copy.
    $agent_post = get_page_by_path( 'the-agent', OBJECT, 'service' );
    if ( $agent_post && (int) $agent_post->ID !== (int) get_the_ID() ) {
        $cards = get_field( 'service_live_clients_cards', (int) $agent_post->ID );
    }
}
if ( empty( $cards ) ) {
    return; // No cards = no carousel
}
?>

<section class="svc-live-clients">
    <div class="svc-live-clients-header">
        <?php if ( $eyebrow ) : ?>
            <p class="svc-live-clients-overline"><span><?php echo esc_html( $eyebrow ); ?></span></p>
        <?php endif; ?>
        <?php if ( $headline ) : ?>
            <h2 class="svc-live-clients-headline"><?php echo esc_html( $headline ); ?></h2>
        <?php endif; ?>
        <?php if ( $sub ) : ?>
            <p class="svc-live-clients-sub"><?php echo esc_html( $sub ); ?></p>
        <?php endif; ?>
    </div>

    <div class="svc-live-carousel-wrap">
        <div class="svc-live-carousel-track" id="liveCarouselTrack">
            <?php foreach ( $cards as $card ) :
                $name     = $card['name']  ?? '';
                $image_id = $card['image'] ?? 0;
                $badge    = $card['badge'] ?? 'Live';
                if ( ! $image_id ) continue;
                $img_full = wp_get_attachment_image_url( $image_id, 'full' );
                $img_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?: $name;
                ?>
                <article class="svc-live-card">
                    <button
                        type="button"
                        class="svc-live-card-screenshot svc-lightbox-trigger"
                        data-src="<?php echo esc_url( $img_full ); ?>"
                        data-caption="<?php echo esc_attr( $name ); ?>"
                        aria-label="<?php echo esc_attr( sprintf( 'Open larger preview of %s', $name ) ); ?>"
                    >
                        <?php echo wp_get_attachment_image( $image_id, 'large', false, array(
                            'alt'     => esc_attr( $img_alt ),
                            'loading' => 'lazy',
                        ) ); ?>
                    </button>
                    <div class="svc-live-card-footer">
                        <span class="svc-live-card-name"><?php echo esc_html( $name ); ?></span>
                        <?php if ( $badge ) : ?>
                            <span class="svc-live-card-badge">
                                <span class="svc-live-card-badge-dot" aria-hidden="true"></span>
                                <?php echo esc_html( $badge ); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="svc-carousel-nav">
        <button class="svc-carousel-btn" id="carouselPrev" type="button" aria-label="Previous client">←</button>
        <div class="svc-carousel-progress" id="carouselDots" aria-hidden="true"></div>
        <button class="svc-carousel-btn" id="carouselNext" type="button" aria-label="Next client">→</button>
    </div>

</section>

<?php // Shared lightbox overlay for any .svc-lightbox-trigger on the page. ?>
<div class="svc-lightbox-overlay" id="saLightbox" role="dialog" aria-modal="true" aria-label="Screenshot preview">
    <div class="svc-lightbox-inner">
        <div class="svc-lightbox-img-wrap">
            <img id="saLightboxImg" src="" alt="" />
            <button class="svc-lightbox-close" id="saLightboxClose" type="button" aria-label="Close preview">
                <span class="svc-lightbox-close-x" aria-hidden="true">✕</span> Close
            </button>
        </div>
        <p class="svc-lightbox-caption" id="saLightboxCaption"></p>
    </div>
</div>
