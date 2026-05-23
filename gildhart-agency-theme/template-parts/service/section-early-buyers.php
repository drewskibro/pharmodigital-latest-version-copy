<?php
/**
 * Service: The Offer section (Playbook — replaces the old tier-cards
 * + price-strap + CTA + "Why Early Buyers Win" stack).
 *
 * Single full-width section, four parts in sequence, all sharing the
 * hero's cream/peach/mint gradient as the continuous backdrop:
 *
 *   1. The Window      — eyebrow + H2 + gold italic subhead + body
 *                        paragraphs + bold closing line. Frames the
 *                        "SEO in 2006 / mother of all second chances"
 *                        positioning.
 *   2. What You Get    — eyebrow + H2 + £497 subtext + 8-item gold
 *                        checkmark value stack + italic anchor line.
 *   3. Client Outcomes — three big stat blocks in a row on desktop
 *                        (300% Ealing · 50% Superior · £100k Puri),
 *                        separated by thin gold vertical dividers.
 *                        Stacks centred on mobile.
 *   4. Price and CTA   — gold display price + descriptor + primary
 *                        green "Get Instant Access" CTA + secondary
 *                        "Or talk to us about Done For You" link.
 *
 * Section keeps the `#buy-now` anchor so existing internal links and
 * the hero's secondary CTA still target the offer block. Returns
 * early when the show toggle is off. Falls back to The Playbook
 * copy from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_early_buyers_show', 1 ) ) {
    return;
}

/* PART 01 — The Window */
$window_eyebrow  = gh_field( 'service_offer_window_eyebrow',  'The Window' );
$window_headline = gh_field( 'service_offer_window_headline', 'This Is the Mother of All Second Chances.' );
$window_subhead  = gh_field( 'service_offer_window_subhead',  'If You Want the "SEO in 2006" Experience — This Is It. Times Ten.' );
$window_paras    = get_field( 'service_offer_window_paragraphs' );
if ( empty( $window_paras ) ) {
    $window_paras = array(
        array( 'text' => 'In 2006 you could rank a healthcare website in Google in weeks. Build a few pages before the national chains caught up and slammed it shut.' ),
        array( 'text' => "This window converts 300–800% better than that one ever did. AI search doesn't show ten results. It picks one. And right now — before Boots, Bupa, and Superdrug have figured out how to game it — that one can be you." ),
        array( 'text' => 'The shortlist is being built right now. Not next year. Now.' ),
        array( 'text' => "Ealing got on it in 6 weeks. Superior got on it in 48 hours. Both moved before their competitors noticed. Their competitors have noticed now. They're already six months behind." ),
        array( 'text' => 'Every week you wait, someone in your area is claiming the spot you should own.' ),
    );
}
$window_closer = gh_field( 'service_offer_window_closer', 'The practices moving now will own the shortlist. The ones waiting will find it already full.' );

/* PART 02 — What You Get Today */
$stack_eyebrow  = gh_field( 'service_offer_stack_eyebrow',  'What You Get Today' );
$stack_headline = gh_field( 'service_offer_stack_headline', 'One Purchase. Everything You Need. Yours Forever.' );
$stack_subtext  = gh_field( 'service_offer_stack_subtext',  '£497 once. No monthly fees. No agency retainer. No recurring costs.' );
$stack_items    = get_field( 'service_offer_stack_items' );
if ( empty( $stack_items ) ) {
    $stack_items = array(
        array( 'text' => "The complete pillar and cluster content architecture — the exact system that put Ealing, Superior, and Puri on ChatGPT's shortlist. Copy-paste ready from day one." ),
        array( 'text' => 'Pre-built healthcare knowledge base — installed into Cowork before you start. Travel vaccines, weight loss, aesthetics, dentistry, cosmetic surgery. Built. Verified. Ready.' ),
        array( 'text' => "Every Claude Skill we've built — the automated weekly content cycle that finds the questions, builds the content, and feeds what's working back into the next cycle. One instruction. Runs automatically." ),
        array( 'text' => 'GPhC, GMC, GDC, and CQC compliant content frameworks — so you never have to worry about what Claude is writing from.' ),
        array( 'text' => 'The indexing system — gets every piece of content in front of Google, ChatGPT, Claude, and Perplexity in days not weeks.' ),
        array( 'text' => 'Monthly strategy calls — live and recorded. As AI platforms evolve, your system evolves with them.' ),
        array( 'text' => 'Every update we ever release — new skills, new knowledge bases, new platform strategies. Automatically. No upgrade fees. Ever.' ),
        array( 'text' => "Personal implementation guarantee — go through the system, follow the steps, and if you're still stuck I'll personally walk you through it one to one." ),
    );
}
$stack_anchor = gh_field( 'service_offer_stack_anchor', "We charge clients £5,000 a month for this exact system. You're buying the system itself. One client engagement pays for it thirty times over." );

/* PART 03 — Client Outcomes */
$outcomes = get_field( 'service_offer_outcomes' );
if ( empty( $outcomes ) ) {
    $outcomes = array(
        array( 'value' => '300%',  'label' => 'Revenue Growth',         'client' => 'Ealing Travel Clinic' ),
        array( 'value' => '50%',   'label' => 'Of Sales From ChatGPT',  'client' => 'Superior Pharmacy' ),
        array( 'value' => '£100k', 'label' => 'From Mounjaro Alone',    'client' => 'Puri Pharmacy' ),
    );
}

/* PART 04 — Price and CTA */
$price_value      = gh_field( 'service_offer_price_value',        '£497 once.' );
$price_descriptor = gh_field( 'service_offer_price_descriptor',   'The Complete System. Cowork Included. Lifetime Support.' );
$primary_label    = gh_field( 'service_offer_primary_cta_label',  'Get Instant Access — £497' );
$primary_url      = gh_field( 'service_offer_primary_cta_url',    '#checkout' );
$secondary_label  = gh_field( 'service_offer_secondary_cta_label','Or talk to us about Done For You' );
$secondary_url    = gh_field( 'service_offer_secondary_cta_url',  '/contact/' );
?>

<section class="svc-offer" id="buy-now">
    <div class="svc-offer-inner">

        <!-- ─── PART 01: The Window ─── -->
        <div class="svc-offer-part svc-offer-window">
            <?php if ( $window_eyebrow ) : ?>
                <p class="svc-offer-eyebrow svc-offer-eyebrow--gold"><?php echo esc_html( $window_eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $window_headline ) : ?>
                <h2 class="svc-offer-headline"><?php echo esc_html( $window_headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $window_subhead ) : ?>
                <p class="svc-offer-window-subhead"><?php echo esc_html( $window_subhead ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $window_paras ) ) : ?>
                <div class="svc-offer-window-body">
                    <?php foreach ( $window_paras as $para ) :
                        $text = $para['text'] ?? '';
                        if ( ! $text ) continue; ?>
                        <p><?php echo wp_kses_post( $text ); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if ( $window_closer ) : ?>
                <p class="svc-offer-window-closer"><?php echo esc_html( $window_closer ); ?></p>
            <?php endif; ?>
        </div>

        <!-- ─── PART 02: What You Get Today ─── -->
        <div class="svc-offer-part svc-offer-stack">
            <?php if ( $stack_eyebrow ) : ?>
                <p class="svc-offer-eyebrow svc-offer-eyebrow--green"><?php echo esc_html( $stack_eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $stack_headline ) : ?>
                <h2 class="svc-offer-headline"><?php echo esc_html( $stack_headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $stack_subtext ) : ?>
                <p class="svc-offer-stack-subtext"><?php echo esc_html( $stack_subtext ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $stack_items ) ) : ?>
                <ul class="svc-offer-stack-list">
                    <?php foreach ( $stack_items as $item ) :
                        $text = $item['text'] ?? '';
                        if ( ! $text ) continue; ?>
                        <li>
                            <span class="svc-offer-check" aria-hidden="true">✓</span>
                            <span class="svc-offer-stack-text"><?php echo wp_kses_post( $text ); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if ( $stack_anchor ) : ?>
                <p class="svc-offer-stack-anchor"><?php echo esc_html( $stack_anchor ); ?></p>
            <?php endif; ?>
        </div>

        <!-- ─── PART 03: Client Outcomes ─── -->
        <?php if ( ! empty( $outcomes ) ) : ?>
            <div class="svc-offer-part svc-offer-outcomes">
                <div class="svc-offer-outcomes-row">
                    <?php foreach ( $outcomes as $stat ) :
                        $value  = $stat['value']  ?? '';
                        $label  = $stat['label']  ?? '';
                        $client = $stat['client'] ?? '';
                        if ( ! $value && ! $label ) continue; ?>
                        <div class="svc-offer-stat">
                            <?php if ( $value ) : ?>
                                <span class="svc-offer-stat-value"><?php echo esc_html( $value ); ?></span>
                            <?php endif; ?>
                            <?php if ( $label ) : ?>
                                <span class="svc-offer-stat-label"><?php echo esc_html( $label ); ?></span>
                            <?php endif; ?>
                            <?php if ( $client ) : ?>
                                <span class="svc-offer-stat-client"><?php echo esc_html( $client ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ─── PART 04: Price and CTA ─── -->
        <div class="svc-offer-part svc-offer-cta">
            <div class="svc-offer-price">
                <?php if ( $price_value ) : ?>
                    <span class="svc-offer-price-value"><?php echo esc_html( $price_value ); ?></span>
                <?php endif; ?>
                <?php if ( $price_descriptor ) : ?>
                    <span class="svc-offer-price-desc"><?php echo esc_html( $price_descriptor ); ?></span>
                <?php endif; ?>
            </div>
            <?php if ( $primary_label && $primary_url ) : ?>
                <a class="svc-offer-cta-primary" href="<?php echo esc_url( $primary_url ); ?>">
                    <?php echo esc_html( $primary_label ); ?>
                    <span class="svc-offer-cta-arrow" aria-hidden="true">→</span>
                </a>
            <?php endif; ?>
            <?php if ( $secondary_label && $secondary_url ) : ?>
                <a class="svc-offer-cta-secondary" href="<?php echo esc_url( $secondary_url ); ?>">
                    <?php echo esc_html( $secondary_label ); ?> →
                </a>
            <?php endif; ?>
        </div>

    </div>
</section>
