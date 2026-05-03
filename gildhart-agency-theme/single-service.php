<?php
/**
 * Single Service template.
 *
 * Service CPT entries (The Playbook, The Agent, Web Pro Elite, …) each
 * render a different ordered set of sections. The set is defined by
 * gildhart_service_section_roster( $slug ) in inc/post-types.php — that
 * function is the single source of truth for "which sections live on
 * which product's page." Adding/removing a section per product = edit
 * the roster array, not this template.
 *
 * Each section template part is independently editable via its own ACF
 * field group on the service CPT, mirroring the homepage pattern. Most
 * sections also carry a "Show this section" toggle so an editor can
 * temporarily hide a section in the roster without removing it.
 *
 * Sections fall back to design defaults when their ACF fields are empty
 * — a freshly published service entry renders complete with no data
 * entry. Defaults live in gildhart_service_defaults_by_slug() and are
 * picked by post_name (slug-aware).
 *
 * @package Gildhart
 */

get_header(); ?>

<main id="main" class="site-main service-main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            $slug     = get_post_field( 'post_name', get_the_ID() );
            $sections = gildhart_service_section_roster( $slug );
            foreach ( $sections as $section ) {
                get_template_part( 'template-parts/service/section-' . $section );
            }
        endwhile;
    endif;
    ?>
</main>

<?php get_footer();
