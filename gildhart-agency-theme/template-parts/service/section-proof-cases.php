<?php
/**
 * Service: Three Proof Cases section.
 *
 * Dark navy section that substantiates the hero stats with full client
 * case studies — image + name + tag + result + how + optional quote.
 * Cases alternate left/right via a `--reverse` modifier on every other
 * row (CSS uses direction: rtl to flip the grid). An optional Bing
 * rankings image sits below the cases as the final proof point.
 *
 * Reads from per-section ACF group `Service · Three Proof Cases`.
 * Returns early when the show toggle is off. Falls back to The Playbook
 * copy from the static spec when ACF fields are empty.
 *
 * Rich text fields (result, how, quote) accept inline <strong> markup
 * and are output via wp_kses_post() so editors can bold the headline
 * numbers/phrases inside each block.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_proof_cases_show', 1 ) ) {
    return;
}

$eyebrow     = gh_field( 'service_proof_cases_eyebrow',     'Three Practices. Same Result.' );
$headline    = gh_field( 'service_proof_cases_headline',    'Three Different Approaches. One Outcome: Domination.' );
$subheadline = gh_field( 'service_proof_cases_subheadline', 'Same foundation. Different implementations. All outranking national chains.' );

$cases = get_field( 'service_proof_cases_items' );
if ( empty( $cases ) ) {
    $cases = array(
        array(
            'client_name' => 'Ealing Travel Clinic',
            'client_tag'  => 'Travel Clinic',
            'image'       => 0,
            'result_text' => '<strong>#1 in Google AI Overviews</strong> for HPV vaccines. Outranking Boots and Superdrug. <strong>300% revenue growth</strong> in 6 months.',
            'how_text'    => 'Six weeks. Zero ad spend. Five pieces of interactive content. Featured in <strong>Google AI Overviews, ChatGPT, and Claude</strong>. This is the core system.',
            'quote_text'  => "Traffic's up <strong>300%</strong> and compounding every month. Not just traffic for the sake of it, but <strong>patients actually booking appointments</strong>.",
            'quote_attr'  => '— Sachin Mehta, Owner, Ealing Travel Clinic',
        ),
        array(
            'client_name' => 'Superior Pharmacy',
            'client_tag'  => 'Pharmacy',
            'image'       => 0,
            'result_text' => 'Launched January 2026. <strong>First sale in 48 hours</strong>. Now <strong>50% of sales from ChatGPT and Bing combined</strong>. Competing nationally against operators with million-pound budgets.',
            'how_text'    => 'Two-person team. New website. <strong>#1 on Bing for "Best Mounjaro Provider UK."</strong> That Bing ranking feeds ChatGPT\'s recommendations — when patients ask ChatGPT, Superior appears in comparison tables. Bing traffic converts higher than Google. Commercial intent buyers, not browsers. Patients switching from Juniper, SHEmed, and Pharmacy Express — national operators they\'d never heard of Superior until Bing and ChatGPT put them on the shortlist.',
            'quote_text'  => '',
            'quote_attr'  => '',
        ),
    );
}

$bing_id = get_field( 'service_proof_cases_bing_image' );
?>

<section class="svc-proof">
    <div class="svc-proof-inner">
        <div class="svc-proof-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-proof-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-proof-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $subheadline ) : ?>
                <p class="svc-proof-subheadline"><?php echo esc_html( $subheadline ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $cases ) ) : ?>
            <div class="svc-proof-cases">
                <?php foreach ( $cases as $i => $case ) :
                    $name        = $case['client_name'] ?? '';
                    $tag         = $case['client_tag']  ?? '';
                    $image_id    = $case['image']       ?? 0;
                    $result_text = $case['result_text'] ?? '';
                    $how_text    = $case['how_text']    ?? '';
                    $quote_text  = $case['quote_text']  ?? '';
                    $quote_attr  = $case['quote_attr']  ?? '';
                    $reverse     = ( $i % 2 === 1 );
                    $classes     = 'svc-proof-case' . ( $reverse ? ' svc-proof-case--reverse' : '' );
                ?>
                    <div class="<?php echo esc_attr( $classes ); ?>">
                        <div class="svc-proof-case-image">
                            <?php if ( $image_id ) : ?>
                                <?php echo wp_get_attachment_image( $image_id, 'large', false, array(
                                    'alt'     => esc_attr( $name ),
                                    'loading' => 'lazy',
                                ) ); ?>
                            <?php else : ?>
                                <div class="svc-proof-case-image-placeholder" aria-hidden="true"></div>
                            <?php endif; ?>
                        </div>
                        <div class="svc-proof-case-content">
                            <?php if ( $name || $tag ) : ?>
                                <div class="svc-proof-case-client-row">
                                    <?php if ( $name ) : ?>
                                        <h3 class="svc-proof-case-client-name"><?php echo esc_html( $name ); ?></h3>
                                    <?php endif; ?>
                                    <?php if ( $tag ) : ?>
                                        <span class="svc-proof-case-client-tag"><?php echo esc_html( $tag ); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( $result_text ) : ?>
                                <div class="svc-proof-case-result">
                                    <p class="svc-proof-case-result-label">The Result</p>
                                    <p class="svc-proof-case-result-text"><?php echo wp_kses_post( $result_text ); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if ( $how_text ) : ?>
                                <div class="svc-proof-case-how">
                                    <p class="svc-proof-case-how-label">How</p>
                                    <p class="svc-proof-case-how-text"><?php echo wp_kses_post( $how_text ); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if ( $quote_text ) : ?>
                                <div class="svc-proof-case-quote">
                                    <p class="svc-proof-case-quote-text"><?php echo wp_kses_post( $quote_text ); ?></p>
                                    <?php if ( $quote_attr ) : ?>
                                        <p class="svc-proof-case-quote-attr"><?php echo esc_html( $quote_attr ); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $bing_id ) : ?>
            <div class="svc-proof-bing">
                <?php echo wp_get_attachment_image( $bing_id, 'large', false, array(
                    'alt'     => 'Bing search results — #1 ranking proof',
                    'loading' => 'lazy',
                ) ); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
