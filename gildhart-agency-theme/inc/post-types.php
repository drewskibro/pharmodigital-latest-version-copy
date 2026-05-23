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
            // Live Clients (A1)
            'service_live_clients_eyebrow'     => 'Live Right Now',
            'service_live_clients_headline'    => 'The Practices That Saw Where Healthcare Was Going.',
            'service_live_clients_sub'         => 'Seven from our global network, already operating with AI at the core of their patient acquisition. Not piloting it. Not planning it. Running it.',
            'service_live_clients_footnote'    => 'Every practice shown is generating revenue automatically, capturing patient intent data on every interaction, and building a compounding commercial advantage across their entire service portfolio. What you see here is a fraction of our active client network.',
            // Why This Exists (A1)
            'service_why_eyebrow'              => 'Why This Exists',
            'service_why_headline'             => "Your Patients Are Asking Thousands of Clinical Questions.\nRight Now, They're Getting the Answers Somewhere Else.",
            'service_why_lead'                 => "Every day, patients land on your site with a specific clinical question. Mounjaro eligibility. Yellow fever. Southeast Asia vaccines for a child. When you can't answer them in that moment — they leave. They don't come back.",
            'service_why_lead_stat'            => 'Their question gets answered. Just not by you.',
            // Track Record (A2 — cinematic redesign)
            'service_track_record_overline'    => 'The Track Record',
            'service_track_record_headline'    => "Last Tuesday. 9:47pm.\nSomeone landed on your website with a specific question about Mounjaro.\nYour website had nothing to say.\nSo they went back to Google. Found another practice. Booked. Paid.\nNever came back.",
            'service_track_record_intro'       => "We have never deployed an agent that didn't find revenue a practice didn't know it was missing.",
            'service_track_record_kicker'      => "That record matters to us more than anything else on this page. The practices already live aren't reading pages like this anymore. They're reading their booking confirmations.",
            'service_track_record_kicker_attribution' => '— The Pharmodigital team',
            'service_track_record_close'       => 'Your practice will be no different.',
            // SalesAgent Pro (A2)
            'service_sa_pro_eyebrow'           => 'The Agent',
            'service_sa_pro_headline'          => "ChatGPT Recommended You.\nThe Patient Had Questions.\nYour Competitor's AI Agent Answered First.",
            'service_sa_pro_cta_label'         => 'See The System',
            'service_sa_pro_cta_url'           => '#eligibility',
            // Testimonial (A3)
            'service_testimonial_metric_value' => '#1',
            'service_testimonial_metric_label' => 'Outranks Boots in local search',
            'service_testimonial_quote'        => "<strong>We're now outranking Boots and major chains in our area.</strong> But what changed everything was the AI sales agent. It handles patient inquiries around the clock, converts the traffic we're driving, and books appointments without us lifting a finger.\n\nWe're now <em>taking that national.</em>\n\nDrew builds pharmacy growth engines. <strong>I trust him because he understands both pharmacy and digital, that's rare to find.</strong>",
            'service_testimonial_name'         => 'Rahul Puri',
            'service_testimonial_role'         => 'Owner, Puri Pharmacy',
            // Intelligence Engine (A3)
            'service_intel_eyebrow'            => 'The Intelligence Engine',
            'service_intel_headline'           => 'Every Patient Question Is A Revenue Signal.',
            'service_intel_sub'                => "Your AI agent doesn't just answer — it captures the exact language patients use, the clinical questions they ask, and the services they're ready to pay for. Then we turn that into content that ranks.",
            // Content Flywheel (A4)
            'service_flywheel_eyebrow'         => 'The Content Flywheel',
            'service_flywheel_headline'        => "Your Patients Write Your Marketing For You.\nThen It Brings You More Patients.",
            'service_flywheel_desc'            => 'Every question a patient asks your agent becomes content that ranks in Google, ChatGPT, and Claude. That content brings new patients. Those patients ask new questions. The machine feeds itself.',
            'service_flywheel_loop_label'      => 'Continuous Loop',
            'service_flywheel_loop_pill'       => 'Accelerates over time — the longer you run it, the wider the gap',
            'service_flywheel_closing'         => 'Your competitors are guessing what patients want. Your patients are <em>telling</em> you. Every single day.',
            // Editorial Proof (A4)
            'service_editorial_proof_eyebrow'  => 'The Numbers',
            'service_editorial_proof_headline' => '10:47pm. A Patient Has A Question. Your Website Has Nothing To Say.',
            'service_editorial_proof_sub'      => 'Not rankings. Not traffic. <strong>Revenue.</strong> Here&rsquo;s what it looks like in practice.',
            // How It Works (A5)
            'service_how_eyebrow'              => 'The Process',
            'service_how_headline'             => "One client received their first weight loss booking five minutes after going live. Here's how we get you there in seven days.",
            'service_how_timeline_start'       => 'Day 1',
            'service_how_timeline_end'         => 'Day 7 — Go Live',
            // FAQ (A5) — eyebrow / headline / cta_show overridden so the
            // Agent FAQ doesn't render with Playbook copy or the £497 CTA.
            // The full Agent items list lives in gildhart_service_faq_defaults()
            // because repeater rows aren't reliably backfilled via load_value.
            'service_faq_eyebrow'              => 'Frequently Asked Questions',
            'service_faq_headline'             => 'Everything You Need to Know Before You Deploy.',
            'service_faq_cta_show'             => 0,
            'service_faq_cta_text'             => '',
            'service_faq_cta_label'            => '',
            'service_faq_cta_url'              => '',
            // Closing Offer (A6) — header + waiver + form copy
            'service_closing_overline'         => 'The Offer',
            'service_closing_headline'         => "For The First Time,\nBeing Independent Is The Advantage.",
            'service_closing_copy_intro'       => "The big chains have procurement committees. Board approvals. Six-month technology cycles. By the time they deploy AI that actually works, your practice has been live for a year — capturing patients they can't reach, answering questions they can't respond to, and compounding revenue they'll never recover.",
            'service_closing_copy_names'       => 'Superior Pharmacy. Ealing Travel Clinic. Malvern Travel Clinic.',
            'service_closing_copy_mid'         => 'Independent practices now sitting at the top of their markets. Not because they outspent the chains. Because they outmoved them.',
            'service_closing_copy_punch'       => 'This is the technology that separates the top earning independents from everyone else. The practices already live know that. The ones still deciding are finding out.',
            'service_closing_stack_label'      => "What's included",
            'service_closing_elig_intro1'      => "Most practices that come to us have the same concern. They're not sure if they're ready. They are.",
            'service_closing_elig_intro2'      => "Every practice we've deployed this for was live within a week. Every single one started generating enquiries they didn't have before.",
            'service_closing_elig_label'       => 'This was built for you if',
            'service_closing_test_label'       => 'From practices already live',
            'service_closing_pricing_promo'    => 'Choose Your Plan',
            'service_closing_waiver_eyebrow'   => 'Online Activation Bonus',
            'service_closing_waiver_amount'    => '£1,500',
            'service_closing_waiver_badge'     => 'Waived',
            'service_closing_waiver_label'     => 'Setup fee waived entirely.',
            'service_closing_waiver_details'   => '<strong>No call needed.</strong> No onboarding queue. Deploys in 7 days. The decision is yours.',
            'service_closing_punchline'        => 'One family travel booking covers the monthly plan for four months. One Mounjaro patient covers the annual plan entirely.',
            'service_closing_pull_quote_text'  => 'Patients use it at all hours. We just see the bookings come in.',
            'service_closing_pull_quote_attr'  => '— Southdowns Pharmacy Group',
            'service_closing_bold_close'       => 'The cost question answers itself. Usually within the first week.',
            'service_closing_submit_label'     => 'Deploy The Agent',
            'service_closing_secure_note'      => 'Payments processed securely via Stripe.',
            'service_closing_joining_note'     => 'Joining 50+ practices across the UK, US, and beyond.',
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
            'method', 'what-you-get', 'medihub-testimonial', 'early-buyers', 'math',
            'next-steps', 'faq', 'guarantee', 'final-cta',
        ),
        'the-agent' => array(
            // A0
            'hero', 'logo-bar',
            // A1
            'live-clients', 'why-this-exists',
            // A2
            'track-record', 'sales-agent-pro',
            // A3
            'testimonial', 'intelligence-engine',
            // A4 — editorial-proof was retired from this roster as of the
            // SA Pro stats consolidation. Its proofs (£200K Southdowns,
            // 50% Superior, 25% Ealing, 100K network) are now redundant
            // with the SA Pro stat cards above + the Track Record + the
            // cinematic story punchline. ACF data and the section file
            // are preserved — re-add 'editorial-proof' below to revive.
            'flywheel',
            // A5
            'how-it-works', 'faq',
            // A5b — second standalone testimonial (Emjad / Medihub).
            // Lives between FAQ and the closing offer so it lands as
            // a distinct section, with full top/bottom section
            // spacing, just before the buy decision.
            'testimonial-emjad',
            // A6 — closes the page. The Agent's "closing offer" replaces the
            // Playbook's separate Guarantee + Final CTA pair with a single
            // consolidated section (header → value stack + eligibility +
            // testimonials | proof row + pricing + form on the right).
            'closing-offer',
        ),
    );
    // Unknown slug falls back to the Playbook roster as the longest-running
    // baseline — adding a new product = add a new entry above.
    return $rosters[ $slug ] ?? $rosters['the-playbook'];
}

/**
 * Map of ACF field group keys → section slugs.
 *
 * Drives the admin-side metabox filter below: any field group listed
 * here is treated as a per-section group and only renders in the
 * Service edit screen when its section slug is in the post's roster.
 * Field groups NOT in this map (e.g. group_gh_service_nav) always
 * render — those are product-agnostic.
 */
function gildhart_service_field_group_map() {
    return array(
        'group_gh_service_hero'             => 'hero',
        'group_gh_service_logo_bar'         => 'logo-bar',
        'group_gh_service_live_clients'     => 'live-clients',
        'group_gh_service_why_this_exists'  => 'why-this-exists',
        'group_gh_service_track_record'     => 'track-record',
        'group_gh_service_sales_agent_pro'  => 'sales-agent-pro',
        'group_gh_service_testimonial'      => 'testimonial',
        'group_gh_service_testimonial_emjad' => 'testimonial-emjad',
        'group_gh_service_intelligence_engine' => 'intelligence-engine',
        'group_gh_service_flywheel'         => 'flywheel',
        'group_gh_service_editorial_proof'  => 'editorial-proof',
        'group_gh_service_how_it_works'     => 'how-it-works',
        'group_gh_service_closing_offer'    => 'closing-offer',
        'group_gh_service_problem_shift'    => 'problem-shift',
        'group_gh_service_proof_cases'      => 'proof-cases',
        'group_gh_service_playing_field'    => 'playing-field',
        'group_gh_service_method'           => 'method',
        'group_gh_service_what_you_get'     => 'what-you-get',
        'group_gh_service_medihub_testimonial' => 'medihub-testimonial',
        'group_gh_service_early_buyers'     => 'early-buyers',
        'group_gh_service_math'             => 'math',
        'group_gh_service_next_steps'       => 'next-steps',
        'group_gh_service_faq'              => 'faq',
        'group_gh_service_guarantee'        => 'guarantee',
        'group_gh_service_final_cta'        => 'final-cta',
    );
}

/**
 * Slug-aware FAQ defaults for section-faq.php.
 *
 * The FAQ section template is shared between products (the Playbook
 * and the Agent both use the same accordion + ACF group), but each
 * product needs its own copy. This helper returns the eyebrow,
 * headline, items, and bottom-CTA defaults keyed by post slug — used
 * as the gh_field() / get_field() fallbacks inside section-faq.php
 * when the user hasn't populated the corresponding ACF fields.
 *
 * Items are returned in full here (not via acf/load_value) because
 * ACF repeater parents can't be reliably backfilled by load_value;
 * the template-side fallback handles them.
 *
 * Adding a third product = add a third entry. Unknown slugs fall
 * back to the Playbook copy.
 *
 * @param string $slug Service post_name.
 * @return array
 */
function gildhart_service_faq_defaults( $slug ) {
    $defaults = array(
        'the-playbook' => array(
            'eyebrow'   => 'No Surprises',
            'headline'  => "Questions You're Asking",
            'cta_show'  => 1,
            'cta_text'  => 'Still have questions? <strong>Get the system now and ask me directly on the monthly calls.</strong>',
            'cta_label' => 'Get Instant Access — £497',
            'cta_url'   => '#buy-now',
            'items'     => array(
                array(
                    'question' => "\"I'm not technical. Can I do this?\"",
                    'answer'   => "If you can copy and paste, yes. Module 1 walks you through setup step by step. All prompts are written — you paste them in. And if you can't figure it out after the modules, <strong>I'll personally walk you through it on a call.</strong>",
                ),
                array(
                    'question' => '"Will this work for my specialty?"',
                    'answer'   => 'Yes. Ealing is a travel clinic. Superior is a pharmacy. Works for <strong>private clinics, IVF clinics, dental practices, specialist consultants, private hospitals</strong> — any private healthcare where patients search online. The method is identical. Only the keywords change.',
                ),
                array(
                    'question' => '"How long until I see results?"',
                    'answer'   => 'Ealing: <strong>6 weeks to first Google AI Overview feature</strong>. Superior: <strong>first ChatGPT sale in 48 hours</strong>. Typical range: 6–12 weeks for solid AI presence. Some practices see features in 2–4 weeks. Depends on how competitive your niche is and how quickly you publish.',
                ),
                array(
                    'question' => '"I don\'t have time."',
                    'answer'   => "1 hour per week. One pillar. Four clusters. Five pieces. The prompts are written — you're not starting from scratch. If you can't find 1 hour per week, the done-for-you option (starting at £5k/month) might suit you better.",
                ),
                array(
                    'question' => '"What if AI platforms change their algorithm?"',
                    'answer'   => "Monthly calls cover this. ChatGPT updates. Google changes. Claude features. <strong>You'll know what to adjust before your competitors do.</strong> Every call is recorded so you never miss an update.",
                ),
                array(
                    'question' => '"Can I use this for multiple practices?"',
                    'answer'   => 'Yes. You own it. <strong>One practice or fifty. No limits.</strong> The prompts work across any healthcare specialty. One purchase covers everything.',
                ),
                array(
                    'question' => '"Why not just hire you to do it?"',
                    'answer'   => 'You can. Done-for-you starts at £5k/month. But if you want to own the system — no ongoing fees, no dependency on an agency — this is for you. <strong>£497 once vs £60k/year.</strong> Same results.',
                ),
                array(
                    'question' => '"Is there a refund policy?"',
                    'answer'   => "No refunds — because this works. It's documented. The screenshots don't lie. But if you go through all 5 modules and still don't understand how to implement it, <strong>I'll personally walk you through it on a 1-on-1 call at no extra charge.</strong> You're not buying a course. You're getting a system that works.",
                ),
            ),
        ),
        'the-agent' => array(
            'eyebrow'   => 'No Surprises',
            'headline'  => 'The Questions Every Smart Practice Owner Asks First.',
            'cta_show'  => 0,
            'cta_text'  => '',
            'cta_label' => '',
            'cta_url'   => '',
            'items'     => array(
                array(
                    'question' => 'Is this medically compliant?',
                    'answer'   => 'Yes. The agent draws only from your own practice content and medically verified sources. It never diagnoses, never recommends specific medications, and never issues clinical advice. Its job is to answer questions, reassure patients, and guide them toward booking. The moment a question requires clinical judgment — dosing, interactions, contraindications — it routes the patient directly to your team. That boundary is hardcoded. It cannot be crossed.',
                ),
                array(
                    'question' => 'What guardrails are in place?',
                    'answer'   => "We've spent 18 months testing this against real patient scenarios. The agent knows exactly what it can say and what it can't. When a question falls outside its scope, it doesn't guess — it tells the patient to speak directly with your pharmacist and provides your contact details. Across 50+ practices and hundreds of thousands of conversations, it has never given unsafe medical information. That's not luck. That's 18 months of deliberate refinement.",
                ),
                array(
                    'question' => 'How is this different from a standard chatbot?',
                    'answer'   => 'A standard chatbot follows a decision tree. Ask it something unexpected and it falls over. The Agent holds a real conversation. It listens. It responds. It handles objections, answers follow-up questions, and moves patients toward booking naturally. Underneath it is a medically verified knowledge base built over 18 months, intent data capture on every conversation, and Microsoft Clarity showing you exactly where each patient came from. A standard chatbot is a script. <strong>This is infrastructure.</strong>',
                ),
                array(
                    'question' => 'Where do patient enquiries go?',
                    'answer'   => 'Wherever you want them. CRM, spreadsheet, email, or all three. Every conversation is fully transcribed so you know exactly what was asked, what was answered, and how close that patient is to booking. Nothing gets lost.',
                ),
                array(
                    'question' => 'What services can it be trained on?',
                    'answer'   => 'All of them. Weight loss, travel health, aesthetics, occupational health, ear wax removal, private GP. There are no limitations. If you offer it, the agent can handle it.',
                ),
                array(
                    'question' => 'How does it know my specific services and pricing?',
                    'answer'   => 'We start with our medically verified knowledge base built over 18 months. Then we layer in your services, your pricing, your processes, and your practice personality. By the time it goes live it sounds like your team. Not a generic bot. Not a template. Yours.',
                ),
                array(
                    'question' => 'How long does setup take?',
                    'answer'   => "Seven days. We build it, test it, and deploy it. You don't touch a single line of code. You review it, approve it, and it goes live.",
                ),
                array(
                    'question' => 'Do I need any technical knowledge?',
                    'answer'   => 'None. You approve the agent before it goes live. After that it runs itself. Every update as the AI space evolves gets rolled in automatically. You always have the most current version without doing anything.',
                ),
                array(
                    'question' => 'Is patient data secure and GDPR compliant?',
                    'answer'   => "Fully. Every agent includes compliant patient messaging explaining how data is used, so patients know from the first interaction. We operate under UK GDPR with data minimisation and purpose limitation as core principles — we collect only what's needed, store nothing beyond its purpose, and never share data with third parties. All communications are encrypted in transit and at rest. Your practice acts as data controller; we act as processor under a formal Data Processing Agreement. We update your privacy policy as part of setup. You're covered from day one.",
                ),
                array(
                    'question' => 'What happens after 12 months?',
                    'answer'   => "If you paid upfront, your price is locked in. Renews at the same rate regardless of what happens to pricing in the market. You also get every update we make as AI continues to evolve — included, no extra cost. If you're on the monthly plan it rolls over automatically. Either way the authority, the intent data, and the patient conversations you've built keep compounding. The agent gets more valuable every month it runs.",
                ),
            ),
        ),
    );
    return $defaults[ $slug ] ?? $defaults['the-playbook'];
}

/**
 * Hide ACF metaboxes for sections that aren't in the current post's
 * roster, so the editor only sees fields that actually render.
 *
 * Runs after ACF has registered its metaboxes (priority 20 — ACF
 * registers at default 10), and removes the metaboxes for any field
 * group whose section isn't in the roster for this post's slug.
 *
 * Skips on auto-drafts (no slug yet) so the editor still sees every
 * section while creating a new service. Once the post is published
 * and reloaded, the filter kicks in and hides the irrelevant ones.
 */
function gildhart_service_filter_admin_metaboxes() {
    global $post, $pagenow;

    if ( ! in_array( $pagenow, array( 'post.php', 'post-new.php' ), true ) ) {
        return;
    }
    if ( ! $post || $post->post_type !== 'service' ) {
        return;
    }
    if ( empty( $post->post_name ) ) {
        return; // auto-draft — show everything until publish.
    }

    $roster        = gildhart_service_section_roster( $post->post_name );
    $field_groups  = gildhart_service_field_group_map();

    foreach ( $field_groups as $group_key => $section_slug ) {
        if ( ! in_array( $section_slug, $roster, true ) ) {
            remove_meta_box( 'acf-' . $group_key, 'service', 'normal' );
        }
    }
}
add_action( 'add_meta_boxes', 'gildhart_service_filter_admin_metaboxes', 20 );

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
        // The Offer (4-part section replacing the old Early Buyers stack)
        'service_offer_price_value'         => '£497 once.',
        'service_offer_price_descriptor'    => 'The Complete System. Cowork Included. Lifetime Support.',
        'service_offer_primary_cta_label'   => 'Get Instant Access — £497',
        'service_offer_primary_cta_url'     => '#checkout',
        'service_offer_secondary_cta_label' => 'Or talk to us about Done For You',
        'service_offer_secondary_cta_url'   => '/contact/',
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
