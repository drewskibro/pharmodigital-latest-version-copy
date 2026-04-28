<?php
/**
 * Template Name: Home
 *
 * Gildhart homepage — composed of section template parts loaded in order.
 * Each section pulls its content from ACF fields (B-series) registered in
 * inc/acf-fields.php with this template as their location rule.
 *
 * @package Gildhart
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php get_template_part( 'template-parts/section-hero' ); ?>
    <?php get_template_part( 'template-parts/section-logo-bar' ); ?>
    <?php get_template_part( 'template-parts/section-featured-case-study' ); ?>
    <?php get_template_part( 'template-parts/section-split' ); ?>
    <?php get_template_part( 'template-parts/section-shift' ); ?>
    <?php get_template_part( 'template-parts/section-two-paths' ); ?>
    <?php get_template_part( 'template-parts/section-case-studies' ); ?>
    <?php get_template_part( 'template-parts/section-founder' ); ?>
    <?php get_template_part( 'template-parts/section-revenue' ); ?>
</main>

<?php get_footer();
