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

/**
 * B1 — Home page · Hero
 *
 * Headline is a textarea: each line break becomes one of the three large
 * stacked lines. Mobile override lets you swap copy on small screens
 * (e.g. shorter wording). Leave blank to reuse the desktop copy.
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_home_hero',
    'title'    => 'Home · Hero',
    'fields'   => array(
        array(
            'key'           => 'field_gh_home_hero_eyebrow',
            'label'         => 'Eyebrow',
            'name'          => 'hero_eyebrow',
            'type'          => 'text',
            'default_value' => 'AI Search for Healthcare',
        ),
        array(
            'key'           => 'field_gh_home_hero_headline_desktop',
            'label'         => 'Headline (Desktop)',
            'name'          => 'hero_headline_desktop',
            'type'          => 'textarea',
            'rows'          => 3,
            'instructions'  => 'One line per line break. Renders as three stacked lines with progressively larger sizes.',
            'default_value' => "National Chains Spend Millions.\nStill Lose to Our\nClients.",
        ),
        array(
            'key'          => 'field_gh_home_hero_headline_mobile',
            'label'        => 'Headline (Mobile)',
            'name'         => 'hero_headline_mobile',
            'type'         => 'textarea',
            'rows'         => 3,
            'instructions' => 'Optional. Shorter mobile copy. Leave blank to reuse the desktop headline on mobile.',
        ),
        array(
            'key'          => 'field_gh_home_hero_subtitle',
            'label'        => 'Subtitle',
            'name'         => 'hero_subtitle',
            'type'         => 'textarea',
            'rows'         => 4,
        ),
        array(
            'key'           => 'field_gh_home_hero_primary_cta_label',
            'label'         => 'Primary CTA — Label',
            'name'          => 'hero_primary_cta_label',
            'type'          => 'text',
            'default_value' => 'Get The System',
        ),
        array(
            'key'           => 'field_gh_home_hero_primary_cta_url',
            'label'         => 'Primary CTA — URL',
            'name'          => 'hero_primary_cta_url',
            'type'          => 'text',
            'instructions'  => 'Use a full URL or an anchor like #contact.',
            'default_value' => '#contact',
        ),
        array(
            'key'           => 'field_gh_home_hero_secondary_cta_label',
            'label'         => 'Secondary CTA — Label',
            'name'          => 'hero_secondary_cta_label',
            'type'          => 'text',
            'default_value' => 'See The Proof',
        ),
        array(
            'key'           => 'field_gh_home_hero_secondary_cta_url',
            'label'         => 'Secondary CTA — URL',
            'name'          => 'hero_secondary_cta_url',
            'type'          => 'text',
            'default_value' => '#case-studies',
        ),
        array(
            'key'           => 'field_gh_home_hero_trust_stats',
            'label'         => 'Trust Stats',
            'name'          => 'hero_trust_stats',
            'type'          => 'text',
            'instructions'  => 'Use | as a separator between stats. Example: £50M+ Revenue | 1000+ AI Rankings | 50+ Healthcare Clients',
            'default_value' => '£50M+ Revenue | 1000+ AI Rankings | 50+ Healthcare Clients',
        ),
        array(
            'key'           => 'field_gh_home_hero_image',
            'label'         => 'Hero Image',
            'name'          => 'hero_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'page-templates/page-home.php',
            ),
        ),
    ),
) );

/**
 * B2 — Home page · Logo Bar
 *
 * Auto-loops the logos via CSS animation; we render the gallery twice for a
 * seamless infinite scroll. Eyebrow text sits in the cream band above.
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_home_logo_bar',
    'title'    => 'Home · Logo Bar',
    'fields'   => array(
        array(
            'key'           => 'field_gh_home_logo_bar_eyebrow',
            'label'         => 'Eyebrow',
            'name'          => 'logo_bar_eyebrow',
            'type'          => 'text',
            'default_value' => 'Trusted by healthcare practices across the UK & Worldwide',
        ),
        array(
            'key'           => 'field_gh_home_logo_bar_logos',
            'label'         => 'Client Logos',
            'name'          => 'logo_bar_logos',
            'type'          => 'gallery',
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'instructions'  => 'Upload client logos. Order is preserved. The set is duplicated automatically for the seamless scroll loop.',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'page-templates/page-home.php',
            ),
        ),
    ),
) );

/**
 * Nav metadata — Service CPT.
 *
 * Adds a "Nav Subtitle" field to the Service edit screen, used as the smaller
 * gold subtitle text in the "Our Work" dropdown (e.g. "Bespoke Healthcare
 * Website" under "The Build"). The full Service field group lands in Chunk E.
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_service_nav',
    'title'    => 'Navigation',
    'fields'   => array(
        array(
            'key'          => 'field_gh_service_nav_subtitle',
            'label'        => 'Nav Subtitle',
            'name'         => 'service_nav_subtitle',
            'type'         => 'text',
            'instructions' => 'Short tagline shown beneath the service name in the "Our Work" dropdown.',
            'placeholder'  => 'e.g. Bespoke Healthcare Website',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'service',
            ),
        ),
    ),
    'menu_order' => -10,
    'position'   => 'side',
) );

/**
 * Nav metadata — Case Study CPT.
 *
 * Adds a "Nav Subtitle" field to the Case Study edit screen, used as the
 * smaller gold subtitle text in the "The Proof" dropdown (e.g. "300% Revenue
 * Growth" under "Ealing Travel Clinic"). Full Case Study field group lands
 * in Chunk D.
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_case_study_nav',
    'title'    => 'Navigation',
    'fields'   => array(
        array(
            'key'          => 'field_gh_case_study_nav_subtitle',
            'label'        => 'Nav Subtitle',
            'name'         => 'case_study_nav_subtitle',
            'type'         => 'text',
            'instructions' => 'Short result/headline shown beneath the case study title in the "The Proof" dropdown.',
            'placeholder'  => 'e.g. 300% Revenue Growth',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'case_study',
            ),
        ),
    ),
    'menu_order' => -10,
    'position'   => 'side',
) );
