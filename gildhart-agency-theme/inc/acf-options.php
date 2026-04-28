<?php
/**
 * ACF Options Pages — "Gildhart Settings" admin menu.
 *
 * @package Gildhart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register ACF Options Pages.
 */
function gildhart_register_options_pages() {

    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( array(
        'page_title' => 'Gildhart Settings',
        'menu_title' => 'Gildhart Settings',
        'menu_slug'  => 'gildhart-settings',
        'capability' => 'edit_posts',
        'redirect'   => true,
        'icon_url'   => 'dashicons-businessperson',
        'position'   => 30,
    ) );

    acf_add_options_sub_page( array(
        'page_title'  => 'Branding',
        'menu_title'  => 'Branding',
        'menu_slug'   => 'gildhart-branding',
        'parent_slug' => 'gildhart-settings',
        'capability'  => 'edit_posts',
    ) );

    acf_add_options_sub_page( array(
        'page_title'  => 'Contact',
        'menu_title'  => 'Contact',
        'menu_slug'   => 'gildhart-contact',
        'parent_slug' => 'gildhart-settings',
        'capability'  => 'edit_posts',
    ) );

    acf_add_options_sub_page( array(
        'page_title'  => 'Social Media',
        'menu_title'  => 'Social Media',
        'menu_slug'   => 'gildhart-social',
        'parent_slug' => 'gildhart-settings',
        'capability'  => 'edit_posts',
    ) );

    acf_add_options_sub_page( array(
        'page_title'  => 'Navigation',
        'menu_title'  => 'Navigation',
        'menu_slug'   => 'gildhart-navigation',
        'parent_slug' => 'gildhart-settings',
        'capability'  => 'edit_posts',
    ) );

    acf_add_options_sub_page( array(
        'page_title'  => 'Footer',
        'menu_title'  => 'Footer',
        'menu_slug'   => 'gildhart-footer',
        'parent_slug' => 'gildhart-settings',
        'capability'  => 'edit_posts',
    ) );
}
add_action( 'acf/init', 'gildhart_register_options_pages' );
