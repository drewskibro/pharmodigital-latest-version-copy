<?php
/**
 * Service: Method section.
 *
 * Dark navy two-column section. Left column is a sticky anchor with
 * eyebrow + headline + proof-line + a 3-block timeline (Wk 1-2 / 3-4 /
 * 5-6). Right column is the four-step build process — numbered
 * circles connected by a gold-progressed thread.
 *
 * Steps reveal on scroll via svcReveal('.svc-method-step', 'is-visible').
 * The first step is active by default; service.js syncs the active state
 * (and the timeline block to its left) as steps scroll into view.
 *
 * Reads from per-section ACF group `Service · Method`. Returns early
 * when the show toggle is off. Falls back to The Playbook copy from
 * the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_method_show', 1 ) ) {
    return;
}

$eyebrow        = gh_field( 'service_method_eyebrow',        'The Method' );
$headline       = gh_field( 'service_method_headline',       'How We Get You Featured in ChatGPT, Claude & Google AI Overviews' );
$proof_line     = gh_field( 'service_method_proof_line',     'Four steps. <strong>Six weeks to first rankings.</strong> The exact system that put Ealing Travel Clinic and Superior Pharmacy on the AI shortlist — ahead of Boots and Bupa.' );
$timeline_label = gh_field( 'service_method_timeline_label', 'Typical client timeline' );

$weeks = get_field( 'service_method_weeks' );
if ( empty( $weeks ) ) {
    $weeks = array(
        array( 'range' => 'Wk 1–2', 'summary' => 'Discovery & Architecture' ),
        array( 'range' => 'Wk 3–4', 'summary' => 'Content Build' ),
        array( 'range' => 'Wk 5–6', 'summary' => 'First AI Rankings ✓' ),
    );
}

$steps = get_field( 'service_method_steps' );
if ( empty( $steps ) ) {
    $steps = array(
        array(
            'week_label' => 'Week 1–2',
            'title'      => 'Discovery & Content Architecture',
            'text'       => 'We interrogate every AI platform — ChatGPT, Claude, Perplexity, Google AI — to find the exact questions your patients are asking. Then we map a pillar + cluster architecture that owns the answer space, not just isolated keywords.',
            'proof_pill' => '',
            'week_block' => 0,
        ),
        array(
            'week_label' => 'Week 2–4',
            'title'      => 'Interactive Content That AI Trusts',
            'text'       => 'Generic blog posts average 30 seconds on-page. Our quizzes, comparison tools, and symptom calculators average 5+ minutes. AI platforms read engagement signals — high dwell time signals authority and earns features.',
            'proof_pill' => 'Ealing Travel Clinic: avg. 6m 40s session duration',
            'week_block' => 1,
        ),
        array(
            'week_label' => 'Week 3–5',
            'title'      => 'AI-Specific Technical Optimisation',
            'text'       => 'We structure content for how LLMs actually parse pages — entity relationships, citation density, schema markup, and the specific formatting patterns that Claude, ChatGPT, and Google AI Overviews favour when building their answers.',
            'proof_pill' => '',
            'week_block' => 1,
        ),
        array(
            'week_label' => 'Week 5–6',
            'title'      => 'Rapid Indexing & Live Tracking',
            'text'       => 'Custom indexing techniques get content crawled weeks faster than standard publishing. Then we monitor every AI platform daily — you see the exact moment you appear in recommendations, and we iterate in real time.',
            'proof_pill' => 'Superior Pharmacy: in ChatGPT results within 4 weeks',
            'week_block' => 2,
        ),
    );
}
?>

<section class="svc-method" id="method">
    <div class="svc-method-layout">
        <div class="svc-method-anchor">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-method-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-method-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $proof_line ) : ?>
                <p class="svc-method-proof-line"><?php echo wp_kses_post( $proof_line ); ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $weeks ) ) : ?>
                <?php if ( $timeline_label ) : ?>
                    <p class="svc-method-timeline-label"><?php echo esc_html( $timeline_label ); ?></p>
                <?php endif; ?>
                <div class="svc-method-weeks">
                    <?php foreach ( $weeks as $i => $week ) :
                        $range   = $week['range']   ?? '';
                        $summary = $week['summary'] ?? '';
                        if ( ! $range && ! $summary ) continue;
                        $active  = ( 0 === $i ) ? ' is-active' : ''; ?>
                        <button class="svc-method-week<?php echo esc_attr( $active ); ?>" type="button" data-week="<?php echo esc_attr( $i ); ?>">
                            <?php if ( $range ) : ?>
                                <span class="svc-method-week-num"><?php echo esc_html( $range ); ?></span>
                            <?php endif; ?>
                            <?php if ( $summary ) : ?>
                                <span class="svc-method-week-label"><?php echo esc_html( $summary ); ?></span>
                            <?php endif; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="svc-method-steps">
            <?php foreach ( $steps as $i => $step ) :
                $week_label = $step['week_label'] ?? '';
                $title      = $step['title']      ?? '';
                $text       = $step['text']       ?? '';
                $proof_pill = $step['proof_pill'] ?? '';
                $week_block = $step['week_block'] ?? 0;
                $active     = ( 0 === $i ) ? ' is-active' : '';
                $num        = sprintf( '%02d', $i + 1 );
                ?>
                <div class="svc-method-step<?php echo esc_attr( $active ); ?>" data-step="<?php echo esc_attr( $i ); ?>" data-week-block="<?php echo esc_attr( $week_block ); ?>">
                    <div class="svc-method-step-node">
                        <div class="svc-method-step-circle">
                            <span class="svc-method-step-num"><?php echo esc_html( $num ); ?></span>
                        </div>
                    </div>
                    <div class="svc-method-step-body">
                        <?php if ( $week_label ) : ?>
                            <p class="svc-method-step-week"><?php echo esc_html( $week_label ); ?></p>
                        <?php endif; ?>
                        <?php if ( $title ) : ?>
                            <h3 class="svc-method-step-title"><?php echo esc_html( $title ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $text ) : ?>
                            <p class="svc-method-step-text"><?php echo esc_html( $text ); ?></p>
                        <?php endif; ?>
                        <?php if ( $proof_pill ) : ?>
                            <span class="svc-method-step-proof"><?php echo esc_html( $proof_pill ); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
