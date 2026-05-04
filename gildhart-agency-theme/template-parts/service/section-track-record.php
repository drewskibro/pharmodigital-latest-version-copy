<?php
/**
 * Service: Track Record (Guarantee) section.
 *
 * Cream-warm centred section with a gold caps overline, big H2,
 * supporting body, and a bold close line. Sits between Why This
 * Exists and the SalesAgent Pro section, anchoring the deployment
 * promise before the dark proof block begins.
 *
 * Reads from per-section ACF group `Service · Track Record`. Returns
 * early when the show toggle is off. Falls back to The Agent copy
 * from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_track_record_show', 1 ) ) {
    return;
}

$overline = gh_field( 'service_track_record_overline', 'The Track Record' );
$headline = gh_field( 'service_track_record_headline', '18 months. 100,000+ patient conversations. Every single practice wondered if it would work for them. It did.' );
$body     = gh_field( 'service_track_record_body',     "We have never deployed an agent that didn't find revenue a practice didn't know it was missing. Southdowns found commercial needle stick contracts at midnight. Ealing filled HPV slots that used to sit empty. Not once have we deployed one that stayed quiet. That record matters to us more than anything else on this page." );
$close    = gh_field( 'service_track_record_close',    'Your practice will be no different.' );
?>

<section class="svc-track-record">
    <div class="svc-track-record-inner">
        <?php if ( $overline ) : ?>
            <span class="svc-track-record-overline"><?php echo esc_html( $overline ); ?></span>
        <?php endif; ?>
        <?php if ( $headline ) : ?>
            <h2 class="svc-track-record-headline"><?php echo esc_html( $headline ); ?></h2>
        <?php endif; ?>
        <?php if ( $body ) : ?>
            <p class="svc-track-record-body"><?php echo wp_kses_post( $body ); ?></p>
        <?php endif; ?>
        <?php if ( $close ) : ?>
            <p class="svc-track-record-close"><?php echo esc_html( $close ); ?></p>
        <?php endif; ?>
    </div>
</section>
