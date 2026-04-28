<?php
/**
 * Default page template. Used when a Page has no custom template assigned.
 *
 * @package Gildhart
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="section-container" style="padding-top: 6rem; padding-bottom: 6rem;">
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer();
