<?php
/**
 * Service: Playbook Checkout section.
 *
 * Standalone payment section that sits after the Offer block on the
 * Playbook page. Two columns on desktop, single column on mobile,
 * over the hero's cream/peach/mint gradient.
 *
 * Architecture mirrors the Agent page's closing-offer section but
 * with Playbook-specific content and a simpler price model (one-time
 * £995 vs the Agent's monthly/annual toggle). Reuses the Agent's
 * .svc-closing-* classes for shared components (testimonial card,
 * form fields, submit button, secure note, joining note) so the
 * visual treatment stays in lockstep without CSS duplication. Adds
 * .svc-pb-checkout-* classes only for unique elements (section
 * wrapper, 2-col grid, intro block, gold-check checklist, pricing
 * card, left + right closer lines).
 *
 * Desktop layout:
 *   ┌──────────────┬───────────────┐
 *   │ intro        │               │
 *   ├──────────────┤   pricing +   │
 *   │ checklist    │   form +      │
 *   ├──────────────┤   right       │
 *   │ testimonials │   closer +    │
 *   ├──────────────┤   CTA +       │
 *   │ left-closer  │   notes       │
 *   └──────────────┴───────────────┘
 *
 * Mobile order:
 *   intro → checklist → left-closer → pricing → form → right-closer →
 *   CTA → notes → testimonials.
 *
 * The form is rendered as static HTML — Stripe integration is out of
 * scope. The submit no-ops until backend wiring is added.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_pb_checkout_show', 1 ) ) {
    return;
}

/* Left column — intro */
$eyebrow  = gh_field( 'service_pb_checkout_eyebrow',  'Your Turn' );
$headline = gh_field( 'service_pb_checkout_headline', 'Ealing Spent £995. Then Generated £100k From One Service.' );
$body     = gh_field( 'service_pb_checkout_body',     "Every month you pay for marketing. Every month the results are someone else's to switch off. This is different. One purchase. One system. Yours forever." );

/* Left column — checklist (gold ✓) */
$checklist = get_field( 'service_pb_checkout_checklist' );
if ( empty( $checklist ) ) {
    $checklist = array(
        array( 'text' => 'The exact content architecture that got Ealing to #1 in Google AI Overviews — copy-paste ready.' ),
        array( 'text' => "Every Claude Skill we use across 50+ practices — built, tested, yours in minutes." ),
        array( 'text' => 'Pre-built healthcare knowledge base — installed into Cowork before you start. GPhC, GMC, GDC, and CQC compliant.' ),
        array( 'text' => 'Monthly strategy calls — so your system evolves as AI platforms evolve.' ),
        array( 'text' => 'Lifetime access — deploy across one practice or fifty, no extra cost.' ),
        array( 'text' => "Personal implementation guarantee — go through the system, follow the steps, and if you're still stuck I'll personally walk you through it one-on-one." ),
    );
}

/* Left column — bold closer line under checklist */
$left_closer = gh_field( 'service_pb_checkout_left_closer', 'Ealing did it. Superior did it. Puri did it. National chains spent millions. They spent £995.' );

/* Left column — testimonials */
$testimonials = get_field( 'service_pb_checkout_testimonials' );
if ( empty( $testimonials ) ) {
    $testimonials = array(
        array(
            'quote'  => 'We went live and within a couple of days patients were booking HPV appointments through it at night. The diary was full in three weeks.',
            'name'   => 'Sachin Mehta',
            'role'   => 'Founder, Ealing Travel Clinic',
            'metric' => '55+ bookings per month',
            'avatar' => 0,
        ),
        array(
            'quote'  => "Drew builds pharmacy growth engines. I trust him because he understands both pharmacy and digital — that's rare to find.",
            'name'   => 'Rahul Puri',
            'role'   => 'Founder, Puri Pharmacy',
            'metric' => '£100k from Mounjaro alone',
            'avatar' => 0,
        ),
        array(
            'quote'  => "I've been working with Drew since 2018. He's had a helping hand in growing our pharmacy group, and he's had a direct impact on growing our private service revenue.",
            'name'   => 'Samit Patel',
            'role'   => 'Founder, Miles Pharmacy Group',
            'metric' => 'Since 2018',
            'avatar' => 0,
        ),
    );
}

/* Right column — pricing card */
$card_label   = gh_field( 'service_pb_checkout_card_label',   'The AI Search Playbook' );
$card_price   = gh_field( 'service_pb_checkout_card_price',   '£995' );
$card_suffix  = gh_field( 'service_pb_checkout_card_suffix',  'one-time · lifetime access' );
$card_feature = gh_field( 'service_pb_checkout_card_feature', 'The exact system that put independent pharmacies and clinics above Boots, Superdrug, and NHS.uk in AI search. Yours forever. Starts working this week.' );

/* Left column — hero image (between body and checklist). Lives inside
 * the intro block as the last child so the grid-template-areas layout
 * doesn't need a new row (which would render an empty 3rem gap when
 * no image is uploaded). */
$hero_image_id = (int) get_field( 'your_turn_hero_image' );

/* Right column — form */
$right_closer = gh_field( 'service_pb_checkout_right_closer', '£995. One time. Ealing spent it. Then made £198,000 from one service.' );
$cta_label    = gh_field( 'service_pb_checkout_cta_label',    'Continue to Payment' );
$secure_note  = gh_field( 'service_pb_checkout_secure_note',  'Payments processed securely via Stripe.' );
$joining_note = gh_field( 'service_pb_checkout_joining_note', "Every practice that's live right now started exactly where you are." );
?>

<section class="svc-pb-checkout" id="your-turn">
    <?php // Legacy anchor alias: several CTAs (hero, problem-shift strip, FAQ)
          // still target #buy-now from saved ACF values. This makes that
          // anchor land on the Your Turn section so they all work without
          // touching the saved data. ?>
    <span id="buy-now" class="svc-pb-checkout-anchor" aria-hidden="true"></span>
    <div class="svc-pb-checkout-inner">

        <!-- ─── Intro (left, top) ─── -->
        <div class="svc-pb-checkout-intro">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-pb-checkout-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-pb-checkout-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $body ) : ?>
                <p class="svc-pb-checkout-body"><?php echo esc_html( $body ); ?></p>
            <?php endif; ?>
            <?php if ( $hero_image_id ) : ?>
                <figure class="svc-pb-checkout-hero-image">
                    <?php
                    $hero_alt = trim( (string) get_post_meta( $hero_image_id, '_wp_attachment_image_alt', true ) );
                    if ( '' === $hero_alt ) {
                        $hero_alt = $headline ?: 'AI Search Playbook for Healthcare';
                    }
                    echo wp_get_attachment_image( $hero_image_id, 'full', false, array(
                        'alt'     => esc_attr( $hero_alt ),
                        'loading' => 'lazy',
                    ) ); ?>
                </figure>
            <?php endif; ?>
        </div>

        <!-- ─── Checklist (left) ─── -->
        <?php if ( ! empty( $checklist ) ) : ?>
            <ul class="svc-pb-checkout-checklist">
                <?php foreach ( $checklist as $item ) :
                    $text = $item['text'] ?? '';
                    if ( ! $text ) continue; ?>
                    <li>
                        <span class="svc-pb-checkout-check" aria-hidden="true">✓</span>
                        <span class="svc-pb-checkout-check-text"><?php echo wp_kses_post( $text ); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- ─── Testimonials (left, below checklist on desktop) ─── -->
        <?php if ( ! empty( $testimonials ) ) : ?>
            <div class="svc-pb-checkout-testimonials">
                <?php foreach ( $testimonials as $t ) :
                    $quote     = $t['quote']  ?? '';
                    $name      = $t['name']   ?? '';
                    $role      = $t['role']   ?? '';
                    $metric    = $t['metric'] ?? '';
                    $avatar_id = (int) ( $t['avatar'] ?? 0 );
                    if ( ! $quote && ! $name ) continue;
                    $initial = $name ? strtoupper( mb_substr( trim( $name ), 0, 1 ) ) : ''; ?>
                    <article class="svc-closing-testimonial-card">
                        <?php if ( $quote ) : ?>
                            <p class="svc-closing-testimonial-quote">&ldquo;<?php echo esc_html( $quote ); ?>&rdquo;</p>
                        <?php endif; ?>
                        <div class="svc-closing-testimonial-footer">
                            <div class="svc-closing-testimonial-meta-row">
                                <?php if ( $avatar_id ) : ?>
                                    <?php echo wp_get_attachment_image( $avatar_id, 'thumbnail', false, array(
                                        'alt'   => esc_attr( $name ),
                                        'class' => 'svc-closing-testimonial-avatar',
                                    ) ); ?>
                                <?php elseif ( $initial ) : ?>
                                    <span class="svc-closing-testimonial-avatar svc-closing-testimonial-avatar--monogram" aria-hidden="true"><?php echo esc_html( $initial ); ?></span>
                                <?php endif; ?>
                                <div class="svc-closing-testimonial-meta">
                                    <?php if ( $name ) : ?>
                                        <span class="svc-closing-testimonial-name"><?php echo esc_html( $name ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $role ) : ?>
                                        <span class="svc-closing-testimonial-role"><?php echo esc_html( $role ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if ( $metric ) : ?>
                                <span class="svc-closing-testimonial-metric"><?php echo esc_html( $metric ); ?></span>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- ─── Left-column bold closer (desktop bottom-left, mobile after checklist) ─── -->
        <?php if ( $left_closer ) : ?>
            <p class="svc-pb-checkout-left-closer"><?php echo esc_html( $left_closer ); ?></p>
        <?php endif; ?>

        <!-- ─── Right column: pricing card + form + CTA + notes ─── -->
        <div class="svc-pb-checkout-right">

            <!-- Pricing card -->
            <div class="svc-pb-checkout-card">
                <?php if ( $card_label ) : ?>
                    <p class="svc-pb-checkout-card-label"><?php echo esc_html( $card_label ); ?></p>
                <?php endif; ?>
                <?php if ( $card_price ) : ?>
                    <p class="svc-pb-checkout-card-price"><?php echo esc_html( $card_price ); ?></p>
                <?php endif; ?>
                <?php if ( $card_suffix ) : ?>
                    <p class="svc-pb-checkout-card-suffix"><?php echo esc_html( $card_suffix ); ?></p>
                <?php endif; ?>
                <div class="svc-pb-checkout-card-divider" aria-hidden="true"></div>
                <?php if ( $card_feature ) : ?>
                    <p class="svc-pb-checkout-card-feature"><?php echo esc_html( $card_feature ); ?></p>
                <?php endif; ?>
            </div>

            <!-- Form (static — Stripe wiring out of scope) -->
            <form class="svc-closing-form svc-pb-checkout-form" id="svcPbCheckoutForm" action="" method="post" novalidate>
                <div class="svc-closing-form-group">
                    <label class="svc-closing-form-label" for="svcPbPractice">Practice Name</label>
                    <input type="text" id="svcPbPractice" name="practice" class="svc-closing-form-input" placeholder="e.g. Ealing Travel Clinic" />
                </div>
                <div class="svc-closing-form-row">
                    <div class="svc-closing-form-group">
                        <label class="svc-closing-form-label" for="svcPbFirstName">First Name</label>
                        <input type="text" id="svcPbFirstName" name="first_name" class="svc-closing-form-input" placeholder="e.g. Sarah" />
                    </div>
                    <div class="svc-closing-form-group">
                        <label class="svc-closing-form-label" for="svcPbLastName">Last Name</label>
                        <input type="text" id="svcPbLastName" name="last_name" class="svc-closing-form-input" placeholder="e.g. Jones" />
                    </div>
                </div>
                <div class="svc-closing-form-group">
                    <label class="svc-closing-form-label" for="svcPbEmail">Email</label>
                    <input type="email" id="svcPbEmail" name="email" class="svc-closing-form-input" placeholder="hello@yourpractice.co.uk" />
                </div>
                <div class="svc-closing-form-group">
                    <label class="svc-closing-form-label" for="svcPbWebsite">Website URL</label>
                    <input type="url" id="svcPbWebsite" name="website" class="svc-closing-form-input" placeholder="https://yourpractice.co.uk" />
                </div>

                <div class="svc-closing-form-group svc-pb-services-group" data-services-multiselect>
                    <label class="svc-closing-form-label" for="svcPbServicesSearch">Which services do you want to dominate?</label>
                    <p class="svc-pb-services-subtext">Choose up to 5. We build your knowledge base around your selections.</p>

                    <div class="svc-pb-services-pills" data-services-pills role="list" aria-label="Selected services"></div>

                    <div class="svc-pb-services-input-wrap">
                        <input
                            type="text"
                            id="svcPbServicesSearch"
                            class="svc-closing-form-input svc-pb-services-search"
                            placeholder="Type to search services…"
                            autocomplete="off"
                            aria-haspopup="listbox"
                            aria-expanded="false"
                            aria-controls="svcPbServicesDropdown"
                        />
                        <div
                            class="svc-pb-services-dropdown"
                            id="svcPbServicesDropdown"
                            data-services-dropdown
                            role="listbox"
                            hidden
                        ></div>
                    </div>

                    <div class="svc-pb-services-custom" data-services-custom hidden>
                        <input
                            type="text"
                            class="svc-closing-form-input svc-pb-services-custom-input"
                            data-services-custom-input
                            placeholder="Type your service here"
                            aria-label="Custom service name"
                        />
                        <button type="button" class="svc-pb-services-custom-add" data-services-custom-add>Add</button>
                    </div>

                    <p class="svc-pb-services-max-msg" data-services-max-msg role="status">
                        You've selected 5 services. Remove one to make a change.
                    </p>

                    <input type="hidden" name="services" data-services-value value="" />

                    <button type="button" class="svc-pb-services-sheet-backdrop" data-services-sheet-close hidden aria-label="Close service selector"></button>
                </div>

                <div class="svc-pb-services-reassure">
                    <p class="svc-pb-services-reassure-eyebrow">Included in your onboarding</p>
                    <p class="svc-pb-services-reassure-text">Not sure? Make your best guess for now. During onboarding we'll research exactly what patients in your area are searching for across AI platforms — and we'll confirm or refine your selections based on real keyword data before we build anything.</p>
                </div>

                <?php
                // Card Payment section — hidden until Step 1 (lead form) succeeds.
                // playbook-checkout.js reveals it and mounts the Stripe Payment
                // Element after /playbook-checkout returns a client_secret.
                ?>
                <div class="svc-closing-form-group" id="svcPbPaymentSection" hidden>
                    <span class="svc-closing-form-label">Card Payment</span>
                    <div id="svcPbPaymentMount" class="svc-closing-payment-mount" aria-live="polite"></div>
                </div>
                <div id="svcPbFormError" class="svc-closing-form-error" role="alert" hidden></div>

                <?php if ( $right_closer ) : ?>
                    <p class="svc-pb-checkout-right-closer"><?php echo esc_html( $right_closer ); ?></p>
                <?php endif; ?>

                <?php if ( $cta_label ) : ?>
                    <button type="submit" class="svc-closing-form-submit">
                        <?php echo esc_html( $cta_label ); ?>
                        <span aria-hidden="true">→</span>
                    </button>
                <?php endif; ?>

                <?php if ( $secure_note ) : ?>
                    <p class="svc-closing-form-note">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        <?php echo esc_html( $secure_note ); ?>
                    </p>
                <?php endif; ?>
                <?php if ( $joining_note ) : ?>
                    <p class="svc-closing-joining-note"><?php echo esc_html( $joining_note ); ?></p>
                <?php endif; ?>
            </form>
        </div>

    </div>
</section>
