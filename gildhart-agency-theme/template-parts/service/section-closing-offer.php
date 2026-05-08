<?php
/**
 * Service: Closing Offer + Pricing section.
 *
 * Cream-warm closing section. Three top-level blocks:
 *
 *   1. Centred top header — gold overline, big H2, and a four-row
 *      copy block (regular paragraph → bordered "names" line → mid
 *      paragraph → bold punchline).
 *
 *   2. Two-column grid below (collapses to single column at <= 1024px,
 *      with a horizontal-scroll testimonial strip on tablet):
 *        Left:
 *          - Value Stack (gold caps label + tick-bullet list, items
 *            separated by hairlines).
 *          - Eligibility Bar (2 intro paragraphs + caps label + 2
 *            tick-bullet items).
 *          - Testimonials (caps label + 3 quote cards with avatar +
 *            name + role + gold metric pill).
 *        Right (sticky to nav-h + 100px):
 *          - Proof row (3 client stat columns).
 *          - Pricing card (promo eyebrow + Pay Monthly / Pay Upfront
 *            cards with "or" separator, the upfront card carries a
 *            "Most Popular" navy ribbon, a green save pill, a gold
 *            "fee waived" pill, a navy total bar, and a price-lock
 *            italic line).
 *          - Fee waiver callout (gold gradient panel — original
 *            amount strike-through + green "waived" badge + label
 *            + details).
 *          - Punchline italic.
 *          - Lead-capture form: 4 fields + Stripe placeholder + pull
 *            quote + bold close + submit + secure note + joining note.
 *
 * The form is rendered as plain HTML. Backend wiring (Stripe + lead
 * capture) is out of scope for this commit — the form's action is
 * empty so the submit no-ops until wired.
 *
 * Reads from per-section ACF group `Service · Closing Offer`.
 * Returns early when the show toggle is off. Falls back to The Agent
 * copy from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_closing_show', 1 ) ) {
    return;
}

/* Top header */
$overline    = gh_field( 'service_closing_overline',  'The Offer' );
$headline    = gh_field( 'service_closing_headline',  "For The First Time,\nBeing Independent Is The Advantage." );
$copy_intro  = gh_field( 'service_closing_copy_intro', "The big chains have procurement committees. Board approvals. Six-month technology cycles. By the time they deploy AI that actually works, your practice has been live for a year — capturing patients they can't reach, answering questions they can't respond to, and compounding revenue they'll never recover." );
$copy_names  = gh_field( 'service_closing_copy_names', 'Superior Pharmacy. Ealing Travel Clinic. Malvern Travel Clinic.' );
$copy_mid    = gh_field( 'service_closing_copy_mid',   'Independent practices now sitting at the top of their markets. Not because they outspent the chains. Because they outmoved them.' );
$copy_punch  = gh_field( 'service_closing_copy_punch', 'This is the technology that separates the top earning independents from everyone else. The practices already live know that. The ones still deciding are finding out.' );

/* Value stack (left) */
$stack_label = gh_field( 'service_closing_stack_label', "What's included" );
$stack_items = get_field( 'service_closing_stack_items' );
if ( empty( $stack_items ) ) {
    $stack_items = array(
        array( 'title' => 'Fully Branded AI Sales Agent',                 'desc' => "Your avatar, your colours, every service you offer. Patients think they're talking to your team." ),
        array( 'title' => 'Built, Tested & Live in 7 Days',               'desc' => 'We run hundreds of real patient scenarios before it touches your site. Bulletproof on day one.' ),
        array( 'title' => "Your Best Employee. Never Calls in Sick",       'desc' => 'While Sachin at Ealing Travel Clinic was seeing his last patient of the day, his agent had already booked three HPV appointments. By closing time, his diary was full.' ),
        array( 'title' => 'Full Conversation Transcripts & Intent Data',   'desc' => "Know exactly what patients ask, how they ask it, and what they're ready to pay for." ),
        array( 'title' => 'X-Ray Vision Into Your AI Traffic',             'desc' => 'We install Microsoft Clarity. See where your AI traffic comes from — Google, ChatGPT, Claude, Gemini — in real time.' ),
        array( 'title' => 'Authority That Compounds Monthly',              'desc' => 'Every conversation builds clinical authority. Every interaction sends trust signals to Google, ChatGPT, Claude, Bing, and Gemini. The agent gets more valuable every single month.' ),
    );
}

/* Eligibility bar */
$elig_intro1 = gh_field( 'service_closing_elig_intro1', "Most practices that come to us have the same concern. They're not sure if they're ready. They are." );
$elig_intro2 = gh_field( 'service_closing_elig_intro2', "Every practice we've deployed this for was live within a week. Every single one started generating enquiries they didn't have before." );
$elig_label  = gh_field( 'service_closing_elig_label',  'This was built for you if' );
$elig_items  = get_field( 'service_closing_elig_items' );
if ( empty( $elig_items ) ) {
    $elig_items = array(
        array( 'text' => 'You offer at least one private service — weight loss, travel health, private prescriptions, or similar.' ),
        array( 'text' => 'You have patients visiting your website who never make contact. Not because they changed their mind. Because nobody answered.' ),
    );
}

/* Testimonials (left) */
$test_label = gh_field( 'service_closing_test_label', 'From practices already live' );
$test_cards = get_field( 'service_closing_test_cards' );
if ( empty( $test_cards ) ) {
    $test_cards = array(
        array(
            'quote'  => "We went live and within a couple of days patients were booking HPV appointments through it at night. I'm thinking where were these people going before.",
            'name'   => 'Sachin Mehta',
            'role'   => 'Ealing Travel Clinic',
            'metric' => 'Diary full in 3 weeks',
            'avatar' => 0,
        ),
        array(
            'quote'  => "I didn't realise how many enquiries we were losing until it started catching them as patients are using it at all hours. We just see the bookings come in.",
            'name'   => 'Nemesh Patel',
            'role'   => 'Southdowns Pharmacy Group',
            'metric' => '£200k+ revenue',
            'avatar' => 0,
        ),
        array(
            'quote'  => "Half our weight loss sales come through it now. Mounjaro, Wegovy questions, eligibility checks etc. It handles all of it. I can see patients asking questions. It also really helped when we had an issue with our payment Gateway.",
            'name'   => 'Raman',
            'role'   => 'Superior Pharmacy',
            'metric' => '50% of sales via AI',
            'avatar' => 0,
        ),
    );
}

/* Proof row (right) */
$proof_cols = get_field( 'service_closing_proof_cols' );
if ( empty( $proof_cols ) ) {
    $proof_cols = array(
        array( 'client' => 'Southdowns Pharmacy', 'stat' => '£200k',       'label' => 'Annual revenue run rate from their AI agent. On track.' ),
        array( 'client' => 'Medihub Pharmacy',    'stat' => 'Weight Loss', 'label' => 'Generating consistent weight loss enquiries every day since launch.' ),
        array( 'client' => 'Raylane Group',       'stat' => 'Malvern',     'label' => "Part of one of the UK's largest travel clinic networks. The Agent deployed across their Malvern sites." ),
    );
}

/* Pricing */
$pricing_promo = gh_field( 'service_closing_pricing_promo', 'Choose Your Plan' );
$pricing_cards = get_field( 'service_closing_pricing_cards' );
if ( empty( $pricing_cards ) ) {
    $pricing_cards = array(
        array(
            'plan_id'      => 'monthly',
            'is_popular'   => 0,
            'badge'        => '',
            'label'        => 'Pay Monthly',
            'price'        => '£125',
            'price_suffix' => '/mo',
            'tax_note'     => '+ 20% VAT',
            'detail'       => 'For practices that want to start today and pay as they go. 12-month agreement. <strong>£1,500 setup fee waived</strong> — see below. The annual plan saves you £505, but the results are identical either way.',
            'save_green'   => '',
            'save_gold'    => '',
            'total'        => '',
            'price_lock'   => '',
        ),
        array(
            'plan_id'      => 'annual',
            'is_popular'   => 1,
            'badge'        => 'Most Popular',
            'label'        => 'Pay Upfront',
            'price'        => '£995',
            'price_suffix' => '',
            'tax_note'     => '+ 20% VAT',
            'detail'       => 'Full year',
            'save_green'   => 'Save £505 vs monthly',
            'save_gold'    => '£1,500 setup fee waived — online only',
            'total'        => 'Total saving: £2,005',
            'price_lock'   => 'As demand grows and pricing increases, you renew at £995. Always.',
        ),
    );
}

/* Fee waiver callout */
$waiver_show    = gh_field( 'service_closing_waiver_show',    1 );
$waiver_eyebrow = gh_field( 'service_closing_waiver_eyebrow', 'Online Activation Bonus' );
$waiver_amount  = gh_field( 'service_closing_waiver_amount',  '£1,500' );
$waiver_badge   = gh_field( 'service_closing_waiver_badge',   'Waived' );
$waiver_label   = gh_field( 'service_closing_waiver_label',   'Setup fee waived entirely.' );
$waiver_details = gh_field( 'service_closing_waiver_details', '<strong>No call needed.</strong> No onboarding queue. Deploys in 7 days. The decision is yours.' );

$punchline = gh_field( 'service_closing_punchline', 'One family travel booking covers the monthly plan for four months. One Mounjaro patient covers the annual plan entirely.' );

/* Form */
$pull_quote_text = gh_field( 'service_closing_pull_quote_text', 'Patients use it at all hours. We just see the bookings come in.' );
$pull_quote_attr = gh_field( 'service_closing_pull_quote_attr', '— Southdowns Pharmacy Group' );
$bold_close      = gh_field( 'service_closing_bold_close',      'The cost question answers itself. Usually within the first week.' );
$submit_label    = gh_field( 'service_closing_submit_label',    'Deploy The Agent' );
$secure_note     = gh_field( 'service_closing_secure_note',     'Payments processed securely via Stripe.' );
$joining_note    = gh_field( 'service_closing_joining_note',    'Joining 50+ practices across the UK, US, and beyond.' );

$headline_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $headline ) ) );
?>

<section class="svc-closing" id="eligibility">
    <div class="svc-closing-top">
        <?php if ( $overline ) : ?>
            <span class="svc-closing-overline"><?php echo esc_html( $overline ); ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $headline_lines ) ) : ?>
            <h2 class="svc-closing-headline">
                <?php echo implode( '<br />', array_map( 'esc_html', $headline_lines ) ); ?>
            </h2>
        <?php endif; ?>
        <?php if ( $copy_intro || $copy_names || $copy_mid || $copy_punch ) : ?>
            <div class="svc-closing-copy-block">
                <?php if ( $copy_intro ) : ?>
                    <p><?php echo esc_html( $copy_intro ); ?></p>
                <?php endif; ?>
                <?php if ( $copy_names ) : ?>
                    <p class="svc-closing-copy-names"><?php echo esc_html( $copy_names ); ?></p>
                <?php endif; ?>
                <?php if ( $copy_mid ) : ?>
                    <p><?php echo esc_html( $copy_mid ); ?></p>
                <?php endif; ?>
                <?php if ( $copy_punch ) : ?>
                    <p class="svc-closing-copy-punch"><?php echo esc_html( $copy_punch ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="svc-closing-inner">
        <div class="svc-closing-offer">
            <?php if ( ! empty( $stack_items ) ) : ?>
                <?php if ( $stack_label ) : ?>
                    <span class="svc-closing-stack-label"><?php echo esc_html( $stack_label ); ?></span>
                <?php endif; ?>
                <ul class="svc-closing-stack">
                    <?php foreach ( $stack_items as $item ) :
                        $title = $item['title'] ?? '';
                        $desc  = $item['desc']  ?? '';
                        if ( ! $title && ! $desc ) continue;
                        ?>
                        <li>
                            <span class="svc-closing-stack-icon" aria-hidden="true">✓</span>
                            <div class="svc-closing-stack-content">
                                <?php if ( $title ) : ?>
                                    <p class="svc-closing-stack-title"><?php echo esc_html( $title ); ?></p>
                                <?php endif; ?>
                                <?php if ( $desc ) : ?>
                                    <p class="svc-closing-stack-desc"><?php echo esc_html( $desc ); ?></p>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if ( $elig_intro1 || $elig_intro2 || ! empty( $elig_items ) ) : ?>
                <div class="svc-closing-elig-bar">
                    <?php if ( $elig_intro1 ) : ?>
                        <p class="svc-closing-elig-intro"><?php echo esc_html( $elig_intro1 ); ?></p>
                    <?php endif; ?>
                    <?php if ( $elig_intro2 ) : ?>
                        <p class="svc-closing-elig-intro"><?php echo esc_html( $elig_intro2 ); ?></p>
                    <?php endif; ?>
                    <?php if ( $elig_label ) : ?>
                        <span class="svc-closing-elig-bar-label"><?php echo esc_html( $elig_label ); ?></span>
                    <?php endif; ?>
                    <?php foreach ( (array) $elig_items as $item ) :
                        $text = $item['text'] ?? '';
                        if ( ! $text ) continue; ?>
                        <span class="svc-closing-elig-item"><?php echo esc_html( $text ); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $test_cards ) ) : ?>
                <div class="svc-closing-testimonials">
                    <?php if ( $test_label ) : ?>
                        <p class="svc-closing-testimonials-label"><?php echo esc_html( $test_label ); ?></p>
                    <?php endif; ?>
                    <?php foreach ( $test_cards as $card ) :
                        $quote     = $card['quote']  ?? '';
                        $name      = $card['name']   ?? '';
                        $role      = $card['role']   ?? '';
                        $metric    = $card['metric'] ?? '';
                        $avatar_id = $card['avatar'] ?? 0;
                        if ( ! $quote && ! $name ) continue; ?>
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
        </div>

        <div class="svc-closing-checkout-lane">
            <?php if ( ! empty( $proof_cols ) ) : ?>
                <div class="svc-closing-proof-row">
                    <?php foreach ( $proof_cols as $col ) :
                        $client = $col['client'] ?? '';
                        $stat   = $col['stat']   ?? '';
                        $label  = $col['label']  ?? '';
                        if ( ! $client && ! $stat ) continue; ?>
                        <div class="svc-closing-proof-col">
                            <?php if ( $client ) : ?>
                                <p class="svc-closing-proof-client"><?php echo esc_html( $client ); ?></p>
                            <?php endif; ?>
                            <?php if ( $stat ) : ?>
                                <p class="svc-closing-proof-stat"><?php echo esc_html( $stat ); ?></p>
                            <?php endif; ?>
                            <?php if ( $label ) : ?>
                                <p class="svc-closing-proof-label"><?php echo esc_html( $label ); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="svc-closing-pricing">
                <?php if ( $pricing_promo ) : ?>
                    <span class="svc-closing-promo"><?php echo esc_html( $pricing_promo ); ?></span>
                <?php endif; ?>

                <?php if ( ! empty( $pricing_cards ) ) : ?>
                    <div class="svc-closing-cards" role="radiogroup" aria-label="Choose a billing plan">
                        <?php $card_count = count( $pricing_cards ); foreach ( $pricing_cards as $i => $card ) :
                            $plan_id      = $card['plan_id']      ?? ( $i === 0 ? 'monthly' : 'annual' );
                            $is_popular   = ! empty( $card['is_popular'] );
                            $badge        = $card['badge']        ?? '';
                            $label        = $card['label']        ?? '';
                            $price        = $card['price']        ?? '';
                            $price_suffix = $card['price_suffix'] ?? '';
                            $tax_note     = $card['tax_note']     ?? '';
                            $detail       = $card['detail']       ?? '';
                            $save_green   = $card['save_green']   ?? '';
                            $save_gold    = $card['save_gold']    ?? '';
                            $total        = $card['total']        ?? '';
                            $price_lock   = $card['price_lock']   ?? '';
                            $card_class   = 'svc-closing-card' . ( $is_popular ? ' svc-closing-card--popular' : '' );
                        ?>
                            <button
                                type="button"
                                class="<?php echo esc_attr( $card_class ); ?>"
                                data-plan="<?php echo esc_attr( $plan_id ); ?>"
                                role="radio"
                                aria-checked="<?php echo $is_popular ? 'true' : 'false'; ?>"
                            >
                                <?php if ( $is_popular && $badge ) : ?>
                                    <span class="svc-closing-card-badge"><?php echo esc_html( $badge ); ?></span>
                                <?php endif; ?>
                                <span class="svc-closing-card-tick" aria-hidden="true">✓</span>
                                <?php if ( $label ) : ?>
                                    <p class="svc-closing-card-label"><?php echo esc_html( $label ); ?></p>
                                <?php endif; ?>
                                <?php if ( $price ) : ?>
                                    <p class="svc-closing-card-price">
                                        <?php echo esc_html( $price ); ?>
                                        <?php if ( $price_suffix ) : ?>
                                            <span class="svc-closing-card-price-suffix"><?php echo esc_html( $price_suffix ); ?></span>
                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ( $tax_note ) : ?>
                                    <p class="svc-closing-card-tax-note"><?php echo esc_html( $tax_note ); ?></p>
                                <?php endif; ?>
                                <?php if ( $detail ) : ?>
                                    <p class="svc-closing-card-detail"><?php echo wp_kses_post( $detail ); ?></p>
                                <?php endif; ?>
                                <?php if ( $save_green ) : ?>
                                    <span class="svc-closing-card-save"><?php echo esc_html( $save_green ); ?></span>
                                <?php endif; ?>
                                <?php if ( $save_gold ) : ?>
                                    <span class="svc-closing-card-save svc-closing-card-save--gold"><?php echo esc_html( $save_gold ); ?></span>
                                <?php endif; ?>
                                <?php if ( $total ) : ?>
                                    <p class="svc-closing-card-total"><?php echo esc_html( $total ); ?></p>
                                <?php endif; ?>
                                <?php if ( $price_lock ) : ?>
                                    <p class="svc-closing-card-price-lock"><?php echo esc_html( $price_lock ); ?></p>
                                <?php endif; ?>
                            </button>
                            <?php // "or" separator between adjacent cards on desktop. ?>
                            <?php if ( $i === 0 && $card_count > 1 ) : ?>
                                <span class="svc-closing-cards-or" aria-hidden="true">or</span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $waiver_show && ( $waiver_eyebrow || $waiver_amount || $waiver_label ) ) : ?>
                    <div class="svc-closing-waiver">
                        <?php if ( $waiver_eyebrow ) : ?>
                            <span class="svc-closing-waiver-eyebrow"><?php echo esc_html( $waiver_eyebrow ); ?></span>
                        <?php endif; ?>
                        <div class="svc-closing-waiver-amount-row">
                            <?php if ( $waiver_amount ) : ?>
                                <span class="svc-closing-waiver-amount"><?php echo esc_html( $waiver_amount ); ?></span>
                            <?php endif; ?>
                            <?php if ( $waiver_badge ) : ?>
                                <span class="svc-closing-waiver-badge"><span aria-hidden="true">✓</span> <?php echo esc_html( $waiver_badge ); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ( $waiver_label ) : ?>
                            <p class="svc-closing-waiver-label"><?php echo esc_html( $waiver_label ); ?></p>
                        <?php endif; ?>
                        <div class="svc-closing-waiver-divider" aria-hidden="true"></div>
                        <?php if ( $waiver_details ) : ?>
                            <p class="svc-closing-waiver-details"><?php echo wp_kses_post( $waiver_details ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $punchline ) : ?>
                    <p class="svc-closing-punchline"><?php echo esc_html( $punchline ); ?></p>
                <?php endif; ?>

                <div class="svc-closing-form-divider" aria-hidden="true"></div>

                <form class="svc-closing-form" action="" method="post" onsubmit="event.preventDefault();">
                    <input type="hidden" name="plan" id="svcClosingPlan" value="annual" />

                    <div class="svc-closing-form-group">
                        <label class="svc-closing-form-label" for="svcClosingPractice">Practice Name</label>
                        <input type="text" id="svcClosingPractice" name="practice" class="svc-closing-form-input" placeholder="e.g. Ealing Travel Clinic" />
                    </div>
                    <div class="svc-closing-form-row">
                        <div class="svc-closing-form-group">
                            <label class="svc-closing-form-label" for="svcClosingFirstName">First Name</label>
                            <input type="text" id="svcClosingFirstName" name="first_name" class="svc-closing-form-input" placeholder="e.g. Sarah" />
                        </div>
                        <div class="svc-closing-form-group">
                            <label class="svc-closing-form-label" for="svcClosingLastName">Last Name</label>
                            <input type="text" id="svcClosingLastName" name="last_name" class="svc-closing-form-input" placeholder="e.g. Jones" />
                        </div>
                    </div>
                    <div class="svc-closing-form-group">
                        <label class="svc-closing-form-label" for="svcClosingEmail">Email</label>
                        <input type="email" id="svcClosingEmail" name="email" class="svc-closing-form-input" placeholder="hello@yourpractice.co.uk" />
                    </div>
                    <div class="svc-closing-form-group">
                        <label class="svc-closing-form-label" for="svcClosingWebsite">Website URL</label>
                        <input type="url" id="svcClosingWebsite" name="website" class="svc-closing-form-input" placeholder="https://yourpractice.co.uk" />
                    </div>
                    <div class="svc-closing-form-group">
                        <span class="svc-closing-form-label">Card Payment</span>
                        <div class="svc-closing-stripe-placeholder" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            <span>Stripe payment fields load here</span>
                        </div>
                    </div>

                    <?php if ( $pull_quote_text || $pull_quote_attr ) : ?>
                        <div class="svc-closing-pull-quote">
                            <?php if ( $pull_quote_text ) : ?>
                                <p class="svc-closing-pull-quote-text">&ldquo;<?php echo esc_html( $pull_quote_text ); ?>&rdquo;</p>
                            <?php endif; ?>
                            <?php if ( $pull_quote_attr ) : ?>
                                <p class="svc-closing-pull-quote-attr"><?php echo esc_html( $pull_quote_attr ); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $bold_close ) : ?>
                        <p class="svc-closing-bold-close"><?php echo esc_html( $bold_close ); ?></p>
                    <?php endif; ?>

                    <?php if ( $submit_label ) : ?>
                        <button type="submit" class="svc-closing-form-submit">
                            <?php echo esc_html( $submit_label ); ?>
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
    </div>
</section>
