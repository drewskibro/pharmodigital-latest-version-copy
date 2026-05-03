<?php
/**
 * Service: Final CTA section.
 *
 * Hero-gradient closer. Two-column header: left (eyebrow + H2 + body
 * + tick-bullet feature list + footer line), right (sticky white
 * price card with eyebrow, title, price row, primary CTA button,
 * and secondary link). Below the header, a two-column "Final
 * Choices" grid contrasts inaction vs action.
 *
 * Sticky behaviour on the price card uses position: sticky so it
 * pins to (var(--nav-h) + offset) as the user reads the left column.
 *
 * Reads from per-section ACF group `Service · Final CTA`. Returns
 * early when the show toggle is off. Falls back to The Playbook copy
 * from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_final_show', 1 ) ) {
    return;
}

$eyebrow      = gh_field( 'service_final_eyebrow',   'Your Turn' );
$headline     = gh_field( 'service_final_headline',  'Ealing Spent £497. Then Generated £100k From One Service.' );
$body         = gh_field( 'service_final_body',      "Every month you pay for marketing. Every month the results are someone else's to switch off. This is different. One purchase. One system. Yours forever." );

$features = get_field( 'service_final_features' );
if ( empty( $features ) ) {
    $features = array(
        array( 'text' => 'The exact content architecture that got Ealing to #1 in Google AI Overviews — copy-paste ready' ),
        array( 'text' => 'Every prompt we use across 50+ practices — built, tested, yours in minutes' ),
        array( 'text' => 'Monthly strategy calls — so your system evolves as AI platforms evolve' ),
        array( 'text' => 'Lifetime access — deploy across one practice or fifty, no extra cost' ),
        array( 'text' => "Personal implementation guarantee — go through the system, follow the steps, and if you're still stuck I'll personally walk you through it one-on-one" ),
    );
}

$footer_line = gh_field( 'service_final_footer_line', 'Ealing did it. Superior did it. Southdowns did it. National chains spent millions. They spent £497.' );

$price_eyebrow      = gh_field( 'service_final_price_eyebrow',  'The AI Search Playbook' );
$price_title        = gh_field( 'service_final_price_title',    'One System. Every AI Platform. Yours Forever.' );
$price_value        = gh_field( 'service_final_price_value',    '£497' );
$price_qualifier    = gh_field( 'service_final_price_qualifier', 'one-time · lifetime access' );
$price_cta_label    = gh_field( 'service_final_price_cta_label', 'Get Instant Access — £497' );
$price_cta_url      = gh_field( 'service_final_price_cta_url',   '#buy-now' );
$price_secondary    = gh_field( 'service_final_price_secondary', 'Or <a href="#contact">talk to us about Done-For-You →</a>' );

$choices = get_field( 'service_final_choices' );
if ( empty( $choices ) ) {
    $choices = array(
        array(
            'kind'  => 'inaction',
            'title' => "Keep Doing What You're Doing",
            'text'  => "Every month the agency bill lands. Every month the ad spend disappears. Every month Boots gets stronger. And every month a patient finds your competitor on ChatGPT instead of you.",
        ),
        array(
            'kind'  => 'action',
            'title' => 'Do What Ealing Did',
            'text'  => "£497 once. The exact system behind Ealing's £100k HPV revenue, Superior's £500k trajectory, and Puri outranking Boots nationally. One hour a week. Compounds forever.",
        ),
    );
}
?>

<section class="svc-final" id="buy-now">
    <div class="svc-final-inner">
        <div class="svc-final-header">
            <div class="svc-final-left">
                <?php if ( $eyebrow ) : ?>
                    <p class="svc-final-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="svc-final-headline"><?php echo esc_html( $headline ); ?></h2>
                <?php endif; ?>
                <?php if ( $body ) : ?>
                    <p class="svc-final-body"><?php echo esc_html( $body ); ?></p>
                <?php endif; ?>

                <?php if ( ! empty( $features ) ) : ?>
                    <ul class="svc-final-features">
                        <?php foreach ( $features as $f ) :
                            $text = $f['text'] ?? '';
                            if ( ! $text ) continue; ?>
                            <li><span class="svc-final-check" aria-hidden="true">✓</span><?php echo esc_html( $text ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( $footer_line ) : ?>
                    <p class="svc-final-footer-line"><?php echo esc_html( $footer_line ); ?></p>
                <?php endif; ?>
            </div>

            <div class="svc-final-right">
                <div class="svc-final-price-card">
                    <?php if ( $price_eyebrow ) : ?>
                        <p class="svc-final-price-eyebrow"><?php echo esc_html( $price_eyebrow ); ?></p>
                    <?php endif; ?>
                    <?php if ( $price_title ) : ?>
                        <h3 class="svc-final-price-title"><?php echo esc_html( $price_title ); ?></h3>
                    <?php endif; ?>
                    <?php if ( $price_value || $price_qualifier ) : ?>
                        <div class="svc-final-price-row">
                            <?php if ( $price_value ) : ?>
                                <span class="svc-final-price-num"><?php echo esc_html( $price_value ); ?></span>
                            <?php endif; ?>
                            <?php if ( $price_qualifier ) : ?>
                                <span class="svc-final-price-qualifier"><?php echo esc_html( $price_qualifier ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( $price_cta_label ) : ?>
                        <a href="<?php echo esc_url( $price_cta_url ); ?>" class="svc-final-price-btn">
                            <?php echo esc_html( $price_cta_label ); ?>
                            <span class="svc-btn-arrow" aria-hidden="true">→</span>
                        </a>
                    <?php endif; ?>
                    <?php if ( $price_secondary ) : ?>
                        <p class="svc-final-price-secondary"><?php echo wp_kses_post( $price_secondary ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ( ! empty( $choices ) ) : ?>
            <div class="svc-final-choices">
                <?php foreach ( $choices as $choice ) :
                    $kind  = $choice['kind']  ?? 'action';
                    $title = $choice['title'] ?? '';
                    $text  = $choice['text']  ?? '';
                    if ( ! $title && ! $text ) continue;
                    $classes = 'svc-final-choice svc-final-choice--' . esc_attr( $kind ); ?>
                    <article class="<?php echo esc_attr( $classes ); ?>">
                        <?php if ( $title ) : ?>
                            <h3 class="svc-final-choice-title"><?php echo esc_html( $title ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $text ) : ?>
                            <p class="svc-final-choice-text"><?php echo esc_html( $text ); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
