<?php
/**
 * Service: Early Buyers section.
 *
 * Cream-warm offer block with three sub-blocks:
 *   1. Three tier cards in a row — each "kind" controls the colour
 *      treatment (manual = white card, automated = dark featured,
 *      lifetime = green-banner light card).
 *   2. A navy price-strap below the cards (gold price + descriptor).
 *   3. A centered green "Get Instant Access" CTA below the strap.
 *   4. A navy "Why Early Buyers Win" callout with eyebrow, H3, and
 *      multiple paragraphs.
 *
 * Reads from per-section ACF group `Service · Early Buyers`. Returns
 * early when the show toggle is off. Falls back to The Playbook copy
 * from the static spec when ACF fields are empty. Tier cards reveal
 * staggered via svcReveal('.svc-tier-card', 'is-visible').
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_early_buyers_show', 1 ) ) {
    return;
}

$tier_cards = get_field( 'service_early_buyers_tiers' );
if ( empty( $tier_cards ) ) {
    $tier_cards = array(
        array(
            'kind'         => 'manual',
            'proof_banner' => 'Superior, Ealing and Puri used this to outrank Boots',
            'recommended'  => '',
            'category'     => 'Do It Yourself',
            'top_label'    => 'Included Today',
            'title'        => 'The Complete Content System',
            'body'         => "Every prompt, every template, every content architecture that put Ealing, Superior, and Puri on ChatGPT's shortlist. Refined across thousands of pieces of content. Copy-paste ready from day one. Built specifically for healthcare practices. Nothing generic. Nothing theoretical. Everything tested.",
            'bullets'      => array(),
        ),
        array(
            'kind'         => 'automated',
            'proof_banner' => 'Built for: Ealing  |  Superior  |  Puri  |  50+ Healthcare Practices',
            'recommended'  => 'Recommended',
            'category'     => 'The Automation Layer',
            'top_label'    => '',
            'title'        => 'Your Healthcare AI Engine',
            'body'         => 'This is where it gets powerful. Your Cowork setup comes pre-loaded with our proprietary healthcare knowledge base — refined across hundreds of thousands of AI conversations and thousands of pieces of content. One instruction triggers the entire content build. No manual friction. No starting from scratch. Claude does the work. You review the output.',
            'bullets'      => array(
                array( 'text' => 'Pre-built healthcare knowledge base — installed, not built' ),
                array( 'text' => 'One instruction builds entire content infrastructure' ),
                array( 'text' => 'Runs automatically on your desktop via Cowork' ),
                array( 'text' => 'No writers. No agencies. No monthly fees.' ),
            ),
        ),
        array(
            'kind'         => 'lifetime',
            'proof_banner' => 'Live across our global network',
            'recommended'  => '',
            'category'     => 'Lifetime Access',
            'top_label'    => 'Included Free',
            'title'        => 'Updates For Life. As Fast As AI Moves.',
            'body'         => "AI isn't standing still. Claude updates. ChatGPT updates. Google's algorithms update. Every time they do, your system needs to evolve. That's why lifetime support isn't a bonus — it's essential. You get every update we release, every new skill we build, and monthly strategy calls to make sure your system stays ahead of every platform change.",
            'bullets'      => array(
                array( 'text' => 'Monthly strategy calls — live and recorded' ),
                array( 'text' => 'Platform updates as Claude, ChatGPT, and Google evolve' ),
                array( 'text' => 'New skills added as AI capabilities expand' ),
                array( 'text' => 'No recurring fees — ever' ),
            ),
        ),
    );
}

$strap_price       = gh_field( 'service_early_buyers_strap_price',       '£497 once.' );
$strap_desc        = gh_field( 'service_early_buyers_strap_desc',        'The Complete System. Cowork Included. Lifetime Support.' );
$cta_label         = gh_field( 'service_early_buyers_cta_label',         'Get Instant Access — £497' );
$cta_url           = gh_field( 'service_early_buyers_cta_url',           '#buy-now' );
$callout_show      = gh_field( 'service_early_buyers_callout_show',      1 );
$callout_eyebrow   = gh_field( 'service_early_buyers_callout_eyebrow',   '' );
$callout_headline  = gh_field( 'service_early_buyers_callout_headline',  'Why Early Buyers Win' );
$callout_paragraphs = get_field( 'service_early_buyers_callout_paragraphs' );
if ( empty( $callout_paragraphs ) ) {
    $callout_paragraphs = array(
        array( 'text' => 'Cowork is live. The knowledge base is built. The skills are ready. Everything you need is available today.' ),
        array( 'text' => 'Every week more practices find this. Every week the shortlist gets harder to crack. Every week the gap between the practices already ranking and the ones still waiting gets wider.' ),
        array( 'text' => "The price reflects what's included right now. As new Claude skills ship, as AI platforms evolve, as we refine the knowledge base, early buyers get every update automatically. No upgrade fees. No new purchases." ),
        array( 'text' => '<strong>The practices moving now will own the shortlist. The ones waiting will find it already full.</strong>' ),
    );
}
?>

<section class="svc-early-buyers" id="buy-now">
    <div class="svc-eb-inner">
        <?php if ( ! empty( $tier_cards ) ) : ?>
            <div class="svc-tiers">
                <?php foreach ( $tier_cards as $tier ) :
                    $kind         = $tier['kind']         ?? 'manual';
                    $proof_banner = $tier['proof_banner'] ?? '';
                    $recommended  = $tier['recommended']  ?? '';
                    $category     = $tier['category']     ?? '';
                    $top_label    = $tier['top_label']    ?? '';
                    $title        = $tier['title']        ?? '';
                    $body         = $tier['body']         ?? '';
                    $bullets      = $tier['bullets']      ?? array();
                ?>
                    <div class="svc-tier-card svc-tier-card--<?php echo esc_attr( $kind ); ?>">
                        <?php if ( $proof_banner ) : ?>
                            <div class="svc-tier-proof-banner"><?php echo esc_html( $proof_banner ); ?></div>
                        <?php endif; ?>
                        <div class="svc-tier-card-inner">
                            <?php if ( $recommended ) : ?>
                                <span class="svc-tier-recommended"><?php echo esc_html( $recommended ); ?></span>
                            <?php endif; ?>
                            <?php if ( $category ) : ?>
                                <p class="svc-tier-category"><?php echo esc_html( $category ); ?></p>
                            <?php endif; ?>
                            <?php if ( $top_label ) : ?>
                                <p class="svc-tier-label"><?php echo esc_html( $top_label ); ?></p>
                            <?php endif; ?>
                            <?php if ( $title ) : ?>
                                <h3 class="svc-tier-title"><?php echo esc_html( $title ); ?></h3>
                            <?php endif; ?>
                            <?php if ( $body ) : ?>
                                <p class="svc-tier-body"><?php echo esc_html( $body ); ?></p>
                            <?php endif; ?>
                            <?php if ( ! empty( $bullets ) ) : ?>
                                <ul class="svc-tier-list">
                                    <?php foreach ( $bullets as $bullet ) :
                                        $text = $bullet['text'] ?? '';
                                        if ( ! $text ) continue; ?>
                                        <li><span class="svc-tier-check" aria-hidden="true">✓</span><?php echo esc_html( $text ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $strap_price || $strap_desc ) : ?>
            <div class="svc-strap">
                <?php if ( $strap_price ) : ?>
                    <span class="svc-strap-price"><?php echo esc_html( $strap_price ); ?></span>
                <?php endif; ?>
                <?php if ( $strap_desc ) : ?>
                    <span class="svc-strap-desc"><?php echo esc_html( $strap_desc ); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( $cta_label ) : ?>
            <div class="svc-strap-cta">
                <a href="<?php echo esc_url( $cta_url ); ?>">
                    <?php echo esc_html( $cta_label ); ?>
                    <span class="svc-btn-arrow" aria-hidden="true">→</span>
                </a>
            </div>
        <?php endif; ?>

        <?php if ( $callout_show && ( $callout_headline || ! empty( $callout_paragraphs ) ) ) : ?>
            <div class="svc-eb-callout">
                <?php if ( $callout_eyebrow ) : ?>
                    <span class="svc-eb-callout-eyebrow"><?php echo esc_html( $callout_eyebrow ); ?></span>
                <?php endif; ?>
                <?php if ( $callout_headline ) : ?>
                    <h3><?php echo esc_html( $callout_headline ); ?></h3>
                <?php endif; ?>
                <?php foreach ( $callout_paragraphs as $para ) :
                    $text = $para['text'] ?? '';
                    if ( ! $text ) continue; ?>
                    <p><?php echo wp_kses_post( $text ); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
