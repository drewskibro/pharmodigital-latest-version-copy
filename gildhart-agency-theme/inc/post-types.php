<?php
/**
 * Custom Post Types & Taxonomies for Gildhart.
 *
 *   Service     — agency offering (AI Domination System, Sales Agent, WebPro Elite, etc.)
 *   Case Study  — client work (each tagged with one or more `industry` terms)
 *   Industry    — taxonomy attached to Case Studies (e.g. Travel Clinic, Pharmacy, Dental)
 *
 * @package Gildhart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the `service` CPT.
 */
function gildhart_register_service_cpt() {
    $labels = array(
        'name'                  => _x( 'Services', 'Post type general name', 'gildhart' ),
        'singular_name'         => _x( 'Service', 'Post type singular name', 'gildhart' ),
        'menu_name'             => _x( 'Services', 'Admin Menu text', 'gildhart' ),
        'name_admin_bar'        => _x( 'Service', 'Add New on Toolbar', 'gildhart' ),
        'add_new'               => __( 'Add New', 'gildhart' ),
        'add_new_item'          => __( 'Add New Service', 'gildhart' ),
        'new_item'              => __( 'New Service', 'gildhart' ),
        'edit_item'             => __( 'Edit Service', 'gildhart' ),
        'view_item'             => __( 'View Service', 'gildhart' ),
        'all_items'             => __( 'All Services', 'gildhart' ),
        'search_items'          => __( 'Search Services', 'gildhart' ),
        'not_found'             => __( 'No services found.', 'gildhart' ),
        'not_found_in_trash'    => __( 'No services found in Trash.', 'gildhart' ),
        'featured_image'        => __( 'Service Image', 'gildhart' ),
        'archives'              => __( 'Services Archive', 'gildhart' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-portfolio',
        'menu_position'      => 22,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'services', 'with_front' => false ),
        'capability_type'    => 'post',
        'has_archive'        => 'services',
        'hierarchical'       => false,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'revisions' ),
    );

    register_post_type( 'service', $args );
}
add_action( 'init', 'gildhart_register_service_cpt' );

/**
 * Register the `case_study` CPT.
 */
function gildhart_register_case_study_cpt() {
    $labels = array(
        'name'                  => _x( 'Case Studies', 'Post type general name', 'gildhart' ),
        'singular_name'         => _x( 'Case Study', 'Post type singular name', 'gildhart' ),
        'menu_name'             => _x( 'Case Studies', 'Admin Menu text', 'gildhart' ),
        'name_admin_bar'        => _x( 'Case Study', 'Add New on Toolbar', 'gildhart' ),
        'add_new'               => __( 'Add New', 'gildhart' ),
        'add_new_item'          => __( 'Add New Case Study', 'gildhart' ),
        'new_item'              => __( 'New Case Study', 'gildhart' ),
        'edit_item'             => __( 'Edit Case Study', 'gildhart' ),
        'view_item'             => __( 'View Case Study', 'gildhart' ),
        'all_items'             => __( 'All Case Studies', 'gildhart' ),
        'search_items'          => __( 'Search Case Studies', 'gildhart' ),
        'not_found'             => __( 'No case studies found.', 'gildhart' ),
        'not_found_in_trash'    => __( 'No case studies found in Trash.', 'gildhart' ),
        'featured_image'        => __( 'Case Study Image', 'gildhart' ),
        'archives'              => __( 'Case Studies Archive', 'gildhart' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-awards',
        'menu_position'      => 23,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'case-studies', 'with_front' => false ),
        'capability_type'    => 'post',
        'has_archive'        => 'case-studies',
        'hierarchical'       => false,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'revisions' ),
    );

    register_post_type( 'case_study', $args );
}
add_action( 'init', 'gildhart_register_case_study_cpt' );

/**
 * Register the `industry` taxonomy (attached to case_study).
 *
 * Used to filter case studies by client sector (Travel Clinic, Pharmacy, etc.).
 */
function gildhart_register_industry_taxonomy() {
    $labels = array(
        'name'              => _x( 'Industries', 'taxonomy general name', 'gildhart' ),
        'singular_name'     => _x( 'Industry', 'taxonomy singular name', 'gildhart' ),
        'search_items'      => __( 'Search Industries', 'gildhart' ),
        'all_items'         => __( 'All Industries', 'gildhart' ),
        'parent_item'       => __( 'Parent Industry', 'gildhart' ),
        'parent_item_colon' => __( 'Parent Industry:', 'gildhart' ),
        'edit_item'         => __( 'Edit Industry', 'gildhart' ),
        'update_item'       => __( 'Update Industry', 'gildhart' ),
        'add_new_item'      => __( 'Add New Industry', 'gildhart' ),
        'new_item_name'     => __( 'New Industry Name', 'gildhart' ),
        'menu_name'         => __( 'Industries', 'gildhart' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'industry', 'with_front' => false ),
    );

    register_taxonomy( 'industry', array( 'case_study' ), $args );
}
add_action( 'init', 'gildhart_register_industry_taxonomy' );

/**
 * Flush rewrite rules once after CPT/taxonomy registration so /case-studies/ and
 * /services/ URLs work immediately. Uses an option flag so we only flush once
 * (flushing on every load is expensive).
 */
function gildhart_maybe_flush_rewrites_for_cpts() {
    if ( get_option( 'gildhart_cpt_rewrites_flushed' ) !== '1' ) {
        flush_rewrite_rules();
        update_option( 'gildhart_cpt_rewrites_flushed', '1' );
    }
}
add_action( 'init', 'gildhart_maybe_flush_rewrites_for_cpts', 20 );
