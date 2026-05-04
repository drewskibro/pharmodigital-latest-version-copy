<?php
/**
 * Service: Track Record (Guarantee) section.
 *
 * Cream-warm centred section. Cinematic typographic rhythm:
 *   - gold caps overline
 *   - staggered multi-line headline (each newline → its own block,
 *     last line bumps up as a crescendo)
 *   - intro paragraph (the deployment promise)
 *   - horizontal trio of proof points (gold caps client label + navy
 *     bold body line, separated by hairline rules above and below)
 *   - kicker line in italic navy with a gold-tinted top border —
 *     visually divorced from the intro
 *   - bold close stamp with a 60px centred gold underline accent
 *
 * Reads from per-section ACF group `Service · Track Record`. Returns
 * early when the show toggle is off. Falls back to The Agent copy
 * from the static spec when ACF fields are empty.
 *
 * Legacy: the `service_track_record_body` ACF field is deprecated as
 * of the cinematic redesign — it's no longer rendered. Existing copy
 * lives in the new intro + proofs + kicker fields.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_track_record_show', 1 ) ) {
    return;
}

$overline = gh_field( 'service_track_record_overline', 'The Track Record' );
$headline = gh_field( 'service_track_record_headline', "Last Tuesday. 9:47pm.\nSomeone landed on your website with a specific question about Mounjaro.\nYour website had nothing to say.\nSo they went back to Google. Found another practice. Booked. Paid.\nNever came back." );
$intro    = gh_field( 'service_track_record_intro',    "We have never deployed an agent that didn't find revenue a practice didn't know it was missing." );

$proofs = get_field( 'service_track_record_proofs' );
if ( empty( $proofs ) ) {
    $proofs = array(
        array( 'label' => 'Southdowns',   'text' => 'Found commercial needle stick contracts at midnight.' ),
        array( 'label' => 'Ealing',       'text' => 'Filled HPV slots that used to sit empty.' ),
        array( 'label' => 'Our network',  'text' => 'Not once have we deployed one that stayed quiet.' ),
    );
}

$kicker = gh_field( 'service_track_record_kicker', "That record matters to us more than anything else on this page. The practices already live aren't reading pages like this anymore. They're reading their booking confirmations." );
$close  = gh_field( 'service_track_record_close',  'Your practice will be no different.' );

$headline_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $headline ) ) );
?>

<section class="svc-track-record">
    <div class="svc-track-record-inner">
        <?php if ( $overline ) : ?>
            <span class="svc-track-record-overline"><?php echo esc_html( $overline ); ?></span>
        <?php endif; ?>

        <?php if ( ! empty( $headline_lines ) ) : ?>
            <h2 class="svc-track-record-headline">
                <?php foreach ( $headline_lines as $line ) : ?>
                    <span class="svc-track-record-headline-line"><?php echo esc_html( $line ); ?></span>
                <?php endforeach; ?>
            </h2>
        <?php endif; ?>

        <?php if ( $intro ) : ?>
            <p class="svc-track-record-intro"><?php echo wp_kses_post( $intro ); ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $proofs ) ) : ?>
            <div class="svc-track-record-proofs">
                <?php foreach ( $proofs as $proof ) :
                    $label = $proof['label'] ?? '';
                    $text  = $proof['text']  ?? '';
                    if ( ! $label && ! $text ) continue; ?>
                    <div class="svc-track-record-proof">
                        <?php if ( $label ) : ?>
                            <p class="svc-track-record-proof-label"><?php echo esc_html( $label ); ?></p>
                        <?php endif; ?>
                        <?php if ( $text ) : ?>
                            <p class="svc-track-record-proof-text"><?php echo esc_html( $text ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $kicker ) : ?>
            <p class="svc-track-record-kicker"><?php echo wp_kses_post( $kicker ); ?></p>
        <?php endif; ?>

        <?php if ( $close ) : ?>
            <p class="svc-track-record-close"><span><?php echo esc_html( $close ); ?></span></p>
        <?php endif; ?>
    </div>
</section>
