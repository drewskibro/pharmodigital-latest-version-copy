<?php
/**
 * Service: Next Steps section.
 *
 * Cream-warm vertical timeline of 6 steps from purchase to ranked.
 * A green-to-fade vertical line runs behind the numbered circles
 * (left column); each step's body sits in a white card with a
 * green left border. The final step swaps to a navy card with
 * gold accents to feel like the destination.
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
$subheadline = gh_field( 'service_next_subheadline', 'No guesswork. No waiting to find out what happens next. This is the exact sequence — day by day, week by week.' );

$steps = get_field( 'service_next_steps' );
if ( empty( $steps ) ) {
    $steps = array(
        array( 'label' => 'Today',      'title' => "You're Inside. The System is Ready.",                  'text' => 'Your knowledge base is built around your five services. Your Claude Skills are configured. Everything is waiting for you in Cowork. From download to first run: 20 minutes.', 'is_final' => 0 ),
        array( 'label' => 'This Week',  'title' => 'You Upload Once. Claude Takes Over.',                  'text' => 'Drag your knowledge base into Cowork. Run the first Skill. Claude interrogates your services against what patients in your area are already searching for — and maps the exact content architecture that puts you on the AI shortlist.', 'is_final' => 0 ),
        array( 'label' => 'Next Week',  'title' => 'Your First Content Goes Live.',                        'text' => 'One pillar page. Four cluster pages. Five pieces of clinically accurate, AI-optimised content — written by Claude from your knowledge base, in your voice, about your services. You review it. You publish it. One hour of your time.', 'is_final' => 0 ),
        array( 'label' => 'Weeks 2–6',  'title' => 'Content Live. Indexing Started. Rankings Appearing.',  'text' => "Every piece of content is submitted to Google, ChatGPT, Claude, and Perplexity using the indexing system. You don't wait months to get crawled. Ealing appeared in Google AI Overviews within 6 weeks. Superior had their first booking from ChatGPT within 48 hours of going live.", 'is_final' => 0 ),
        array( 'label' => 'Weeks 6–12', 'title' => "You're on the Shortlist.",                             'text' => "Your practice is appearing in AI recommendations. New patients are finding you, reading your content, and deciding you're the specialist before they've even made contact. The system runs automatically every week. You spend one hour reviewing what Claude produced.", 'is_final' => 0 ),
        array( 'label' => 'Day 90',     'title' => 'Ranked. Compounding. Impossible to Displace.',         'text' => "Your target services are featured across Google AI, ChatGPT, Perplexity, and Claude. Every week the system gets smarter. Every week the gap between you and every competitor who isn't doing this gets wider. This is what Ealing, Superior, and Puri look like right now. This is where you're going.", 'is_final' => 1 ),
    );
}
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
                    $label    = $step['label']    ?? '';
                    $title    = $step['title']    ?? '';
                    $text     = $step['text']     ?? '';
                    $is_final = ! empty( $step['is_final'] );
                    $classes  = 'svc-next-step' . ( $is_final ? ' svc-next-step--final' : '' );
                    ?>
                    <div class="<?php echo esc_attr( $classes ); ?>">
                        <div class="svc-next-step-node">
                            <div class="svc-next-step-circle">
                                <span class="svc-next-step-num"><?php echo esc_html( $i + 1 ); ?></span>
                            </div>
                        </div>
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
    </div>
</section>
