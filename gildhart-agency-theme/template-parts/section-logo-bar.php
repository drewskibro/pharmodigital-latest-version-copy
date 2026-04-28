<?php
/**
 * Section: Logo Bar (homepage)
 *
 * Eyebrow band + horizontally-scrolling client logo strip.
 * The gallery is rendered twice in a row for the seamless infinite-scroll
 * CSS animation (translateX 0 → -50%).
 *
 * @package Gildhart
 */

$eyebrow = gh_field( 'logo_bar_eyebrow', 'Trusted by healthcare practices across the UK & Worldwide' );
$logos   = gh_field( 'logo_bar_logos', array() );

if ( empty( $logos ) ) {
    return;
}
?>

<?php if ( $eyebrow ) : ?>
    <div class="logo-bar-eyebrow-band">
        <p class="logo-bar-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
    </div>
<?php endif; ?>

<section class="logo-bar">
    <div class="logo-bar-scroller">
        <?php
        // For a seamless infinite scroll the scroller needs total width >
        // 2× viewport. We tile each unique logo enough times so each "set"
        // has at least MIN_PER_SET items, then render the whole set twice
        // (the CSS animation translates by -50% of the scroller's width).
        $MIN_PER_SET = 9;
        $count       = max( 1, count( $logos ) );
        $repeats     = (int) ceil( $MIN_PER_SET / $count );

        for ( $pass = 0; $pass < 2; $pass++ ) {
            for ( $rep = 0; $rep < $repeats; $rep++ ) {
                foreach ( $logos as $logo ) {
                    $alt = ! empty( $logo['alt'] ) ? $logo['alt'] : ( ! empty( $logo['title'] ) ? $logo['title'] : '' );
                    $src = $logo['sizes']['medium'] ?? $logo['url'];
                    echo '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy" />';
                }
            }
        }
        ?>
    </div>
</section>
