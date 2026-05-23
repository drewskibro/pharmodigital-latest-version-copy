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
$headline    = gh_field( 'service_next_headline',    'What Happens Next' );
$subheadline = gh_field( 'service_next_subheadline', 'From purchase to AI rankings — exactly as it happened for Ealing and Superior.' );

$steps = get_field( 'service_next_steps' );
if ( empty( $steps ) ) {
    $steps = array(
        array( 'label' => 'Today',      'title' => 'Get instant access',                 'text' => 'Watch Module 1. Set up your Claude Project. Takes 20 minutes.',                                                                  'is_final' => 0 ),
        array( 'label' => 'This Week',  'title' => 'Complete the system',                'text' => 'Work through all 5 modules. Total runtime: 2 hours. You now know the full system.',                                              'is_final' => 0 ),
        array( 'label' => 'Next Week',  'title' => 'Create your first content',          'text' => 'One pillar page. Four clusters. Five pieces total. One hour of your time using the prompts I give you.',                       'is_final' => 0 ),
        array( 'label' => 'Weeks 2–6',  'title' => 'Publish and submit',                 'text' => 'Content goes live. Submit to AI platforms using the indexing technique. Rankings start appearing.',                            'is_final' => 0 ),
        array( 'label' => 'Weeks 6–12', 'title' => 'AI features appear',                 'text' => 'Featured in ChatGPT. Google AI Overviews. Claude. Traffic climbing. New patients booking. Ealing: 6 weeks. Superior: 48 hours for first sale.', 'is_final' => 0 ),
        array( 'label' => 'Day 90',     'title' => 'Ranked. Traffic compounding. Revenue growing.', 'text' => 'Your target service is featured in AI search. New patients finding you. The system runs on 1 hour per week. Everything compounds from here.', 'is_final' => 1 ),
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
