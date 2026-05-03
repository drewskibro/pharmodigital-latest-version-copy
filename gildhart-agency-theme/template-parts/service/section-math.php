<?php
/**
 * Service: The Numbers (Math) section.
 *
 * Cream section that reframes the £497 price by audience. Header
 * (eyebrow + H2 + sub-headline) above a 2-column grid of audience
 * cards. Each card carries a label, a punch headline, and a body —
 * card colour rotates by row index (navy / white / sage / cream).
 *
 * Reads from per-section ACF group `Service · Math`. Returns early
 * when the show toggle is off. Falls back to The Playbook copy from
 * the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_math_show', 1 ) ) {
    return;
}

$eyebrow     = gh_field( 'service_math_eyebrow',     'The Numbers' );
$headline    = gh_field( 'service_math_headline',    'What This Actually Means For You' );
$subheadline = gh_field( 'service_math_subheadline', "The playbook costs £497. But what you're really buying depends on who you are." );

$cards = get_field( 'service_math_cards' );
if ( empty( $cards ) ) {
    $cards = array(
        array(
            'label'    => 'For Pharmacy & Clinic Owners',
            'headline' => "Every Month You Wait Is Revenue You Won't Get Back.",
            'body'     => "This is the exact system behind Ealing's £100k HPV revenue, Superior's £500k trajectory, and Puri outranking Boots nationally. Buy it once. Own it forever. Deploy it this week.",
        ),
        array(
            'label'    => 'For Marketing Directors',
            'headline' => 'Be The Person Who Brought AI To The Practice.',
            'body'     => "That's a promotion-level move. While everyone else is still Googling what AI Overviews are, you'll own the fastest-growing channel in healthcare marketing. One purchase. Career-defining skill.",
        ),
        array(
            'label'    => 'For Multi-Site Groups',
            'headline' => 'One System. Every Location. No Per-Site Fees.',
            'body'     => 'Buy it once. Train your entire marketing team. Deploy across every practice you operate. The system scales with you — no limits, no recurring costs, no agencies taking a cut.',
        ),
        array(
            'label'    => 'For Agencies & Consultants',
            'headline' => 'The £5k/Month System. For £497.',
            'body'     => "We charge clients £5k/month for this exact system. You're buying the system itself. Use it with your own clients. One client engagement pays for it thirty times over.",
        ),
    );
}
?>

<section class="svc-math">
    <div class="svc-math-inner">
        <div class="svc-math-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-math-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-math-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $subheadline ) : ?>
                <p class="svc-math-subheadline"><?php echo esc_html( $subheadline ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $cards ) ) : ?>
            <div class="svc-math-grid">
                <?php foreach ( $cards as $card ) :
                    $label    = $card['label']    ?? '';
                    $cheadline = $card['headline'] ?? '';
                    $body     = $card['body']     ?? '';
                    if ( ! $label && ! $cheadline && ! $body ) continue; ?>
                    <article class="svc-math-card">
                        <?php if ( $label ) : ?>
                            <span class="svc-math-card-label"><?php echo esc_html( $label ); ?></span>
                        <?php endif; ?>
                        <?php if ( $cheadline ) : ?>
                            <h3><?php echo esc_html( $cheadline ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $body ) : ?>
                            <p><?php echo esc_html( $body ); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
