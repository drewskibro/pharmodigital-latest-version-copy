<?php
/**
 * Service: Intelligence Engine section ("Not A Chatbot").
 *
 * Cream section split into two parts:
 *   1. Hero block — gold eyebrow + dark H2 + sub paragraph + optional
 *      product image stacked below.
 *   2. Three "Patient Query → Agent Outcome → Content Signal" cards
 *      in a row, each with a green left-border. Each card carries
 *      three labelled blocks separated by hairline dividers:
 *        - Patient Query (grey caps label, navy body)
 *        - Agent Outcome (green caps label, grey body)
 *        - Content Signal (amber caps label, amber-tinted callout)
 *
 * Reads from per-section ACF group `Service · Intelligence Engine`.
 * Returns early when the show toggle is off. Falls back to The Agent
 * copy from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_intel_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_intel_eyebrow',  'The Intelligence Engine' );
$headline = gh_field( 'service_intel_headline', 'Every Patient Question Is A Revenue Signal.' );
$sub      = gh_field( 'service_intel_sub',      "Your AI agent doesn't just answer — it captures the exact language patients use, the clinical questions they ask, and the services they're ready to pay for. Then we turn that into content that ranks." );
$image_id = get_field( 'service_intel_image' );

$cards = get_field( 'service_intel_cards' );
if ( empty( $cards ) ) {
    $cards = array(
        array(
            'query'   => "\"I'm at risk of needlestick injury at work. I need Hepatitis A/B and tetanus vaccines urgently for occupational health. Can I start immediately?\"",
            'outcome' => 'Qualified for occupational health pathway. Urgent appointment booked. Three vaccine course initiated.',
            'intel'   => '<strong>Blog created:</strong> "Needlestick Injury Vaccines: What You Need and How Quickly You Can Start" → ranks in AI Overview for occupational health vaccine queries',
        ),
        array(
            'query'   => "\"I'm on week three of Mounjaro but I take medication for high blood pressure. Is this safe to continue?\"",
            'outcome' => 'Medically accurate response delivered. Patient reassured. Follow-up consultation booked.',
            'intel'   => '<strong>Blog created:</strong> "Mounjaro and Blood Pressure Medication: Is It Safe?" → ranks in ChatGPT for weight loss drug interaction queries',
        ),
        array(
            'query'   => "\"I'm travelling to Southeast Asia in three weeks. My child is seven. What vaccines do we need?\"",
            'outcome' => 'Full travel health assessment completed. Family vaccination course recommended and booked.',
            'intel'   => '<strong>Blog created:</strong> "Southeast Asia Vaccines for Families: What Children Under 10 Need" → ranks in Google AI Overview for family travel health',
        ),
    );
}
?>

<section class="svc-intel">
    <div class="svc-intel-inner">
        <div class="svc-intel-hero">
            <div class="svc-intel-hero-copy">
                <?php if ( $eyebrow ) : ?>
                    <p class="svc-intel-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="svc-intel-headline"><?php echo esc_html( $headline ); ?></h2>
                <?php endif; ?>
                <?php if ( $sub ) : ?>
                    <p class="svc-intel-sub"><?php echo esc_html( $sub ); ?></p>
                <?php endif; ?>
            </div>
            <?php if ( $image_id ) : ?>
                <div class="svc-intel-hero-image">
                    <?php echo wp_get_attachment_image( $image_id, 'large', false, array(
                        'alt'     => 'AI agent — patient chat preview',
                        'loading' => 'lazy',
                    ) ); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $cards ) ) : ?>
            <div class="svc-intel-cards">
                <?php foreach ( $cards as $card ) :
                    $query   = $card['query']   ?? '';
                    $outcome = $card['outcome'] ?? '';
                    $intel   = $card['intel']   ?? '';
                    if ( ! $query && ! $outcome && ! $intel ) continue;
                ?>
                    <article class="svc-intel-card">
                        <?php if ( $query ) : ?>
                            <p class="svc-intel-card-label svc-intel-card-label--patient">Patient Query</p>
                            <p class="svc-intel-card-text"><?php echo esc_html( $query ); ?></p>
                            <div class="svc-intel-card-divider" aria-hidden="true"></div>
                        <?php endif; ?>
                        <?php if ( $outcome ) : ?>
                            <p class="svc-intel-card-label svc-intel-card-label--agent">Agent Outcome</p>
                            <p class="svc-intel-card-outcome"><?php echo esc_html( $outcome ); ?></p>
                            <div class="svc-intel-card-divider" aria-hidden="true"></div>
                        <?php endif; ?>
                        <?php if ( $intel ) : ?>
                            <p class="svc-intel-card-label svc-intel-card-label--intel">Content Signal</p>
                            <p class="svc-intel-card-intel"><?php echo wp_kses_post( $intel ); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
