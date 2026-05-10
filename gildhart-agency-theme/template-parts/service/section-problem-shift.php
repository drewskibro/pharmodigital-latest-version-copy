<?php
/**
 * Service: Problem Shift section + teal CTA strip.
 *
 * Dark navy section that pivots from the hero claim to the underlying
 * shift in healthcare search. Below the headline + intro sits a
 * stacked dashboard of stat cards — each row a 3-col grid:
 *
 *   ┌──────────────────────┬───────┬───────────────────────────────┐
 *   │ Stat (gold ~48-64px) │  →    │ ✗  Pain statement (white bold)│
 *   │ Subtext (white 0.85) │ gold  │                               │
 *   │ Source (gold italic) │       │                               │
 *   └──────────────────────┴───────┴───────────────────────────────┘
 *
 * Cards stack flush with a 1px gold-tinted hairline between rows so
 * the dashboard reads as one continuous data block. Each row carries
 * a gold left accent that intensifies to 100% opacity on hover; the
 * card's background also lightens a fraction. Below the dashboard a
 * teal CTA strip closes the section.
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
        array(
            'number'      => '4.4x',
            'stat_text'   => "ChatGPT visitors convert 4.4 times better than Google organic. They've already chosen before they arrive.",
            'source_text' => 'Source: Semrush, across hundreds of healthcare sites.',
            'lose_text'   => "You're optimising for the channel with the lower converting traffic.",
        ),
        array(
            'number'      => '6 weeks',
            'stat_text'   => 'Ealing Travel Clinic in Google AI Overviews. Ahead of Boots. Ahead of Superdrug.',
            'source_text' => '',
            'lose_text'   => 'A clinic half your size ranked above you this morning.',
        ),
        array(
            'number'      => '82,000',
            'stat_text'   => 'Monthly visitors to Miles Clinic. Google and AI search combined. Zero ad spend.',
            'source_text' => '',
            'lose_text'   => 'Your ad budget is funding a platform patients are leaving.',
        ),
        array(
            'number'      => '£500k',
            'stat_text'   => 'Superior Pharmacy this year. Two-person team. No ad spend. Competing nationally against operators with million-pound budgets.',
            'source_text' => '',
            'lose_text'   => "They'd never heard of Superior until ChatGPT put them on the shortlist.",
        ),
        array(
            'number'      => '£100k',
            'stat_text'   => 'Sachin at Ealing — HPV vaccinations alone. One service. One clinic. One year.',
            'source_text' => '',
            'lose_text'   => 'ChatGPT recommended your competitor. Not you.',
        ),
        array(
            'number'      => '6x',
            'stat_text'   => 'Google AI Overview results get clicked 6 times more than standard organic results. They appear above everything — above Boots, above NHS.uk, above paid ads. Most practices have no strategy to get featured.',
            'source_text' => '',
            'lose_text'   => "You're ranking on page one but appearing below practices a fraction of your size in AI Overviews.",
        ),
        array(
            'number'      => 'Virtually 0%',
            'stat_text'   => 'Of SEO agencies serving independent pharmacies are optimising for ChatGPT, Claude, Perplexity, and Google AI Overviews simultaneously. Your agency is optimising for one channel. Your patients are using four.',
            'source_text' => '',
            'lose_text'   => "You're paying for half a strategy and wondering why growth has stalled.",
        ),
        array(
            'number'      => '0%',
            'stat_text'   => "Of your Google rankings help you appear on ChatGPT. ChatGPT pulls recommendations from Bing. That's why Boots appears. That's why you don't.",
            'source_text' => '',
            'lose_text'   => 'Every pound spent on Google SEO is invisible to the fastest growing patient acquisition channel.',
        ),
        array(
            'number'      => '80%',
            'stat_text'   => 'Of practices frustrated with their current agency are getting more traffic but less revenue. More blog posts. Wrong pages ranking.',
            'source_text' => '',
            'lose_text'   => 'Your money pages — the ones that actually book patients — are losing ground while your agency celebrates traffic growth.',
        ),
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
                        $num    = $pair['number']      ?? '';
                        $stat   = $pair['stat_text']   ?? '';
                        $source = $pair['source_text'] ?? '';
                        $lose   = $pair['lose_text']   ?? '';
                        if ( ! $num && ! $stat && ! $lose ) continue; ?>
                        <div class="svc-ps-row">
                            <div class="svc-ps-win">
                                <?php if ( $num ) : ?>
                                    <div class="svc-ps-stat-num"><?php echo esc_html( $num ); ?></div>
                                <?php endif; ?>
                                <?php if ( $stat ) : ?>
                                    <p class="svc-ps-stat-text"><?php echo esc_html( $stat ); ?></p>
                                <?php endif; ?>
                                <?php if ( $source ) : ?>
                                    <p class="svc-ps-stat-source"><?php echo esc_html( $source ); ?></p>
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
