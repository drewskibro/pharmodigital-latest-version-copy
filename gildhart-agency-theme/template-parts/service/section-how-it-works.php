<?php
/**
 * Service: How It Works (Agent V2 layout) section.
 *
 * Dark navy gradient section with a centred header (gold eyebrow +
 * multi-line H2) and a vertical list of numbered steps below. Each
 * step = circle marker (gold mono digit, hover lifts + glows green)
 * connected by a vertical green-fade line down to the next, with a
 * content block on the right (label + title + body).
 *
 * Below the steps, a green-gradient timeline bar with two endpoint
 * labels (e.g. "Day 1" / "Day 7 — Go Live"). The fill animates from
 * 0 → 100% width once the bar scrolls into view.
 *
 * Reads from per-section ACF group `Service · How It Works`.
 * Returns early when the show toggle is off. Falls back to The Agent
 * 3-step deployment process when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_how_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_how_eyebrow',  'The Process' );
$headline = gh_field( 'service_how_headline', "One client received their first weight loss booking five minutes after going live. Here's how we get you there in seven days." );

$steps = get_field( 'service_how_steps' );
if ( empty( $steps ) ) {
    $steps = array(
        array(
            'label' => 'Train',
            'title' => 'Built Around Your Practice. Not A Template.',
            'text'  => "Your services. Your pricing. Your clinical protocols. Your tone. We build the agent around all of it — so it knows the difference between a Mounjaro consultation and a private prescription. It handles the questions your best member of staff handles. And the ones they don't know how to answer yet.\n\nNothing generic. Nothing off the shelf. Yours.",
        ),
        array(
            'label' => 'Test',
            'title' => '100,000 Patient Conversations. Before Yours.',
            'text'  => "Eighteen months. 100,000+ real patient conversations. Every edge case already handled. Every sensitive clinical question already answered. Every compliance boundary already mapped.\n\nBy the time it goes live on your site, nothing is new. Nothing is untested. Nothing is a guess.",
        ),
        array(
            'label' => 'Deploy',
            'title' => "Seven Days. Then It's Yours.",
            'text'  => "Southdowns took a commercial needle stick contract at midnight. Ealing booked HPV appointments before the clinic opened. Superior closed Mounjaro consultations on a Sunday afternoon.\n\nSeven days after you sign off, that's your practice. Your agent starts the moment it goes live. It doesn't stop.",
        ),
    );
}

$timeline_show  = gh_field( 'service_how_timeline_show',  1 );
$timeline_start = gh_field( 'service_how_timeline_start', 'Day 1' );
$timeline_end   = gh_field( 'service_how_timeline_end',   'Day 7 — Go Live' );

$total_steps = count( $steps );
?>

<section class="svc-how">
    <div class="svc-how-inner">
        <div class="svc-how-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-how-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-how-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $steps ) ) : ?>
            <div class="svc-how-steps">
                <?php foreach ( $steps as $i => $step ) :
                    $label   = $step['label'] ?? '';
                    $title   = $step['title'] ?? '';
                    $text    = $step['text']  ?? '';
                    $num     = sprintf( '%02d', $i + 1 );
                    $is_last = ( $i === $total_steps - 1 );
                    $classes = 'svc-how-step' . ( $is_last ? ' svc-how-step--last' : '' );
                    // Render text paragraphs split on blank lines so the
                    // long step bodies don't run together.
                    $paras = array_filter( array_map( 'trim', preg_split( '/\r\n\r\n|\r\r|\n\n/', $text ) ) );
                    ?>
                    <div class="<?php echo esc_attr( $classes ); ?>">
                        <div class="svc-how-step-marker">
                            <span class="svc-how-step-num"><?php echo esc_html( $num ); ?></span>
                            <?php if ( ! $is_last ) : ?>
                                <span class="svc-how-step-line" aria-hidden="true"></span>
                            <?php endif; ?>
                        </div>
                        <div class="svc-how-step-content">
                            <?php if ( $label ) : ?>
                                <p class="svc-how-step-label"><?php echo esc_html( $label ); ?></p>
                            <?php endif; ?>
                            <?php if ( $title ) : ?>
                                <h3 class="svc-how-step-title"><?php echo esc_html( $title ); ?></h3>
                            <?php endif; ?>
                            <?php if ( ! empty( $paras ) ) : ?>
                                <div class="svc-how-step-text">
                                    <?php foreach ( $paras as $para ) : ?>
                                        <p><?php echo esc_html( $para ); ?></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $timeline_show && ( $timeline_start || $timeline_end ) ) : ?>
            <div class="svc-how-timeline">
                <div class="svc-how-timeline-track">
                    <div class="svc-how-timeline-fill"></div>
                </div>
                <div class="svc-how-timeline-labels">
                    <span><?php echo esc_html( $timeline_start ); ?></span>
                    <span><?php echo esc_html( $timeline_end ); ?></span>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
