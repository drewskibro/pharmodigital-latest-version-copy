<?php
/**
 * Service: The System section (Playbook — formerly "What You Get").
 *
 * Dark navy section that walks through the five-step Playbook system
 * the customer runs themselves: onboarding → knowledge base → skills
 * → content → results. Five cards in a 2+2+1 grid (last card spans
 * full-width as the closing proof beat).
 *
 * Each card carries:
 *   - 60×60 icon panel at the top (ACF image upload OR a styled
 *     brand-aligned SVG fallback per icon_kind)
 *   - Small gold caps step label
 *   - Bold white title
 *   - Italic muted-cream subtitle
 *   - Body copy
 *   - Gold-anchored stat line at the bottom
 *
 * The closer (card 05) gets a richer navy background + subtle gold
 * radial halo so it lands as the section's destination, not just
 * another card in the grid.
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

$modules = get_field( 'service_what_you_get_modules' );
if ( empty( $modules ) ) {
    $modules = array(
        array(
            'icon_kind'        => 'menu',
            'icon'             => 0,
            'label'            => 'Step 01 — Onboarding',
            'title'            => "Most Clinics Spend Months Figuring Out Where to Start. You'll Know in Five Minutes.",
            'subtitle'         => 'Select your services. Everything builds around them.',
            'body'             => 'During onboarding you choose up to five services from a guided menu — travel vaccines, weight loss, aesthetics, dentistry, cosmetic surgery. The moment you select them, your knowledge base is built around them, your content architecture is built around them, your ranking targets are built around them. One decision. The entire system follows.',
            'stat_value'       => '10+',
            'stat_descriptor'  => 'pre-built healthcare knowledge bases',
            'is_closer'        => 0,
        ),
        array(
            'icon_kind'        => 'library',
            'icon'             => 0,
            'label'            => 'Step 02 — Knowledge Base',
            'title'            => 'The Only Technical Step You Ever Take Is Uploading One Folder.',
            'subtitle'         => 'Everything inside it already built. Already compliant. Already structured for AI.',
            'body'             => 'We build your knowledge base from our pre-verified healthcare content library — clinically accurate, structured for AI citation, and aligned with GPhC, GMC, GDC, and CQC standards depending on your specialism. You download it. You drag it into Cowork. That\'s it. Claude handles everything from that point forward.',
            'stat_value'       => 'GPhC · GMC · GDC · CQC · MHRA',
            'stat_descriptor'  => '',
            'is_closer'        => 0,
        ),
        array(
            'icon_kind'        => 'cycle',
            'icon'             => 0,
            'label'            => 'Step 03 — The Skills',
            'title'            => 'You Review the Outputs. Claude Does Everything Else.',
            'subtitle'         => 'Connected to your Google Search Console. Running every week.',
            'body'             => 'The Skills find the questions your patients are already typing into ChatGPT, Google AI, and Perplexity. They build the content that answers those questions. They feed what\'s working back into the next cycle. Every week. Automatically. The only thing the system asks of you is ten minutes to review what Claude produced.',
            'stat_value'       => '6 wks',
            'stat_descriptor'  => 'Ealing beat Boots. Superior hit 50% of sales from AI search.',
            'is_closer'        => 0,
        ),
        array(
            'icon_kind'        => 'engagement',
            'icon'             => 0,
            'label'            => 'Step 04 — The Content',
            'title'            => 'An IVF Clinic Read One Article and Started Sending Referrals.',
            'subtitle'         => "That's what six minutes of engagement looks like in practice.",
            'body'             => "Generic content gets thirty seconds. Content built from your clinical expertise — in your voice, about your services, answering the exact questions your patients are asking — gets six minutes. That dwell time is what Claude, ChatGPT, and Google AI read as authority. It's the difference between existing online and being recommended by AI to every patient who searches.",
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
            'body'             => 'Claude monitors Google AI Overviews, ChatGPT, Perplexity, and Claude itself every week. You see exactly where you appear, which competitors you\'ve overtaken, and what the next content cycle should target. Every cycle feeds the next one. The longer it runs, the harder you are to displace.',
            'stat_value'       => '48hrs',
            'stat_descriptor'  => "Superior's first booking from AI search after going live",
            'is_closer'        => 1,
        ),
    );
}

/**
 * Minimal SVG glyph keyed by icon kind. Brand-aligned (uses
 * currentColor so the wrapper's text colour drives the stroke), and
 * intentionally abstract so they read as platform / system markers
 * rather than literal product logos. Overridden by an ACF image
 * upload when one is set on the row.
 */
$icon_svg = function( $kind ) {
    $icons = array(
        'menu'       => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><line x1="10" y1="14" x2="38" y2="14" stroke-linecap="round"/><line x1="10" y1="24" x2="38" y2="24" stroke-linecap="round"/><line x1="10" y1="34" x2="30" y2="34" stroke-linecap="round"/><circle cx="38" cy="34" r="3" fill="currentColor" stroke="none"/></svg>',
        'library'    => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="8" y="10" width="32" height="28" rx="2"/><line x1="8" y1="18" x2="40" y2="18"/><line x1="14" y1="24" x2="34" y2="24" stroke-linecap="round"/><line x1="14" y1="30" x2="28" y2="30" stroke-linecap="round"/></svg>',
        'cycle'      => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M38 24a14 14 0 1 1-4.1-9.9" stroke-linecap="round"/><polyline points="38,8 38,16 30,16" stroke-linecap="round" stroke-linejoin="round"/><circle cx="24" cy="24" r="3" fill="currentColor" stroke="none"/></svg>',
        'engagement' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><line x1="10" y1="12" x2="38" y2="12" stroke-linecap="round"/><line x1="10" y1="20" x2="38" y2="20" stroke-linecap="round"/><line x1="10" y1="28" x2="32" y2="28" stroke-linecap="round"/><line x1="10" y1="36" x2="24" y2="36" stroke-linecap="round"/><circle cx="36" cy="36" r="4" fill="currentColor" stroke="none"/></svg>',
        'dashboard'  => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="6" y="8" width="36" height="32" rx="2"/><polyline points="12,28 18,22 24,26 32,16 38,20" stroke-linecap="round" stroke-linejoin="round"/><circle cx="38" cy="20" r="2.5" fill="currentColor" stroke="none"/></svg>',
    );
    return $icons[ $kind ] ?? $icons['menu'];
};
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
        </header>

        <?php if ( ! empty( $modules ) ) : ?>
            <div class="svc-system-modules">
                <?php foreach ( $modules as $module ) :
                    $kind            = $module['icon_kind']       ?? 'menu';
                    $icon_id         = (int) ( $module['icon']    ?? 0 );
                    $label           = $module['label']           ?? '';
                    $title           = $module['title']           ?? '';
                    $subtitle        = $module['subtitle']        ?? '';
                    $body            = $module['body']            ?? '';
                    $stat_value      = $module['stat_value']      ?? '';
                    $stat_descriptor = $module['stat_descriptor'] ?? '';
                    $is_closer       = ! empty( $module['is_closer'] );
                    if ( ! $title && ! $body ) continue;
                    $card_class = 'svc-system-module' . ( $is_closer ? ' svc-system-module--closer' : '' );
                    ?>
                    <article class="<?php echo esc_attr( $card_class ); ?>">
                        <div class="svc-system-module-inner">
                            <div class="svc-system-module-icon svc-system-module-icon--<?php echo esc_attr( $kind ); ?>">
                                <?php if ( $icon_id ) : ?>
                                    <?php echo wp_get_attachment_image( $icon_id, 'medium', false, array(
                                        'alt'     => esc_attr( $title ),
                                        'loading' => 'lazy',
                                    ) ); ?>
                                <?php else : ?>
                                    <?php echo $icon_svg( $kind ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — static SVG ?>
                                <?php endif; ?>
                            </div>
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
