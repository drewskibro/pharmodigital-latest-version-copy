<?php
/**
 * Service: Problem Shift section + teal CTA strip.
 *
 * Dark navy section that pivots from the hero claim to the underlying
 * shift in healthcare search. Carries five paired rows: gold-stat win
 * on the left, red-x consequence on the right, separated by a pulsing
 * gold arrow. A teal strip with a short rallying line and CTA closes
 * the section flush below.
 *
 * Reads from per-section ACF group `Service · Problem Shift`. Returns
 * early when the show toggle is off. Falls back to The Playbook copy
 * from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_problem_shift_show', 1 ) ) {
    return;
}

$label    = gh_field( 'service_problem_shift_label',    'The Shift' );
$headline = gh_field( 'service_problem_shift_headline', "In Two Years, The Practices On ChatGPT's Shortlist Will Own Your Market." );
$intro    = gh_field( 'service_problem_shift_intro',    "That shortlist is being built right now. Every week a practice claims a spot. Every week it gets harder to displace them. And the patients those practices are capturing — Semrush confirmed it across hundreds of sites — convert 4.4 times better than Google organic visitors. Not because of the platform. Because by the time they click a name on ChatGPT's recommendation, the decision is already made." );

$pairs = get_field( 'service_problem_shift_pairs' );
if ( empty( $pairs ) ) {
    $pairs = array(
        array( 'number' => '4.4x',    'stat_text' => "ChatGPT visitor conversion rate vs Google organic. They've already chosen before they arrive.", 'lose_text' => 'Still invisible on ChatGPT, Perplexity, Google AI Overviews' ),
        array( 'number' => '6 weeks', 'stat_text' => 'Ealing Travel Clinic in Google AI Overviews. Ahead of Boots.',                                      'lose_text' => 'Losing patients to independents half their size' ),
        array( 'number' => '£500k',   'stat_text' => 'Superior Pharmacy this year. Two-person team. No ad spend.',                                        'lose_text' => 'Paying for Google rankings that are disappearing' ),
        array( 'number' => '£100k',   'stat_text' => 'Sachin at Ealing — HPV vaccinations alone this year.',                                              'lose_text' => "No presence on the channel that's replacing them" ),
        array( 'number' => '82,000',  'stat_text' => 'Monthly visitors to Miles Clinic. Google + AI search. Zero ad spend.',                              'lose_text' => 'Google traffic dropping 25% by 2026 — Gartner' ),
    );
}

$strip_show     = gh_field( 'service_problem_shift_strip_show', 1 );
$strip_text     = gh_field( 'service_problem_shift_strip_text', 'First time in 20 years independent practices can outrank national chains. Not in 5 years. In weeks.' );
$strip_cta_lbl  = gh_field( 'service_problem_shift_strip_cta_label', 'Get The System' );
$strip_cta_url  = gh_field( 'service_problem_shift_strip_cta_url',   '#buy-now' );
?>

<section class="svc-problem-shift-wrap">
    <div class="svc-problem-shift">
        <div class="svc-ps-inner">
            <?php if ( $label ) : ?>
                <p class="svc-ps-label"><?php echo esc_html( $label ); ?></p>
            <?php endif; ?>

            <?php if ( $headline ) : ?>
                <h2 class="svc-ps-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>

            <?php if ( $intro ) : ?>
                <p class="svc-ps-intro"><?php echo esc_html( $intro ); ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $pairs ) ) : ?>
                <div class="svc-ps-rows">
                    <?php foreach ( $pairs as $pair ) :
                        $num  = $pair['number']    ?? '';
                        $stat = $pair['stat_text'] ?? '';
                        $lose = $pair['lose_text'] ?? '';
                        if ( ! $num && ! $stat && ! $lose ) continue; ?>
                        <div class="svc-ps-row">
                            <div class="svc-ps-win">
                                <?php if ( $num ) : ?>
                                    <div class="svc-ps-stat-num"><?php echo esc_html( $num ); ?></div>
                                <?php endif; ?>
                                <?php if ( $stat ) : ?>
                                    <p class="svc-ps-stat-text"><?php echo esc_html( $stat ); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="svc-ps-vs"><span class="svc-ps-vs-label" aria-hidden="true">→</span></div>
                            <div class="svc-ps-lose">
                                <span class="svc-ps-lose-icon" aria-hidden="true">✗</span>
                                <?php if ( $lose ) : ?>
                                    <p class="svc-ps-lose-text"><?php echo esc_html( $lose ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ( $strip_show && ( $strip_text || $strip_cta_lbl ) ) : ?>
        <div class="svc-teal-strip">
            <?php if ( $strip_text ) : ?>
                <p class="svc-teal-strip-text"><?php echo esc_html( $strip_text ); ?></p>
            <?php endif; ?>
            <?php if ( $strip_cta_lbl ) : ?>
                <a href="<?php echo esc_url( $strip_cta_url ); ?>" class="svc-teal-strip-btn">
                    <?php echo esc_html( $strip_cta_lbl ); ?>
                    <span class="svc-btn-arrow" aria-hidden="true">→</span>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
