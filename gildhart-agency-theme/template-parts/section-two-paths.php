<?php
/**
 * Section: Three-tier pricing cards (homepage).
 *
 * Three product cards arranged in a row. Card 2 ("is_featured") gets the
 * forest-green hero treatment with reversed gold-button CTA. Card 3
 * ("is_dark") gets the navy treatment for the always-on agent product.
 * Card 1 stays cream as the entry-level offer.
 *
 * Each card supports: optional hero image at the very top (flush, top
 * corners rounded), banner (outer cards only), kicker, eyebrow label,
 * title, proof body, numeric proof anchor, bullets, price + italic note,
 * CTA. Tick icons removed by design — bullets render bare on outer cards
 * and with a gold em-dash on the hero card.
 *
 * Cards stagger in via .tp-visible (added per-card by home.js).
 *
 * @package Gildhart
 */

$eyebrow     = gh_field( 'two_paths_eyebrow', 'CHOOSE YOUR ENTRY POINT' );
$headline    = gh_field( 'two_paths_headline' );
$subheadline = gh_field( 'two_paths_subheadline' );
$cards       = gh_field( 'two_paths_cards', array() );
// Trust line beneath the cards was removed — the field is still
// registered in ACF so any saved value isn't orphaned, but nothing
// renders here.

if ( empty( $cards ) ) {
    return;
}
?>

<section class="two-paths-section" id="get-started">
    <div class="two-paths-inner">

        <?php if ( $eyebrow || $headline || $subheadline ) : ?>
            <div class="two-paths-header">
                <?php if ( $eyebrow ) : ?>
                    <p class="two-paths-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="two-paths-headline"><?php echo esc_html( $headline ); ?></h2>
                <?php endif; ?>
                <?php if ( $subheadline ) : ?>
                    <p class="two-paths-subheadline"><?php echo esc_html( $subheadline ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="two-paths-grid">
            <?php foreach ( $cards as $card ) :
                $banner       = $card['banner']       ?? '';
                $is_hero      = ! empty( $card['is_featured'] );
                $is_dark      = ! empty( $card['is_dark'] );
                $image_id     = $card['image']        ?? 0;
                $kicker       = $card['kicker']       ?? '';
                $label        = $card['label']        ?? '';
                $title        = $card['title']        ?? '';
                $body         = $card['body']         ?? '';
                $proof_num    = $card['proof_number'] ?? '';
                $proof_label  = $card['proof_label']  ?? '';
                $features     = $card['features']     ?? array();
                $price_value  = $card['price_value']  ?? '';
                $price_note   = $card['price_value_note'] ?? '';
                $cta_label    = $card['cta_label']    ?? '';
                $cta_url      = $card['cta_url']      ?? '';

                $card_classes = 'two-paths-card';
                if ( $is_hero ) {
                    $card_classes .= ' two-paths-card--hero';
                } elseif ( $is_dark ) {
                    $card_classes .= ' two-paths-card--dark';
                }

                // Default placeholder copy when no image is uploaded yet.
                $placeholder_text = $is_hero ? 'Insert Three Browser Mockup Image'
                    : ( $is_dark ? 'Insert Booking Notification Image' : 'Insert Playbook Device Mockup' );
                ?>

                <div class="<?php echo esc_attr( $card_classes ); ?>">
                    <div class="two-paths-card-image">
                        <?php if ( $image_id ) : ?>
                            <?php echo wp_get_attachment_image( $image_id, 'large', false, array(
                                'alt'     => esc_attr( $title ),
                                'loading' => 'lazy',
                            ) ); ?>
                        <?php else : ?>
                            <div class="two-paths-card-image-placeholder" aria-hidden="true">
                                <span><?php echo esc_html( $placeholder_text ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ( ! $is_hero && $banner ) : ?>
                        <div class="two-paths-banner"><?php echo esc_html( $banner ); ?></div>
                    <?php endif; ?>

                    <div class="two-paths-card-inner">
                        <?php if ( $kicker ) : ?>
                            <p class="two-paths-kicker"><?php echo esc_html( $kicker ); ?></p>
                        <?php endif; ?>

                        <?php if ( $label ) : ?>
                            <p class="two-paths-label"><?php echo esc_html( $label ); ?></p>
                        <?php endif; ?>

                        <?php if ( $title ) : ?>
                            <h3 class="two-paths-card-title"><?php echo esc_html( $title ); ?></h3>
                        <?php endif; ?>

                        <?php if ( $body ) : ?>
                            <p class="two-paths-card-body"><?php echo esc_html( $body ); ?></p>
                        <?php endif; ?>

                        <?php if ( $proof_num || $proof_label ) : ?>
                            <div class="two-paths-proof">
                                <?php if ( $proof_num ) : ?>
                                    <span class="two-paths-proof-number"><?php echo esc_html( $proof_num ); ?></span>
                                <?php endif; ?>
                                <?php if ( $proof_label ) : ?>
                                    <span class="two-paths-proof-label"><?php echo esc_html( $proof_label ); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $features ) ) : ?>
                            <ul class="two-paths-features">
                                <?php foreach ( $features as $feature ) :
                                    if ( empty( $feature['text'] ) ) continue; ?>
                                    <li><?php echo esc_html( $feature['text'] ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ( $price_value || $price_note ) : ?>
                            <div class="two-paths-price-block">
                                <?php if ( $price_value ) : ?>
                                    <span class="two-paths-price"><?php echo esc_html( $price_value ); ?></span>
                                <?php endif; ?>
                                <?php if ( $price_note ) : ?>
                                    <span class="two-paths-price-note"><?php echo esc_html( $price_note ); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $cta_label ) : ?>
                            <a href="<?php echo esc_url( $cta_url ); ?>" class="two-paths-btn two-paths-btn-primary">
                                <?php echo esc_html( $cta_label ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
