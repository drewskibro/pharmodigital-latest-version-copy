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
    'menu_order' => 1,
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
    'menu_order' => 2,
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
 * B3 — Home page · Featured Case Study
 *
 * Quote-led testimonial card with author, stars, and a linked CTA card on
 * the right summarising the result.
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_home_featured_case',
    'title'    => 'Home · Featured Case Study',
    'menu_order' => 3,
    'fields'   => array(
        array(
            'key'           => 'field_gh_home_fcs_image',
            'label'         => 'Image',
            'name'          => 'fcs_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
        ),
        array(
            'key'          => 'field_gh_home_fcs_quote',
            'label'        => 'Quote',
            'name'         => 'fcs_quote',
            'type'         => 'textarea',
            'rows'         => 4,
            'instructions' => 'Supports limited HTML (e.g. <strong> for emphasis on key words).',
            'default_value' => '"Traffic\'s up <strong>300%</strong> and compounding every month. Not just traffic for the sake of it, but <strong>patients actually booking appointments.</strong>"',
        ),
        array(
            'key'   => 'field_gh_home_fcs_author_name',
            'label' => 'Author Name',
            'name'  => 'fcs_author_name',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_home_fcs_author_title',
            'label' => 'Author Title',
            'name'  => 'fcs_author_title',
            'type'  => 'text',
        ),
        array(
            'key'           => 'field_gh_home_fcs_show_stars',
            'label'         => 'Show 5 Stars',
            'name'          => 'fcs_show_stars',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),

        // CTA card (right column)
        array(
            'key'           => 'field_gh_home_fcs_cta_badge',
            'label'         => 'CTA Card · Badge',
            'name'          => 'fcs_cta_badge',
            'type'          => 'text',
            'default_value' => 'Full Case Study',
        ),
        array(
            'key'           => 'field_gh_home_fcs_cta_text',
            'label'         => 'CTA Card · Lead Text',
            'name'          => 'fcs_cta_text',
            'type'          => 'text',
            'default_value' => 'See the 6-month transformation that generated',
        ),
        array(
            'key'           => 'field_gh_home_fcs_cta_number',
            'label'         => 'CTA Card · Big Number',
            'name'          => 'fcs_cta_number',
            'type'          => 'text',
            'default_value' => '300%',
        ),
        array(
            'key'           => 'field_gh_home_fcs_cta_label',
            'label'         => 'CTA Card · Number Suffix',
            'name'          => 'fcs_cta_label',
            'type'          => 'text',
            'default_value' => 'more patients →',
        ),
        array(
            'key'   => 'field_gh_home_fcs_cta_meta',
            'label' => 'CTA Card · Meta Line',
            'name'  => 'fcs_cta_meta',
            'type'  => 'text',
            'default_value' => '6-month transformation • AI Overview rankings • Real booking data',
        ),
        array(
            'key'   => 'field_gh_home_fcs_cta_how',
            'label' => 'CTA Card · How Line',
            'name'  => 'fcs_cta_how',
            'type'  => 'text',
            'default_value' => 'How: AI-optimised content. Zero ad spend. Six weeks to #1 in Google AI Overviews.',
        ),
        array(
            'key'           => 'field_gh_home_fcs_cta_link_label',
            'label'         => 'CTA Card · Link Label',
            'name'          => 'fcs_cta_link_label',
            'type'          => 'text',
            'default_value' => 'See How We Did It',
        ),
        array(
            'key'          => 'field_gh_home_fcs_case_study',
            'label'        => 'CTA Card · Case Study',
            'name'         => 'fcs_case_study',
            'type'         => 'post_object',
            'post_type'    => array( 'case_study' ),
            'return_format' => 'id',
            'allow_null'   => 1,
            'instructions' => 'Optional. If selected, the CTA card links to this case study and overrides the URL field below.',
        ),
        array(
            'key'          => 'field_gh_home_fcs_link_url',
            'label'        => 'CTA Card · Link URL',
            'name'         => 'fcs_link_url',
            'type'         => 'text',
            'instructions' => 'Used when no Case Study is selected above. Accepts full URLs or anchors.',
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
 * B4 — Home page · Split (Problem / Solution)
 *
 * Two-column block: dark navy "Problem" copy on the left, warm gradient
 * "Solution" with a card grid on the right. Full-width gold-on-green CTA
 * strip beneath. Cards use Font Awesome icons; enter the icon name (e.g.
 * "chart-line") and the gh_fa_class helper auto-prefixes "fas".
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_home_split',
    'title'    => 'Home · Split (Problem / Solution)',
    'menu_order' => 4,
    'fields'   => array(
        // Problem (left)
        array(
            'key'           => 'field_gh_home_split_problem_eyebrow',
            'label'         => 'Problem · Eyebrow',
            'name'          => 'split_problem_eyebrow',
            'type'          => 'text',
            'default_value' => 'THE PROBLEM',
        ),
        array(
            'key'   => 'field_gh_home_split_problem_title',
            'label' => 'Problem · Title',
            'name'  => 'split_problem_title',
            'type'  => 'text',
        ),
        array(
            'key'          => 'field_gh_home_split_problem_lines',
            'label'        => 'Problem · Body Paragraphs',
            'name'         => 'split_problem_lines',
            'type'         => 'repeater',
            'layout'       => 'block',
            'min'          => 0,
            'max'          => 4,
            'instructions' => 'Add up to 4 paragraphs. Each animates in sequentially when the section scrolls into view.',
            'sub_fields'   => array(
                array(
                    'key'   => 'field_gh_home_split_problem_line_text',
                    'label' => 'Paragraph',
                    'name'  => 'text',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ),
            ),
        ),

        // Solution (right)
        array(
            'key'           => 'field_gh_home_split_solution_eyebrow',
            'label'         => 'Solution · Eyebrow',
            'name'          => 'split_solution_eyebrow',
            'type'          => 'text',
            'default_value' => 'THE SOLUTION',
        ),
        array(
            'key'          => 'field_gh_home_split_cards',
            'label'        => 'Solution · Cards',
            'name'         => 'split_cards',
            'type'         => 'repeater',
            'layout'       => 'block',
            'min'          => 0,
            'max'          => 6,
            'instructions' => 'Up to 6 cards in a 2-column grid.',
            'sub_fields'   => array(
                array(
                    'key'          => 'field_gh_home_split_card_icon',
                    'label'        => 'Icon (Font Awesome name)',
                    'name'         => 'icon',
                    'type'         => 'text',
                    'instructions' => 'e.g. "chart-line" or "magnifying-glass". Auto-prefixed "fas".',
                ),
                array(
                    'key'   => 'field_gh_home_split_card_title',
                    'label' => 'Title',
                    'name'  => 'title',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_home_split_card_text',
                    'label' => 'Body',
                    'name'  => 'text',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ),
            ),
        ),

        // CTA strip
        array(
            'key'   => 'field_gh_home_split_cta_text',
            'label' => 'CTA Strip · Text',
            'name'  => 'split_cta_text',
            'type'  => 'textarea',
            'rows'  => 2,
        ),
        array(
            'key'           => 'field_gh_home_split_cta_label',
            'label'         => 'CTA Strip · Button Label',
            'name'          => 'split_cta_label',
            'type'          => 'text',
            'default_value' => 'Get The System →',
        ),
        array(
            'key'           => 'field_gh_home_split_cta_url',
            'label'         => 'CTA Strip · Button URL',
            'name'          => 'split_cta_url',
            'type'          => 'text',
            'default_value' => '#contact',
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
 * B5 — Home page · The Shift
 *
 * Three blocks: header, two-column comparison (Google search mockup vs
 * ChatGPT mockup), and a row of three "client result" proof cards. The
 * mockup decorations themselves (fake search-result bars, AI bubble
 * styling) are hardcoded in the template part — only the editable copy
 * (queries, captions, recommendations) is fielded here.
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_home_shift',
    'title'    => 'Home · The Shift',
    'menu_order' => 5,
    'fields'   => array(
        array(
            'key'           => 'field_gh_home_shift_eyebrow',
            'label'         => 'Eyebrow',
            'name'          => 'shift_eyebrow',
            'type'          => 'text',
            'default_value' => 'The Shift',
        ),
        array(
            'key'   => 'field_gh_home_shift_headline',
            'label' => 'Headline',
            'name'  => 'shift_headline',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_home_shift_subheadline',
            'label' => 'Subheadline',
            'name'  => 'shift_subheadline',
            'type'  => 'textarea',
            'rows'  => 2,
        ),

        // Old column
        array(
            'key'           => 'field_gh_home_shift_old_label',
            'label'         => 'Old Column · Label',
            'name'          => 'shift_old_label',
            'type'          => 'text',
            'default_value' => 'The Old Game',
        ),
        array(
            'key'           => 'field_gh_home_shift_old_query',
            'label'         => 'Old Column · Search Query',
            'name'          => 'shift_old_query',
            'type'          => 'text',
            'instructions'  => 'Shown inside the fake Google search bar.',
            'default_value' => 'Best Mounjaro provider',
        ),
        array(
            'key'   => 'field_gh_home_shift_old_caption',
            'label' => 'Old Column · Caption',
            'name'  => 'shift_old_caption',
            'type'  => 'textarea',
            'rows'  => 2,
            'instructions' => 'Supports limited HTML (<strong>).',
        ),

        // New column
        array(
            'key'           => 'field_gh_home_shift_new_label',
            'label'         => 'New Column · Label',
            'name'          => 'shift_new_label',
            'type'          => 'text',
            'default_value' => 'The New Reality',
        ),
        array(
            'key'           => 'field_gh_home_shift_new_logo_label',
            'label'         => 'New Column · AI Tool Name',
            'name'          => 'shift_new_logo_label',
            'type'          => 'text',
            'default_value' => 'ChatGPT',
        ),
        array(
            'key'           => 'field_gh_home_shift_new_query',
            'label'         => 'New Column · User Query',
            'name'          => 'shift_new_query',
            'type'          => 'text',
            'default_value' => 'Best Mounjaro provider UK?',
        ),
        array(
            'key'   => 'field_gh_home_shift_new_response_intro',
            'label' => 'New Column · AI Response Intro',
            'name'  => 'shift_new_response_intro',
            'type'  => 'textarea',
            'rows'  => 2,
            'default_value' => 'Here are the top providers currently recommended for Mounjaro in the UK:',
        ),
        array(
            'key'          => 'field_gh_home_shift_new_recommendations',
            'label'        => 'New Column · AI Recommendations',
            'name'         => 'shift_new_recommendations',
            'type'         => 'repeater',
            'layout'       => 'block',
            'min'          => 1,
            'max'          => 3,
            'sub_fields'   => array(
                array(
                    'key'   => 'field_gh_home_shift_new_rec_name',
                    'label' => 'Name',
                    'name'  => 'name',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_home_shift_new_rec_detail',
                    'label' => 'Detail',
                    'name'  => 'detail',
                    'type'  => 'textarea',
                    'rows'  => 2,
                ),
            ),
        ),
        array(
            'key'           => 'field_gh_home_shift_new_shortlist_note',
            'label'         => 'New Column · Shortlist Note',
            'name'          => 'shift_new_shortlist_note',
            'type'          => 'text',
            'default_value' => "AI gives 3–5 recommendations. That's the entire market.",
        ),
        array(
            'key'   => 'field_gh_home_shift_new_caption',
            'label' => 'New Column · Caption',
            'name'  => 'shift_new_caption',
            'type'  => 'textarea',
            'rows'  => 2,
            'instructions' => 'Supports limited HTML (<strong>).',
        ),

        // Proof cards
        array(
            'key'          => 'field_gh_home_shift_proof_cards',
            'label'        => 'Proof Cards',
            'name'         => 'shift_proof_cards',
            'type'         => 'repeater',
            'layout'       => 'block',
            'min'          => 0,
            'max'          => 6,
            'instructions' => 'Three cards looks best. Each is one client result.',
            'sub_fields'   => array(
                array(
                    'key'           => 'field_gh_home_shift_proof_label',
                    'label'         => 'Label',
                    'name'          => 'label',
                    'type'          => 'text',
                    'default_value' => 'CLIENT RESULT',
                ),
                array(
                    'key'   => 'field_gh_home_shift_proof_name',
                    'label' => 'Client Name',
                    'name'  => 'name',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_home_shift_proof_win',
                    'label' => 'Result Description',
                    'name'  => 'win',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ),
                array(
                    'key'   => 'field_gh_home_shift_proof_stat',
                    'label' => 'Headline Stat',
                    'name'  => 'stat',
                    'type'  => 'text',
                ),
            ),
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
 * B6 — Home page · Two Paths
 *
 * Three-card pricing/offering block. Centre card can be marked "featured"
 * for the dark-fill highlighted style (with a "Recommended" pill).
 * Each card has an optional proof banner above (with a dark variant for
 * green-fill banners). Price block accepts either a big number+note
 * (e.g. "£497" / "One-time. Yours forever.") or a muted paragraph (used
 * for the Done-For-You card's "ROI within 90 days..." copy) — or both,
 * or neither.
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_home_two_paths',
    'title'    => 'Home · Two Paths',
    'menu_order' => 6,
    'fields'   => array(
        array(
            'key'           => 'field_gh_home_two_paths_eyebrow',
            'label'         => 'Section Eyebrow',
            'name'          => 'two_paths_eyebrow',
            'type'          => 'text',
            'default_value' => 'CHOOSE YOUR ENTRY POINT',
            'instructions'  => 'Small caps line above the headline. Tracked-out gold treatment.',
        ),
        array(
            'key'   => 'field_gh_home_two_paths_headline',
            'label' => 'Headline',
            'name'  => 'two_paths_headline',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_home_two_paths_subheadline',
            'label' => 'Subheadline',
            'name'  => 'two_paths_subheadline',
            'type'  => 'text',
        ),
        array(
            'key'        => 'field_gh_home_two_paths_cards',
            'label'      => 'Cards',
            'name'       => 'two_paths_cards',
            'type'       => 'repeater',
            'layout'     => 'block',
            'min'        => 0,
            'max'        => 6,
            'instructions' => 'Three cards is the designed layout. Drag the centre card into position 2 and mark it "Hero" for the dark forest-green hero treatment with gold ribbon.',
            'sub_fields' => array(
                array(
                    'key'           => 'field_gh_home_tp_card_featured',
                    'label'         => 'Hero Card (Forest-Green Treatment)',
                    'name'          => 'is_featured',
                    'type'          => 'true_false',
                    'instructions'  => 'Mark the centre card to give it the forest-green fill, gold inner border, slightly taller padding, and reversed gold-button CTA. Use on Card 2 only.',
                    'default_value' => 0,
                    'ui'            => 1,
                ),
                array(
                    'key'           => 'field_gh_home_tp_card_dark',
                    'label'         => 'Dark Card (Navy Treatment)',
                    'name'          => 'is_dark',
                    'type'          => 'true_false',
                    'instructions'  => 'Mark to give the card the dark navy fill with cream/white type. Use on Card 3 (The Agent). Mutually exclusive with Hero Card — Hero takes precedence if both are on.',
                    'default_value' => 0,
                    'ui'            => 1,
                ),
                array(
                    'key'           => 'field_gh_home_tp_card_image',
                    'label'         => 'Hero Image',
                    'name'          => 'image',
                    'type'          => 'image',
                    'return_format' => 'id',
                    'preview_size'  => 'medium',
                    'instructions'  => 'Optional. Renders flush at the top of the card with rounded top corners. ~200-220px tall. Falls back to a styled placeholder when empty.',
                ),
                array(
                    'key'           => 'field_gh_home_tp_card_ribbon',
                    'label'         => 'Hero Ribbon Text (deprecated)',
                    'name'          => 'ribbon_text',
                    'type'          => 'text',
                    'instructions'  => 'No longer rendered. Left in place for legacy data only — leave empty.',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_banner',
                    'label' => 'Banner Text (Outer Cards Only)',
                    'name'  => 'banner',
                    'type'  => 'text',
                    'instructions' => 'Small caps banner at the top of non-hero cards. Hidden on the hero card (which uses the gold ribbon instead).',
                ),
                array(
                    'key'           => 'field_gh_home_tp_card_banner_dark',
                    'label'         => 'Banner Style — Dark Green (deprecated)',
                    'name'          => 'banner_dark',
                    'type'          => 'true_false',
                    'instructions'  => 'No longer used by the redesigned section. Left in place for legacy data only.',
                    'default_value' => 0,
                    'ui'            => 1,
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_kicker',
                    'label' => 'Kicker (Small Italic Above Title)',
                    'name'  => 'kicker',
                    'type'  => 'text',
                    'instructions' => 'Optional. Small italic line above the title. e.g. "Deployed worldwide".',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_label',
                    'label' => 'Eyebrow Label',
                    'name'  => 'label',
                    'type'  => 'text',
                    'instructions' => 'Small caps gold label. e.g. "THE AGENT".',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_title',
                    'label' => 'Title',
                    'name'  => 'title',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_body',
                    'label' => 'Body (Proof Statement)',
                    'name'  => 'body',
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'instructions' => 'The headline proof statement. Italic, with a gold left-border treatment. Set the value, do not write a paragraph.',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_proof_number',
                    'label' => 'Proof Anchor — Number',
                    'name'  => 'proof_number',
                    'type'  => 'text',
                    'instructions' => 'Single big numeric proof point. e.g. "55", "50+", "£500k".',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_proof_label',
                    'label' => 'Proof Anchor — Descriptor',
                    'name'  => 'proof_label',
                    'type'  => 'text',
                    'instructions' => 'Small descriptor under the proof number. e.g. "HPV appointments in one month — one practice".',
                ),
                array(
                    'key'        => 'field_gh_home_tp_card_features',
                    'label'      => 'Bullet List',
                    'name'       => 'features',
                    'type'       => 'repeater',
                    'layout'     => 'table',
                    'min'        => 0,
                    'sub_fields' => array(
                        array(
                            'key'   => 'field_gh_home_tp_card_feature_text',
                            'label' => 'Bullet',
                            'name'  => 'text',
                            'type'  => 'text',
                        ),
                    ),
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_price',
                    'label' => 'Price',
                    'name'  => 'price_value',
                    'type'  => 'text',
                    'instructions' => 'e.g. "£497", "From £125/mo", "By application".',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_price_note',
                    'label' => 'Price Note (Italic)',
                    'name'  => 'price_value_note',
                    'type'  => 'text',
                    'instructions' => 'Italic line under the price. e.g. "One-time. Yours forever." / "Custom investment. Waitlist only."',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_price_muted',
                    'label' => 'Price — Muted Paragraph (deprecated)',
                    'name'  => 'price_muted_text',
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'instructions' => 'No longer rendered. Left in place for legacy data only.',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_cta_label',
                    'label' => 'CTA Button Label',
                    'name'  => 'cta_label',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_cta_url',
                    'label' => 'CTA Button URL',
                    'name'  => 'cta_url',
                    'type'  => 'text',
                ),
            ),
        ),
        array(
            'key'           => 'field_gh_home_two_paths_trust_line',
            'label'         => 'Trust Line (Below Cards)',
            'name'          => 'two_paths_trust_line',
            'type'          => 'text',
            'default_value' => "Every path is built on revenue we've already generated for real practices.",
            'instructions'  => 'Italic centred line below the three cards.',
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
 * B7 — Home page · Case Studies Carousel
 *
 * Auto-pulls published case_study posts. Each card displays the post's
 * featured image, first `industry` taxonomy term as the tag, title,
 * excerpt as the description, and a CTA label that defaults to the
 * carousel's default but can be overridden per-post.
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_home_case_studies',
    'title'    => 'Home · Case Studies Carousel',
    'menu_order' => 7,
    'fields'   => array(
        array(
            'key'           => 'field_gh_home_cs_title',
            'label'         => 'Section Title',
            'name'          => 'cs_carousel_title',
            'type'          => 'text',
            'default_value' => 'Healthcare marketing success stories',
        ),
        array(
            'key'           => 'field_gh_home_cs_subtitle',
            'label'         => 'Section Subtitle',
            'name'          => 'cs_carousel_subtitle',
            'type'          => 'text',
            'default_value' => "See how we've helped practices dominate AI search",
        ),
        array(
            'key'           => 'field_gh_home_cs_default_cta',
            'label'         => 'Default Card CTA',
            'name'          => 'cs_carousel_default_cta',
            'type'          => 'text',
            'instructions'  => 'Default link label used on each card unless that case study overrides it on its own edit screen.',
            'default_value' => 'See exactly how they did it →',
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
 * Per-Case-Study override — Card CTA label for the homepage carousel.
 *
 * Lives on the Case Study edit screen alongside the existing Nav Subtitle
 * field group (positioned in the sidebar). Lets each case study tweak the
 * "See exactly how they did it →" CTA text without changing the carousel
 * default.
 */
acf_add_local_field_group( array(
    'key'        => 'group_gh_case_study_card',
    'title'      => 'Card / Carousel',
    'fields'     => array(
        array(
            'key'          => 'field_gh_case_study_card_cta',
            'label'        => 'Card CTA Label',
            'name'         => 'case_study_card_cta_label',
            'type'         => 'text',
            'instructions' => 'Optional. Overrides the homepage carousel default for this case study.',
            'placeholder'  => 'e.g. See how they did it →',
        ),
    ),
    'location'   => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'case_study',
            ),
        ),
    ),
    'menu_order' => -9,
    'position'   => 'side',
) );

/**
 * B8 — Home page · Founder
 *
 * Two-column section: portrait left (with a soft cream-fade gradient at the
 * bottom) + ACF-driven copy block right. Body paragraphs reveal sequentially
 * via .founder-visible scroll trigger.
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_home_founder',
    'title'    => 'Home · Founder',
    'menu_order' => 8,
    'fields'   => array(
        array(
            'key'           => 'field_gh_home_founder_image',
            'label'         => 'Portrait Image',
            'name'          => 'founder_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
        ),
        array(
            'key'           => 'field_gh_home_founder_eyebrow',
            'label'         => 'Eyebrow',
            'name'          => 'founder_eyebrow',
            'type'          => 'text',
            'default_value' => 'The Person Behind The Results',
        ),
        array(
            'key'   => 'field_gh_home_founder_headline',
            'label' => 'Headline',
            'name'  => 'founder_headline',
            'type'  => 'text',
        ),
        array(
            'key'          => 'field_gh_home_founder_paragraphs',
            'label'        => 'Body Paragraphs',
            'name'         => 'founder_paragraphs',
            'type'         => 'repeater',
            'layout'       => 'block',
            'min'          => 0,
            'max'          => 5,
            'instructions' => 'Each paragraph reveals sequentially. Last paragraph gets bold-emphasis styling.',
            'sub_fields'   => array(
                array(
                    'key'   => 'field_gh_home_founder_paragraph_text',
                    'label' => 'Paragraph',
                    'name'  => 'text',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ),
            ),
        ),
        array(
            'key'           => 'field_gh_home_founder_name',
            'label'         => 'Founder Name',
            'name'          => 'founder_name',
            'type'          => 'text',
            'default_value' => 'Drew',
        ),
        array(
            'key'           => 'field_gh_home_founder_title',
            'label'         => 'Founder Title',
            'name'          => 'founder_title',
            'type'          => 'text',
            'default_value' => 'Founder, Gildhart',
        ),
        array(
            'key'   => 'field_gh_home_founder_linkedin_url',
            'label' => 'LinkedIn URL',
            'name'  => 'founder_linkedin_url',
            'type'  => 'url',
        ),
        array(
            'key'           => 'field_gh_home_founder_linkedin_text',
            'label'         => 'LinkedIn Pitch Text',
            'name'          => 'founder_linkedin_text',
            'type'          => 'text',
            'default_value' => 'Connect with me on LinkedIn — 5,000+ healthcare professionals follow our AI search insights.',
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
 * B9 — Home page · Revenue Results
 *
 * Dark navy section with header + 2x2 grid of revenue cards (cards 2 and 4
 * get the elevated/featured styling automatically) + a closing block with
 * stat callout, body copy, gut-punch line, and dual CTAs.
 *
 * The optional gildhart logo divider sits above this section and can be
 * toggled on/off.
 */
acf_add_local_field_group( array(
    'key'      => 'group_gh_home_revenue',
    'title'    => 'Home · Revenue Results',
    'menu_order' => 9,
    'fields'   => array(
        array(
            'key'           => 'field_gh_home_revenue_show_divider',
            'label'         => 'Show Gildhart Logo Divider Above',
            'name'          => 'revenue_show_divider',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),

        array(
            'key'               => 'field_gh_home_revenue_divider_logo',
            'label'             => 'Divider Logo Override',
            'name'              => 'revenue_divider_logo',
            'type'              => 'image',
            'return_format'     => 'id',
            'preview_size'      => 'medium',
            'instructions'      => 'Upload a logo specifically for this divider strip. Leave blank to use the global brand logo.',
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => 'field_gh_home_revenue_show_divider',
                        'operator' => '==',
                        'value'    => '1',
                    ),
                ),
            ),
        ),

        array(
            'key'           => 'field_gh_home_revenue_eyebrow',
            'label'         => 'Eyebrow',
            'name'          => 'revenue_eyebrow',
            'type'          => 'text',
            'default_value' => 'The Numbers',
        ),
        array(
            'key'   => 'field_gh_home_revenue_headline',
            'label' => 'Headline (Top Line)',
            'name'  => 'revenue_headline',
            'type'  => 'text',
        ),
        array(
            'key'          => 'field_gh_home_revenue_headline_accent',
            'label'        => 'Headline (Accent — Gold Underline)',
            'name'         => 'revenue_headline_accent',
            'type'         => 'text',
            'instructions' => 'Renders below the top line in cream with a gold underline.',
        ),
        array(
            'key'          => 'field_gh_home_revenue_subheadline',
            'label'        => 'Subheadline',
            'name'         => 'revenue_subheadline',
            'type'         => 'textarea',
            'rows'         => 2,
            'instructions' => 'Supports limited HTML (<strong>).',
        ),

        array(
            'key'          => 'field_gh_home_revenue_cards',
            'label'        => 'Revenue Cards',
            'name'         => 'revenue_cards',
            'type'         => 'repeater',
            'layout'       => 'block',
            'min'          => 0,
            'max'          => 4,
            'instructions' => '2×2 grid. Cards 2 and 4 automatically get the elevated featured styling.',
            'sub_fields'   => array(
                array(
                    'key'   => 'field_gh_home_revenue_card_label',
                    'label' => 'Client / Label',
                    'name'  => 'label',
                    'type'  => 'text',
                ),
                array(
                    'key'          => 'field_gh_home_revenue_card_number',
                    'label'        => 'Big Number',
                    'name'         => 'number',
                    'type'         => 'text',
                    'instructions' => 'Pre-formatted, e.g. "50%", "£99k/year", "£200k".',
                ),
                array(
                    'key'   => 'field_gh_home_revenue_card_descriptor',
                    'label' => 'Descriptor',
                    'name'  => 'descriptor',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_home_revenue_card_proof',
                    'label' => 'Proof Detail',
                    'name'  => 'proof',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ),
            ),
        ),

        // Closing block
        array(
            'key'          => 'field_gh_home_revenue_close_headline',
            'label'        => 'Closing · Headline',
            'name'         => 'revenue_close_headline',
            'type'         => 'text',
            'instructions' => 'Italic centered headline above the stat callout.',
        ),
        array(
            'key'          => 'field_gh_home_revenue_close_stat_num',
            'label'        => 'Closing · Stat Number',
            'name'         => 'revenue_close_stat_num',
            'type'         => 'text',
            'instructions' => 'e.g. 4.4×',
        ),
        array(
            'key'   => 'field_gh_home_revenue_close_stat_strong',
            'label' => 'Closing · Stat Label (Strong First Line)',
            'name'  => 'revenue_close_stat_strong',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_home_revenue_close_stat_label',
            'label' => 'Closing · Stat Label (Detail)',
            'name'  => 'revenue_close_stat_label',
            'type'  => 'textarea',
            'rows'  => 2,
        ),
        array(
            'key'        => 'field_gh_home_revenue_close_body',
            'label'      => 'Closing · Body Paragraphs',
            'name'       => 'revenue_close_body',
            'type'       => 'repeater',
            'layout'     => 'block',
            'min'        => 0,
            'max'        => 5,
            'sub_fields' => array(
                array(
                    'key'   => 'field_gh_home_revenue_close_body_text',
                    'label' => 'Paragraph',
                    'name'  => 'text',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ),
            ),
        ),
        array(
            'key'   => 'field_gh_home_revenue_close_final',
            'label' => 'Closing · Final Line (Centered Italic)',
            'name'  => 'revenue_close_final',
            'type'  => 'textarea',
            'rows'  => 3,
        ),
        array(
            'key'           => 'field_gh_home_revenue_close_cta1_label',
            'label'         => 'Closing · Primary CTA Label',
            'name'          => 'revenue_close_cta_primary_label',
            'type'          => 'text',
            'default_value' => "See If You're On The AI Shortlist →",
        ),
        array(
            'key'           => 'field_gh_home_revenue_close_cta1_url',
            'label'         => 'Closing · Primary CTA URL',
            'name'          => 'revenue_close_cta_primary_url',
            'type'          => 'text',
            'default_value' => '#contact',
        ),
        array(
            'key'           => 'field_gh_home_revenue_close_cta2_label',
            'label'         => 'Closing · Secondary CTA Label',
            'name'          => 'revenue_close_cta_secondary_label',
            'type'          => 'text',
            'default_value' => 'See What We Build →',
        ),
        array(
            'key'           => 'field_gh_home_revenue_close_cta2_url',
            'label'         => 'Closing · Secondary CTA URL',
            'name'          => 'revenue_close_cta_secondary_url',
            'type'          => 'text',
            'default_value' => '/services',
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

/* ─────────────────────────────────────────────────────────────────────────
 * SERVICE CPT — One field group per section (homepage pattern).
 *
 * Each section has its own ACF field group on the service CPT, ordered by
 * menu_order to match the render sequence in single-service.php. Every group
 * carries a "Show this section" toggle so individual services can hide the
 * section that doesn't apply to them. Fields are name-prefixed (service_X_)
 * to keep them unambiguous in the database.
 *
 * Groups ship in chunks: S0 = Hero. S1+ append Problem Shift, Three Proof
 * Cases, Method, FAQ, etc.
 * ───────────────────────────────────────────────────────────────────────── */

/* Service · Hero */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_hero',
    'title'      => 'Service · Hero',
    'menu_order' => 1,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_hero_show',
            'label'         => 'Show this section',
            'name'          => 'service_hero_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
            'instructions'  => 'Toggle off to hide the Hero section on this service.',
        ),
        array(
            'key'           => 'field_gh_service_hero_eyebrow',
            'label'         => 'Eyebrow',
            'name'          => 'service_hero_eyebrow',
            'type'          => 'text',
            'instructions'  => 'Small caps line above the title. Default: "The AI Search Playbook".',
        ),
        array(
            'key'          => 'field_gh_service_hero_title',
            'label'        => 'Title (H1)',
            'name'         => 'service_hero_title',
            'type'         => 'textarea',
            'rows'         => 3,
            'new_lines'    => '',
            'instructions' => 'Single line for a regular hero, or one line per row for a stacked title (lines progressively grow in size, like the Agent hero).',
        ),
        array(
            'key'   => 'field_gh_service_hero_subtitle',
            'label' => 'Subtitle',
            'name'  => 'service_hero_subtitle',
            'type'  => 'textarea',
            'rows'  => 3,
        ),
        array(
            'key'        => 'field_gh_service_hero_stats',
            'label'      => 'Stats Row',
            'name'       => 'service_hero_stats',
            'type'       => 'repeater',
            'layout'     => 'table',
            'min'        => 0,
            'max'        => 4,
            'instructions' => 'Three stats is the designed layout. Big number + small uppercase descriptor.',
            'sub_fields' => array(
                array(
                    'key'   => 'field_gh_service_hero_stat_num',
                    'label' => 'Number',
                    'name'  => 'number',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_service_hero_stat_label',
                    'label' => 'Label',
                    'name'  => 'label',
                    'type'  => 'text',
                ),
            ),
        ),
        array(
            'key'   => 'field_gh_service_hero_cta1_label',
            'label' => 'Primary CTA — Label',
            'name'  => 'service_hero_cta_primary_label',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_service_hero_cta1_url',
            'label' => 'Primary CTA — URL',
            'name'  => 'service_hero_cta_primary_url',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_service_hero_cta2_label',
            'label' => 'Secondary CTA — Label',
            'name'  => 'service_hero_cta_secondary_label',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_service_hero_cta2_url',
            'label' => 'Secondary CTA — URL',
            'name'  => 'service_hero_cta_secondary_url',
            'type'  => 'text',
        ),
        array(
            'key'           => 'field_gh_service_hero_image',
            'label'         => 'Hero Image',
            'name'          => 'service_hero_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'instructions'  => 'Right-column image. Hidden on mobile.',
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
) );

/* Service · Problem Shift */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_problem_shift',
    'title'      => 'Service · Problem Shift',
    'menu_order' => 2,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_ps_show',
            'label'         => 'Show this section',
            'name'          => 'service_problem_shift_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
            'instructions'  => 'Toggle off to hide the Problem Shift section on this service.',
        ),
        array(
            'key'   => 'field_gh_service_ps_label',
            'label' => 'Eyebrow Label',
            'name'  => 'service_problem_shift_label',
            'type'  => 'text',
            'instructions' => 'Small caps label above the headline. Default: "The Shift".',
        ),
        array(
            'key'   => 'field_gh_service_ps_headline',
            'label' => 'Headline (H2)',
            'name'  => 'service_problem_shift_headline',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_service_ps_intro',
            'label' => 'Intro Paragraph',
            'name'  => 'service_problem_shift_intro',
            'type'  => 'textarea',
            'rows'  => 5,
        ),
        array(
            'key'   => 'field_gh_service_ps_narrative_eyebrow',
            'label' => 'Editorial Narrative — Eyebrow',
            'name'  => 'service_problem_shift_narrative_eyebrow',
            'type'  => 'text',
            'instructions' => 'Gold mono uppercase label at the top of the narrative card.',
        ),
        array(
            'key'   => 'field_gh_service_ps_narrative_headline',
            'label' => 'Editorial Narrative — Headline',
            'name'  => 'service_problem_shift_narrative_headline',
            'type'  => 'text',
            'instructions' => 'Forest-green bold sub-headline directly under the eyebrow.',
        ),
        array(
            'key'           => 'field_gh_service_ps_narrative_image',
            'label'         => 'Editorial Narrative — Image (Desktop)',
            'name'          => 'service_problem_shift_narrative_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'instructions'  => 'Full-width hero image above the narrative card. Renders at native proportions with a soft gold halo behind it. Use a landscape composition tuned for desktop. Leave empty to render the narrative card with no hero image.',
        ),
        array(
            'key'           => 'field_gh_service_ps_narrative_image_mobile',
            'label'         => 'Editorial Narrative — Image (Mobile, optional)',
            'name'          => 'service_problem_shift_narrative_image_mobile',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'instructions'  => 'Optional portrait/tall crop served only on screens ≤640px wide. Leave empty to fall back to the desktop image on all viewports.',
        ),
        array(
            'key'        => 'field_gh_service_ps_narrative',
            'label'      => 'Editorial Narrative — Paragraphs',
            'name'       => 'service_problem_shift_narrative_paragraphs',
            'type'       => 'repeater',
            'layout'     => 'row',
            'min'        => 0,
            'max'        => 30,
            'instructions' => 'Long-form story that sits in a cream editorial card between the intro and the stat cards. Each row is one paragraph; line breaks between paragraphs are preserved automatically. The first and last paragraphs receive automatic editorial treatment (opener / closing pull-quote). Mark mid-narrative beats as "Emphasis" to apply italic + gold left border. Leave the repeater empty to hide the card entirely.',
            'sub_fields' => array(
                array(
                    'key'   => 'field_gh_service_ps_narrative_text',
                    'label' => 'Paragraph',
                    'name'  => 'text',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ),
                array(
                    'key'           => 'field_gh_service_ps_narrative_style',
                    'label'         => 'Style',
                    'name'          => 'style',
                    'type'          => 'select',
                    'choices'       => array(
                        'body'     => 'Body (default)',
                        'emphasis' => 'Emphasis (italic + gold left border)',
                        'evidence' => 'Evidence (inline image with label + caption)',
                    ),
                    'default_value' => 'body',
                ),
                array(
                    'key'           => 'field_gh_service_ps_narrative_evidence_image',
                    'label'         => 'Evidence Image (Desktop)',
                    'name'          => 'evidence_image',
                    'type'          => 'image',
                    'return_format' => 'id',
                    'preview_size'  => 'medium',
                    'instructions'  => 'Inline screenshot displayed between paragraphs. Centred in the reading column, max-width 600px on desktop, 16px radius, drop shadow. Use a landscape/wide crop suited to a desktop reading column.',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field'    => 'field_gh_service_ps_narrative_style',
                                'operator' => '==',
                                'value'    => 'evidence',
                            ),
                        ),
                    ),
                ),
                array(
                    'key'           => 'field_gh_service_ps_narrative_evidence_image_mobile',
                    'label'         => 'Evidence Image (Mobile, optional)',
                    'name'          => 'evidence_image_mobile',
                    'type'          => 'image',
                    'return_format' => 'id',
                    'preview_size'  => 'medium',
                    'instructions'  => 'Optional portrait/tall crop served only on screens ≤640px wide. Leave empty to fall back to the desktop image on all viewports.',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field'    => 'field_gh_service_ps_narrative_style',
                                'operator' => '==',
                                'value'    => 'evidence',
                            ),
                        ),
                    ),
                ),
                array(
                    'key'           => 'field_gh_service_ps_narrative_evidence_label',
                    'label'         => 'Evidence Label',
                    'name'          => 'evidence_label',
                    'type'          => 'text',
                    'instructions'  => 'Small gold uppercase label above the image. e.g. "SACHIN · EALING TRAVEL CLINIC · WHATSAPP".',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field'    => 'field_gh_service_ps_narrative_style',
                                'operator' => '==',
                                'value'    => 'evidence',
                            ),
                        ),
                    ),
                ),
            ),
        ),
        array(
            'key'        => 'field_gh_service_ps_pairs',
            'label'      => 'Win / Consequence Pairs',
            'name'       => 'service_problem_shift_pairs',
            'type'       => 'repeater',
            'layout'     => 'row',
            'min'        => 0,
            'max'        => 12,
            'instructions' => 'Each row is a stacked-card stat: gold stat number + supporting subtext + optional source attribution on the left, gold arrow gutter, red-x pain statement on the right. The dashboard reads top-to-bottom; designed for 8–10 rows.',
            'sub_fields' => array(
                array(
                    'key'   => 'field_gh_service_ps_pair_num',
                    'label' => 'Stat Number',
                    'name'  => 'number',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_service_ps_pair_stat',
                    'label' => 'Stat Description',
                    'name'  => 'stat_text',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ),
                array(
                    'key'   => 'field_gh_service_ps_pair_source',
                    'label' => 'Source Attribution (optional)',
                    'name'  => 'source_text',
                    'type'  => 'text',
                    'instructions' => 'e.g. "Source: Semrush, across hundreds of healthcare sites." Renders italic gold beneath the stat description. Leave blank to hide.',
                ),
                array(
                    'key'   => 'field_gh_service_ps_pair_lose',
                    'label' => 'Consequence (pain statement)',
                    'name'  => 'lose_text',
                    'type'  => 'textarea',
                    'rows'  => 2,
                ),
            ),
        ),
        array(
            'key'           => 'field_gh_service_ps_strip_show',
            'label'         => 'Show Teal CTA Strip',
            'name'          => 'service_problem_shift_strip_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
            'instructions'  => 'Toggle off to hide the green strip + button below the pairs.',
        ),
        array(
            'key'   => 'field_gh_service_ps_strip_text',
            'label' => 'Teal Strip — Text',
            'name'  => 'service_problem_shift_strip_text',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_service_ps_strip_cta_label',
            'label' => 'Teal Strip — CTA Label',
            'name'  => 'service_problem_shift_strip_cta_label',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_service_ps_strip_cta_url',
            'label' => 'Teal Strip — CTA URL',
            'name'  => 'service_problem_shift_strip_cta_url',
            'type'  => 'text',
            'instructions' => 'Anchor (#buy-now) or full URL.',
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
) );

/* Service · Three Proof Cases */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_proof_cases',
    'title'      => 'Service · Three Proof Cases',
    'menu_order' => 3,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_proof_show',
            'label'         => 'Show this section',
            'name'          => 'service_proof_cases_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array(
            'key'   => 'field_gh_service_proof_eyebrow',
            'label' => 'Eyebrow',
            'name'  => 'service_proof_cases_eyebrow',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_service_proof_headline',
            'label' => 'Headline (H2)',
            'name'  => 'service_proof_cases_headline',
            'type'  => 'text',
        ),
        array(
            'key'   => 'field_gh_service_proof_subheadline',
            'label' => 'Sub-headline',
            'name'  => 'service_proof_cases_subheadline',
            'type'  => 'textarea',
            'rows'  => 3,
        ),
        array(
            'key'        => 'field_gh_service_proof_items',
            'label'      => 'Cases',
            'name'       => 'service_proof_cases_items',
            'type'       => 'repeater',
            'layout'     => 'block',
            'min'        => 0,
            'max'        => 6,
            'instructions' => 'Cases alternate left/right automatically. Result, How and Quote accept inline <strong> markup for emphasis.',
            'sub_fields' => array(
                array(
                    'key'   => 'field_gh_service_proof_item_name',
                    'label' => 'Client Name',
                    'name'  => 'client_name',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_service_proof_item_tag',
                    'label' => 'Sector Tag',
                    'name'  => 'client_tag',
                    'type'  => 'text',
                    'instructions' => 'e.g. Travel Clinic, Pharmacy, Dental.',
                ),
                array(
                    'key'           => 'field_gh_service_proof_item_image',
                    'label'         => 'Case Image',
                    'name'          => 'image',
                    'type'          => 'image',
                    'return_format' => 'id',
                    'preview_size'  => 'medium',
                ),
                array(
                    'key'   => 'field_gh_service_proof_item_result',
                    'label' => 'The Result',
                    'name'  => 'result_text',
                    'type'  => 'textarea',
                    'rows'  => 4,
                    'instructions' => 'Inline <strong>tags allowed</strong>.',
                ),
                array(
                    'key'   => 'field_gh_service_proof_item_how',
                    'label' => 'How',
                    'name'  => 'how_text',
                    'type'  => 'textarea',
                    'rows'  => 5,
                    'instructions' => 'Inline <strong>tags allowed</strong>.',
                ),
                array(
                    'key'   => 'field_gh_service_proof_item_quote',
                    'label' => 'Quote (optional)',
                    'name'  => 'quote_text',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ),
                array(
                    'key'   => 'field_gh_service_proof_item_attr',
                    'label' => 'Quote Attribution',
                    'name'  => 'quote_attr',
                    'type'  => 'text',
                ),
            ),
        ),
        array(
            'key'           => 'field_gh_service_proof_bing',
            'label'         => 'Bing Rankings Image (optional)',
            'name'          => 'service_proof_cases_bing_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'instructions'  => 'Full-bleed proof image rendered below the cases.',
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
) );

/* Service · Playing Field */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_playing_field',
    'title'      => 'Service · Playing Field',
    'menu_order' => 4,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_pf_show',
            'label'         => 'Show this section',
            'name'          => 'service_playing_field_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_pf_eyebrow',     'label' => 'Eyebrow',     'name' => 'service_playing_field_eyebrow',     'type' => 'text' ),
        array( 'key' => 'field_gh_service_pf_headline',    'label' => 'Headline',    'name' => 'service_playing_field_headline',    'type' => 'text' ),
        array( 'key' => 'field_gh_service_pf_subheadline', 'label' => 'Subheadline', 'name' => 'service_playing_field_subheadline', 'type' => 'textarea', 'rows' => 3 ),
        array( 'key' => 'field_gh_service_pf_old_label',   'label' => 'Old Column — Label',   'name' => 'service_playing_field_old_label',   'type' => 'text' ),
        array(
            'key' => 'field_gh_service_pf_old_rows', 'label' => 'Old Column — Rows', 'name' => 'service_playing_field_old_rows',
            'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 8,
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_pf_old_row_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text' ),
            ),
        ),
        array( 'key' => 'field_gh_service_pf_old_caption', 'label' => 'Old Column — Caption', 'name' => 'service_playing_field_old_caption', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Inline <strong>tags allowed</strong>.' ),
        array( 'key' => 'field_gh_service_pf_new_label',   'label' => 'New Column — Label',   'name' => 'service_playing_field_new_label',   'type' => 'text' ),
        array(
            'key' => 'field_gh_service_pf_new_rows', 'label' => 'New Column — Rows', 'name' => 'service_playing_field_new_rows',
            'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 8,
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_pf_new_row_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text' ),
            ),
        ),
        array( 'key' => 'field_gh_service_pf_new_caption',     'label' => 'New Column — Caption',     'name' => 'service_playing_field_new_caption',     'type' => 'textarea', 'rows' => 3, 'instructions' => 'Inline <strong>tags allowed</strong>.' ),
        array( 'key' => 'field_gh_service_pf_callout_text',    'label' => 'Callout — Main Line',      'name' => 'service_playing_field_callout_text',    'type' => 'text' ),
        array( 'key' => 'field_gh_service_pf_callout_high',    'label' => 'Callout — Gold Highlight', 'name' => 'service_playing_field_callout_highlight', 'type' => 'text' ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Method */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_method',
    'title'      => 'Service · Method',
    'menu_order' => 5,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_method_show',
            'label'         => 'Show this section',
            'name'          => 'service_method_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_method_eyebrow',  'label' => 'Eyebrow',  'name' => 'service_method_eyebrow',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_method_headline', 'label' => 'Headline', 'name' => 'service_method_headline', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_method_proof',    'label' => 'Proof Line', 'name' => 'service_method_proof_line', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Inline <strong>tags allowed</strong>.' ),
        array( 'key' => 'field_gh_service_method_tl_label', 'label' => 'Timeline Label', 'name' => 'service_method_timeline_label', 'type' => 'text' ),
        array(
            'key' => 'field_gh_service_method_weeks', 'label' => 'Timeline Blocks', 'name' => 'service_method_weeks',
            'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 6,
            'instructions' => 'Three blocks is the designed default. Each is clickable and scrolls to the first matching step.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_method_week_range',   'label' => 'Range Label', 'name' => 'range',   'type' => 'text' ),
                array( 'key' => 'field_gh_service_method_week_summary', 'label' => 'Summary',     'name' => 'summary', 'type' => 'text' ),
            ),
        ),
        array(
            'key' => 'field_gh_service_method_steps', 'label' => 'Steps', 'name' => 'service_method_steps',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 8,
            'instructions' => 'Numbered automatically (01, 02, 03…). The first step is active by default; scroll updates which step is highlighted.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_method_step_week',  'label' => 'Week Label (gold)', 'name' => 'week_label', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_method_step_title', 'label' => 'Step Title',        'name' => 'title',      'type' => 'text' ),
                array( 'key' => 'field_gh_service_method_step_text',  'label' => 'Body Text',         'name' => 'text',       'type' => 'textarea', 'rows' => 4 ),
                array( 'key' => 'field_gh_service_method_step_proof', 'label' => 'Proof Pill (optional)', 'name' => 'proof_pill', 'type' => 'text' ),
                array(
                    'key' => 'field_gh_service_method_step_block', 'label' => 'Linked Timeline Block', 'name' => 'week_block',
                    'type' => 'number', 'min' => 0, 'max' => 5, 'default_value' => 0,
                    'instructions' => 'Index of the timeline block this step belongs to (0 = first block, 1 = second, etc.).',
                ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · What You Get */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_what_you_get',
    'title'      => 'Service · What You Get',
    'menu_order' => 6,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_wyg_show',
            'label'         => 'Show this section',
            'name'          => 'service_what_you_get_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_wyg_eyebrow',     'label' => 'Eyebrow',     'name' => 'service_what_you_get_eyebrow',     'type' => 'text' ),
        array( 'key' => 'field_gh_service_wyg_headline',    'label' => 'Headline',    'name' => 'service_what_you_get_headline',    'type' => 'text' ),
        array( 'key' => 'field_gh_service_wyg_subheadline', 'label' => 'Subheadline', 'name' => 'service_what_you_get_subheadline', 'type' => 'textarea', 'rows' => 3 ),
        array(
            'key' => 'field_gh_service_wyg_modules', 'label' => 'Modules', 'name' => 'service_what_you_get_modules',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 12,
            'instructions' => 'Numbered automatically (01, 02…). Two-column grid; if the count is odd the last card centres in its row.',
            'sub_fields' => array(
                array(
                    'key' => 'field_gh_service_wyg_module_kind', 'label' => 'Icon Kind', 'name' => 'icon_kind',
                    'type' => 'select', 'default_value' => 'engine',
                    'choices' => array(
                        'engine'      => 'Engine (forest green)',
                        'pillar'      => 'Pillar (indigo)',
                        'interactive' => 'Interactive (amber)',
                        'visuals'     => 'Visuals (sage)',
                        'indexed'     => 'Indexed (emerald)',
                    ),
                ),
                array( 'key' => 'field_gh_service_wyg_module_title', 'label' => 'Title',          'name' => 'title',      'type' => 'text' ),
                array( 'key' => 'field_gh_service_wyg_module_hook',  'label' => 'Hook Line',      'name' => 'hook',       'type' => 'text' ),
                array( 'key' => 'field_gh_service_wyg_module_body',  'label' => 'Body',           'name' => 'body',       'type' => 'textarea', 'rows' => 4 ),
                array( 'key' => 'field_gh_service_wyg_module_stat',  'label' => 'Proof — Stat',   'name' => 'proof_stat', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_wyg_module_ptxt',  'label' => 'Proof — Text',   'name' => 'proof_text', 'type' => 'textarea', 'rows' => 2 ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Sub-case Proof */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_sub_case_proof',
    'title'      => 'Service · Sub-case Proof',
    'menu_order' => 7,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_sc_show',
            'label'         => 'Show this section',
            'name'          => 'service_sub_case_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_sc_eyebrow',     'label' => 'Eyebrow',     'name' => 'service_sub_case_eyebrow',     'type' => 'text' ),
        array( 'key' => 'field_gh_service_sc_headline',    'label' => 'Headline',    'name' => 'service_sub_case_headline',    'type' => 'text' ),
        array( 'key' => 'field_gh_service_sc_subheadline', 'label' => 'Subheadline', 'name' => 'service_sub_case_subheadline', 'type' => 'textarea', 'rows' => 3 ),
        array(
            'key' => 'field_gh_service_sc_cards', 'label' => 'Cards', 'name' => 'service_sub_case_cards',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 6,
            'instructions' => 'Two cards is the designed default. Each card = a Search Console screenshot + a caption block.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_sc_card_name', 'label' => 'Client Name', 'name' => 'name', 'type' => 'text' ),
                array(
                    'key' => 'field_gh_service_sc_card_image', 'label' => 'Screenshot',  'name' => 'image',
                    'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium',
                ),
                array( 'key' => 'field_gh_service_sc_card_result', 'label' => 'Result Line', 'name' => 'result', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Inline <strong>tags allowed</strong>.' ),
                array( 'key' => 'field_gh_service_sc_card_data',   'label' => 'Data Line',   'name' => 'data',   'type' => 'text', 'instructions' => 'Mono caps line. e.g. "5.93K clicks · 1.07M impressions · 3 months".' ),
            ),
        ),
        array( 'key' => 'field_gh_service_sc_footer', 'label' => 'Footer Line', 'name' => 'service_sub_case_footer', 'type' => 'text' ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Early Buyers */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_early_buyers',
    'title'      => 'Service · Early Buyers',
    'menu_order' => 8,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_eb_show',
            'label'         => 'Show this section',
            'name'          => 'service_early_buyers_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array(
            'key' => 'field_gh_service_eb_tiers', 'label' => 'Tier Cards', 'name' => 'service_early_buyers_tiers',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 4,
            'instructions' => 'Three cards is the designed default. "Kind" picks the colour treatment; "Automated" is the centre dark featured card.',
            'sub_fields' => array(
                array(
                    'key' => 'field_gh_service_eb_tier_kind', 'label' => 'Kind', 'name' => 'kind',
                    'type' => 'select', 'default_value' => 'manual',
                    'choices' => array(
                        'manual'    => 'Manual (light cream card)',
                        'automated' => 'Automated (forest-green featured card, lifted)',
                        'lifetime'  => 'Lifetime (light cream card)',
                    ),
                ),
                array(
                    'key'           => 'field_gh_service_eb_tier_image',
                    'label'         => 'Top Image (optional)',
                    'name'          => 'image',
                    'type'          => 'image',
                    'return_format' => 'id',
                    'preview_size'  => 'medium',
                    'instructions'  => 'Renders flush at the top of the card (200px tall, 220px on the featured Automated card). Falls back to a gold-mono placeholder when empty.',
                ),
                array( 'key' => 'field_gh_service_eb_tier_banner',  'label' => 'Proof Banner Text', 'name' => 'proof_banner', 'type' => 'text', 'instructions' => 'Mono uppercase strip below the image. Outer cards only — skipped on the featured Automated card.' ),
                array( 'key' => 'field_gh_service_eb_tier_recom',   'label' => 'Recommended Label (optional)', 'name' => 'recommended', 'type' => 'text', 'instructions' => 'Inline gold caps label, typically "Recommended" on the Automated card.' ),
                array( 'key' => 'field_gh_service_eb_tier_cat',     'label' => 'Category Label',   'name' => 'category',  'type' => 'text', 'instructions' => 'e.g. "Do It Yourself", "The Automation Layer".' ),
                array( 'key' => 'field_gh_service_eb_tier_top',     'label' => 'Top Label (gold, optional)', 'name' => 'top_label', 'type' => 'text', 'instructions' => 'e.g. "Included Today", "Included Free". Skipped on the Automated card.' ),
                array( 'key' => 'field_gh_service_eb_tier_title',   'label' => 'Title',            'name' => 'title',     'type' => 'text' ),
                array( 'key' => 'field_gh_service_eb_tier_body',    'label' => 'Body',             'name' => 'body',      'type' => 'textarea', 'rows' => 5 ),
                array(
                    'key' => 'field_gh_service_eb_tier_bullets', 'label' => 'Bullet List (optional)', 'name' => 'bullets',
                    'type' => 'repeater', 'layout' => 'table', 'min' => 0,
                    'sub_fields' => array(
                        array( 'key' => 'field_gh_service_eb_tier_bullet_text', 'label' => 'Bullet', 'name' => 'text', 'type' => 'text' ),
                    ),
                ),
            ),
        ),
        array( 'key' => 'field_gh_service_eb_strap_price', 'label' => 'Price Strap — Price',     'name' => 'service_early_buyers_strap_price', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_eb_strap_desc',  'label' => 'Price Strap — Descriptor', 'name' => 'service_early_buyers_strap_desc',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_eb_cta_label',   'label' => 'CTA Label',                'name' => 'service_early_buyers_cta_label',   'type' => 'text' ),
        array( 'key' => 'field_gh_service_eb_cta_url',     'label' => 'CTA URL',                  'name' => 'service_early_buyers_cta_url',     'type' => 'text' ),
        array(
            'key' => 'field_gh_service_eb_callout_show', 'label' => 'Show "Why Early Buyers Win" Callout', 'name' => 'service_early_buyers_callout_show',
            'type' => 'true_false', 'default_value' => 1, 'ui' => 1,
        ),
        array( 'key' => 'field_gh_service_eb_callout_eyebrow',  'label' => 'Callout — Eyebrow (optional)', 'name' => 'service_early_buyers_callout_eyebrow', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_eb_callout_headline', 'label' => 'Callout — Headline',           'name' => 'service_early_buyers_callout_headline', 'type' => 'text' ),
        array(
            'key' => 'field_gh_service_eb_callout_paras', 'label' => 'Callout — Paragraphs', 'name' => 'service_early_buyers_callout_paragraphs',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 8,
            'instructions' => 'Each row is one paragraph. Inline <strong>tags allowed</strong>.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_eb_callout_para_text', 'label' => 'Paragraph', 'name' => 'text', 'type' => 'textarea', 'rows' => 4 ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Math */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_math',
    'title'      => 'Service · Math (The Numbers)',
    'menu_order' => 9,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_math_show',
            'label'         => 'Show this section',
            'name'          => 'service_math_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_math_eyebrow',     'label' => 'Eyebrow',     'name' => 'service_math_eyebrow',     'type' => 'text' ),
        array( 'key' => 'field_gh_service_math_headline',    'label' => 'Headline',    'name' => 'service_math_headline',    'type' => 'text' ),
        array( 'key' => 'field_gh_service_math_subheadline', 'label' => 'Subheadline', 'name' => 'service_math_subheadline', 'type' => 'textarea', 'rows' => 3 ),
        array(
            'key' => 'field_gh_service_math_cards', 'label' => 'Audience Cards', 'name' => 'service_math_cards',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 8,
            'instructions' => 'Card colour rotates by row index (navy / white / sage / cream-warm) and repeats every four cards.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_math_card_label',    'label' => 'Audience Label', 'name' => 'label',    'type' => 'text' ),
                array( 'key' => 'field_gh_service_math_card_headline', 'label' => 'Headline',       'name' => 'headline', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_math_card_body',     'label' => 'Body',           'name' => 'body',     'type' => 'textarea', 'rows' => 4 ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Next Steps */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_next_steps',
    'title'      => 'Service · Next Steps',
    'menu_order' => 10,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_next_show',
            'label'         => 'Show this section',
            'name'          => 'service_next_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_next_eyebrow',     'label' => 'Eyebrow',     'name' => 'service_next_eyebrow',     'type' => 'text' ),
        array( 'key' => 'field_gh_service_next_headline',    'label' => 'Headline',    'name' => 'service_next_headline',    'type' => 'text' ),
        array( 'key' => 'field_gh_service_next_subheadline', 'label' => 'Subheadline', 'name' => 'service_next_subheadline', 'type' => 'textarea', 'rows' => 3 ),
        array(
            'key' => 'field_gh_service_next_steps', 'label' => 'Timeline Steps', 'name' => 'service_next_steps',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 12,
            'instructions' => 'Numbers (1, 2, 3…) auto-render based on row order. Mark the last row "Final Step" for the navy destination card.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_next_step_label', 'label' => 'Time Label', 'name' => 'label', 'type' => 'text', 'instructions' => 'e.g. "Today", "This Week", "Day 90".' ),
                array( 'key' => 'field_gh_service_next_step_title', 'label' => 'Step Title', 'name' => 'title', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_next_step_text',  'label' => 'Body Text',  'name' => 'text',  'type' => 'textarea', 'rows' => 3 ),
                array(
                    'key' => 'field_gh_service_next_step_final', 'label' => 'Final Step (navy card)', 'name' => 'is_final',
                    'type' => 'true_false', 'default_value' => 0, 'ui' => 1,
                ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · FAQ */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_faq',
    'title'      => 'Service · FAQ',
    'menu_order' => 11,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_faq_show',
            'label'         => 'Show this section',
            'name'          => 'service_faq_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_faq_eyebrow',  'label' => 'Eyebrow',  'name' => 'service_faq_eyebrow',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_faq_headline', 'label' => 'Headline', 'name' => 'service_faq_headline', 'type' => 'text' ),
        array(
            'key' => 'field_gh_service_faq_items', 'label' => 'Q & A', 'name' => 'service_faq_items',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 20,
            'instructions' => 'One row per question. Numbers auto-render (01, 02…). Answers accept inline <strong>tags</strong>.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_faq_item_q', 'label' => 'Question', 'name' => 'question', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_faq_item_a', 'label' => 'Answer',   'name' => 'answer',   'type' => 'textarea', 'rows' => 4 ),
            ),
        ),
        array(
            'key' => 'field_gh_service_faq_cta_show', 'label' => 'Show Bottom CTA', 'name' => 'service_faq_cta_show',
            'type' => 'true_false', 'default_value' => 1, 'ui' => 1,
        ),
        array( 'key' => 'field_gh_service_faq_cta_text',  'label' => 'Bottom CTA — Tag Line',    'name' => 'service_faq_cta_text',  'type' => 'textarea', 'rows' => 2, 'instructions' => 'Inline <strong>tags allowed</strong>.' ),
        array( 'key' => 'field_gh_service_faq_cta_label', 'label' => 'Bottom CTA — Button Label', 'name' => 'service_faq_cta_label', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_faq_cta_url',   'label' => 'Bottom CTA — URL',          'name' => 'service_faq_cta_url',   'type' => 'text' ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Guarantee */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_guarantee',
    'title'      => 'Service · Guarantee',
    'menu_order' => 12,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_guarantee_show',
            'label'         => 'Show this section',
            'name'          => 'service_guarantee_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_guarantee_badge', 'label' => 'Badge Text',  'name' => 'service_guarantee_badge_text', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_guarantee_h',     'label' => 'Headline',    'name' => 'service_guarantee_headline',   'type' => 'text' ),
        array( 'key' => 'field_gh_service_guarantee_body',  'label' => 'Body',        'name' => 'service_guarantee_body',       'type' => 'textarea', 'rows' => 3 ),
        array(
            'key' => 'field_gh_service_guarantee_proof', 'label' => 'Proof Cards', 'name' => 'service_guarantee_proof',
            'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 6,
            'instructions' => 'Three cards is the designed default. Each card = client name + big stat + descriptor.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_guarantee_proof_client', 'label' => 'Client',     'name' => 'client', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_guarantee_proof_stat',   'label' => 'Stat',       'name' => 'stat',   'type' => 'text' ),
                array( 'key' => 'field_gh_service_guarantee_proof_desc',   'label' => 'Descriptor', 'name' => 'desc',   'type' => 'text' ),
            ),
        ),
        array( 'key' => 'field_gh_service_guarantee_personal', 'label' => 'Personal Promise', 'name' => 'service_guarantee_personal_text', 'type' => 'textarea', 'rows' => 4, 'instructions' => 'Inline <strong>tags allowed</strong>.' ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Final CTA */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_final_cta',
    'title'      => 'Service · Final CTA',
    'menu_order' => 13,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_final_show',
            'label'         => 'Show this section',
            'name'          => 'service_final_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_final_eyebrow',  'label' => 'Eyebrow',  'name' => 'service_final_eyebrow',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_final_h',        'label' => 'Headline', 'name' => 'service_final_headline', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_final_body',     'label' => 'Body',     'name' => 'service_final_body',     'type' => 'textarea', 'rows' => 3 ),
        array(
            'key' => 'field_gh_service_final_features', 'label' => 'Feature Bullets', 'name' => 'service_final_features',
            'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 12,
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_final_feature_text', 'label' => 'Bullet', 'name' => 'text', 'type' => 'text' ),
            ),
        ),
        array( 'key' => 'field_gh_service_final_footer', 'label' => 'Closing Footer Line', 'name' => 'service_final_footer_line', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_final_pe',     'label' => 'Price Card — Eyebrow',    'name' => 'service_final_price_eyebrow',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_final_pt',     'label' => 'Price Card — Title',      'name' => 'service_final_price_title',    'type' => 'text' ),
        array( 'key' => 'field_gh_service_final_pv',     'label' => 'Price Card — Price',      'name' => 'service_final_price_value',    'type' => 'text' ),
        array( 'key' => 'field_gh_service_final_pq',     'label' => 'Price Card — Qualifier',  'name' => 'service_final_price_qualifier', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_final_pcl',    'label' => 'Price Card — CTA Label',  'name' => 'service_final_price_cta_label', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_final_pcu',    'label' => 'Price Card — CTA URL',    'name' => 'service_final_price_cta_url',   'type' => 'text' ),
        array( 'key' => 'field_gh_service_final_ps',     'label' => 'Price Card — Secondary Line', 'name' => 'service_final_price_secondary', 'type' => 'textarea', 'rows' => 2, 'instructions' => 'Inline <a href="">links</a> and <strong>tags allowed</strong>.' ),
        array(
            'key' => 'field_gh_service_final_choices', 'label' => 'Final Choices', 'name' => 'service_final_choices',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 4,
            'instructions' => 'Two cards is the designed default. "Inaction" gets a red left border; "Action" gets a green left border.',
            'sub_fields' => array(
                array(
                    'key' => 'field_gh_service_final_choice_kind', 'label' => 'Kind', 'name' => 'kind',
                    'type' => 'select', 'default_value' => 'action',
                    'choices' => array(
                        'inaction' => 'Inaction (red left border)',
                        'action'   => 'Action (green left border)',
                    ),
                ),
                array( 'key' => 'field_gh_service_final_choice_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_final_choice_text',  'label' => 'Body',  'name' => 'text',  'type' => 'textarea', 'rows' => 4 ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Logo Bar
 * menu_order 1.5 doesn't exist (ACF integers only) — leaving the existing
 * Hero=1 and Problem Shift=2 numbering intact and using a custom title prefix
 * "Service · 01.5 Logo Bar" would clutter the admin. ACF sorts ties by post
 * registration order; since this group registers AFTER Hero, it appears
 * directly under it. Render order is controlled by single-service.php, not
 * menu_order — menu_order only affects the admin meta-box stacking. */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_logo_bar',
    'title'      => 'Service · Logo Bar',
    'menu_order' => 1,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_logo_bar_show',
            'label'         => 'Show this section',
            'name'          => 'service_logo_bar_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
            'instructions'  => 'Toggle off to hide the auto-scrolling client logo strip below the hero.',
        ),
        array(
            'key'   => 'field_gh_service_logo_bar_label',
            'label' => 'Label (above the strip)',
            'name'  => 'service_logo_bar_label',
            'type'  => 'text',
            'instructions' => 'Optional caps line above the logos. Leave empty to render just the strip.',
        ),
        array(
            'key'           => 'field_gh_service_logo_bar_logos',
            'label'         => 'Client Logos',
            'name'          => 'service_logo_bar_logos',
            'type'          => 'gallery',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
            'instructions'  => 'Upload each client logo as a separate image. The strip auto-scrolls and loops seamlessly. Empty gallery = section renders nothing.',
        ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Live Clients (Agent A1) */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_live_clients',
    'title'      => 'Service · Live Clients',
    'menu_order' => 2,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_lc_show',
            'label'         => 'Show this section',
            'name'          => 'service_live_clients_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_lc_eyebrow',  'label' => 'Eyebrow',     'name' => 'service_live_clients_eyebrow',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_lc_headline', 'label' => 'Headline',    'name' => 'service_live_clients_headline', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_lc_sub',      'label' => 'Sub-headline', 'name' => 'service_live_clients_sub',      'type' => 'textarea', 'rows' => 3 ),
        array(
            'key' => 'field_gh_service_lc_cards', 'label' => 'Client Cards', 'name' => 'service_live_clients_cards',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 20,
            'instructions' => 'Each row is one carousel card. Upload the website screenshot — the image gets rendered at 420×260px in the carousel and full-resolution inside the lightbox preview.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_lc_card_name',  'label' => 'Client Name', 'name' => 'name',  'type' => 'text' ),
                array(
                    'key' => 'field_gh_service_lc_card_image', 'label' => 'Screenshot', 'name' => 'image',
                    'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium',
                ),
                array( 'key' => 'field_gh_service_lc_card_badge', 'label' => 'Badge Text (optional)', 'name' => 'badge', 'type' => 'text', 'instructions' => 'Defaults to "Live" if empty.' ),
            ),
        ),
        array( 'key' => 'field_gh_service_lc_footnote', 'label' => 'Footnote', 'name' => 'service_live_clients_footnote', 'type' => 'textarea', 'rows' => 4 ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Why This Exists (Agent A1) */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_why_this_exists',
    'title'      => 'Service · Why This Exists',
    'menu_order' => 3,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_why_show',
            'label'         => 'Show this section',
            'name'          => 'service_why_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_why_eyebrow',   'label' => 'Eyebrow',           'name' => 'service_why_eyebrow',   'type' => 'text' ),
        array( 'key' => 'field_gh_service_why_headline',  'label' => 'Headline',          'name' => 'service_why_headline',  'type' => 'textarea', 'rows' => 3, 'instructions' => 'Each line wraps onto its own line in the rendered H2.' ),
        array( 'key' => 'field_gh_service_why_lead',      'label' => 'Lead Paragraph',    'name' => 'service_why_lead',      'type' => 'textarea', 'rows' => 4 ),
        array( 'key' => 'field_gh_service_why_lead_stat', 'label' => 'Lead Stat Pill',    'name' => 'service_why_lead_stat', 'type' => 'text', 'instructions' => 'Optional. Gold caps pill below the lead. Leave empty to hide.' ),
        array(
            'key'           => 'field_gh_service_why_header_image',
            'label'         => 'Header — Product Visual',
            'name'          => 'service_why_header_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'instructions'  => 'Right-column visual on desktop (>960px). Phone or laptop mockup of the agent in a patient conversation works best — same visual vocabulary as the page hero. Renders a styled placeholder when empty. Hidden on mobile.',
        ),
        array(
            'key' => 'field_gh_service_why_blocks', 'label' => 'Feature Blocks', 'name' => 'service_why_blocks',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 6,
            'instructions' => 'Three blocks is the designed default. Each block carries an icon kind, an optional product image, title, and bulleted list. When the image is set, the icon block + corner number hide so the image carries the visual weight.',
            'sub_fields' => array(
                array(
                    'key' => 'field_gh_service_why_block_kind', 'label' => 'Icon Kind', 'name' => 'icon_kind',
                    'type' => 'select', 'default_value' => 'instant',
                    'choices' => array(
                        'instant'      => 'Instant (circle + check)',
                        'intelligence' => 'Intelligence (building)',
                        'moat'         => 'Moat (trending up)',
                    ),
                    'instructions' => 'Icon shown only when no image is set on this block. Also drives the placeholder hint label.',
                ),
                array(
                    'key'           => 'field_gh_service_why_block_image',
                    'label'         => 'Image',
                    'name'          => 'image',
                    'type'          => 'image',
                    'return_format' => 'id',
                    'preview_size'  => 'medium',
                    'instructions'  => 'Optional. Renders flush at the top of the card, ~180px tall. Photo, mockup, or stylised UI all work. When empty, a placeholder shows the icon + a hint label so the card still reads as designed.',
                ),
                array( 'key' => 'field_gh_service_why_block_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ),
                array(
                    'key' => 'field_gh_service_why_block_bullets', 'label' => 'Bullets', 'name' => 'bullets',
                    'type' => 'repeater', 'layout' => 'table', 'min' => 0,
                    'sub_fields' => array(
                        array( 'key' => 'field_gh_service_why_block_bullet_text', 'label' => 'Bullet', 'name' => 'text', 'type' => 'text' ),
                    ),
                ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Track Record (Agent A2) */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_track_record',
    'title'      => 'Service · Track Record',
    'menu_order' => 4,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_tr_show',
            'label'         => 'Show this section',
            'name'          => 'service_track_record_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_tr_overline', 'label' => 'Overline', 'name' => 'service_track_record_overline', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_tr_headline', 'label' => 'Headline', 'name' => 'service_track_record_headline', 'type' => 'textarea', 'rows' => 5, 'instructions' => 'Each newline becomes its own block in the rendered H2. The last line auto-bumps to crescendo size.' ),
        array( 'key' => 'field_gh_service_tr_intro',    'label' => 'Intro Paragraph',  'name' => 'service_track_record_intro', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Single paragraph that sits below the headline, above the proof points.' ),
        array(
            'key' => 'field_gh_service_tr_stats', 'label' => 'Stat Strip', 'name' => 'service_track_record_stats',
            'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 4,
            'instructions' => 'Aggregate metrics shown above the proof cards as a horizontal trio. Three stats is the designed default. Each row = bold display value + small uppercase label.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_tr_stat_value', 'label' => 'Value', 'name' => 'value', 'type' => 'text', 'instructions' => 'e.g. "6", "100%", "0", "<24h"' ),
                array( 'key' => 'field_gh_service_tr_stat_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text', 'instructions' => 'e.g. "Deployments live"' ),
            ),
        ),
        array(
            'key' => 'field_gh_service_tr_proofs', 'label' => 'Proof Points', 'name' => 'service_track_record_proofs',
            'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 6,
            'instructions' => 'Three points is the designed default. Each card renders as: big metric value, small client label, bold outcome line, mono period stamp.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_tr_proof_metric', 'label' => 'Metric', 'name' => 'metric', 'type' => 'text', 'instructions' => 'Big headline number, e.g. "£200K/yr", "55/mo", "6/6"' ),
                array( 'key' => 'field_gh_service_tr_proof_label', 'label' => 'Client / Label', 'name' => 'label', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_tr_proof_text',  'label' => 'Outcome Line', 'name' => 'text',  'type' => 'text' ),
                array( 'key' => 'field_gh_service_tr_proof_period', 'label' => 'Period / Context', 'name' => 'period', 'type' => 'text', 'instructions' => 'Timeframe or context, e.g. "Last 30 days", "Since deploy"' ),
            ),
        ),
        array( 'key' => 'field_gh_service_tr_kicker',   'label' => 'Closing Kicker', 'name' => 'service_track_record_kicker', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Italic navy paragraph above the close line. Renders as a pull-quote with a large gold quote-mark and an attribution line below.' ),
        array( 'key' => 'field_gh_service_tr_kicker_attribution', 'label' => 'Kicker Attribution', 'name' => 'service_track_record_kicker_attribution', 'type' => 'text', 'instructions' => 'Mono uppercase line below the kicker quote. e.g. "— The Pharmodigital team".' ),
        array( 'key' => 'field_gh_service_tr_close',    'label' => 'Crescendo Line', 'name' => 'service_track_record_close',  'type' => 'text', 'instructions' => 'Bold one-liner that closes the section. Renders with a 60px centred gold underline accent.' ),
        array( 'key' => 'field_gh_service_tr_body',     'label' => 'Body (deprecated)', 'name' => 'service_track_record_body', 'type' => 'textarea', 'rows' => 4, 'instructions' => 'No longer rendered as of the cinematic redesign. Field kept for legacy data only — leave empty.' ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · SalesAgent Pro (Agent A2) */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_sales_agent_pro',
    'title'      => 'Service · SalesAgent Pro',
    'menu_order' => 5,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_sap_show',
            'label'         => 'Show this section',
            'name'          => 'service_sa_pro_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_sap_eyebrow',  'label' => 'Eyebrow',  'name' => 'service_sa_pro_eyebrow',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_sap_headline', 'label' => 'Headline', 'name' => 'service_sa_pro_headline', 'type' => 'textarea', 'rows' => 4, 'instructions' => 'Each line wraps onto its own line in the rendered H2.' ),
        array(
            'key' => 'field_gh_service_sap_story', 'label' => 'Story', 'name' => 'service_sa_pro_story',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 30,
            'instructions' => 'Each row is one beat of the story. "Line" = regular paragraph (allows inline <strong> + <em>). "Break" = blank vertical spacer (text ignored). "Punchline" = bold closing line.',
            'sub_fields' => array(
                array(
                    'key' => 'field_gh_service_sap_story_type', 'label' => 'Type', 'name' => 'type',
                    'type' => 'select', 'default_value' => 'line',
                    'choices' => array( 'line' => 'Line', 'break' => 'Break (spacer)', 'punchline' => 'Punchline (bold)' ),
                ),
                array( 'key' => 'field_gh_service_sap_story_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 2, 'instructions' => 'Inline <strong> + <em> allowed. Em-tags render as gold accent.' ),
            ),
        ),
        array(
            'key' => 'field_gh_service_sap_image', 'label' => 'Story Image', 'name' => 'service_sa_pro_image',
            'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium',
            'instructions' => 'Right-column visual. The phone-with-booking-notification screenshot fits the original spec.',
        ),
        array(
            'key' => 'field_gh_service_sap_stats', 'label' => 'Stat Cards', 'name' => 'service_sa_pro_stats',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 5,
            'instructions' => 'Three cards is the designed default. "Kind" picks the body shape — Simple = number + label + sub. Compare = number + label + comparison bars + sub. Text = phrase headline + sub. The Client chip renders as a gold mono-uppercase tag at the top of the card with a pulse dot.',
            'sub_fields' => array(
                array(
                    'key' => 'field_gh_service_sap_stat_kind', 'label' => 'Kind', 'name' => 'kind',
                    'type' => 'select', 'default_value' => 'simple',
                    'choices' => array( 'simple' => 'Simple (number + label + sub)', 'compare' => 'Compare (with bars)', 'text' => 'Text headline (smaller)' ),
                ),
                array( 'key' => 'field_gh_service_sap_stat_client', 'label' => 'Client', 'name' => 'client', 'type' => 'text', 'instructions' => 'Practice name shown as a gold uppercase chip at the top of the card. e.g. "Southdowns Pharmacy Group". Leave empty for stats that span the whole network.' ),
                array( 'key' => 'field_gh_service_sap_stat_num',   'label' => 'Number / phrase', 'name' => 'num',   'type' => 'text' ),
                array( 'key' => 'field_gh_service_sap_stat_label', 'label' => 'Label',           'name' => 'label', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_sap_stat_sub',   'label' => 'Sub-text',        'name' => 'sub',   'type' => 'textarea', 'rows' => 3 ),
                array(
                    'key' => 'field_gh_service_sap_stat_compare', 'label' => 'Comparison Rows (Compare kind only)', 'name' => 'compare_rows',
                    'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 4,
                    'sub_fields' => array(
                        array( 'key' => 'field_gh_service_sap_cmp_label', 'label' => 'Label',     'name' => 'label',    'type' => 'text' ),
                        array( 'key' => 'field_gh_service_sap_cmp_pct',   'label' => 'Fill %',    'name' => 'fill_pct', 'type' => 'number', 'min' => 0, 'max' => 100, 'default_value' => 100 ),
                        array( 'key' => 'field_gh_service_sap_cmp_val',   'label' => 'Value',     'name' => 'value',    'type' => 'text' ),
                        array(
                            'key' => 'field_gh_service_sap_cmp_us', 'label' => 'Us (gold)', 'name' => 'is_us',
                            'type' => 'true_false', 'default_value' => 0, 'ui' => 1,
                            'instructions' => 'On = gold gradient bar, gold value text. Off = grey bar, grey value text.',
                        ),
                    ),
                ),
            ),
        ),
        array(
            'key' => 'field_gh_service_sap_revenue', 'label' => 'Revenue Dashboard (deprecated)', 'name' => 'service_sa_pro_revenue',
            'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 6,
            'instructions' => 'No longer rendered as of the unified 3-card stats redesign. Field kept for legacy data only — the same numbers + attributions now live as Client-tagged Stat Cards above.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_sap_rev_num',   'label' => 'Number',      'name' => 'num',         'type' => 'text' ),
                array( 'key' => 'field_gh_service_sap_rev_label', 'label' => 'Label',       'name' => 'label',       'type' => 'text' ),
                array( 'key' => 'field_gh_service_sap_rev_attr',  'label' => 'Attribution', 'name' => 'attribution', 'type' => 'text' ),
            ),
        ),
        array( 'key' => 'field_gh_service_sap_cta_label', 'label' => 'CTA Label', 'name' => 'service_sa_pro_cta_label', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_sap_cta_url',   'label' => 'CTA URL',   'name' => 'service_sa_pro_cta_url',   'type' => 'text' ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Testimonial (Agent A3) */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_testimonial',
    'title'      => 'Service · Testimonial',
    'menu_order' => 6,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_testimonial_show',
            'label'         => 'Show this section',
            'name'          => 'service_testimonial_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array(
            'key' => 'field_gh_service_testimonial_photo', 'label' => 'Photo', 'name' => 'service_testimonial_photo',
            'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium',
            'instructions' => 'Portrait orientation works best (260×300 desktop / 200×230 mobile).',
        ),
        array( 'key' => 'field_gh_service_testimonial_metric_value', 'label' => 'Metric Value', 'name' => 'service_testimonial_metric_value', 'type' => 'text', 'instructions' => 'Big result number/anchor below the photo. e.g. "#1", "+£89K", "55/mo", "47×".' ),
        array( 'key' => 'field_gh_service_testimonial_metric_label', 'label' => 'Metric Label', 'name' => 'service_testimonial_metric_label', 'type' => 'text', 'instructions' => 'Mono uppercase line under the metric value. e.g. "Outranks Boots in local search".' ),
        array( 'key' => 'field_gh_service_testimonial_quote', 'label' => 'Quote',       'name' => 'service_testimonial_quote', 'type' => 'textarea', 'rows' => 8, 'instructions' => 'Inline <strong> + <em> allowed. Em-tags render as forest-green. Blank lines become paragraph breaks.' ),
        array( 'key' => 'field_gh_service_testimonial_name',  'label' => 'Name',        'name' => 'service_testimonial_name',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_testimonial_role',  'label' => 'Role',        'name' => 'service_testimonial_role',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_testimonial_badge', 'label' => 'Badge Text (deprecated)', 'name' => 'service_testimonial_badge', 'type' => 'text', 'instructions' => 'No longer rendered as of the result-metric redesign. Field kept for legacy data only — leave empty.' ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Testimonial — Emjad (Agent, second testimonial above closing-offer).
 *
 * Standalone second testimonial block. Same structure as the Rahul
 * Puri group above — separate field keys + names so the two blocks
 * never collide on data. */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_testimonial_emjad',
    'title'      => 'Service · Testimonial — Emjad',
    'menu_order' => 6,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_testimonial_emjad_show',
            'label'         => 'Show this section',
            'name'          => 'service_testimonial_emjad_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array(
            'key' => 'field_gh_service_testimonial_emjad_photo', 'label' => 'Photo', 'name' => 'service_testimonial_emjad_photo',
            'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium',
            'instructions' => 'Portrait orientation works best (260×300 desktop / 200×230 mobile).',
        ),
        array( 'key' => 'field_gh_service_testimonial_emjad_metric_value', 'label' => 'Metric Value', 'name' => 'service_testimonial_emjad_metric_value', 'type' => 'text', 'instructions' => 'Big result anchor below the photo. e.g. "Two Sites".' ),
        array( 'key' => 'field_gh_service_testimonial_emjad_metric_label', 'label' => 'Metric Label', 'name' => 'service_testimonial_emjad_metric_label', 'type' => 'text', 'instructions' => 'Mono uppercase line under the metric value. e.g. "Fully Automated".' ),
        array( 'key' => 'field_gh_service_testimonial_emjad_quote', 'label' => 'Quote',       'name' => 'service_testimonial_emjad_quote', 'type' => 'textarea', 'rows' => 8, 'instructions' => 'Inline <strong> + <em> allowed. Em-tags render as forest-green. Blank lines become paragraph breaks.' ),
        array( 'key' => 'field_gh_service_testimonial_emjad_name',  'label' => 'Name',        'name' => 'service_testimonial_emjad_name',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_testimonial_emjad_role',  'label' => 'Role',        'name' => 'service_testimonial_emjad_role',  'type' => 'text' ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Intelligence Engine (Agent A3) */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_intelligence_engine',
    'title'      => 'Service · Intelligence Engine',
    'menu_order' => 7,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_intel_show',
            'label'         => 'Show this section',
            'name'          => 'service_intel_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_intel_eyebrow',  'label' => 'Eyebrow',     'name' => 'service_intel_eyebrow',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_intel_headline', 'label' => 'Headline',    'name' => 'service_intel_headline', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_intel_sub',      'label' => 'Sub-headline', 'name' => 'service_intel_sub',      'type' => 'textarea', 'rows' => 4 ),
        array(
            'key' => 'field_gh_service_intel_image', 'label' => 'Hero Image (optional)', 'name' => 'service_intel_image',
            'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium',
        ),
        array(
            'key' => 'field_gh_service_intel_cards', 'label' => 'Query Cards', 'name' => 'service_intel_cards',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 6,
            'instructions' => 'Each card walks Patient Query → Agent Outcome → Content Signal. Inline <strong> allowed in the Content Signal block.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_intel_card_query',   'label' => 'Patient Query',  'name' => 'query',   'type' => 'textarea', 'rows' => 3 ),
                array( 'key' => 'field_gh_service_intel_card_outcome', 'label' => 'Agent Outcome',  'name' => 'outcome', 'type' => 'textarea', 'rows' => 3 ),
                array( 'key' => 'field_gh_service_intel_card_intel',   'label' => 'Content Signal', 'name' => 'intel',   'type' => 'textarea', 'rows' => 3, 'instructions' => 'Inline <strong> tags allowed.' ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Content Flywheel (Agent A4) */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_flywheel',
    'title'      => 'Service · Content Flywheel',
    'menu_order' => 8,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_fw_show',
            'label'         => 'Show this section',
            'name'          => 'service_flywheel_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_fw_eyebrow',  'label' => 'Eyebrow',     'name' => 'service_flywheel_eyebrow',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_fw_headline', 'label' => 'Headline',    'name' => 'service_flywheel_headline', 'type' => 'textarea', 'rows' => 3 ),
        array( 'key' => 'field_gh_service_fw_desc',     'label' => 'Description', 'name' => 'service_flywheel_desc',     'type' => 'textarea', 'rows' => 3 ),
        array(
            'key' => 'field_gh_service_fw_cards', 'label' => 'Flywheel Cards (4 max)', 'name' => 'service_flywheel_cards',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 4,
            'instructions' => 'Four cards in a 2×2 grid around the centre loop. Cards 1+2 = top row (capture / intel). Cards 3+4 = bottom row (content / rank).',
            'sub_fields' => array(
                array(
                    'key' => 'field_gh_service_fw_card_kind', 'label' => 'Icon Kind', 'name' => 'icon_kind',
                    'type' => 'select', 'default_value' => 'capture',
                    'choices' => array(
                        'capture' => 'Capture (💬, green tint)',
                        'intel'   => 'Intel (🧠, amber tint)',
                        'content' => 'Content (📄, indigo tint)',
                        'rank'    => 'Rank (🔍, emerald tint)',
                    ),
                ),
                array( 'key' => 'field_gh_service_fw_card_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_fw_card_text',  'label' => 'Body',  'name' => 'text',  'type' => 'textarea', 'rows' => 3 ),
            ),
        ),
        array( 'key' => 'field_gh_service_fw_loop_label', 'label' => 'Centre Loop Label', 'name' => 'service_flywheel_loop_label', 'type' => 'text', 'instructions' => 'Caps tag below the spinning ring. Default: "Continuous Loop".' ),
        array( 'key' => 'field_gh_service_fw_loop_pill',  'label' => 'Loop Pill Text',    'name' => 'service_flywheel_loop_pill',  'type' => 'text', 'instructions' => 'Gold caps pill below the grid.' ),
        array( 'key' => 'field_gh_service_fw_closing',    'label' => 'Closing Line',      'name' => 'service_flywheel_closing',    'type' => 'textarea', 'rows' => 3, 'instructions' => 'Inline <em>tags allowed</em> — em renders as gold accent.' ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Editorial Proof (Agent A4) */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_editorial_proof',
    'title'      => 'Service · Editorial Proof',
    'menu_order' => 9,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_ep_show',
            'label'         => 'Show this section',
            'name'          => 'service_editorial_proof_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_ep_eyebrow',  'label' => 'Eyebrow',     'name' => 'service_editorial_proof_eyebrow',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_ep_headline', 'label' => 'Headline',    'name' => 'service_editorial_proof_headline', 'type' => 'textarea', 'rows' => 3 ),
        array( 'key' => 'field_gh_service_ep_sub',      'label' => 'Sub-headline', 'name' => 'service_editorial_proof_sub',      'type' => 'textarea', 'rows' => 3, 'instructions' => 'Inline <strong>tags allowed</strong>.' ),
        array(
            'key' => 'field_gh_service_ep_panels', 'label' => 'Editorial Panels', 'name' => 'service_editorial_proof_panels',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 8,
            'instructions' => 'Each panel = one full-bleed cream row with a huge gold stat number, gold divider, and a content block. Panels alternate between two cream tones automatically.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_ep_panel_num',  'label' => 'Stat Number',          'name' => 'number',     'type' => 'text' ),
                array( 'key' => 'field_gh_service_ep_panel_lab',  'label' => 'Label (gold caps)',    'name' => 'label',      'type' => 'text' ),
                array( 'key' => 'field_gh_service_ep_panel_desc', 'label' => 'Descriptor (green)',   'name' => 'descriptor', 'type' => 'textarea', 'rows' => 2 ),
                array( 'key' => 'field_gh_service_ep_panel_text', 'label' => 'Body Text',            'name' => 'text',       'type' => 'textarea', 'rows' => 4 ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · How It Works (Agent A5) */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_how_it_works',
    'title'      => 'Service · How It Works',
    'menu_order' => 10,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_how_show',
            'label'         => 'Show this section',
            'name'          => 'service_how_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_how_eyebrow',  'label' => 'Eyebrow',  'name' => 'service_how_eyebrow',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_how_headline', 'label' => 'Headline', 'name' => 'service_how_headline', 'type' => 'textarea', 'rows' => 3 ),
        array(
            'key' => 'field_gh_service_how_steps', 'label' => 'Steps', 'name' => 'service_how_steps',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 8,
            'instructions' => 'Each step is a circle marker (numbered automatically) connected to the next via a vertical line. Body text supports blank-line-separated paragraphs.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_how_step_label', 'label' => 'Label (gold caps)', 'name' => 'label', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_how_step_title', 'label' => 'Title',             'name' => 'title', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_how_step_text',  'label' => 'Body Text',         'name' => 'text',  'type' => 'textarea', 'rows' => 6 ),
            ),
        ),
        array(
            'key'           => 'field_gh_service_how_timeline_show',
            'label'         => 'Show Timeline Bar',
            'name'          => 'service_how_timeline_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_how_timeline_start', 'label' => 'Timeline — Start Label', 'name' => 'service_how_timeline_start', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_how_timeline_end',   'label' => 'Timeline — End Label',   'name' => 'service_how_timeline_end',   'type' => 'text' ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* Service · Closing Offer (Agent A6) */
acf_add_local_field_group( array(
    'key'        => 'group_gh_service_closing_offer',
    'title'      => 'Service · Closing Offer',
    'menu_order' => 11,
    'fields'     => array(
        array(
            'key'           => 'field_gh_service_cls_show',
            'label'         => 'Show this section',
            'name'          => 'service_closing_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        // Top header
        array( 'key' => 'field_gh_service_cls_overline',   'label' => 'Top — Overline',     'name' => 'service_closing_overline',   'type' => 'text' ),
        array( 'key' => 'field_gh_service_cls_headline',   'label' => 'Top — Headline',     'name' => 'service_closing_headline',   'type' => 'textarea', 'rows' => 3 ),
        array( 'key' => 'field_gh_service_cls_copy_intro', 'label' => 'Top — Intro Copy',   'name' => 'service_closing_copy_intro', 'type' => 'textarea', 'rows' => 5 ),
        array( 'key' => 'field_gh_service_cls_copy_names', 'label' => 'Top — Names Line',   'name' => 'service_closing_copy_names', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_cls_copy_mid',   'label' => 'Top — Mid Copy',     'name' => 'service_closing_copy_mid',   'type' => 'textarea', 'rows' => 4 ),
        array( 'key' => 'field_gh_service_cls_copy_punch', 'label' => 'Top — Punchline',    'name' => 'service_closing_copy_punch', 'type' => 'textarea', 'rows' => 4 ),
        // Value stack
        array( 'key' => 'field_gh_service_cls_stack_label', 'label' => 'Stack Label', 'name' => 'service_closing_stack_label', 'type' => 'text' ),
        array(
            'key' => 'field_gh_service_cls_stack_items', 'label' => "What's Included Items", 'name' => 'service_closing_stack_items',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 12,
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_cls_stack_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_stack_desc',  'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 3 ),
            ),
        ),
        // Eligibility
        array( 'key' => 'field_gh_service_cls_elig_intro1', 'label' => 'Eligibility — Intro 1', 'name' => 'service_closing_elig_intro1', 'type' => 'textarea', 'rows' => 3 ),
        array( 'key' => 'field_gh_service_cls_elig_intro2', 'label' => 'Eligibility — Intro 2', 'name' => 'service_closing_elig_intro2', 'type' => 'textarea', 'rows' => 3 ),
        array( 'key' => 'field_gh_service_cls_elig_label',  'label' => 'Eligibility — Bar Label', 'name' => 'service_closing_elig_label', 'type' => 'text' ),
        array(
            'key' => 'field_gh_service_cls_elig_items', 'label' => 'Eligibility — Items', 'name' => 'service_closing_elig_items',
            'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 6,
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_cls_elig_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text' ),
            ),
        ),
        // Testimonials
        array( 'key' => 'field_gh_service_cls_test_label', 'label' => 'Testimonials — Label', 'name' => 'service_closing_test_label', 'type' => 'text' ),
        array(
            'key' => 'field_gh_service_cls_test_cards', 'label' => 'Testimonial Cards', 'name' => 'service_closing_test_cards',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 6,
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_cls_test_quote',  'label' => 'Quote',     'name' => 'quote',  'type' => 'textarea', 'rows' => 3 ),
                array( 'key' => 'field_gh_service_cls_test_name',   'label' => 'Name',      'name' => 'name',   'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_test_role',   'label' => 'Role',      'name' => 'role',   'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_test_metric', 'label' => 'Metric',    'name' => 'metric', 'type' => 'text' ),
                array(
                    'key' => 'field_gh_service_cls_test_avatar', 'label' => 'Avatar', 'name' => 'avatar',
                    'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail',
                ),
            ),
        ),
        // Proof row (right column)
        array(
            'key' => 'field_gh_service_cls_proof_cols', 'label' => 'Proof Columns', 'name' => 'service_closing_proof_cols',
            'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 6,
            'sub_fields' => array(
                array( 'key' => 'field_gh_service_cls_proof_client', 'label' => 'Client', 'name' => 'client', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_proof_stat',   'label' => 'Stat',   'name' => 'stat',   'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_proof_label',  'label' => 'Label',  'name' => 'label',  'type' => 'textarea', 'rows' => 3 ),
            ),
        ),
        // Pricing cards
        array( 'key' => 'field_gh_service_cls_pricing_promo', 'label' => 'Pricing — Promo Label', 'name' => 'service_closing_pricing_promo', 'type' => 'text' ),
        array(
            'key' => 'field_gh_service_cls_pricing_cards', 'label' => 'Pricing Cards', 'name' => 'service_closing_pricing_cards',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 4,
            'sub_fields' => array(
                array(
                    'key' => 'field_gh_service_cls_card_plan', 'label' => 'Plan ID', 'name' => 'plan_id',
                    'type' => 'select', 'default_value' => 'monthly',
                    'choices' => array( 'monthly' => 'Monthly', 'annual' => 'Annual' ),
                    'instructions' => 'Determines which Stripe price the card maps to when the customer selects it. Backend wiring uses this slug to look up the corresponding price ID.',
                ),
                array(
                    'key' => 'field_gh_service_cls_card_pop', 'label' => 'Most Popular', 'name' => 'is_popular',
                    'type' => 'true_false', 'default_value' => 0, 'ui' => 1,
                ),
                array( 'key' => 'field_gh_service_cls_card_badge',  'label' => 'Badge Text',     'name' => 'badge',        'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_card_label',  'label' => 'Label',          'name' => 'label',        'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_card_price',  'label' => 'Price',          'name' => 'price',        'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_card_suff',   'label' => 'Price Suffix',   'name' => 'price_suffix', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_card_tax',    'label' => 'Tax Note',       'name' => 'tax_note',     'type' => 'text', 'instructions' => 'Small mono-uppercase line under the price, e.g. "+ 20% VAT". Stripe Tax adds this on top of the headline price at checkout.' ),
                array( 'key' => 'field_gh_service_cls_card_detail', 'label' => 'Detail',         'name' => 'detail',       'type' => 'textarea', 'rows' => 3, 'instructions' => 'Inline <strong> tags allowed.' ),
                array( 'key' => 'field_gh_service_cls_card_savg',   'label' => 'Save (green pill)', 'name' => 'save_green', 'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_card_savgo',  'label' => 'Save (gold pill)',  'name' => 'save_gold',  'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_card_total',  'label' => 'Total Bar Text',  'name' => 'total',         'type' => 'text' ),
                array( 'key' => 'field_gh_service_cls_card_lock',   'label' => 'Price-lock Line', 'name' => 'price_lock',    'type' => 'text' ),
            ),
        ),
        // Fee waiver callout
        array(
            'key'           => 'field_gh_service_cls_waiver_show',
            'label'         => 'Show Fee Waiver Callout',
            'name'          => 'service_closing_waiver_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array( 'key' => 'field_gh_service_cls_waiver_eyebrow', 'label' => 'Waiver — Eyebrow', 'name' => 'service_closing_waiver_eyebrow', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_cls_waiver_amount',  'label' => 'Waiver — Amount',  'name' => 'service_closing_waiver_amount',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_cls_waiver_badge',   'label' => 'Waiver — Badge',   'name' => 'service_closing_waiver_badge',   'type' => 'text' ),
        array( 'key' => 'field_gh_service_cls_waiver_label',   'label' => 'Waiver — Label',   'name' => 'service_closing_waiver_label',   'type' => 'text' ),
        array( 'key' => 'field_gh_service_cls_waiver_details', 'label' => 'Waiver — Details', 'name' => 'service_closing_waiver_details', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Inline <strong> tags allowed.' ),
        // Punchline + form
        array( 'key' => 'field_gh_service_cls_punchline',    'label' => 'Punchline',         'name' => 'service_closing_punchline',    'type' => 'textarea', 'rows' => 3 ),
        array( 'key' => 'field_gh_service_cls_pq_text',      'label' => 'Form — Pull Quote', 'name' => 'service_closing_pull_quote_text', 'type' => 'textarea', 'rows' => 2 ),
        array( 'key' => 'field_gh_service_cls_pq_attr',      'label' => 'Form — Quote Attr', 'name' => 'service_closing_pull_quote_attr', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_cls_bold_close',   'label' => 'Form — Bold Close Line',  'name' => 'service_closing_bold_close',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_cls_submit',       'label' => 'Form — Submit Label',     'name' => 'service_closing_submit_label', 'type' => 'text' ),
        array( 'key' => 'field_gh_service_cls_secure',       'label' => 'Form — Secure Note',      'name' => 'service_closing_secure_note',  'type' => 'text' ),
        array( 'key' => 'field_gh_service_cls_joining',      'label' => 'Form — Joining Note',     'name' => 'service_closing_joining_note', 'type' => 'text' ),
    ),
    'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
) );

/* ─────────────────────────────────────────────────────────────────
 * Service · Agent Thank-you Page
 *
 * Bound to the page-agent-thank-you.php page template (a regular WP
 * Page, not a Service post). Renders post-payment confirmation copy
 * with email + plan personalisation read from the PaymentIntent ID
 * passed in the redirect URL.
 *
 * Most fields have sensible defaults baked into the template via
 * gh_field() — so an editor only needs to fill in the Vimeo video URL
 * to get a fully-styled page. Empty fields fall back to the static
 * spec.
 * ───────────────────────────────────────────────────────────────── */
acf_add_local_field_group( array(
    'key'        => 'group_gh_agent_thank_you',
    'title'      => 'Service · Agent Thank-you Page',
    'menu_order' => 20,
    'fields'     => array(
        // Confirmation hero
        array( 'key' => 'field_gh_aty_hero_title', 'label' => 'Hero — Title',    'name' => 'agent_thank_you_hero_title', 'type' => 'text', 'instructions' => 'Default: "You\'re in."' ),
        array( 'key' => 'field_gh_aty_hero_sub',   'label' => 'Hero — Subtitle', 'name' => 'agent_thank_you_hero_sub',   'type' => 'textarea', 'rows' => 3, 'instructions' => 'Static lines below the personalised email + plan. Default: "Deployment kicks off in 7 days."' ),

        // Welcome video
        array(
            'key'           => 'field_gh_aty_video_show',
            'label'         => 'Show Welcome Video',
            'name'          => 'agent_thank_you_video_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
            'instructions'  => 'Section auto-hides if the Video URL field is empty regardless of this toggle.',
        ),
        array( 'key' => 'field_gh_aty_video_eyebrow', 'label' => 'Video — Eyebrow', 'name' => 'agent_thank_you_video_eyebrow', 'type' => 'text', 'instructions' => 'Default: "Welcome from Drew".' ),
        array( 'key' => 'field_gh_aty_video_url',     'label' => 'Video — URL',     'name' => 'agent_thank_you_video_url',     'type' => 'oembed', 'instructions' => 'Paste a Vimeo or YouTube URL. ACF auto-renders the embed. Section hides when empty.' ),
        array( 'key' => 'field_gh_aty_video_caption', 'label' => 'Video — Caption', 'name' => 'agent_thank_you_video_caption', 'type' => 'text', 'instructions' => 'Default: "A quick word from Drew — what happens next."' ),

        // Timeline
        array( 'key' => 'field_gh_aty_timeline_eyebrow', 'label' => 'Timeline — Eyebrow', 'name' => 'agent_thank_you_timeline_eyebrow', 'type' => 'text', 'instructions' => 'Default: "What happens next".' ),
        array(
            'key' => 'field_gh_aty_timeline_items', 'label' => 'Timeline — Items', 'name' => 'agent_thank_you_timeline_items',
            'type' => 'repeater', 'layout' => 'block', 'min' => 0, 'max' => 6,
            'instructions' => 'Three items is the designed default — Today / Day 1–3 / Day 7. Each item has a mono-uppercase label, a bold title, and a body line.',
            'sub_fields' => array(
                array( 'key' => 'field_gh_aty_tli_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text' ),
                array( 'key' => 'field_gh_aty_tli_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ),
                array( 'key' => 'field_gh_aty_tli_body',  'label' => 'Body',  'name' => 'body',  'type' => 'textarea', 'rows' => 2 ),
            ),
        ),

        // While you wait
        array( 'key' => 'field_gh_aty_wait_eyebrow', 'label' => 'While You Wait — Eyebrow', 'name' => 'agent_thank_you_wait_eyebrow', 'type' => 'text', 'instructions' => 'Default: "While you wait".' ),
        array( 'key' => 'field_gh_aty_wait_intro',   'label' => 'While You Wait — Intro',   'name' => 'agent_thank_you_wait_intro',   'type' => 'textarea', 'rows' => 2 ),
        array(
            'key' => 'field_gh_aty_wait_items', 'label' => 'While You Wait — Items', 'name' => 'agent_thank_you_wait_items',
            'type' => 'repeater', 'layout' => 'table', 'min' => 0, 'max' => 4,
            'sub_fields' => array(
                array( 'key' => 'field_gh_aty_wi_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text' ),
            ),
        ),

        // Reassurance / testimonial
        array( 'key' => 'field_gh_aty_reassure_quote', 'label' => 'Reassurance — Quote',       'name' => 'agent_thank_you_reassure_quote', 'type' => 'textarea', 'rows' => 3 ),
        array( 'key' => 'field_gh_aty_reassure_attr',  'label' => 'Reassurance — Attribution', 'name' => 'agent_thank_you_reassure_attr',  'type' => 'text' ),

        // Founder note
        array( 'key' => 'field_gh_aty_founder_title', 'label' => 'Founder — Title',         'name' => 'agent_thank_you_founder_title', 'type' => 'text' ),
        array( 'key' => 'field_gh_aty_founder_body',  'label' => 'Founder — Body',          'name' => 'agent_thank_you_founder_body',  'type' => 'textarea', 'rows' => 3 ),
        array( 'key' => 'field_gh_aty_founder_name',  'label' => 'Founder — Signoff Name',  'name' => 'agent_thank_you_founder_name',  'type' => 'text', 'instructions' => 'Default: "Drew Clayton".' ),
        array( 'key' => 'field_gh_aty_founder_role',  'label' => 'Founder — Signoff Role',  'name' => 'agent_thank_you_founder_role',  'type' => 'text', 'instructions' => 'Default: "The Gildhart team".' ),
        array( 'key' => 'field_gh_aty_founder_photo', 'label' => 'Founder — Photo',         'name' => 'agent_thank_you_founder_photo', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail', 'instructions' => 'Optional headshot to display next to the founder signoff. Square crop works best — renders as a 56px circular avatar with a thin gold border.' ),

        // ── Playbook Upsell ────────────────────────────────────────────
        // Cross-sell block immediately above the footer that pitches the
        // £497 Playbook to a buyer who's already in "spending money"
        // mode. Two-column split: copy on the left, playbook image on
        // the right. Image defaults to the playbook service post's hero
        // image (so a single asset upload powers both pages); upsell_image
        // overrides if set.
        array(
            'key'           => 'field_gh_aty_upsell_show',
            'label'         => 'Playbook Upsell — Show this section',
            'name'          => 'agent_thank_you_upsell_show',
            'type'          => 'true_false',
            'default_value' => 1,
            'ui'            => 1,
            'instructions'  => 'Toggle off to hide the entire upsell block.',
        ),
        array( 'key' => 'field_gh_aty_upsell_eyebrow',  'label' => 'Playbook Upsell — Eyebrow',  'name' => 'agent_thank_you_upsell_eyebrow',  'type' => 'text',     'instructions' => 'Default: "Complete the system".' ),
        array( 'key' => 'field_gh_aty_upsell_headline', 'label' => 'Playbook Upsell — Headline', 'name' => 'agent_thank_you_upsell_headline', 'type' => 'text',     'instructions' => 'Default: "Your agent converts. Now let\'s fill it."' ),
        array( 'key' => 'field_gh_aty_upsell_subhead',  'label' => 'Playbook Upsell — Subhead',  'name' => 'agent_thank_you_upsell_subhead',  'type' => 'textarea', 'rows' => 2, 'instructions' => 'Default: "The AI Search Playbook — the exact system that drove Ealing\'s £100k HPV revenue to their agent."' ),
        array( 'key' => 'field_gh_aty_upsell_body',     'label' => 'Playbook Upsell — Body',     'name' => 'agent_thank_you_upsell_body',     'type' => 'textarea', 'rows' => 4 ),
        array(
            'key'           => 'field_gh_aty_upsell_image',
            'label'         => 'Playbook Upsell — Image (override)',
            'name'          => 'agent_thank_you_upsell_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'instructions'  => 'Optional. Leave empty to auto-pull the hero image from the Playbook service post (/the-playbook/) so a single asset powers both pages.',
        ),
        array( 'key' => 'field_gh_aty_upsell_cta_label', 'label' => 'Playbook Upsell — CTA Label', 'name' => 'agent_thank_you_upsell_cta_label', 'type' => 'text', 'instructions' => 'Default: "Get the Playbook — £497 →".' ),
        array( 'key' => 'field_gh_aty_upsell_cta_url',   'label' => 'Playbook Upsell — CTA URL',   'name' => 'agent_thank_you_upsell_cta_url',   'type' => 'url',  'instructions' => 'Default: "/the-playbook/".' ),
        array( 'key' => 'field_gh_aty_upsell_footnote',  'label' => 'Playbook Upsell — Footnote (optional)', 'name' => 'agent_thank_you_upsell_footnote', 'type' => 'text', 'instructions' => 'Optional small uppercase text below the CTA. Leave empty to hide.' ),

        // ── Proof block (lives in the left copy column) ────────────────
        // Supporting prose under the body copy: gold label, paragraph,
        // italic takeaway. Each line hides if you blank the field.
        array( 'key' => 'field_gh_aty_upsell_proof_label',    'label' => 'Playbook Upsell — Proof Label',    'name' => 'agent_thank_you_upsell_proof_label',    'type' => 'text',     'instructions' => 'Small gold uppercase label above the proof paragraph. Default: "What happens when the Playbook compounds".' ),
        array( 'key' => 'field_gh_aty_upsell_proof_body',     'label' => 'Playbook Upsell — Proof Paragraph', 'name' => 'agent_thank_you_upsell_proof_body', 'type' => 'textarea', 'rows' => 4 ),
        array( 'key' => 'field_gh_aty_upsell_proof_emphasis', 'label' => 'Playbook Upsell — Italic Takeaway', 'name' => 'agent_thank_you_upsell_proof_emphasis', 'type' => 'text', 'instructions' => 'Italic gold one-liner under the proof paragraph. Default: "Individual patients. Then institutions. That\'s what compounding looks like."' ),
    ),
    'location' => array(
        array(
            array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-templates/page-agent-thank-you.php' ),
        ),
    ),
) );
