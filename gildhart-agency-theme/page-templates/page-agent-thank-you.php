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
$video_url     = gh_field( 'agent_thank_you_video_url',  '' );
$video_eyebrow = gh_field( 'agent_thank_you_video_eyebrow', 'Welcome from Drew' );
$video_caption = gh_field( 'agent_thank_you_video_caption', 'A quick word from Drew — what happens next.' );
$video_embed   = '';
if ( $video_show && $video_url ) {
    $video_embed = wp_oembed_get( $video_url );
}

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
?>

<main id="main" class="site-main">
    <section class="svc-thank-you">
        <div class="svc-thank-you-inner">

            <!-- Confirmation hero -->
            <div class="svc-thank-you-hero">
                <div class="svc-thank-you-hero-check" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="4 12 10 18 20 6"/>
                    </svg>
                </div>

                <?php if ( $hero_title ) : ?>
                    <h1 class="svc-thank-you-hero-title"><?php echo esc_html( $hero_title ); ?></h1>
                <?php endif; ?>

                <p class="svc-thank-you-hero-line">
                    Your subscription to The Agent is active.
                </p>
                <p class="svc-thank-you-hero-line">
                    Confirmation sent to <strong data-personalise="email">your inbox</strong>.
                </p>
                <p class="svc-thank-you-hero-line">
                    <span data-personalise="plan_label">Your subscription</span>.
                </p>
                <?php if ( $hero_sub ) : ?>
                    <p class="svc-thank-you-hero-line svc-thank-you-hero-line--accent"><?php echo esc_html( $hero_sub ); ?></p>
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
                    <?php if ( $founder_name || $founder_role ) : ?>
                        <div class="svc-thank-you-founder-signoff-block">
                            <?php if ( $founder_photo ) : ?>
                                <?php echo wp_get_attachment_image( $founder_photo, 'thumbnail', false, array(
                                    'class' => 'svc-thank-you-founder-photo',
                                    'alt'   => esc_attr( $founder_name ),
                                ) ); ?>
                            <?php endif; ?>
                            <p class="svc-thank-you-founder-signoff">
                                &mdash; <?php echo esc_html( $founder_name ); ?>
                                <?php if ( $founder_role ) : ?>
                                    <br><span class="svc-thank-you-founder-role"><?php echo esc_html( $founder_role ); ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>
</main>

<?php
get_footer();
