<?php
/**
 * Template Name: WebPro Elite Thank-You
 *
 * Confirmation page for the WebPro Elite waitlist form. service.js
 * redirects here after the /gildhart/v1/wpe-waitlist endpoint returns
 * { ok: true }. Unlike the agent/playbook thank-you pages there is no
 * payment — this confirms a waitlist application, sets the "within 24
 * hours" expectation, and soft-cross-sells The AI Search Playbook as
 * the "while you wait" move.
 *
 * Reuses the .svc-thank-you-* component system verbatim (cream backdrop,
 * brand type, halos), so no new CSS is required. All copy reads from
 * gh_field() with baked-in defaults — register a `Service · WPE
 * Thank-you` ACF group later to override without touching this file.
 *
 * @package Gildhart
 */

get_header();

/* Hero confirmation */
$hero_eyebrow = gh_field( 'wpe_thank_you_hero_eyebrow', 'Application received' );
$hero_title   = gh_field( 'wpe_thank_you_hero_title',   "You're on the list." );
$hero_lead    = gh_field( 'wpe_thank_you_hero_lead',    'We review every WebPro Elite application personally — and we only take on a handful of builds each quarter.' );
$hero_status  = gh_field( 'wpe_thank_you_hero_status',  "You'll hear from us within 24 hours." );

/* Status card (right) — replaces the receipt card used on the paid pages. */
$card_eyebrow = gh_field( 'wpe_thank_you_card_eyebrow', 'Your application' );
$card_items   = get_field( 'wpe_thank_you_card_items' );
if ( empty( $card_items ) ) {
    $card_items = array(
        array( 'label' => 'Received',        'state' => 'done' ),
        array( 'label' => 'Under review',    'state' => 'active' ),
        array( 'label' => 'Scoping call',    'state' => 'pending' ),
    );
}

/* Timeline */
$timeline_eyebrow = gh_field( 'wpe_thank_you_timeline_eyebrow', 'What happens next' );
$timeline_items   = get_field( 'wpe_thank_you_timeline_items' );
if ( empty( $timeline_items ) ) {
    $timeline_items = array(
        array(
            'label' => 'Within 24 hours',
            'title' => 'We review your practice.',
            'body'  => 'We look at your services, your market, and the AI search landscape you\'re competing in — then come back to you personally.',
        ),
        array(
            'label' => 'This week',
            'title' => 'A short scoping call.',
            'body'  => '15 minutes, no pressure. We map exactly what your build needs and give you a fixed, scoped quote — no surprises, no scope creep.',
        ),
        array(
            'label' => 'Your timeline',
            'title' => 'The build begins.',
            'body'  => 'Once you\'re happy with scope, we start. Architected on Claude Code for AI search from the first line — the same engine behind Superior\'s £500k run rate.',
        ),
    );
}

/* Playbook cross-sell — the "while you wait" move for a lead who's
 * clearly invested in AI search. Image defaults to the Playbook service
 * post's hero so a single upload powers /the-playbook/ AND this upsell. */
$upsell_show     = gh_field( 'wpe_thank_you_upsell_show',     1 );
$upsell_eyebrow  = gh_field( 'wpe_thank_you_upsell_eyebrow',  'While you wait' );
$upsell_headline = gh_field( 'wpe_thank_you_upsell_headline', 'Get a Head Start on AI Search Today.' );
$upsell_body     = gh_field( 'wpe_thank_you_upsell_body',     'WebPro Elite builds the AI search infrastructure into your site. The AI Search Playbook is that same thinking, packaged as a system you can start using right now — the exact framework we use to get practices featured on ChatGPT, Claude, and Google AI Overviews. Put it to work while your build is scoped, and you\'ll be ahead before your site even goes live.' );
$upsell_cta_lbl  = gh_field( 'wpe_thank_you_upsell_cta_label', 'Explore The Playbook' );
$upsell_cta_url  = gh_field( 'wpe_thank_you_upsell_cta_url',   '/the-playbook/' );
$upsell_footnote = gh_field( 'wpe_thank_you_upsell_footnote',  'Owned forever. Start the same day.' );

$upsell_image_id = (int) get_field( 'wpe_thank_you_upsell_image' );
if ( ! $upsell_image_id ) {
    $playbook_post = get_page_by_path( 'the-playbook', OBJECT, 'service' );
    if ( $playbook_post ) {
        $upsell_image_id = (int) get_field( 'service_hero_image', $playbook_post->ID );
    }
}
?>

<main id="main" class="site-main">
    <section class="svc-thank-you">
        <div class="svc-thank-you-inner">

            <!-- Confirmation hero — left: confirmation message, right: a
                 status card (no receipt: this is a waitlist, not a purchase). -->
            <div class="svc-thank-you-hero">
                <div class="svc-thank-you-hero-grid">

                    <div class="svc-thank-you-hero-message">
                        <div class="svc-thank-you-hero-eyebrow-row">
                            <span class="svc-thank-you-hero-tick" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="4 12 10 18 20 6"/>
                                </svg>
                            </span>
                            <?php if ( $hero_eyebrow ) : ?>
                                <span class="svc-thank-you-hero-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if ( $hero_title ) : ?>
                            <h1 class="svc-thank-you-hero-title"><?php echo esc_html( $hero_title ); ?></h1>
                        <?php endif; ?>

                        <?php if ( $hero_lead ) : ?>
                            <p class="svc-thank-you-hero-lead"><?php echo esc_html( $hero_lead ); ?></p>
                        <?php endif; ?>
                    </div>

                    <aside class="svc-thank-you-receipt" aria-label="Application status">
                        <?php if ( $card_eyebrow ) : ?>
                            <span class="svc-thank-you-receipt-eyebrow"><?php echo esc_html( $card_eyebrow ); ?></span>
                        <?php endif; ?>

                        <dl class="svc-thank-you-receipt-list">
                            <?php foreach ( (array) $card_items as $ci ) :
                                $label = $ci['label'] ?? '';
                                $state = $ci['state'] ?? 'pending';
                                if ( ! $label ) {
                                    continue;
                                }
                                $mark = ( 'done' === $state ) ? '✓' : ( ( 'active' === $state ) ? '•' : '·' ); ?>
                                <div class="svc-thank-you-receipt-row">
                                    <dt><span aria-hidden="true" style="display:inline-block;width:1.25em;color:var(--gildhart-gold);font-weight:700;"><?php echo esc_html( $mark ); ?></span><?php echo esc_html( $label ); ?></dt>
                                    <dd><?php echo esc_html( ucfirst( $state ) ); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>

                        <p class="svc-thank-you-receipt-foot">
                            <svg class="svc-thank-you-receipt-foot-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            Reviewed personally · Limited builds per quarter
                        </p>
                    </aside>

                </div>

                <?php if ( $hero_status ) : ?>
                    <p class="svc-thank-you-hero-status" role="status">
                        <span class="svc-thank-you-hero-status-dot" aria-hidden="true"></span>
                        <span class="svc-thank-you-hero-status-text"><?php echo esc_html( $hero_status ); ?></span>
                    </p>
                <?php endif; ?>
            </div>

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
                            if ( ! $label && ! $title && ! $body ) {
                                continue;
                            } ?>
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

    <!-- Playbook cross-sell -->
    <?php if ( $upsell_show && ( $upsell_headline || $upsell_body ) ) : ?>
        <section class="svc-thank-you-upsell" aria-labelledby="svcWpeUpsellHeading">
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
                            <h2 id="svcWpeUpsellHeading" class="svc-thank-you-upsell-headline"><?php echo esc_html( $upsell_headline ); ?></h2>
                        <?php endif; ?>
                        <?php if ( $upsell_body ) : ?>
                            <p class="svc-thank-you-upsell-body"><?php echo esc_html( $upsell_body ); ?></p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

            <?php if ( $upsell_cta_lbl && $upsell_cta_url ) : ?>
                <div class="svc-thank-you-upsell-inner">
                    <div class="svc-thank-you-upsell-cta-wrap svc-thank-you-upsell-cta-wrap--centered">
                        <a class="svc-thank-you-upsell-cta" href="<?php echo esc_url( $upsell_cta_url ); ?>">
                            <?php echo esc_html( $upsell_cta_lbl ); ?> &rarr;
                        </a>
                        <?php if ( $upsell_footnote ) : ?>
                            <p class="svc-thank-you-upsell-footnote"><?php echo esc_html( $upsell_footnote ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</main>

<?php
get_footer();
