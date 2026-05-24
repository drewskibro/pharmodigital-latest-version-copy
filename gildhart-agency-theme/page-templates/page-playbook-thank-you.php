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
</main>

<?php
get_footer();
