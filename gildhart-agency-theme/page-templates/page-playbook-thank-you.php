<?php
/**
 * Template Name: Playbook Thank-You
 *
 * Post-payment confirmation page for the Playbook one-time checkout.
 *
 * Stripe redirects here after stripe.confirmPayment() succeeds, with
 * payment_intent + redirect_status in the query string. The bundled
 * playbook-thank-you.js reads payment_intent, calls the WP REST
 * endpoint /wp-json/gildhart/v1/payment-intent?id=… (which calls
 * Stripe), and personalises the [data-personalise] spans with the
 * customer's real email, plan label, amount, and first-name headline
 * swap.
 *
 * Leaner than the agent thank-you page: hero confirmation + an
 * optional welcome video (toggle, off by default until a Playbook
 * video is recorded) + a "what happens next" timeline. No subscription
 * / next-charge language — the Playbook is paid once, owned forever.
 *
 * Reuses the agent thank-you page's .svc-thank-you-* CSS verbatim, so
 * no new styles are needed. Copy comes from ACF (Service · Playbook
 * Thank-you Page) with defaults baked in via gh_field().
 *
 * @package Gildhart
 */

get_header();

/* Hero confirmation */
$hero_title = gh_field( 'playbook_thank_you_hero_title', "You're in." );
$hero_lead  = gh_field( 'playbook_thank_you_hero_lead',  'You now own The AI Search Playbook.' );
$hero_sub   = gh_field( 'playbook_thank_you_hero_sub',   "Everything's ready and waiting for you in Cowork." );

/* Welcome video — off by default until a Playbook-specific video exists. */
$video_show    = gh_field( 'playbook_thank_you_video_show', 0 );
$video_eyebrow = gh_field( 'playbook_thank_you_video_eyebrow', 'Welcome from Drew' );
$video_caption = gh_field( 'playbook_thank_you_video_caption', 'A quick word from Drew — what happens next.' );
$video_embed   = $video_show ? gh_field( 'playbook_thank_you_video_url', '' ) : '';

/* Timeline */
$timeline_eyebrow = gh_field( 'playbook_thank_you_timeline_eyebrow', 'What happens next' );
$timeline_items   = get_field( 'playbook_thank_you_timeline_items' );
if ( empty( $timeline_items ) ) {
    $timeline_items = array(
        array(
            'label' => 'Today',
            'title' => 'Your access is on its way.',
            'body'  => 'Your Stripe receipt and Cowork access details land in your inbox within the next 5 minutes.',
        ),
        array(
            'label' => 'Today',
            'title' => 'Download your system.',
            'body'  => 'Your pre-built knowledge base and Claude Skills — built around the services you selected — are ready to download and drop into Cowork.',
        ),
        array(
            'label' => 'This week',
            'title' => 'Upload once. Claude takes over.',
            'body'  => 'Drag your knowledge base into Cowork, run the first Skill, and Claude maps the content architecture that puts you on the AI shortlist. From there it runs every week.',
        ),
    );
}

/* Agent upsell — cross-sell block above the footer pitching the AI
 * Agent to a buyer who's just bought the Playbook (the mirror of the
 * Agent thank-you page's Playbook upsell). Reuses the .svc-thank-you-
 * upsell-* component verbatim, with an added secondary "Learn more"
 * link. The image defaults to the Agent service post's hero so a single
 * upload powers /the-agent/ AND this upsell; the upsell_image field
 * overrides if set. */
$upsell_show     = gh_field( 'playbook_thank_you_upsell_show',      1 );
$upsell_eyebrow  = gh_field( 'playbook_thank_you_upsell_eyebrow',   'Complete the system' );
$upsell_headline = gh_field( 'playbook_thank_you_upsell_headline',  'Your Playbook is Ready. Now Convert the Patients It Sends You.' );
$upsell_body     = gh_field( 'playbook_thank_you_upsell_body',      "The Playbook is the traffic system. Every piece of content you publish through it gets you featured on ChatGPT, Claude, Perplexity, and Google AI Overviews — sending pre-sold patients to your practice around the clock. But when those patients arrive at your website at 11pm on a Sunday, who answers them? The AI Agent does. It qualifies them, captures their details, and books them in — while you sleep. The Playbook fills the pipeline. The Agent converts it. That's the flywheel." );
$upsell_cta_lbl  = gh_field( 'playbook_thank_you_upsell_cta_label', 'Add The AI Agent' );
$upsell_cta_url  = gh_field( 'playbook_thank_you_upsell_cta_url',   '/the-agent/' );
$upsell_more_lbl = gh_field( 'playbook_thank_you_upsell_more_label','Learn more about the AI Agent' );
$upsell_more_url = gh_field( 'agent_page_url',                      '/the-agent/' );
$upsell_footnote = gh_field( 'playbook_thank_you_upsell_footnote',  'Fully built and live in 7 days. Starts generating enquiries immediately.' );
$upsell_image_id = (int) get_field( 'playbook_thank_you_upsell_image' );
if ( ! $upsell_image_id ) {
    $agent_post = get_page_by_path( 'the-agent', OBJECT, 'service' );
    if ( $agent_post ) {
        $upsell_image_id = (int) get_field( 'service_hero_image', $agent_post->ID );
    }
}

/* Proof block inside the upsell. */
$upsell_proof_label    = gh_field( 'playbook_thank_you_upsell_proof_label',    'What happens when both systems run together' );
$upsell_proof_body     = gh_field( 'playbook_thank_you_upsell_proof_body',     'Ealing ranked page one for Zika virus London. An IVF clinic found them. Called them. And started sending referrals. That\'s not a patient booking — that\'s an institution generating recurring revenue on autopilot. The Playbook did that. The Agent means every enquiry that follows gets answered instantly, routed correctly, and converted — without anyone on your team lifting a finger.' );
$upsell_proof_emphasis = gh_field( 'playbook_thank_you_upsell_proof_emphasis', 'The Playbook gets you found. The Agent gets you booked. One without the other is half the system.' );
?>

<main id="main" class="site-main">
    <section class="svc-thank-you">
        <div class="svc-thank-you-inner">

            <!-- Confirmation hero — left: personalised confirmation message,
                 right: order-summary receipt card (one-time £995). The H1 is
                 personalised at runtime by playbook-thank-you.js — when
                 first_name is returned, "You're in." becomes
                 "You're in, [First Name]." -->
            <div class="svc-thank-you-hero">
                <div class="svc-thank-you-hero-grid">

                    <!-- LEFT: confirmation message -->
                    <div class="svc-thank-you-hero-message">
                        <div class="svc-thank-you-hero-eyebrow-row">
                            <span class="svc-thank-you-hero-tick" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="4 12 10 18 20 6"/>
                                </svg>
                            </span>
                            <span class="svc-thank-you-hero-eyebrow">Payment confirmed</span>
                        </div>

                        <?php if ( $hero_title ) : ?>
                            <h1 class="svc-thank-you-hero-title" data-personalise="title"><?php echo esc_html( $hero_title ); ?></h1>
                        <?php endif; ?>

                        <?php if ( $hero_lead ) : ?>
                            <p class="svc-thank-you-hero-lead"><?php echo esc_html( $hero_lead ); ?></p>
                        <?php endif; ?>

                        <p class="svc-thank-you-hero-meta">
                            <span class="svc-thank-you-hero-meta-label">Confirmation sent to</span>
                            <strong class="svc-thank-you-hero-meta-value" data-personalise="email">your inbox</strong>
                        </p>
                    </div>

                    <!-- RIGHT: order summary receipt card -->
                    <aside class="svc-thank-you-receipt" aria-label="Order summary">
                        <span class="svc-thank-you-receipt-eyebrow">Order summary</span>

                        <dl class="svc-thank-you-receipt-list">
                            <div class="svc-thank-you-receipt-row">
                                <dt>Product</dt>
                                <dd data-personalise="plan_label">The AI Search Playbook</dd>
                            </div>
                            <div class="svc-thank-you-receipt-row svc-thank-you-receipt-row--total">
                                <dt>Total paid</dt>
                                <dd>
                                    <span data-personalise="amount_formatted">£995</span>
                                    <span class="svc-thank-you-receipt-vat">incl. VAT</span>
                                </dd>
                            </div>
                        </dl>

                        <p class="svc-thank-you-receipt-foot">
                            <svg class="svc-thank-you-receipt-foot-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="4" y="11" width="16" height="10" rx="2"/>
                                <path d="M8 11V7a4 4 0 1 1 8 0v4"/>
                            </svg>
                            Stripe-secured · One-time payment · Lifetime access
                        </p>
                    </aside>

                </div>

                <?php if ( $hero_sub ) : ?>
                    <p class="svc-thank-you-hero-status" role="status">
                        <span class="svc-thank-you-hero-status-dot" aria-hidden="true"></span>
                        <span class="svc-thank-you-hero-status-text"><?php echo esc_html( $hero_sub ); ?></span>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Welcome video (renders only when an oEmbed URL is set AND the toggle is on) -->
            <?php if ( $video_embed ) : ?>
                <div class="svc-thank-you-video">
                    <?php if ( $video_eyebrow ) : ?>
                        <span class="svc-thank-you-video-eyebrow"><?php echo esc_html( $video_eyebrow ); ?></span>
                    <?php endif; ?>
                    <div class="svc-thank-you-video-frame">
                        <?php echo $video_embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — ACF oembed returns iframe HTML ?>
                    </div>
                    <?php if ( $video_caption ) : ?>
                        <p class="svc-thank-you-video-caption"><?php echo esc_html( $video_caption ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Timeline -->
            <?php if ( ! empty( $timeline_items ) ) : ?>
                <div class="svc-thank-you-timeline">
                    <?php if ( $timeline_eyebrow ) : ?>
                        <span class="svc-thank-you-section-eyebrow"><?php echo esc_html( $timeline_eyebrow ); ?></span>
                    <?php endif; ?>
                    <ol class="svc-thank-you-timeline-list">
                        <?php foreach ( $timeline_items as $item ) :
                            $label = $item['label'] ?? '';
                            $title = $item['title'] ?? '';
                            $body  = $item['body']  ?? '';
                            if ( ! $label && ! $title && ! $body ) continue; ?>
                            <li class="svc-thank-you-timeline-item">
                                <?php if ( $label ) : ?>
                                    <span class="svc-thank-you-timeline-label"><?php echo esc_html( $label ); ?></span>
                                <?php endif; ?>
                                <?php if ( $title ) : ?>
                                    <p class="svc-thank-you-timeline-title"><?php echo esc_html( $title ); ?></p>
                                <?php endif; ?>
                                <?php if ( $body ) : ?>
                                    <p class="svc-thank-you-timeline-body"><?php echo esc_html( $body ); ?></p>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- Agent upsell — mirrors the Agent thank-you page's Playbook upsell.
         Full-width visual anchor on top, copy stack below. -->
    <?php if ( $upsell_show && ( $upsell_headline || $upsell_body ) ) : ?>
        <section class="svc-thank-you-upsell" aria-labelledby="svcPlaybookUpsellHeading">
            <div class="svc-thank-you-upsell-inner">
                <div class="svc-thank-you-upsell-stack">

                    <?php if ( $upsell_image_id ) : ?>
                        <figure class="svc-thank-you-upsell-media">
                            <?php echo wp_get_attachment_image( $upsell_image_id, 'full', false, array(
                                'class'   => 'svc-thank-you-upsell-image',
                                'alt'     => esc_attr( $upsell_headline ),
                                'loading' => 'lazy',
                            ) ); ?>
                        </figure>
                    <?php endif; ?>

                    <div class="svc-thank-you-upsell-copy">
                        <?php if ( $upsell_eyebrow ) : ?>
                            <span class="svc-thank-you-upsell-eyebrow"><?php echo esc_html( $upsell_eyebrow ); ?></span>
                        <?php endif; ?>
                        <?php if ( $upsell_headline ) : ?>
                            <h2 id="svcPlaybookUpsellHeading" class="svc-thank-you-upsell-headline"><?php echo esc_html( $upsell_headline ); ?></h2>
                        <?php endif; ?>
                        <?php if ( $upsell_body ) : ?>
                            <p class="svc-thank-you-upsell-body"><?php echo esc_html( $upsell_body ); ?></p>
                        <?php endif; ?>

                        <?php if ( $upsell_proof_label || $upsell_proof_body || $upsell_proof_emphasis ) : ?>
                            <div class="svc-thank-you-upsell-proof">
                                <?php if ( $upsell_proof_label ) : ?>
                                    <span class="svc-thank-you-upsell-proof-label"><?php echo esc_html( $upsell_proof_label ); ?></span>
                                <?php endif; ?>
                                <?php if ( $upsell_proof_body ) : ?>
                                    <p class="svc-thank-you-upsell-proof-body"><?php echo esc_html( $upsell_proof_body ); ?></p>
                                <?php endif; ?>
                                <?php if ( $upsell_proof_emphasis ) : ?>
                                    <p class="svc-thank-you-upsell-proof-emphasis"><?php echo esc_html( $upsell_proof_emphasis ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $upsell_cta_lbl && $upsell_cta_url ) : ?>
                            <div class="svc-thank-you-upsell-cta-wrap">
                                <a class="svc-thank-you-upsell-cta" href="<?php echo esc_url( $upsell_cta_url ); ?>">
                                    <?php echo esc_html( $upsell_cta_lbl ); ?> &rarr;
                                </a>
                                <?php if ( $upsell_more_lbl && $upsell_more_url ) : ?>
                                    <a class="svc-thank-you-upsell-secondary" href="<?php echo esc_url( $upsell_more_url ); ?>">
                                        <?php echo esc_html( $upsell_more_lbl ); ?> &rarr;
                                    </a>
                                <?php endif; ?>
                                <?php if ( $upsell_footnote ) : ?>
                                    <p class="svc-thank-you-upsell-footnote"><?php echo esc_html( $upsell_footnote ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php
get_footer();
