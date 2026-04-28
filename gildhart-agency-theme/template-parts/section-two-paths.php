<?php
/**
 * Section: Two Paths (homepage)
 *
 * Three-card pricing/offering block. Centre card flagged "featured"
 * gets the dark-fill highlighted style with a Recommended pill.
 * Cards stagger in from below as the section enters the viewport
 * (.tp-visible class added per-card via home.js).
 *
 * @package Gildhart
 */

$headline    = gh_field( 'two_paths_headline' );
$subheadline = gh_field( 'two_paths_subheadline' );
$cards       = gh_field( 'two_paths_cards', array() );

if ( empty( $cards ) ) {
    return;
}
?>

<section class="two-paths-section" id="get-started">
    <div class="two-paths-inner">

        <?php if ( $headline || $subheadline ) : ?>
            <div class="two-paths-header">
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
                $banner          = $card['banner']           ?? '';
                $banner_dark     = ! empty( $card['banner_dark'] );
                $is_featured     = ! empty( $card['is_featured'] );
                $label           = $card['label']            ?? '';
                $title           = $card['title']            ?? '';
                $body            = $card['body']             ?? '';
                $features        = $card['features']         ?? array();
                $price_value     = $card['price_value']      ?? '';
                $price_note      = $card['price_value_note'] ?? '';
                $price_muted     = $card['price_muted_text'] ?? '';
                $cta_label       = $card['cta_label']        ?? '';
                $cta_url         = $card['cta_url']          ?? '';

                $card_classes = 'two-paths-card';
                if ( $is_featured ) {
                    $card_classes .= ' two-paths-card--featured';
                }

                $banner_classes = 'two-paths-proof-banner two-paths-proof-banner--bold';
                $banner_attr    = '';
                if ( $banner_dark ) {
                    $banner_attr = ' style="background:var(--gildhart-green);color:white;border-bottom-color:rgba(201,164,74,0.2);"';
                }
                ?>

                <div class="<?php echo esc_attr( $card_classes ); ?>">
                    <?php if ( $banner ) : ?>
                        <div class="<?php echo esc_attr( $banner_classes ); ?>"<?php echo $banner_attr; ?>>
                            <?php echo esc_html( $banner ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="two-paths-card-inner">
                        <?php if ( $is_featured ) : ?>
                            <span class="two-paths-recommended-label">Recommended</span>
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

                        <?php if ( ! empty( $features ) ) : ?>
                            <ul class="two-paths-features">
                                <?php foreach ( $features as $feature ) :
                                    if ( empty( $feature['text'] ) ) continue; ?>
                                    <li>
                                        <span class="two-paths-check">✓</span>
                                        <?php echo esc_html( $feature['text'] ); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ( $price_value || $price_note || $price_muted ) : ?>
                            <div class="two-paths-price-block">
                                <?php if ( $price_value ) : ?>
                                    <span class="two-paths-price"><?php echo esc_html( $price_value ); ?></span>
                                <?php endif; ?>
                                <?php if ( $price_note ) : ?>
                                    <span class="two-paths-price-note"><?php echo esc_html( $price_note ); ?></span>
                                <?php endif; ?>
                                <?php if ( $price_muted ) : ?>
                                    <span class="two-paths-price-muted"><?php echo esc_html( $price_muted ); ?></span>
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
