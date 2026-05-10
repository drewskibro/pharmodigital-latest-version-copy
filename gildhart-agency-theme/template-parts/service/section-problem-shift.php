<?php
/**
 * Service: Problem Shift section + teal CTA strip.
 *
 * Dark navy section that pivots from the hero claim to the underlying
 * shift in healthcare search. Below the headline + intro sits a
 * cream editorial narrative card (the Sachin story) followed by a
 * 3-column row of premium stat cards, then the teal CTA strip
 * closes the section flush below.
 *
 * Layout:
 *   1. Eyebrow label + headline + intro (white on navy)
 *   2. Editorial narrative card — cream background, navy body text,
 *      generous padding, ~720px reading column. Each paragraph is one
 *      ACF row in service_problem_shift_narrative_paragraphs so editors
 *      can adjust without touching markup. Empty repeater hides the
 *      whole card.
 *   3. Three horizontal stat cards (35fr each) — gold stat number,
 *      white subtext, optional gold-italic source attribution. Same
 *      navy-lift card styling we use elsewhere with a 30%-opacity gold
 *      left accent that pops to 100% on hover.
 *   4. Teal CTA strip.
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
$headline = gh_field( 'service_problem_shift_headline', "The Practices On ChatGPT's Shortlist Are Already Owning Your Market." );
$intro    = gh_field( 'service_problem_shift_intro',    "That shortlist is being built right now. Every week a practice claims a spot. Every week it gets harder to displace them. And the patients those practices are capturing — Semrush confirmed it across hundreds of sites — convert 4.4 times better than Google organic visitors. Not because of the platform. Because by the time they click a name on ChatGPT's recommendation, the decision is already made." );

// Editorial narrative — Sachin / Ealing story. ACF-driven; defaults
// fall back to the spec copy when no rows are saved.
$narrative_paragraphs = get_field( 'service_problem_shift_narrative_paragraphs' );
if ( empty( $narrative_paragraphs ) ) {
    $narrative_paragraphs = array(
        array( 'text' => "Sachin at Ealing Travel Clinic won't touch Google Ads." ),
        array( 'text' => 'He had a beautiful website. Professionally designed. Properly built. And in six months it had generated eight HPV bookings. Eight.' ),
        array( 'text' => 'Not because the site was bad. Because nobody could find it.' ),
        array( 'text' => "He didn't hire an agency. He used the Playbook. He'd never written a word about HPV before. Never created a single piece of content for the service." ),
        array( 'text' => 'Then something shifted.' ),
        array( 'text' => "Not overnight. Gradually — and then all at once. Daily enquiries started arriving from across London. People he'd never reached before. Asking specifically about HPV. About Gardasil 9. Patients who'd found his content, read it properly, and decided before they even made contact that Sachin was the person they trusted." ),
        array( 'text' => 'Eight bookings in six months became 55 bookings a month.' ),
        array( 'text' => 'Then an IVF clinic called.' ),
        array( 'text' => "They'd found his content on Zika virus testing. Read it. Decided he was a specialist. And started sending him their referrals." ),
        array( 'text' => 'A medical institution. Finding a pharmacist through content. Calling him. Trusting him enough to send patients.' ),
        array( 'text' => 'His patients tell him how good the content is. They arrive already convinced.' ),
        array( 'text' => "That's not traffic. That's authority. And authority compounds in a way that ad spend never will." ),
    );
}

// Three premium stat cards, full-bleed below the narrative. The
// nine-row dashboard was retired here — these three carry the proof
// without the lullaby effect of a long stat list.
$pairs = get_field( 'service_problem_shift_pairs' );
if ( empty( $pairs ) ) {
    $pairs = array(
        array(
            'number'      => '4.4x',
            'stat_text'   => "ChatGPT visitors convert 4.4 times better than Google organic. They've already chosen before they arrive.",
            'source_text' => 'Source: Semrush, across hundreds of healthcare sites.',
            'lose_text'   => '',
        ),
        array(
            'number'      => '6 weeks',
            'stat_text'   => 'Ealing Travel Clinic in Google AI Overviews. Ahead of Boots. Ahead of Superdrug. Ranking across the whole of London.',
            'source_text' => '',
            'lose_text'   => '',
        ),
        array(
            'number'      => '55',
            'stat_text'   => 'HPV bookings per month. Up from eight in six months. No ads. No agency. Just the system.',
            'source_text' => '',
            'lose_text'   => '',
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

            <?php if ( ! empty( $narrative_paragraphs ) ) : ?>
                <article class="svc-ps-narrative">
                    <div class="svc-ps-narrative-inner">
                        <?php foreach ( $narrative_paragraphs as $para ) :
                            $text = $para['text'] ?? '';
                            if ( ! $text ) continue; ?>
                            <p><?php echo esc_html( $text ); ?></p>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endif; ?>

            <?php if ( ! empty( $pairs ) ) : ?>
                <div class="svc-ps-cards">
                    <?php foreach ( $pairs as $pair ) :
                        $num    = $pair['number']      ?? '';
                        $stat   = $pair['stat_text']   ?? '';
                        $source = $pair['source_text'] ?? '';
                        if ( ! $num && ! $stat ) continue; ?>
                        <div class="svc-ps-card">
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
