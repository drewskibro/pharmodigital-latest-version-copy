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
            'instructions' => 'Three cards is the designed layout. Mark one as "featured" for the dark Recommended treatment.',
            'sub_fields' => array(
                array(
                    'key'   => 'field_gh_home_tp_card_banner',
                    'label' => 'Proof Banner Text',
                    'name'  => 'banner',
                    'type'  => 'text',
                ),
                array(
                    'key'           => 'field_gh_home_tp_card_banner_dark',
                    'label'         => 'Banner Style — Dark Green',
                    'name'          => 'banner_dark',
                    'type'          => 'true_false',
                    'instructions'  => 'Use the green-fill banner style (white text on Gildhart green).',
                    'default_value' => 0,
                    'ui'            => 1,
                ),
                array(
                    'key'           => 'field_gh_home_tp_card_featured',
                    'label'         => 'Featured (Dark Card with "Recommended" pill)',
                    'name'          => 'is_featured',
                    'type'          => 'true_false',
                    'default_value' => 0,
                    'ui'            => 1,
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_label',
                    'label' => 'Eyebrow Label',
                    'name'  => 'label',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_title',
                    'label' => 'Title',
                    'name'  => 'title',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_body',
                    'label' => 'Body',
                    'name'  => 'body',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ),
                array(
                    'key'        => 'field_gh_home_tp_card_features',
                    'label'      => 'Feature List',
                    'name'       => 'features',
                    'type'       => 'repeater',
                    'layout'     => 'table',
                    'min'        => 0,
                    'sub_fields' => array(
                        array(
                            'key'   => 'field_gh_home_tp_card_feature_text',
                            'label' => 'Feature',
                            'name'  => 'text',
                            'type'  => 'text',
                        ),
                    ),
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_price',
                    'label' => 'Price (Big Number)',
                    'name'  => 'price_value',
                    'type'  => 'text',
                    'instructions' => 'e.g. £497. Leave blank to skip the big-number price.',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_price_note',
                    'label' => 'Price Note',
                    'name'  => 'price_value_note',
                    'type'  => 'text',
                    'instructions' => 'Sub-label under the price, e.g. "One-time. Yours forever."',
                ),
                array(
                    'key'   => 'field_gh_home_tp_card_price_muted',
                    'label' => 'Price — Muted Paragraph',
                    'name'  => 'price_muted_text',
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'instructions' => 'Alternative to the big number — used for "investment ranges" or paragraph-style pricing.',
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
