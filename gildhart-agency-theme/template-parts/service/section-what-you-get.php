<?php
/**
 * Service: What You Get section.
 *
 * Cream-warm section that itemises the system's modules. 2-column grid
 * of module cards; if there's an odd count the last card centres in
 * its own row via the `:last-child` grid override in service.css.
 *
 * Each card carries a numbered badge, a coloured icon, title, hook
 * line, body, and a green proof-stat callout. Icon "kind" picks the
 * SVG + tonal background — engine / pillar / interactive / visuals /
 * indexed (rotates if more cards than kinds).
 *
 * Reads from per-section ACF group `Service · What You Get`. Returns
 * early when the show toggle is off. Falls back to The Playbook copy
 * from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_what_you_get_show', 1 ) ) {
    return;
}

$eyebrow     = gh_field( 'service_what_you_get_eyebrow',     'The System' );
$headline    = gh_field( 'service_what_you_get_headline',    'What Ealing, Superior, and Puri Actually Used. Now Yours.' );
$subheadline = gh_field( 'service_what_you_get_subheadline', 'The same system. Used across three practices. Now generating five figures monthly, £500k annual revenue, and £100k from a single service. Fully automated. Yours today.' );

$modules = get_field( 'service_what_you_get_modules' );
if ( empty( $modules ) ) {
    $modules = array(
        array( 'icon_kind' => 'engine',      'title' => 'Your AI Content Engine',                'hook' => 'Set up in 20 minutes. Runs while you see patients.',          'body' => 'Produces content that gets you featured on Google AI Overviews, ChatGPT, Claude, and Perplexity — without hiring a writer, briefing an agency, or paying a monthly retainer.', 'proof_stat' => '£0/mo', 'proof_text' => 'Replaces agency content retainers entirely' ),
        array( 'icon_kind' => 'pillar',      'title' => 'The Pillar Domination Method',          'hook' => 'Own every topic you serve. Every pillar compounds.',          'body' => 'A repeatable content architecture that dominates across ChatGPT, Claude, Google AI Overviews, and Perplexity simultaneously. Deploy once. Replicate for every service.',          'proof_stat' => '6 wks',  'proof_text' => 'Ealing beat Boots. Superior hit 50% of sales from AI search.' ),
        array( 'icon_kind' => 'interactive', 'title' => 'Interactive Content That AI Trusts',    'hook' => '5+ minute engagement vs 30 seconds. AI notices the difference.', 'body' => 'Quizzes, calculators, and comparison tools that AI platforms read as trust signals. Longer engagement means higher recommendations — the difference between being on the shortlist and invisible.', 'proof_stat' => '6m 40s', 'proof_text' => 'Ealing Travel Clinic avg. session duration' ),
        array( 'icon_kind' => 'visuals',     'title' => 'Professional Visuals Without The Bill', 'hook' => 'What agencies charge thousands for, built into the system.',  'body' => 'Clinically credible medical imagery and custom infographics in minutes, on demand. Low quality imagery signals low quality content to AI platforms — this eliminates that problem.', 'proof_stat' => '£0',     'proof_text' => 'Replaces £2k/shoot photography + £500/graphic design' ),
        array( 'icon_kind' => 'indexed',     'title' => 'Indexed In Days, Not Months',           'hook' => "If AI hasn't crawled it, it doesn't exist. This fixes that.",  'body' => 'Gets every piece of content in front of Google, ChatGPT, and Claude in days rather than weeks. The reason every practice using this system sees results faster than any traditional SEO timeline.', 'proof_stat' => '48 hrs', 'proof_text' => "Superior's first AI-driven sale after going live" ),
    );
}

/**
 * Inline icon SVG keyed by kind. Returns markup that's safe to print
 * inside .svc-system-module-icon — the wrapper applies the tonal bg
 * via the matching --{kind} CSS class.
 */
$icon_svg = function( $kind ) {
    $icons = array(
        'engine'      => '<svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
        'pillar'      => '<svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>',
        'interactive' => '<svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
        'visuals'     => '<svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
        'indexed'     => '<svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>',
    );
    return $icons[ $kind ] ?? $icons['engine'];
};
?>

<section class="svc-system" id="what-you-get">
    <div class="svc-system-inner">
        <div class="svc-system-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-system-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-system-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $subheadline ) : ?>
                <p class="svc-system-subheadline"><?php echo esc_html( $subheadline ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $modules ) ) : ?>
            <div class="svc-system-modules">
                <?php foreach ( $modules as $i => $module ) :
                    $kind        = $module['icon_kind']  ?? 'engine';
                    $title       = $module['title']      ?? '';
                    $hook        = $module['hook']       ?? '';
                    $body        = $module['body']       ?? '';
                    $proof_stat  = $module['proof_stat'] ?? '';
                    $proof_text  = $module['proof_text'] ?? '';
                    $num         = sprintf( '%02d', $i + 1 );
                    if ( ! $title && ! $hook && ! $body ) continue;
                    ?>
                    <article class="svc-system-module">
                        <div class="svc-system-module-top">
                            <div class="svc-system-module-num"><?php echo esc_html( $num ); ?></div>
                            <div class="svc-system-module-icon svc-system-module-icon--<?php echo esc_attr( $kind ); ?>">
                                <?php echo $icon_svg( $kind ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — static SVG ?>
                            </div>
                        </div>
                        <div class="svc-system-module-content">
                            <?php if ( $title ) : ?>
                                <h3 class="svc-system-module-title"><?php echo esc_html( $title ); ?></h3>
                            <?php endif; ?>
                            <?php if ( $hook ) : ?>
                                <p class="svc-system-module-hook"><?php echo esc_html( $hook ); ?></p>
                            <?php endif; ?>
                            <?php if ( $body ) : ?>
                                <p class="svc-system-module-body"><?php echo esc_html( $body ); ?></p>
                            <?php endif; ?>
                            <?php if ( $proof_stat || $proof_text ) : ?>
                                <div class="svc-system-module-proof">
                                    <?php if ( $proof_stat ) : ?>
                                        <span class="svc-system-module-proof-stat"><?php echo esc_html( $proof_stat ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $proof_text ) : ?>
                                        <span class="svc-system-module-proof-text"><?php echo esc_html( $proof_text ); ?></span>
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
