<?php
/**
 * Service: Real Lead Captured proof (Agent).
 *
 * A branded recreation of a genuine lead the agent captured — a
 * complex 10-country travel-vaccination enquiry with a Yellow Fever
 * routing decision, taken at 11:35pm while the practice was closed.
 * Lands right after the Intelligence Engine section: that section
 * argues "every question is a revenue signal," this shows one it caught.
 *
 * PRIVACY: this is a real patient's enquiry, so it is anonymised by
 * design — first name + initial only, and NO email or phone. The
 * clinical scenario (the persuasive part) is real; nothing here
 * identifies the individual. Do not add contact details to the ACF
 * fields or defaults.
 *
 * Recreated (not a raw screenshot) so it renders on-brand and keeps
 * the redaction under our control. Dark navy stage, light lead card:
 * practice header bar → AI summary → lead rows → gold stat strip,
 * with a closing kicker beneath.
 *
 * Reads from per-section ACF group `Service · Lead Proof`. Returns
 * early when the show toggle is off.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_lead_proof_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_lead_proof_eyebrow',  'One Real Lead. Captured At 11:35pm.' );
$headline = gh_field( 'service_lead_proof_headline', "Their Booking Calendar Couldn't Take This Enquiry. The Agent Did." );

$practice = gh_field( 'service_lead_proof_practice', 'Southdowns Pharmacy Group' );
$badge    = gh_field( 'service_lead_proof_badge',    'Captured 11:35pm' );
$summary  = gh_field( 'service_lead_proof_summary',  'User selected Travel Vaccinations. Travelling to Colombia, Peru, Bolivia, Chile, Argentina, Uruguay, Paraguay, Brazil, Panama and Costa Rica. Yellow Fever required, so directed to Bosmere Pharmacy. Also has children who will need vaccinations — to be booked separately.' );

$lead_name    = gh_field( 'service_lead_proof_name',    'Clare W.' );
$lead_service = gh_field( 'service_lead_proof_service', 'Travel Vaccinations — Colombia, Peru, Bolivia, Chile, Argentina, Uruguay, Paraguay, Brazil, Panama & Costa Rica' );
$lead_branch  = gh_field( 'service_lead_proof_branch',  'Bosmere Pharmacy, Havant' );

$stats = get_field( 'service_lead_proof_stats' );
if ( empty( $stats ) ) {
    $stats = array(
        array( 'value' => '£1,400', 'label' => 'Estimated vaccination value' ),
        array( 'value' => '11:35pm', 'label' => 'Captured after hours' ),
        array( 'value' => '10',      'label' => 'Countries in one trip' ),
        array( 'value' => '0',       'label' => 'Staff involved' ),
    );
}

$caption = gh_field( 'service_lead_proof_caption', 'A booking form asks for a date. This patient needed a conversation — ten countries, a Yellow Fever routing decision, and a follow-up for the children. The agent handled all of it and delivered a qualified £1,400 lead at 11:35pm, while the practice was closed.' );
?>

<section class="svc-lead" id="lead-proof">
    <div class="svc-lead-inner">
        <div class="svc-lead-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-lead-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-lead-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
        </div>

        <div class="svc-lead-card">
            <div class="svc-lead-card-top">
                <div class="svc-lead-card-top-text">
                    <?php if ( $practice ) : ?>
                        <span class="svc-lead-card-practice"><?php echo esc_html( $practice ); ?></span>
                    <?php endif; ?>
                    <span class="svc-lead-card-title">New Appointment Lead</span>
                </div>
                <?php if ( $badge ) : ?>
                    <span class="svc-lead-card-badge"><?php echo esc_html( $badge ); ?></span>
                <?php endif; ?>
            </div>

            <?php if ( $summary ) : ?>
                <div class="svc-lead-summary">
                    <span class="svc-lead-summary-label">AI Lead Summary</span>
                    <p class="svc-lead-summary-text"><?php echo esc_html( $summary ); ?></p>
                </div>
            <?php endif; ?>

            <div class="svc-lead-info">
                <span class="svc-lead-info-label">Lead Information</span>
                <?php if ( $lead_name ) : ?>
                    <div class="svc-lead-row">
                        <span class="svc-lead-row-key">Name</span>
                        <span class="svc-lead-row-val"><?php echo esc_html( $lead_name ); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ( $lead_service ) : ?>
                    <div class="svc-lead-row">
                        <span class="svc-lead-row-key">Service Requested</span>
                        <span class="svc-lead-row-val"><?php echo esc_html( $lead_service ); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ( $lead_branch ) : ?>
                    <div class="svc-lead-row">
                        <span class="svc-lead-row-key">Branch</span>
                        <span class="svc-lead-row-val svc-lead-row-val--pill"><?php echo esc_html( $lead_branch ); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ( ! empty( $stats ) ) : ?>
                <div class="svc-lead-stats">
                    <?php foreach ( $stats as $stat ) :
                        $value = $stat['value'] ?? '';
                        $label = $stat['label'] ?? '';
                        if ( ! $value && ! $label ) continue; ?>
                        <div class="svc-lead-stat">
                            <?php if ( $value ) : ?>
                                <span class="svc-lead-stat-value"><?php echo esc_html( $value ); ?></span>
                            <?php endif; ?>
                            <?php if ( $label ) : ?>
                                <span class="svc-lead-stat-label"><?php echo esc_html( $label ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( $caption ) : ?>
            <p class="svc-lead-kicker"><?php echo esc_html( $caption ); ?></p>
        <?php endif; ?>
    </div>
</section>
