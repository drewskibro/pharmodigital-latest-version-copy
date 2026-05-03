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
        'rewrite'            => false,
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
 * Render Service CPT entries at the root: /the-playbook/ rather than
 * /services/the-playbook/. Two pieces:
 *
 *   1. post_type_link filter — outputs the public permalink as /{slug}/.
 *   2. request filter — when WordPress resolves a single-segment URL to
 *      ?name=foo with no post_type set (the default catch-all behaviour),
 *      we check if a Service exists with that slug and switch post_type
 *      to 'service'. Pages still resolve first because page rules set
 *      pagename instead of name. Doesn't touch the rewrite rule table,
 *      so no flush is needed for it to work.
 *
 *   The /services/ archive still resolves via has_archive on the CPT
 *   registration.
 */
function gildhart_service_root_permalink( $post_link, $post ) {
    if ( 'service' === $post->post_type && 'publish' === $post->post_status ) {
        $post_link = home_url( '/' . $post->post_name . '/' );
    }
    return $post_link;
}
add_filter( 'post_type_link', 'gildhart_service_root_permalink', 10, 2 );

function gildhart_service_request_filter( $vars ) {
    if ( is_admin() && ! wp_doing_ajax() ) {
        return $vars;
    }
    if ( empty( $vars['name'] ) || ! empty( $vars['post_type'] ) || ! empty( $vars['pagename'] ) ) {
        return $vars;
    }
    $service = get_page_by_path( $vars['name'], OBJECT, 'service' );
    if ( $service ) {
        $vars['post_type'] = 'service';
    }
    return $vars;
}
add_filter( 'request', 'gildhart_service_request_filter' );

/**
 * Pre-populate Service CPT field values when they are empty.
 *
 * Backfills the static-spec defaults via acf/load_value so freshly published
 * service entries — and any service field saved as empty — render complete
 * in BOTH the admin UI (pre-filled inputs) and the frontend. Saved non-empty
 * values always win; only empty / null values are backfilled.
 *
 * Defaults are slug-aware: each service product (`the-playbook`, `the-agent`,
 * `web-pro-elite`, …) has its own defaults map. The active map is picked from
 * the post slug (post_name); unknown slugs fall back to The Playbook so a
 * fresh service still renders complete copy.
 *
 * Repeater rows are not backfilled here (ACF's load_value handling for
 * repeater parents is unreliable). The template-side fallback in each
 * section template part renders the default rows on the frontend; the admin
 * UI shows an empty repeater that the editor can fill if they want to
 * override the defaults.
 *
 * Adding new defaults: extend the matching slug array in
 * gildhart_service_defaults_by_slug().
 */
function gildhart_service_defaults_by_slug() {
    return array(
        'the-agent' => array(
            // Hero
            'service_hero_eyebrow'             => 'The Agent',
            'service_hero_title'               => "Someone Just Left Your Website.\nThey Had A Question.\nNobody Answered.",
            'service_hero_subtitle'            => "Sachin at Ealing Travel Clinic went from sporadic HPV bookings to 55 a month. The practice didn't change. The channel did.\n\n£200k a year. Generated after hours. Southdowns Pharmacy Group doesn't have night staff. They have something better.",
            'service_hero_cta_primary_label'   => 'Deploy The Agent This May',
            'service_hero_cta_primary_url'     => '#eligibility',
            'service_hero_cta_secondary_label' => '',
            'service_hero_cta_secondary_url'   => '',
            // Logo Bar
            'service_logo_bar_label'           => 'Every practice live is generating enquiries they never had before',
        ),
    );
}

/**
 * Section roster for each service product.
 *
 * Returns the ordered list of section slugs that single-service.php
 * renders for a given service post_name. This is the single source of
 * truth for "which sections appear on this product's page" — the per-
 * section "Show this section" toggles in the admin still work as a
 * per-instance hide, but the roster decides whether the section is
 * even considered.
 *
 * Why a roster (vs. show toggles alone): ACF field-level default_value
 * pre-populates show toggles as 1 on a fresh post; once saved that
 * value sticks and can't be overridden by my acf/load_value filter.
 * The roster sidesteps the whole loop — single-service.php only loops
 * over the products's roster, regardless of what any post has saved.
 *
 * Adding a section to a product = append the section slug here.
 * Section slugs map to template-parts/service/section-{slug}.php.
 *
 * @param string $slug Service post_name.
 * @return string[]
 */
function gildhart_service_section_roster( $slug ) {
    $rosters = array(
        'the-playbook' => array(
            'hero', 'logo-bar', 'problem-shift', 'proof-cases', 'playing-field',
            'method', 'what-you-get', 'sub-case-proof', 'early-buyers', 'math',
            'next-steps', 'faq', 'guarantee', 'final-cta',
        ),
        'the-agent' => array(
            // A0 — shipped
            'hero', 'logo-bar',
            // A1+ append here as each chunk lands. The Agent reuses the FAQ /
            // Guarantee / Final CTA templates (with Agent copy) once their
            // A-chunks land in A2 / A5 / A6 — until then those sections are
            // intentionally not in the roster, so the Agent page ends after
            // the logo bar.
        ),
    );
    // Unknown slug falls back to the Playbook roster as the longest-running
    // baseline — adding a new product = add a new entry above.
    return $rosters[ $slug ] ?? $rosters['the-playbook'];
}

function gildhart_service_default_values( $value, $post_id, $field ) {
    if ( ! is_numeric( $post_id ) ) {
        return $value;
    }
    if ( get_post_type( $post_id ) !== 'service' ) {
        return $value;
    }
    // Skip on auto-drafts — WP hasn't generated the slug yet, so we'd serve
    // the fallback (Playbook) defaults and ACF would write them back to the
    // post's meta on first publish. Returning $value (empty) means freshly
    // created services have blank fields until the user publishes; the
    // slug-matched defaults then populate after publish, when post_name is
    // set. (The 'new' state is theoretical — WP uses 'auto-draft' in
    // practice, but listed for safety.)
    if ( in_array( get_post_status( $post_id ), array( 'auto-draft', 'new' ), true ) ) {
        return $value;
    }
    if ( $value !== '' && $value !== null && ! ( is_array( $value ) && empty( $value ) ) ) {
        return $value;
    }

    $slug              = get_post_field( 'post_name', $post_id );
    $defaults_by_slug  = gildhart_service_defaults_by_slug();
    $slug_defaults     = $defaults_by_slug[ $slug ] ?? array();

    $playbook_defaults = array(
        // Hero
        'service_hero_eyebrow'             => 'The AI Search Playbook',
        'service_hero_title'               => "While You're Reading This, ChatGPT Is Recommending Your Competitors.",
        'service_hero_subtitle'            => 'Rahul at Puri Pharmacy is now on that shortlist. So is Raman at Superior Pharmacy and Sachin at Ealing Travel Clinic. One playbook. Three practices. No ad spend.',
        'service_hero_cta_primary_label'   => 'Get The Playbook — £497',
        'service_hero_cta_primary_url'     => '#buy-now',
        'service_hero_cta_secondary_label' => "See What's Inside",
        'service_hero_cta_secondary_url'   => '#what-you-get',
        // Problem Shift
        'service_problem_shift_label'           => 'The Shift',
        'service_problem_shift_headline'        => "In Two Years, The Practices On ChatGPT's Shortlist Will Own Your Market.",
        'service_problem_shift_intro'           => "That shortlist is being built right now. Every week a practice claims a spot. Every week it gets harder to displace them. And the patients those practices are capturing — Semrush confirmed it across hundreds of sites — convert 4.4 times better than Google organic visitors. Not because of the platform. Because by the time they click a name on ChatGPT's recommendation, the decision is already made.",
        'service_problem_shift_strip_text'      => 'First time in 20 years independent practices can outrank national chains. Not in 5 years. In weeks.',
        'service_problem_shift_strip_cta_label' => 'Get The System',
        'service_problem_shift_strip_cta_url'   => '#buy-now',
        // Three Proof Cases
        'service_proof_cases_eyebrow'     => 'Three Practices. Same Result.',
        'service_proof_cases_headline'    => 'Three Different Approaches. One Outcome: Domination.',
        'service_proof_cases_subheadline' => 'Same foundation. Different implementations. All outranking national chains.',
        // Playing Field
        'service_playing_field_eyebrow'           => 'The Opportunity',
        'service_playing_field_headline'          => 'AI Search Killed Brand Authority',
        'service_playing_field_subheadline'       => "Traditional search rewarded authority. Boots wins because they've spent 50 years building links you'll never match. AI search doesn't care.",
        'service_playing_field_old_label'         => 'The Old Game',
        'service_playing_field_old_caption'       => "Boots, Bupa, Superdrug — they own Google because they've spent decades and millions you'll never match.",
        'service_playing_field_new_label'         => 'The New Reality',
        'service_playing_field_new_caption'       => '<strong>Ealing outranked Boots in 6 weeks. On this new playing field, the best answer wins — not the biggest brand.</strong>',
        'service_playing_field_callout_text'      => 'Same foundation Ealing used. Same foundation Superior used.',
        'service_playing_field_callout_highlight' => 'Level playing field. Finally.',
        // Method
        'service_method_eyebrow'        => 'The Method',
        'service_method_headline'       => 'How We Get You Featured in ChatGPT, Claude & Google AI Overviews',
        'service_method_proof_line'     => 'Four steps. <strong>Six weeks to first rankings.</strong> The exact system that put Ealing Travel Clinic and Superior Pharmacy on the AI shortlist — ahead of Boots and Bupa.',
        'service_method_timeline_label' => 'Typical client timeline',
        // What You Get
        'service_what_you_get_eyebrow'     => 'The System',
        'service_what_you_get_headline'    => 'What Ealing, Superior, and Puri Actually Used. Now Yours.',
        'service_what_you_get_subheadline' => 'The same system. Used across three practices. Now generating five figures monthly, £500k annual revenue, and £100k from a single service. Fully automated. Yours today.',
        // Sub-case Proof
        'service_sub_case_eyebrow'     => 'The Proof',
        'service_sub_case_headline'    => 'Real Traffic. Real Results. Real Data.',
        'service_sub_case_subheadline' => 'Google Search Console screenshots from clients who used this system.',
        'service_sub_case_footer'      => 'Verified Search Console data. No invented numbers. Just results.',
        // Early Buyers
        'service_early_buyers_strap_price'      => '£497 once.',
        'service_early_buyers_strap_desc'       => 'The Complete System. Cowork Included. Lifetime Support.',
        'service_early_buyers_cta_label'        => 'Get Instant Access — £497',
        'service_early_buyers_cta_url'          => '#buy-now',
        'service_early_buyers_callout_headline' => 'Why Early Buyers Win',
        // Math
        'service_math_eyebrow'     => 'The Numbers',
        'service_math_headline'    => 'What This Actually Means For You',
        'service_math_subheadline' => "The playbook costs £497. But what you're really buying depends on who you are.",
        // Next Steps
        'service_next_eyebrow'     => 'Your Timeline',
        'service_next_headline'    => 'What Happens Next',
        'service_next_subheadline' => 'From purchase to AI rankings — exactly as it happened for Ealing and Superior.',
        // FAQ
        'service_faq_eyebrow'   => 'No Surprises',
        'service_faq_headline'  => "Questions You're Asking",
        'service_faq_cta_text'  => 'Still have questions? <strong>Get the system now and ask me directly on the monthly calls.</strong>',
        'service_faq_cta_label' => 'Get Instant Access — £497',
        'service_faq_cta_url'   => '#buy-now',
        // Guarantee
        'service_guarantee_badge_text'    => 'Personal Implementation Guarantee',
        'service_guarantee_headline'      => 'If You Implement This, It Works',
        'service_guarantee_body'          => "This isn't a promise. It's a documented fact. Three practices. Three different specialties. Same system. Same result.",
        'service_guarantee_personal_text' => "Go through all 5 modules. Follow the system. If you still don't understand how to implement it, <strong>I'll personally walk you through it on a 1-on-1 call.</strong> You're not buying a course. You're getting a system that works — and I'll make sure you know how to use it.",
        // Final CTA
        'service_final_eyebrow'         => 'Your Turn',
        'service_final_headline'        => 'Ealing Spent £497. Then Generated £100k From One Service.',
        'service_final_body'            => "Every month you pay for marketing. Every month the results are someone else's to switch off. This is different. One purchase. One system. Yours forever.",
        'service_final_footer_line'     => 'Ealing did it. Superior did it. Southdowns did it. National chains spent millions. They spent £497.',
        'service_final_price_eyebrow'   => 'The AI Search Playbook',
        'service_final_price_title'     => 'One System. Every AI Platform. Yours Forever.',
        'service_final_price_value'     => '£497',
        'service_final_price_qualifier' => 'one-time · lifetime access',
        'service_final_price_cta_label' => 'Get Instant Access — £497',
        'service_final_price_cta_url'   => '#buy-now',
        'service_final_price_secondary' => 'Or <a href="#contact">talk to us about Done-For-You →</a>',
    );

    // Slug-specific defaults override Playbook defaults (the fallback).
    $defaults = array_merge( $playbook_defaults, $slug_defaults );

    if ( isset( $defaults[ $field['name'] ] ) ) {
        return $defaults[ $field['name'] ];
    }
    return $value;
}
add_filter( 'acf/load_value', 'gildhart_service_default_values', 10, 3 );

/**
 * Flush rewrite rules once after CPT/taxonomy registration so /case-studies/
 * URLs work immediately. Uses an option flag so we only flush once.
 */
function gildhart_maybe_flush_rewrites_for_cpts() {
    if ( get_option( 'gildhart_cpt_rewrites_flushed' ) !== '4_request_filter' ) {
        flush_rewrite_rules();
        update_option( 'gildhart_cpt_rewrites_flushed', '4_request_filter' );
    }
}
add_action( 'init', 'gildhart_maybe_flush_rewrites_for_cpts', 20 );
