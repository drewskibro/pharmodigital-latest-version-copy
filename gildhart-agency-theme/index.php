<?php
/**
 * Default fallback template. Renders for any request without a more specific
 * template. Gildhart is page/CPT-driven; this is here so WP has a fallback.
 *
 * @package Gildhart
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="section-container" style="padding-top: 6rem; padding-bottom: 6rem;">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div><?php the_excerpt(); ?></div>
                </article>
            <?php endwhile; ?>

            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p><?php esc_html_e( 'Nothing here yet.', 'gildhart' ); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer();
