<?php
/**
 * ACF Field Groups — Gildhart Agency.
 *
 * Letter-coded series:
 *   A1 — Branding (options)
 *   A2 — Contact (options)
 *   A3 — Social Media (options)
 *   A4 — Navigation (options)
 *   A5 — Footer (options)
 *   B+ — Page-specific groups, added as each page is built (Phase 3+).
 *
 * @package Gildhart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

/**
 * A1 — Branding
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_branding',
    'title'    => 'Branding',
    'fields'   => array(
        array(
            'key'           => 'field_gh_agency_logo',
            'label'         => 'Logo',
            'name'          => 'agency_logo',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'instructions'  => 'Used in the header and footer. Falls back to the WordPress custom logo, then a default SVG.',
        ),
        array(
            'key'          => 'field_gh_agency_name',
            'label'        => 'Agency Name',
            'name'         => 'agency_name',
            'type'         => 'text',
            'default_value' => 'Gildhart',
        ),
        array(
            'key'          => 'field_gh_agency_tagline',
            'label'        => 'Tagline',
            'name'         => 'agency_tagline',
            'type'         => 'text',
            'default_value' => 'AI Search for Healthcare',
            'instructions' => 'Short brand tagline shown in footer and meta tags.',
        ),
        array(
            'key'          => 'field_gh_agency_description',
            'label'        => 'Short Description',
            'name'         => 'agency_description',
            'type'         => 'textarea',
            'rows'         => 3,
            'instructions' => 'One- to two-sentence description used in the footer.',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'options_page',
                'operator' => '==',
                'value'    => 'gildhart-branding',
            ),
        ),
    ),
) );

/**
 * A2 — Contact
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_contact',
    'title'    => 'Contact',
    'fields'   => array(
        array(
            'key'   => 'field_gh_agency_phone',
            'label' => 'Phone',
            'name'  => 'agency_phone',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_agency_email',
            'label' => 'Email',
            'name'  => 'agency_email',
            'type'  => 'email',
        ),
        array(
            'key'   => 'field_gh_agency_address',
            'label' => 'Address',
            'name'  => 'agency_address',
            'type'  => 'textarea',
            'rows'  => 3,
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'options_page',
                'operator' => '==',
                'value'    => 'gildhart-contact',
            ),
        ),
    ),
) );

/**
 * A3 — Social Media
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_social',
    'title'    => 'Social Media',
    'fields'   => array(
        array(
            'key'   => 'field_gh_social_linkedin',
            'label' => 'LinkedIn URL',
            'name'  => 'social_linkedin',
            'type'  => 'url',
        ),
        array(
            'key'   => 'field_gh_social_twitter',
            'label' => 'Twitter / X URL',
            'name'  => 'social_twitter',
            'type'  => 'url',
        ),
        array(
            'key'   => 'field_gh_social_youtube',
            'label' => 'YouTube URL',
            'name'  => 'social_youtube',
            'type'  => 'url',
        ),
        array(
            'key'   => 'field_gh_social_instagram',
            'label' => 'Instagram URL',
            'name'  => 'social_instagram',
            'type'  => 'url',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'options_page',
                'operator' => '==',
                'value'    => 'gildhart-social',
            ),
        ),
    ),
) );

/**
 * A4 — Navigation
 *
 * Top-level dropdown structure mirrors the static design (Who We Help, Our Work,
 * The Proof, About, Waitlist CTA). "Our Work" and "The Proof" auto-populate
 * from the service / case_study CPTs in the header template, so we don't store
 * those items here. "Who We Help" is a repeater because those items don't map
 * to a CPT (they're audience segments, not content entries).
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_navigation',
    'title'    => 'Navigation',
    'fields'   => array(
        array(
            'key'           => 'field_gh_nav_waitlist_label',
            'label'         => 'Waitlist CTA — Label',
            'name'          => 'waitlist_label',
            'type'          => 'text',
            'default_value' => 'Join The Waitlist',
        ),
        array(
            'key'          => 'field_gh_nav_waitlist_page',
            'label'        => 'Waitlist CTA — Page',
            'name'         => 'waitlist_page',
            'type'         => 'page_link',
            'instructions' => 'Page the CTA links to. Defaults to /waitlist/.',
            'allow_null'   => 1,
        ),
        array(
            'key'      => 'field_gh_nav_who_we_help',
            'label'    => '"Who We Help" Items',
            'name'     => 'who_we_help_items',
            'type'     => 'repeater',
            'layout'   => 'table',
            'min'      => 0,
            'sub_fields' => array(
                array(
                    'key'   => 'field_gh_nav_wwh_label',
                    'label' => 'Label',
                    'name'  => 'label',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_nav_wwh_url',
                    'label' => 'URL',
                    'name'  => 'url',
                    'type'  => 'url',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'options_page',
                'operator' => '==',
                'value'    => 'gildhart-navigation',
            ),
        ),
    ),
) );

/**
 * A5 — Footer
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_footer',
    'title'    => 'Footer',
    'fields'   => array(
        array(
            'key'           => 'field_gh_footer_tagline',
            'label'         => 'Footer Tagline',
            'name'          => 'footer_tagline',
            'type'          => 'text',
            'default_value' => 'The AI Search Playbook for Healthcare',
        ),
        array(
            'key'   => 'field_gh_footer_description',
            'label' => 'Footer Description',
            'name'  => 'footer_description',
            'type'  => 'textarea',
            'rows'  => 3,
        ),
        array(
            'key'           => 'field_gh_footer_brand_link_label',
            'label'         => 'Brand Link Label',
            'name'          => 'footer_brand_link_label',
            'type'          => 'text',
            'instructions'  => 'CTA-style link below footer description (optional).',
            'default_value' => 'Get The Playbook — £497 →',
        ),
        array(
            'key'        => 'field_gh_footer_brand_link_url',
            'label'      => 'Brand Link URL',
            'name'       => 'footer_brand_link_url',
            'type'       => 'url',
        ),
        array(
            'key'        => 'field_gh_footer_legal_links',
            'label'      => 'Legal Links',
            'name'       => 'footer_legal_links',
            'type'       => 'repeater',
            'layout'     => 'table',
            'min'        => 0,
            'sub_fields' => array(
                array(
                    'key'   => 'field_gh_footer_legal_label',
                    'label' => 'Label',
                    'name'  => 'label',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_footer_legal_url',
                    'label' => 'URL',
                    'name'  => 'url',
                    'type'  => 'url',
                ),
            ),
        ),
        array(
            'key'           => 'field_gh_footer_copyright',
            'label'         => 'Copyright Text',
            'name'          => 'footer_copyright',
            'type'          => 'text',
            'instructions'  => 'Use {year} for the current year.',
            'default_value' => '© {year} Gildhart. All rights reserved.',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'options_page',
                'operator' => '==',
                'value'    => 'gildhart-footer',
            ),
        ),
    ),
) );
