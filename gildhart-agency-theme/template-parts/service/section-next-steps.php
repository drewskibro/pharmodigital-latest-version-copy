<?php
/**
 * Service: Next Steps section.
 *
 * Cream-warm vertical timeline answering "what happens after I buy?"
 * — a compact, cardless sequence of milestone steps. Each step is a
 * small gold node on a thin vertical line beside a date label, tight
 * title, and one short line of copy.
 *
 * The visual weight tapers step to step, driven by the inline --i
 * (step index) / --n (total) custom properties: the first step reads
 * urgent (larger title, solid node), the last reads calm and
 * inevitable (smaller, softer). No card, no numbered circles, no
 * "arrival" treatment — the de-escalation IS the arrival.
 *
 * Reads from per-section ACF group `Service · Next Steps`. Returns
 * early when the show toggle is off. Falls back to The Playbook
 * timeline from the static spec when ACF fields are empty. Steps
 * activate on scroll via svcReveal.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_next_show', 1 ) ) {
    return;
}

$eyebrow     = gh_field( 'service_next_eyebrow',     'Your Timeline' );
$headline    = gh_field( 'service_next_headline',    'From Purchase to AI Rankings. Exactly as it Happened for Ealing and Superior.' );
$subheadline = gh_field( 'service_next_subheadline', 'No guesswork. No waiting. This is the exact sequence.' );

// Closing CTA — converts the timeline's momentum into the buy step.
$cta_label = gh_field( 'service_next_cta_label', 'Get The Playbook — £1,995' );
$cta_url   = gh_field( 'service_next_cta_url',   '#your-turn' );

$steps = get_field( 'service_next_steps' );
if ( empty( $steps ) ) {
    $steps = array(
        array( 'label' => 'Today',     'title' => 'We Set It Up Together.',                       'text' => 'Your private AI workspace is configured around your practice — your services, your pricing, your clinical protocols loaded in before you run a single session. You leave the setup call knowing exactly how to run it every week.' ),
        array( 'label' => 'This Week', 'title' => 'Your First Content Is Built.',                  'text' => "Claude works through your first service — clinically accurate, structured for AI citation, written in your voice. Not generic health content: your Mounjaro clinic, your travel vaccines, your HPV service. You review it. You publish it." ),
        array( 'label' => 'Weeks 2–6', 'title' => 'Rankings Appearing.',                          'text' => 'Ealing appeared in Google AI Overviews within 6 weeks. Superior had their first ChatGPT booking within 48 hours of going live. The indexing system cuts the window — results in weeks, not months.' ),
        array( 'label' => 'Day 90',    'title' => 'Ranked. Compounding. Impossible to Displace.', 'text' => "Every week the system gets stronger. Every week the gap between you and every competitor who isn't doing this gets wider. This is what Ealing, Superior, and Puri look like right now. This is where you're going." ),
    );
}
$step_total = count( $steps );
?>

<section class="svc-next">
    <div class="svc-next-inner">
        <div class="svc-next-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-next-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-next-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $subheadline ) : ?>
                <p class="svc-next-subheadline"><?php echo esc_html( $subheadline ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $steps ) ) : ?>
            <div class="svc-next-timeline">
                <?php foreach ( $steps as $i => $step ) :
                    $label = $step['label'] ?? '';
                    $title = $step['title'] ?? '';
                    $text  = $step['text']  ?? '';
                    // --i drives the step-to-step taper (title size, node,
                    // colour): step 0 reads urgent, the last reads calm and
                    // inevitable. --n is the total for count-relative maths.
                    ?>
                    <div class="svc-next-step" style="--i: <?php echo (int) $i; ?>; --n: <?php echo (int) $step_total; ?>;">
                        <div class="svc-next-step-node" aria-hidden="true"></div>
                        <div class="svc-next-step-body">
                            <?php if ( $label ) : ?>
                                <p class="svc-next-step-label"><?php echo esc_html( $label ); ?></p>
                            <?php endif; ?>
                            <?php if ( $title ) : ?>
                                <p class="svc-next-step-title"><?php echo esc_html( $title ); ?></p>
                            <?php endif; ?>
                            <?php if ( $text ) : ?>
                                <p class="svc-next-step-text"><?php echo esc_html( $text ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $cta_label ) : ?>
            <div class="svc-next-cta">
                <a href="<?php echo esc_url( $cta_url ); ?>" class="svc-next-cta-btn">
                    <?php echo esc_html( $cta_label ); ?>
                    <span class="svc-next-cta-arrow" aria-hidden="true">→</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
