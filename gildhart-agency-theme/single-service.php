<?php
/**
 * Single Service template.
 *
 * Service CPT entries (e.g. The Playbook, The Agent) compose their page from
 * the ACF Flexible Content field 'service_sections'. Each layout maps to a
 * template part at template-parts/service/section-{layout-name}.php.
 *
 * Editors: add/reorder/remove sections per service in WP Admin → Service →
 * Sections. Each section template falls back to the design defaults when its
 * ACF sub-fields are empty, so a freshly published service entry renders
 * complete without any data entry.
 *
 * @package Gildhart
 */

get_header(); ?>

<main id="main" class="site-main service-main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();

            if ( function_exists( 'have_rows' ) && have_rows( 'service_sections' ) ) :
                while ( have_rows( 'service_sections' ) ) :
                    the_row();
                    $layout = get_row_layout();
                    if ( is_string( $layout ) && preg_match( '/^[a-z0-9_-]+$/', $layout ) ) {
                        get_template_part( 'template-parts/service/section', $layout );
                    }
                endwhile;
            endif;

        endwhile;
    endif;
    ?>
</main>

<?php get_footer();
