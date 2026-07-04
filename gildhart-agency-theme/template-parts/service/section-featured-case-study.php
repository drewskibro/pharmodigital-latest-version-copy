<?php
/**
 * Service: Featured Case Study (Sachin / Ealing) — Playbook variant.
 *
 * Re-homes the homepage's featured-case-study testimonial onto the
 * Playbook, where it belongs: Sachin is Ealing Travel Clinic, the hero
 * case the whole page is built around. Photo left, quote + author +
 * stars right, and the forest-green "300%" case-study card beneath.
 *
 * Content MIRRORS the homepage section — it reads the same `fcs_*`
 * fields off the home page so there's one source of truth (edit the
 * homepage testimonial and this follows, photo included). Falls back
 * to the Sachin/Ealing defaults if the home page can't be resolved.
 *
 * The one deliberate divergence: the green card's link is repointed
 * from "Read the full story → (the Playbook)" — which would be
 * circular here — to "Get The Playbook →", scrolling to the #your-turn
 * checkout. The proof card becomes a conversion nudge.
 *
 * Reuses the homepage `.featured-*` classes; their styles are ported
 * into service.css in a statically-visible form (the homepage relies
 * on home.js for its reveal animation, which doesn't load here).
 *
 * @package Gildhart
 */

// Resolve the home page so we can mirror its testimonial fields.
$home_id    = 0;
$home_pages = get_posts( array(
    'post_type'      => 'page',
    'posts_per_page' => 1,
    'fields'         => 'ids',
    'meta_key'       => '_wp_page_template',
    'meta_value'     => 'page-templates/page-home.php',
    'no_found_rows'  => true,
) );
if ( ! empty( $home_pages ) ) {
    $home_id = (int) $home_pages[0];
}

// Read an fcs_* field from the home page, falling back to the shared
// default (matches the homepage section's own defaults).
$fcs = function( $name, $default = '' ) use ( $home_id ) {
    if ( $home_id ) {
        $v = get_field( $name, $home_id );
        if ( $v !== null && $v !== '' ) {
            return $v;
        }
    }
    return $default;
};

$image_id     = (int) $fcs( 'fcs_image', 0 );
$quote        = $fcs( 'fcs_quote', "Traffic's up <strong>300%</strong> and compounding every month. Not just traffic for the sake of it, but <strong>patients actually booking appointments</strong>." );
$author_name  = $fcs( 'fcs_author_name', 'Sachin Patel' );
$author_title = $fcs( 'fcs_author_title', 'Founder, Ealing Travel Clinic' );
$show_stars   = $fcs( 'fcs_show_stars', 1 );

$cta_badge  = $fcs( 'fcs_cta_badge', 'Case Study · Ealing Travel Clinic' );
$cta_text   = $fcs( 'fcs_cta_text',  'Six-month transformation' );
$cta_number = $fcs( 'fcs_cta_number', '300%' );
$cta_label  = $fcs( 'fcs_cta_label',  'More patients' );
$cta_meta   = $fcs( 'fcs_cta_meta',   'AI Overview rankings · Real booking data' );
$cta_how    = $fcs( 'fcs_cta_how',    'AI-optimised content. Zero ad spend. Six weeks to #1 in Google AI Overviews.' );

// Repoint: on the Playbook itself, the card drives to the checkout
// rather than back to this same page.
$cta_url        = '#your-turn';
$cta_link_label = 'Get The Playbook';

$allowed_quote_tags = array(
    'strong' => array(),
    'em'     => array(),
    'br'     => array(),
);
?>

<section class="featured-case-study featured-case-study--static">
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

            <?php $has_cta_content = $cta_badge || $cta_text || $cta_number || $cta_meta || $cta_how || $cta_link_label; ?>
            <?php if ( $has_cta_content ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="featured-cta-card">
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
                    <?php if ( $cta_link_label ) : ?>
                        <span class="featured-cta-link"><?php echo esc_html( $cta_link_label ); ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

        </div>
    </div>
</section>
