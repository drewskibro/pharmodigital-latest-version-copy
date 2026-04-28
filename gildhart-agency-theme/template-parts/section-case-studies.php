<?php
/**
 * Section: Case Studies Carousel (homepage)
 *
 * Auto-pulls published case_study CPT entries and renders them as an
 * infinitely-scrolling horizontal carousel. Like the logo bar, the cards
 * are auto-tiled if there are too few unique entries to fill the
 * viewport — so the seamless translateX(-50%) loop always works.
 *
 * Per-card data:
 *   - Featured image     → card image
 *   - First industry term → tag
 *   - Title              → card title
 *   - Excerpt            → card description
 *   - Per-post `case_study_card_cta_label` → CTA, falls back to the
 *     section-level default
 *
 * @package Gildhart
 */

$title       = gh_field( 'cs_carousel_title', 'Healthcare marketing success stories' );
$subtitle    = gh_field( 'cs_carousel_subtitle', "See how we've helped practices dominate AI search" );
$default_cta = gh_field( 'cs_carousel_default_cta', 'See exactly how they did it →' );

$query = new WP_Query( array(
    'post_type'      => 'case_study',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

if ( ! $query->have_posts() ) {
    return;
}

// Collect rendered cards into a buffer once, then echo the buffer twice (and
// optionally tile within each pass) so the seamless scroll always has enough
// content to cover 2× viewport.
$cards = array();
while ( $query->have_posts() ) {
    $query->the_post();
    $post_id   = get_the_ID();
    $image     = get_the_post_thumbnail_url( $post_id, 'large' );
    $terms     = get_the_terms( $post_id, 'industry' );
    $tag       = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
    $title_txt = get_the_title();
    $desc      = get_the_excerpt();
    $url       = get_permalink();
    $cta       = function_exists( 'get_field' ) ? get_field( 'case_study_card_cta_label' ) : '';
    if ( ! $cta ) {
        $cta = $default_cta;
    }

    ob_start();
    ?>
    <div class="case-card">
        <?php if ( $image ) : ?>
            <div class="case-card-image">
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title_txt ); ?>" loading="lazy">
            </div>
        <?php endif; ?>
        <div class="case-card-content">
            <?php if ( $tag ) : ?>
                <div class="case-card-tag"><?php echo esc_html( $tag ); ?></div>
            <?php endif; ?>
            <?php if ( $title_txt ) : ?>
                <h3 class="case-card-title"><?php echo esc_html( $title_txt ); ?></h3>
            <?php endif; ?>
            <?php if ( $desc ) : ?>
                <p class="case-card-desc"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
            <a href="<?php echo esc_url( $url ); ?>" class="case-card-cta">
                <?php echo esc_html( $cta ); ?>
                <i class="cta-arrow">→</i>
            </a>
        </div>
    </div>
    <?php
    $cards[] = ob_get_clean();
}
wp_reset_postdata();

if ( empty( $cards ) ) {
    return;
}

// Auto-tile so the seamless loop has at least 6 cards per pass before the
// duplicate set is rendered (matches the static design's filler approach).
$MIN_PER_PASS = 6;
$count        = max( 1, count( $cards ) );
$repeats      = (int) ceil( $MIN_PER_PASS / $count );
?>

<section class="case-studies" id="case-studies">
    <div class="section-header">
        <?php if ( $title ) : ?>
            <h2><?php echo esc_html( $title ); ?></h2>
        <?php endif; ?>
        <?php if ( $subtitle ) : ?>
            <p><?php echo esc_html( $subtitle ); ?></p>
        <?php endif; ?>
    </div>
    <div class="carousel-container">
        <div class="carousel-track">
            <?php
            for ( $pass = 0; $pass < 2; $pass++ ) {
                for ( $r = 0; $r < $repeats; $r++ ) {
                    foreach ( $cards as $card_html ) {
                        echo $card_html;
                    }
                }
            }
            ?>
        </div>
    </div>
</section>
