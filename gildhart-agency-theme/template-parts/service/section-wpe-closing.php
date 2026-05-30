<?php
/**
 * Service: WebPro Elite — Closing CTA + Waitlist Form.
 *
 * Forest-green two-column section. Left: investment copy, scoped-pricing
 * block, and three trust items. Right: white waitlist form card with
 * Practice Name, Name, Email, Phone, Website, and Practice Type fields.
 *
 * Reads from per-section ACF group `Service · WPE Closing`. Returns
 * early when the show toggle is off.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_wpe_closing_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_wpe_closing_eyebrow', 'The Investment' );
$headline = gh_field( 'service_wpe_closing_headline', "Scoped To Your Practice.\nPriced To Pay For Itself." );
$body     = gh_field( 'service_wpe_closing_body', "WebPro Elite isn't a standard web package. Every build is scoped to your specific services, your market, and the AI search landscape you're competing in.\n\nOne fixed project fee. No retainer. No ongoing monthly charges. The website and the AI search infrastructure — both yours, forever." );

$pricing_eyebrow = gh_field( 'service_wpe_closing_pricing_eyebrow', 'Custom-Scoped Pricing' );
$pricing_detail  = gh_field( 'service_wpe_closing_pricing_detail',  'Every project is priced to your services, your market, and your timeline. We scope before we quote — no surprise costs, no scope creep.' );

$trust_items = get_field( 'service_wpe_closing_trust_items' );
if ( empty( $trust_items ) ) {
    $trust_items = array(
        'One fixed fee — no retainer, no monthly charges',
        'Typically recovers within the first 3–5 new patients',
        'GPhC-compliant build, hosted and supported for 12 months',
    );
}

$form_eyebrow = gh_field( 'service_wpe_closing_form_eyebrow', 'Join The Waitlist' );
$form_subhead = gh_field( 'service_wpe_closing_form_subhead', "We take on a limited number of builds per quarter. Tell us about your practice and we'll be in touch within 24 hours." );
$form_submit  = gh_field( 'service_wpe_closing_form_submit',  'Join The Waitlist' );
$form_note    = gh_field( 'service_wpe_closing_form_note',    "No commitment. We'll confirm your spot and scope the project together." );
$form_success_title = gh_field( 'service_wpe_closing_form_success_title', "You're on the waitlist." );
$form_success_body  = gh_field( 'service_wpe_closing_form_success_body',  "We'll be in touch within 24 hours to confirm your spot and scope the project together." );

$body_paras = array_values( array_filter( array_map( 'trim', preg_split( '/\r\n\r\n|\r\r|\n\n/', $body ) ) ) );
if ( empty( $body_paras ) && $body ) {
    $body_paras = array( $body );
}

if ( is_string( $trust_items ) ) {
    $trust_items = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $trust_items ) ) );
}

$headline_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $headline ) ) );
?>

<section class="svc-wpe-closing" id="contact">
    <div class="svc-wpe-closing-inner">

        <div class="svc-wpe-closing-left">
            <?php if ( $eyebrow ) : ?>
                <span class="svc-wpe-closing-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $headline_lines ) ) : ?>
                <h2 class="svc-wpe-closing-headline">
                    <?php foreach ( $headline_lines as $line ) : ?>
                        <span><?php echo esc_html( $line ); ?></span>
                    <?php endforeach; ?>
                </h2>
            <?php endif; ?>
            <?php foreach ( $body_paras as $para ) : ?>
                <p class="svc-wpe-closing-body"><?php echo esc_html( $para ); ?></p>
            <?php endforeach; ?>

            <?php if ( $pricing_eyebrow || $pricing_detail ) : ?>
                <div class="svc-wpe-closing-pricing">
                    <?php if ( $pricing_eyebrow ) : ?>
                        <p class="svc-wpe-closing-pricing-eyebrow"><?php echo esc_html( $pricing_eyebrow ); ?></p>
                    <?php endif; ?>
                    <?php if ( $pricing_detail ) : ?>
                        <p class="svc-wpe-closing-pricing-detail"><?php echo esc_html( $pricing_detail ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $trust_items ) ) : ?>
                <ul class="svc-wpe-closing-trust">
                    <?php foreach ( (array) $trust_items as $item ) :
                        $text = is_array( $item ) ? ( $item['text'] ?? '' ) : $item;
                        if ( ! $text ) {
                            continue;
                        } ?>
                        <li>
                            <span class="svc-wpe-closing-trust-icon" aria-hidden="true">✓</span>
                            <?php echo esc_html( $text ); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="svc-wpe-closing-right">
            <div class="svc-wpe-closing-form-card">
                <?php if ( $form_eyebrow ) : ?>
                    <p class="svc-wpe-closing-form-eyebrow"><?php echo esc_html( $form_eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $form_subhead ) : ?>
                    <p class="svc-wpe-closing-form-subhead"><?php echo esc_html( $form_subhead ); ?></p>
                <?php endif; ?>

                <form
                    class="svc-wpe-closing-form"
                    id="svcWpeWaitlistForm"
                    action=""
                    method="post"
                    novalidate
                    data-success-title="<?php echo esc_attr( $form_success_title ); ?>"
                    data-success-body="<?php echo esc_attr( $form_success_body ); ?>"
                >
                    <?php // Honeypot — hidden from real users, bots fill it. ?>
                    <div class="svc-wpe-closing-form-honeypot" aria-hidden="true">
                        <label for="svcWpeCompanyRole">Company role (leave blank)</label>
                        <input type="text" id="svcWpeCompanyRole" name="company_role" tabindex="-1" autocomplete="off" />
                    </div>

                    <div class="svc-wpe-closing-form-group">
                        <label class="svc-wpe-closing-form-label" for="svcWpePractice">Practice Name</label>
                        <input type="text" id="svcWpePractice" name="practice_name" class="svc-wpe-closing-form-input" placeholder="e.g. Superior Pharmacy" />
                    </div>
                    <div class="svc-wpe-closing-form-row">
                        <div class="svc-wpe-closing-form-group">
                            <label class="svc-wpe-closing-form-label" for="svcWpeFirstName">First Name</label>
                            <input type="text" id="svcWpeFirstName" name="first_name" class="svc-wpe-closing-form-input" placeholder="e.g. Sarah" />
                        </div>
                        <div class="svc-wpe-closing-form-group">
                            <label class="svc-wpe-closing-form-label" for="svcWpeLastName">Last Name</label>
                            <input type="text" id="svcWpeLastName" name="last_name" class="svc-wpe-closing-form-input" placeholder="e.g. Jones" />
                        </div>
                    </div>
                    <div class="svc-wpe-closing-form-group">
                        <label class="svc-wpe-closing-form-label" for="svcWpeEmail">Email</label>
                        <input type="email" id="svcWpeEmail" name="email" class="svc-wpe-closing-form-input" placeholder="hello@yourpractice.co.uk" />
                    </div>
                    <div class="svc-wpe-closing-form-group">
                        <label class="svc-wpe-closing-form-label" for="svcWpePhone">Phone</label>
                        <input type="tel" id="svcWpePhone" name="phone" class="svc-wpe-closing-form-input" placeholder="e.g. 020 7946 0958" />
                    </div>
                    <div class="svc-wpe-closing-form-group">
                        <label class="svc-wpe-closing-form-label" for="svcWpeWebsite">Current Website</label>
                        <input type="url" id="svcWpeWebsite" name="website" class="svc-wpe-closing-form-input" placeholder="https://yourpractice.co.uk" />
                    </div>
                    <div class="svc-wpe-closing-form-group">
                        <label class="svc-wpe-closing-form-label" for="svcWpePracticeType">Practice Type</label>
                        <select id="svcWpePracticeType" name="practice_type" class="svc-wpe-closing-form-select">
                            <option value="" disabled selected>Select your practice type</option>
                            <option value="pharmacy">Independent Pharmacy</option>
                            <option value="travel-clinic">Travel Clinic</option>
                            <option value="weight-loss">Weight Loss Clinic</option>
                            <option value="gp">Private GP / GP Practice</option>
                            <option value="aesthetics">Aesthetics Clinic</option>
                            <option value="other">Other Healthcare Practice</option>
                        </select>
                    </div>

                    <div id="svcWpeFormError" class="svc-wpe-closing-form-error" role="alert" hidden></div>

                    <?php if ( $form_submit ) : ?>
                        <button type="submit" class="svc-wpe-closing-form-submit">
                            <?php echo esc_html( $form_submit ); ?>
                            <span aria-hidden="true">→</span>
                        </button>
                    <?php endif; ?>

                    <?php if ( $form_note ) : ?>
                        <p class="svc-wpe-closing-form-note"><?php echo esc_html( $form_note ); ?></p>
                    <?php endif; ?>

                </form>
            </div>
        </div>

    </div>
</section>
