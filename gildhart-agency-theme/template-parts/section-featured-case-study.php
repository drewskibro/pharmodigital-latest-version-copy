<?php
/**
 * Section: Featured Case Study (homepage)
 *
 * Two-column block: image left, quote + author + stars + CTA card right.
 * Uses the IntersectionObserver in home.js — when the section enters the
 * viewport, it gains a `.fcs-visible` class which triggers the staggered
 * reveal animations.
 *
 * @package Gildhart
 */

$image_id      = gh_field( 'fcs_image' );
$quote         = gh_field( 'fcs_quote', "Traffic's up <strong>300%</strong> and compounding every month. Not just traffic for the sake of it, but <strong>patients actually booking appointments</strong>." );
$author_name   = gh_field( 'fcs_author_name', 'Sachin Patel' );
$author_title  = gh_field( 'fcs_author_title', 'Founder, Ealing Travel Clinic' );
$show_stars    = gh_field( 'fcs_show_stars', 1 );

$cta_badge     = gh_field( 'fcs_cta_badge', 'Case Study · Ealing Travel Clinic' );
$cta_text      = gh_field( 'fcs_cta_text',  'Six-month transformation' );
$cta_number    = gh_field( 'fcs_cta_number', '300%' );
$cta_label     = gh_field( 'fcs_cta_label',  'More patients' );
$cta_meta      = gh_field( 'fcs_cta_meta',   'AI Overview rankings · Real booking data' );
$cta_how       = gh_field( 'fcs_cta_how',    'AI-optimised content. Zero ad spend. Six weeks to #1 in Google AI Overviews.' );
$cta_link_label = gh_field( 'fcs_cta_link_label', 'Read the full story' );

// Resolve the CTA card link: case_study post override → URL field
// → the Playbook page as the editorial-house default.
$case_study_id = gh_field( 'fcs_case_study' );
$cta_url       = '';
if ( $case_study_id ) {
    $cta_url = get_permalink( $case_study_id );
} else {
    $cta_url = gh_field( 'fcs_link_url' );
}
if ( ! $cta_url ) {
    $cta_url = home_url( '/the-playbook/' );
}

// Allowed inline tags inside the quote (e.g. <strong>).
$allowed_quote_tags = array(
    'strong' => array(),
    'em'     => array(),
    'br'     => array(),
);

// Always render — the defaults above carry the section even when ACF
// is empty (image falls through gracefully, copy holds the layout).
?>

<section class="featured-case-study">
    <div class="featured-case-inner">

        <?php if ( $image_id ) : ?>
            <div class="featured-case-image">
                <?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'loading' => 'lazy' ) ); ?>
            </div>
        <?php endif; ?>

        <div class="featured-case-content">

            <div class="featured-quote-mark">&ldquo;</div>

            <?php if ( $quote ) : ?>
                <p class="featured-quote"><?php echo wp_kses( $quote, $allowed_quote_tags ); ?></p>
            <?php endif; ?>

            <?php if ( $author_name || $author_title ) : ?>
                <div class="featured-author">
                    <?php if ( $author_name ) : ?>
                        <div class="featured-author-name"><?php echo esc_html( $author_name ); ?></div>
                    <?php endif; ?>
                    <?php if ( $author_title ) : ?>
                        <div class="featured-author-title"><?php echo esc_html( $author_title ); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ( $show_stars ) : ?>
                <div class="featured-stars" aria-hidden="true">
                    <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                </div>
            <?php endif; ?>

            <?php
            $cta_card_open  = $cta_url ? '<a href="' . esc_url( $cta_url ) . '" class="featured-cta-card">' : '<div class="featured-cta-card">';
            $cta_card_close = $cta_url ? '</a>' : '</div>';
            $has_cta_content = $cta_badge || $cta_text || $cta_number || $cta_meta || $cta_how || ( $cta_url && $cta_link_label );
            ?>
            <?php if ( $has_cta_content ) : ?>
                <?php echo $cta_card_open; ?>
                    <?php if ( $cta_badge ) : ?>
                        <div class="featured-cta-badge"><?php echo esc_html( $cta_badge ); ?></div>
                    <?php endif; ?>
                    <?php if ( $cta_text ) : ?>
                        <p class="featured-cta-text"><?php echo esc_html( $cta_text ); ?></p>
                    <?php endif; ?>
                    <?php if ( $cta_number || $cta_label ) : ?>
                        <div class="featured-cta-stat">
                            <?php if ( $cta_number ) : ?>
                                <span class="featured-cta-number"><?php echo esc_html( $cta_number ); ?></span>
                            <?php endif; ?>
                            <?php if ( $cta_label ) : ?>
                                <span class="featured-cta-label"><?php echo esc_html( $cta_label ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( $cta_meta ) : ?>
                        <p class="featured-cta-meta"><?php echo esc_html( $cta_meta ); ?></p>
                    <?php endif; ?>
                    <?php if ( $cta_how ) : ?>
                        <p class="featured-cta-how"><?php echo esc_html( $cta_how ); ?></p>
                    <?php endif; ?>
                    <?php if ( $cta_url && $cta_link_label ) : ?>
                        <span class="featured-cta-link"><?php echo esc_html( $cta_link_label ); ?></span>
                    <?php endif; ?>
                <?php echo $cta_card_close; ?>
            <?php endif; ?>

        </div>
    </div>
</section>
