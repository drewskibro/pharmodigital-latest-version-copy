<?php
/**
 * Section: Revenue Results (homepage) + closing block.
 *
 * Optional Gildhart logo divider above. Then a dark navy section with
 * eyebrow + 2-line headline (top + gold-underlined accent) + subheadline
 * + 2x2 revenue card grid (cards 2 and 4 styled as elevated/featured) +
 * a closing block (italic centered headline, stat callout, body
 * paragraphs, gut-punch line, dual CTAs).
 *
 * Reveal staggers via .rev-visible scroll-trigger class added by home.js.
 *
 * @package Gildhart
 */

$show_divider        = (int) gh_field( 'revenue_show_divider', 1 );
$divider_logo_id     = gh_field( 'revenue_divider_logo' );

$eyebrow          = gh_field( 'revenue_eyebrow', 'The Numbers' );
$headline         = gh_field( 'revenue_headline' );
$headline_accent  = gh_field( 'revenue_headline_accent' );
$subheadline      = gh_field( 'revenue_subheadline' );

$cards            = gh_field( 'revenue_cards', array() );

$close_headline   = gh_field( 'revenue_close_headline' );
$close_stat_num   = gh_field( 'revenue_close_stat_num' );
$close_stat_strong = gh_field( 'revenue_close_stat_strong' );
$close_stat_label = gh_field( 'revenue_close_stat_label' );
$close_intro      = gh_field( 'revenue_close_intro', "These aren't projections. This is last month." );
$close_body       = gh_field( 'revenue_close_body', array() );
if ( empty( $close_body ) ) {
    $close_body = array(
        array( 'text' => 'Practices on AI search convert at 4.4 times the rate of standard organic. Not because they spent more. Because they got there first. That gap widens every single week.' ),
        array( 'text' => 'The practices moving now will be impossible to displace in twelve months. The ones waiting will find the shortlist already full.' ),
    );
}
$close_final      = gh_field( 'revenue_close_final', 'The window is open. The practices moving today will own the market. The ones waiting will find it already closed.' );

$cta1_label       = gh_field( 'revenue_close_cta_primary_label', "See If You're On The AI Shortlist →" );
$cta1_url         = gh_field( 'revenue_close_cta_primary_url', home_url( '/the-playbook/' ) );
$cta2_label       = gh_field( 'revenue_close_cta_secondary_label', 'See What We Build →' );
$cta2_url         = gh_field( 'revenue_close_cta_secondary_url', home_url( '/the-build/' ) );

if ( ! $headline && empty( $cards ) && ! $close_headline ) {
    return;
}

$allowed_inline = array( 'strong' => array(), 'em' => array(), 'br' => array() );
$logo_url       = $divider_logo_id
    ? wp_get_attachment_image_url( $divider_logo_id, 'full' )
    : gh_logo_url();
?>

<?php if ( $show_divider ) : ?>
    <div class="gh-divider" style="background:#FAF8F3;">
        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( gh_agency_name() ); ?>">
    </div>
<?php endif; ?>

<section class="revenue-section" id="revenue-results">
    <div class="revenue-inner">

        <div class="revenue-header">
            <?php if ( $eyebrow ) : ?>
                <p class="revenue-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>

            <?php if ( $headline || $headline_accent ) : ?>
                <h2 class="revenue-headline">
                    <?php
                    if ( $headline ) {
                        echo esc_html( $headline );
                    }
                    if ( $headline && $headline_accent ) {
                        echo '<br>';
                    }
                    if ( $headline_accent ) {
                        echo '<span class="revenue-headline-accent">' . esc_html( $headline_accent ) . '</span>';
                    }
                    ?>
                </h2>
            <?php endif; ?>

            <?php if ( $subheadline ) : ?>
                <p class="revenue-subheadline"><?php echo wp_kses( $subheadline, $allowed_inline ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $cards ) ) : ?>
            <div class="revenue-cards">
                <?php foreach ( $cards as $card ) :
                    $label      = $card['label']      ?? '';
                    $number     = $card['number']     ?? '';
                    $descriptor = $card['descriptor'] ?? '';
                    $proof      = $card['proof']      ?? '';
                    ?>
                    <div class="revenue-card">
                        <?php if ( $label ) : ?>
                            <p class="revenue-card-label"><?php echo esc_html( $label ); ?></p>
                        <?php endif; ?>
                        <?php if ( $number ) : ?>
                            <p class="revenue-card-number"><?php echo esc_html( $number ); ?></p>
                        <?php endif; ?>
                        <?php if ( $descriptor ) : ?>
                            <p class="revenue-card-descriptor"><?php echo esc_html( $descriptor ); ?></p>
                        <?php endif; ?>
                        <div class="revenue-card-divider"></div>
                        <?php if ( $proof ) : ?>
                            <p class="revenue-card-proof"><?php echo esc_html( $proof ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $close_headline || $close_stat_num || ! empty( $close_body ) || $close_final ) : ?>
            <div class="revenue-close-section">
                <?php if ( $close_headline ) : ?>
                    <p class="revenue-close-headline"><?php echo esc_html( $close_headline ); ?></p>
                <?php endif; ?>

                <?php if ( $close_stat_num || $close_stat_label || $close_stat_strong ) : ?>
                    <div class="revenue-close-stat">
                        <?php if ( $close_stat_num ) : ?>
                            <span class="revenue-close-stat-num"><?php echo esc_html( $close_stat_num ); ?></span>
                        <?php endif; ?>
                        <div class="revenue-close-stat-label">
                            <?php if ( $close_stat_strong ) : ?>
                                <strong><?php echo esc_html( $close_stat_strong ); ?></strong>
                            <?php endif; ?>
                            <?php if ( $close_stat_label ) : ?>
                                <?php echo esc_html( $close_stat_label ); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( $close_intro ) : ?>
                    <p class="revenue-close-intro"><?php echo esc_html( $close_intro ); ?></p>
                <?php endif; ?>

                <?php if ( ! empty( $close_body ) ) : ?>
                    <div class="revenue-close-body">
                        <?php foreach ( $close_body as $para ) :
                            if ( empty( $para['text'] ) ) continue; ?>
                            <p><?php echo esc_html( $para['text'] ); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $close_final ) : ?>
                    <p class="revenue-close-final"><?php echo esc_html( $close_final ); ?></p>
                <?php endif; ?>

                <?php if ( $cta1_label || $cta2_label ) : ?>
                    <div class="revenue-close-cta-buttons">
                        <?php if ( $cta1_label ) : ?>
                            <a href="<?php echo esc_url( $cta1_url ); ?>" class="btn btn-primary revenue-close-btn-primary">
                                <?php echo esc_html( $cta1_label ); ?>
                            </a>
                        <?php endif; ?>
                        <?php if ( $cta2_label ) : ?>
                            <a href="<?php echo esc_url( $cta2_url ); ?>" class="revenue-close-btn-outline">
                                <?php echo esc_html( $cta2_label ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
