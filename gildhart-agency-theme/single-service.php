<?php
/**
 * Single Service template.
 *
 * Service CPT entries (The Playbook, The Agent, Web Pro Elite) render a
 * fixed sequence of section template parts. Each section is independently
 * editable via its own ACF field group on the service CPT, mirroring the
 * homepage pattern. Each section has a "Show this section" toggle so a
 * service can hide sections that don't apply (e.g. Web Pro Elite might
 * hide the math section).
 *
 * Sections fall back to design defaults when their ACF fields are empty —
 * a freshly published service entry renders complete with no data entry.
 *
 * Sections ship in chunks: S0 = Hero. S1+ uncomment further parts as they
 * land.
 *
 * @package Gildhart
 */

get_header(); ?>

<main id="main" class="site-main service-main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/service/section-hero' ); ?>
            <?php get_template_part( 'template-parts/service/section-problem-shift' ); ?>
            <?php get_template_part( 'template-parts/service/section-proof-cases' ); ?>
            <?php get_template_part( 'template-parts/service/section-playing-field' ); ?>
            <?php get_template_part( 'template-parts/service/section-method' ); ?>
            <?php get_template_part( 'template-parts/service/section-what-you-get' ); ?>
            <?php get_template_part( 'template-parts/service/section-sub-case-proof' ); ?>
            <?php // get_template_part( 'template-parts/service/section-early-buyers' );   // S4 ?>
            <?php // get_template_part( 'template-parts/service/section-math' );           // S4 ?>
            <?php // get_template_part( 'template-parts/service/section-next-steps' );     // S5 ?>
            <?php // get_template_part( 'template-parts/service/section-faq' );            // S5 ?>
            <?php // get_template_part( 'template-parts/service/section-guarantee' );      // S6 ?>
            <?php // get_template_part( 'template-parts/service/section-final-cta' );      // S6 ?>
        <?php endwhile;
    endif;
    ?>
</main>

<?php get_footer();
