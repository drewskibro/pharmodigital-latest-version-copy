<?php
/**
 * Service: The System section (cream/light Claude-badge variant).
 *
 * Cream-gradient section that walks through the five-step Playbook
 * system the customer runs themselves: onboarding → knowledge base →
 * skills → content → results. Five white cards in a 2+2+1 grid (last
 * card spans full-width as the closing proof beat).
 *
 * The new visual identity leads each card with a Claude product badge
 * (uploaded per card via ACF) — "Powered by Claude Cowork" for the
 * onboarding/knowledge cards, "Built with Claude" for the skills /
 * content / results cards. Below the header subtext, a centered
 * "Built with Claude" badge anchors the section to the underlying
 * platform.
 *
 * Each card carries:
 *   - Claude product badge (ACF image upload, omitted when empty)
 *   - Small forest-green caps step label
 *   - Bold dark-navy title
 *   - Italic muted-navy subtitle
 *   - Body copy
 *   - Gold-anchored stat line at the bottom
 *
 * Reads from per-section ACF group `Service · What You Get` (key
 * preserved so historical metabox position holds). Returns early
 * when the show toggle is off.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_what_you_get_show', 1 ) ) {
    return;
}

$eyebrow     = gh_field( 'service_what_you_get_eyebrow',     'The System' );
$headline    = gh_field( 'service_what_you_get_headline',    'It Runs While You See Patients.' );
$subheadline = gh_field( 'service_what_you_get_subheadline', "Ealing, Superior, and Rahul's weight loss clinic didn't brief writers, hire agencies, or manage campaigns. They selected their services. We built their knowledge base. They uploaded it to Cowork once. Claude has run the content cycle automatically every week since." );

// Header "Built with Claude" badge — centred under the subhead.
$built_with_id = (int) get_field( 'system_built_with_claude_badge' );

// Per-card Claude product badges. Top-level ACF fields, indexed 1–5
// by card position. Renders nothing when a slot is empty (no
// orphaned container).
$card_badges = array(
    1 => (int) get_field( 'system_card_01_badge' ),
    2 => (int) get_field( 'system_card_02_badge' ),
    3 => (int) get_field( 'system_card_03_badge' ),
    4 => (int) get_field( 'system_card_04_badge' ),
    5 => (int) get_field( 'system_card_05_badge' ),
);

$modules = get_field( 'service_what_you_get_modules' );
if ( empty( $modules ) ) {
    $modules = array(
        array(
            'icon_kind'        => 'menu',
            'icon'             => 0,
            'label'            => 'Step 01 — Onboarding',
            'title'            => "Most Clinics Spend Months Figuring Out Where to Start. You'll Know in Five Minutes.",
            'subtitle'         => 'Select your services. Everything builds around them.',
            'body'             => 'During onboarding you choose up to five services from a guided menu — travel vaccines, weight loss, aesthetics, dentistry, cosmetic surgery. One decision. Your knowledge base, content architecture, and ranking targets all build around that selection automatically.',
            'stat_value'       => '10+',
            'stat_descriptor'  => 'pre-built healthcare knowledge bases',
            'is_closer'        => 0,
        ),
        array(
            'icon_kind'        => 'library',
            'icon'             => 0,
            'label'            => 'Step 02 — Knowledge Base',
            'title'            => 'The Only Technical Step You Ever Take Is Uploading One Folder.',
            'subtitle'         => 'Everything inside already built. Already compliant. Already structured for AI.',
            'body'             => "We build your knowledge base from our pre-verified healthcare content library — clinically accurate and aligned with GPhC, GMC, GDC, and CQC standards. You download it. You drag it into Cowork. Claude handles everything from that point forward.",
            'stat_value'       => 'Verified',
            'stat_descriptor'  => 'Built to the standards of your regulatory body. GPhC, GMC, GDC, or CQC depending on your specialism.',
            'is_closer'        => 0,
        ),
        array(
            'icon_kind'        => 'cycle',
            'icon'             => 0,
            'label'            => 'Step 03 — The Skills',
            'title'            => 'You Review the Outputs. Claude Does Everything Else.',
            'subtitle'         => 'Connected to Google Search Console. Running every week.',
            'body'             => "The Skills find the questions your patients are typing into ChatGPT, Google AI, and Perplexity. They build the content. They feed what's working back into the next cycle. Every week. Automatically.",
            'stat_value'       => '6 wks',
            'stat_descriptor'  => 'Ealing beat Boots. Superior hit 50% of sales from AI search.',
            'is_closer'        => 0,
        ),
        array(
            'icon_kind'        => 'engagement',
            'icon'             => 0,
            'label'            => 'Step 04 — The Content',
            'title'            => 'An IVF Clinic Started Sending Referrals. A School Enquired About 200 Students. This Is Why.',
            'subtitle'         => 'Six minutes of engagement versus thirty seconds. AI notices the difference.',
            'body'             => 'Content built from your clinical expertise gets read for 6 minutes instead of 30 seconds. That dwell time is what Claude, ChatGPT, and Google AI read as authority. It is the difference between being ignored and being recommended.',
            'stat_value'       => '6m 40s',
            'stat_descriptor'  => 'Ealing Travel Clinic avg. session duration',
            'is_closer'        => 0,
        ),
        array(
            'icon_kind'        => 'dashboard',
            'icon'             => 0,
            'label'            => 'Step 05 — The Results',
            'title'            => 'Every Week the System Gets Smarter. Every Week the Gap Widens.',
            'subtitle'         => 'Live in Cowork. Watching every AI platform. Automatically.',
            'body'             => "Claude monitors Google AI Overviews, ChatGPT, Perplexity, and Claude itself every week. You see exactly where you appear, which competitors you've overtaken, and what the next cycle should target. Every cycle feeds the next one. The longer it runs, the harder you are to displace.",
            'stat_value'       => '50%',
            'stat_descriptor'  => "of Superior Pharmacy's sales now come through ChatGPT",
            'is_closer'        => 1,
        ),
    );
}
?>

<section class="svc-system" id="what-you-get">
    <div class="svc-system-inner">
        <header class="svc-system-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-system-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-system-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $subheadline ) : ?>
                <p class="svc-system-subheadline"><?php echo esc_html( $subheadline ); ?></p>
            <?php endif; ?>
            <?php if ( $built_with_id ) : ?>
                <div class="svc-system-built-with">
                    <?php echo wp_get_attachment_image( $built_with_id, 'medium', false, array(
                        'alt'     => 'Built with Claude',
                        'loading' => 'lazy',
                    ) ); ?>
                </div>
            <?php endif; ?>
        </header>

        <?php if ( ! empty( $modules ) ) : ?>
            <div class="svc-system-modules">
                <?php foreach ( $modules as $i => $module ) :
                    $label           = $module['label']           ?? '';
                    $title           = $module['title']           ?? '';
                    $subtitle        = $module['subtitle']        ?? '';
                    $body            = $module['body']            ?? '';
                    $stat_value      = $module['stat_value']      ?? '';
                    $stat_descriptor = $module['stat_descriptor'] ?? '';
                    $is_closer       = ! empty( $module['is_closer'] );
                    $card_pos        = $i + 1;
                    $badge_id        = $card_badges[ $card_pos ] ?? 0;
                    if ( ! $title && ! $body ) continue;
                    $card_class = 'svc-system-module' . ( $is_closer ? ' svc-system-module--closer' : '' );
                    ?>
                    <article class="<?php echo esc_attr( $card_class ); ?>">
                        <div class="svc-system-module-inner">
                            <?php if ( $badge_id ) : ?>
                                <div class="svc-system-module-badge">
                                    <?php echo wp_get_attachment_image( $badge_id, 'medium', false, array(
                                        'alt'     => esc_attr( $title ),
                                        'loading' => 'lazy',
                                    ) ); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ( $label ) : ?>
                                <span class="svc-system-module-label"><?php echo esc_html( $label ); ?></span>
                            <?php endif; ?>
                            <?php if ( $title ) : ?>
                                <h3 class="svc-system-module-title"><?php echo esc_html( $title ); ?></h3>
                            <?php endif; ?>
                            <?php if ( $subtitle ) : ?>
                                <p class="svc-system-module-subtitle"><?php echo esc_html( $subtitle ); ?></p>
                            <?php endif; ?>
                            <?php if ( $body ) : ?>
                                <p class="svc-system-module-body"><?php echo esc_html( $body ); ?></p>
                            <?php endif; ?>
                            <?php if ( $stat_value || $stat_descriptor ) : ?>
                                <div class="svc-system-module-stat">
                                    <?php if ( $stat_value ) : ?>
                                        <span class="svc-system-module-stat-value"><?php echo esc_html( $stat_value ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $stat_descriptor ) : ?>
                                        <span class="svc-system-module-stat-descriptor"><?php echo esc_html( $stat_descriptor ); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
