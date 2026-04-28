<?php
/**
 * Default archive fallback. CPT-specific archives (case-studies, services)
 * use their own archive-{cpt}.php templates added in Phase 5/6.
 *
 * @package Gildhart
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="section-container" style="padding-top: 6rem; padding-bottom: 6rem;">
        <header class="page-header">
            <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
            <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
        </header>

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
