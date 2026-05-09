<?php
/**
 * Template Name: Agent Thank-You
 *
 * Post-payment confirmation page for the agent subscription checkout.
 *
 * Stripe redirects here after stripe.confirmPayment() succeeds, with
 * payment_intent + redirect_status in the query string. The bundled
 * agent-thank-you.js reads payment_intent, calls the WP REST endpoint
 * /wp-json/gildhart/v1/payment-intent?id=… (which calls Stripe), and
 * personalises any [data-personalise="email"] / [data-personalise="plan_label"]
 * span on the page with the customer's actual email + plan name.
 *
 * If the personalisation request fails (network error, expired session,
 * direct visit without a payment_intent), the page reads naturally with
 * the static fallback copy — nothing breaks.
 *
 * Most copy comes from ACF (Service · Agent Thank-you Page field group)
 * with sensible defaults baked in via gh_field() so a freshly-published
 * page renders premium without any field having been filled.
 *
 * @package Gildhart
 */

get_header();

/* Hero confirmation */
$hero_title = gh_field( 'agent_thank_you_hero_title', "You're in." );
$hero_sub   = gh_field( 'agent_thank_you_hero_sub',   'Deployment kicks off in 7 days.' );

/* Welcome video */
$video_show    = gh_field( 'agent_thank_you_video_show', 1 );
$video_eyebrow = gh_field( 'agent_thank_you_video_eyebrow', 'Welcome from Drew' );
$video_caption = gh_field( 'agent_thank_you_video_caption', 'A quick word from Drew — what happens next.' );
// ACF's oembed field returns the rendered iframe HTML directly when the
// editor pastes a Vimeo / YouTube URL. Don't run it through wp_oembed_get
// again — that takes a URL and would receive HTML, returning false (which
// is why the video previously didn't render even though the URL was set).
$video_embed = $video_show ? gh_field( 'agent_thank_you_video_url', '' ) : '';

/* Timeline */
$timeline_eyebrow = gh_field( 'agent_thank_you_timeline_eyebrow', 'What happens next' );
$timeline_items   = get_field( 'agent_thank_you_timeline_items' );
if ( empty( $timeline_items ) ) {
    $timeline_items = array(
        array(
            'label' => 'Today',
            'title' => 'Confirmation in your inbox.',
            'body'  => 'Stripe invoice + welcome from Drew within the next 5 minutes.',
        ),
        array(
            'label' => 'Day 1–3',
            'title' => 'Onboarding handoff.',
            'body'  => "Brief email asking about your services, your tone, and your conversion goals. ~15 minutes to fill.",
        ),
        array(
            'label' => 'Day 7',
            'title' => 'Your Agent goes live.',
            'body'  => 'Trained, tested, deployed. First patient query typically arrives within 48 hours of launch.',
        ),
    );
}

/* While you wait */
$wait_eyebrow = gh_field( 'agent_thank_you_wait_eyebrow', 'While you wait' );
$wait_intro   = gh_field( 'agent_thank_you_wait_intro',   'Two things you can do today to accelerate go-live:' );
$wait_items   = get_field( 'agent_thank_you_wait_items' );
if ( empty( $wait_items ) ) {
    $wait_items = array(
        array( 'text' => 'Watch your inbox at the email address above.' ),
        array( 'text' => "Prep your services list — we'll ask in onboarding." ),
    );
}

/* Reassurance / testimonial */
$reassure_quote = gh_field( 'agent_thank_you_reassure_quote', 'We went live and within a couple of days patients were booking HPV appointments through it at night.' );
$reassure_attr  = gh_field( 'agent_thank_you_reassure_attr',  'Sachin Mehta · Ealing Travel Clinic' );

/* Founder note */
$founder_title = gh_field( 'agent_thank_you_founder_title', 'Welcome to the network.' );
$founder_body  = gh_field( 'agent_thank_you_founder_body',  "Any questions while you wait, hit reply on the confirmation email — it goes straight to me." );
$founder_name  = gh_field( 'agent_thank_you_founder_name',  'Drew Clayton' );
$founder_role  = gh_field( 'agent_thank_you_founder_role',  'The Gildhart team' );
$founder_photo = get_field( 'agent_thank_you_founder_photo' );

/* Playbook upsell — cross-sell block above the footer pitching the
 * £497 Playbook to a buyer already in "spending money" mode. The
 * image defaults to the Playbook service post's hero image so a
 * single asset upload powers /the-playbook/ AND this upsell; the
 * upsell_image ACF field overrides if explicitly set. */
$upsell_show     = gh_field( 'agent_thank_you_upsell_show',      1 );
$upsell_eyebrow  = gh_field( 'agent_thank_you_upsell_eyebrow',   'Complete the system' );
$upsell_headline = gh_field( 'agent_thank_you_upsell_headline',  "Your agent converts. Now let's fill it." );
$upsell_subhead  = gh_field( 'agent_thank_you_upsell_subhead',   "The AI Search Playbook — the exact system that drove Ealing's £100k HPV revenue to their agent." );
$upsell_body     = gh_field( 'agent_thank_you_upsell_body',      'Your Agent converts the patients who find you. The Playbook is how patients find you — the AI-search ranking system that put Ealing Travel Clinic at the top of ChatGPT and Perplexity for HPV vaccinations, sending £100k of new patient revenue straight to their agent. One-time fee. Compounds for years.' );
$upsell_cta_lbl  = gh_field( 'agent_thank_you_upsell_cta_label', 'Complete the flywheel — £497 →' );
$upsell_cta_url  = gh_field( 'agent_thank_you_upsell_cta_url',   '/the-playbook/' );
$upsell_footnote = gh_field( 'agent_thank_you_upsell_footnote',  'Price increases Q3 2026. Early buyers lock in today.' );
$upsell_image_id = get_field( 'agent_thank_you_upsell_image' );
if ( ! $upsell_image_id ) {
    // Fallback: pull the hero image attachment ID off the Playbook
    // service post. get_page_by_path() returns the Service CPT entry
    // whose slug is "the-playbook". get_field() with the post ID
    // reads the field on that post, not the current page.
    $playbook_post = get_page_by_path( 'the-playbook', OBJECT, 'service' );
    if ( $playbook_post ) {
        $upsell_image_id = (int) get_field( 'service_hero_image', $playbook_post->ID );
    }
}
?>

<main id="main" class="site-main">
    <section class="svc-thank-you">
        <div class="svc-thank-you-inner">

            <!-- Confirmation hero — full-width 2-column. Left: confirmation
                 message with inline gold tick, big personalised headline,
                 lead line, email confirmation. Right: order-summary
                 receipt card (plan / total / next charge). Below:
                 full-width status strip ("Deployment kicks off in 7 days").
                 The headline is personalised at runtime by agent-thank-you.js
                 — when first_name is returned, "You're in." becomes
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

                        <p class="svc-thank-you-hero-lead">
                            Your subscription to The Agent is active.
                        </p>

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
                                <dt>Plan</dt>
                                <dd data-personalise="plan_label">Your subscription</dd>
                            </div>
                            <div class="svc-thank-you-receipt-row svc-thank-you-receipt-row--total">
                                <dt>Total paid</dt>
                                <dd>
                                    <span data-personalise="amount_formatted">—</span>
                                    <span class="svc-thank-you-receipt-vat">incl. VAT</span>
                                </dd>
                            </div>
                        </dl>

                        <p class="svc-thank-you-receipt-foot">
                            <svg class="svc-thank-you-receipt-foot-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="4" y="11" width="16" height="10" rx="2"/>
                                <path d="M8 11V7a4 4 0 1 1 8 0v4"/>
                            </svg>
                            Stripe-secured · Auto-renews
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

            <!-- Welcome video (renders only when an oEmbed URL is set in ACF) -->
            <?php if ( $video_embed ) : ?>
                <div class="svc-thank-you-video">
                    <?php if ( $video_eyebrow ) : ?>
                        <span class="svc-thank-you-video-eyebrow"><?php echo esc_html( $video_eyebrow ); ?></span>
                    <?php endif; ?>
                    <div class="svc-thank-you-video-frame">
                        <?php echo $video_embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — wp_oembed_get returns iframe HTML ?>
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

            <!-- While you wait -->
            <?php if ( $wait_intro || ! empty( $wait_items ) ) : ?>
                <div class="svc-thank-you-wait">
                    <?php if ( $wait_eyebrow ) : ?>
                        <span class="svc-thank-you-section-eyebrow"><?php echo esc_html( $wait_eyebrow ); ?></span>
                    <?php endif; ?>
                    <?php if ( $wait_intro ) : ?>
                        <p class="svc-thank-you-wait-intro"><?php echo esc_html( $wait_intro ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $wait_items ) ) : ?>
                        <ul class="svc-thank-you-wait-list">
                            <?php foreach ( $wait_items as $item ) :
                                $text = $item['text'] ?? '';
                                if ( ! $text ) continue; ?>
                                <li><?php echo esc_html( $text ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Reassurance / testimonial -->
            <?php if ( $reassure_quote ) : ?>
                <div class="svc-thank-you-reassure">
                    <p class="svc-thank-you-reassure-quote">&ldquo;<?php echo esc_html( $reassure_quote ); ?>&rdquo;</p>
                    <?php if ( $reassure_attr ) : ?>
                        <p class="svc-thank-you-reassure-attr">&mdash; <?php echo esc_html( $reassure_attr ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Founder note -->
            <?php if ( $founder_title || $founder_body || $founder_name ) : ?>
                <div class="svc-thank-you-founder">
                    <?php if ( $founder_title ) : ?>
                        <p class="svc-thank-you-founder-title"><?php echo esc_html( $founder_title ); ?></p>
                    <?php endif; ?>
                    <?php if ( $founder_body ) : ?>
                        <p class="svc-thank-you-founder-body"><?php echo esc_html( $founder_body ); ?></p>
                    <?php endif; ?>
                    <?php if ( $founder_photo ) : ?>
                        <div class="svc-thank-you-founder-photo-wrap">
                            <?php echo wp_get_attachment_image( $founder_photo, 'medium', false, array(
                                'class' => 'svc-thank-you-founder-photo',
                                'alt'   => esc_attr( $founder_name ),
                            ) ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( $founder_name || $founder_role ) : ?>
                        <p class="svc-thank-you-founder-signoff">
                            &mdash; <?php echo esc_html( $founder_name ); ?>
                            <?php if ( $founder_role ) : ?>
                                <br><span class="svc-thank-you-founder-role"><?php echo esc_html( $founder_role ); ?></span>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- Playbook upsell — cross-sell block above the footer. Sits as its
         own <section> (not inside .svc-thank-you-inner) so it can carry
         a slightly different background tone, signalling a shift in
         intent from "confirming your purchase" to "here's what's next."
         Two-column split: copy on the left, playbook image on the right.
         Hides entirely when the upsell_show toggle is off. -->
    <?php if ( $upsell_show && ( $upsell_headline || $upsell_subhead || $upsell_body ) ) : ?>
        <section class="svc-thank-you-upsell" aria-labelledby="svcThankYouUpsellHeading">
            <div class="svc-thank-you-upsell-inner">
                <div class="svc-thank-you-upsell-grid">

                    <div class="svc-thank-you-upsell-copy">
                        <?php if ( $upsell_eyebrow ) : ?>
                            <span class="svc-thank-you-upsell-eyebrow"><?php echo esc_html( $upsell_eyebrow ); ?></span>
                        <?php endif; ?>
                        <?php if ( $upsell_headline ) : ?>
                            <h2 id="svcThankYouUpsellHeading" class="svc-thank-you-upsell-headline"><?php echo esc_html( $upsell_headline ); ?></h2>
                        <?php endif; ?>
                        <?php if ( $upsell_subhead ) : ?>
                            <p class="svc-thank-you-upsell-subhead"><?php echo esc_html( $upsell_subhead ); ?></p>
                        <?php endif; ?>
                        <?php if ( $upsell_body ) : ?>
                            <p class="svc-thank-you-upsell-body"><?php echo esc_html( $upsell_body ); ?></p>
                        <?php endif; ?>
                        <?php if ( $upsell_cta_lbl && $upsell_cta_url ) : ?>
                            <div class="svc-thank-you-upsell-cta-wrap">
                                <a class="svc-thank-you-upsell-cta" href="<?php echo esc_url( $upsell_cta_url ); ?>">
                                    <?php echo esc_html( $upsell_cta_lbl ); ?>
                                </a>
                                <?php if ( $upsell_footnote ) : ?>
                                    <p class="svc-thank-you-upsell-footnote"><?php echo esc_html( $upsell_footnote ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ( $upsell_image_id ) : ?>
                        <div class="svc-thank-you-upsell-media">
                            <?php echo wp_get_attachment_image( $upsell_image_id, 'large', false, array(
                                'class' => 'svc-thank-you-upsell-image',
                                'alt'   => esc_attr( $upsell_headline ),
                                'loading' => 'lazy',
                            ) ); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php
get_footer();
