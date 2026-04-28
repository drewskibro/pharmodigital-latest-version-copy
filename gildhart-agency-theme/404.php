<?php
/**
 * 404 — page not found.
 *
 * @package Gildhart
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="section-container" style="padding-top: 8rem; padding-bottom: 8rem; text-align: center;">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; color: var(--gildhart-green);">404</h1>
        <p style="font-size: 1.25rem; color: var(--gray-600); margin-bottom: 2rem;">
            <?php esc_html_e( "We can't find that page.", 'gildhart' ); ?>
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
            <?php esc_html_e( 'Back to home', 'gildhart' ); ?>
        </a>
    </div>
</main>

<?php get_footer();
