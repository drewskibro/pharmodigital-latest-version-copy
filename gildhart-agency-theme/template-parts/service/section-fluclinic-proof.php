<?php
/**
 * Service: FluClinic2You AI-search proof section (Playbook).
 *
 * Dark navy proof beat that sits immediately before the Your Turn
 * checkout. A fresh, different-vertical result — corporate flu,
 * FluClinic2You ranked above Bupa & Boots in Google AI Overviews /
 * ChatGPT / Claude — reinforcing "this works in ANY specialism"
 * right before the buy decision.
 *
 * Structure: eyebrow → H2 → body paragraph → "It took four weeks."
 * gut-punch line → AI Overview screenshot (ACF image, hides when
 * empty) → closing line → three-stat bar (gold dividers on desktop,
 * stacked on mobile).
 *
 * Reads from per-section ACF group `Service · FluClinic Proof`.
 * Returns early when the show toggle is off.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_fluclinic_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_fluclinic_eyebrow',  'Eight Weeks. Three Platforms. One Independent Clinic.' );
$headline = gh_field( 'service_fluclinic_headline', 'FluClinic2You Now Outranks Bupa and Boots for Corporate Flu.' );
$body     = gh_field( 'service_fluclinic_body',     'Not in traditional search. In Google AI Overviews, ChatGPT, and Claude simultaneously. When a business searches "best corporate flu provider" — FluClinic2You is the answer AI gives them. Above Bupa. Above Boots. Above every corporate health conglomerate with a marketing budget that dwarfs anything an independent clinic could match.' );
$punch    = gh_field( 'service_fluclinic_punch',    'It took eight weeks.' );
$closing  = gh_field( 'service_fluclinic_closing',  'This isn\'t a pharmacy story. This isn\'t a travel clinic story. Whatever your specialism — whatever national chain sits above you right now — this is what eight weeks looks like.' );

$screenshot_id = (int) get_field( 'fluclinic_gai_screenshot' );
$mobile_id     = (int) get_field( 'fluclinic_gai_mobile' );

// Testimonial block — sits between the AI Overview screenshot and the
// closing line. Anonymised photo optional (renders when set).
$tst_show  = gh_field( 'service_fluclinic_tst_show', 1 );
$tst_quote = gh_field( 'service_fluclinic_tst_quote', "We're now showing up above Boots and Bupa when companies search for corporate flu providers. We've had enquiries from businesses we'd never spoken to — some of them sizeable contracts. We'd tried other things before this and nothing moved like it did. Eight weeks in and we'd already landed some of the biggest contracts we've ever had. It's still growing." );
$tst_name  = gh_field( 'service_fluclinic_tst_name',  'Paras' );
$tst_role  = gh_field( 'service_fluclinic_tst_role',  'Founder, FluClinic2You' );
$tst_photo = (int) get_field( 'service_fluclinic_tst_photo' );

// One-line reinforcement immediately above the stat bar.
$prestats  = gh_field( 'service_fluclinic_prestats', 'Not just in AI search. Top of Google too. Same keyword. Same competitors. Same result.' );

$stats = get_field( 'service_fluclinic_stats' );
if ( empty( $stats ) ) {
    $stats = array(
        array( 'value' => '8',  'label' => 'Weeks to outrank Bupa and Boots' ),
        array( 'value' => '3',  'label' => 'AI platforms simultaneously' ),
        array( 'value' => '#1', 'label' => 'Google AI Overview' ),
    );
}
?>

<section class="svc-fcp<?php echo $mobile_id ? ' svc-fcp--has-mobile' : ''; ?>" id="fluclinic-proof">
    <div class="svc-fcp-inner">
        <?php if ( $eyebrow ) : ?>
            <p class="svc-fcp-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
        <?php endif; ?>
        <?php if ( $headline ) : ?>
            <h2 class="svc-fcp-headline"><?php echo esc_html( $headline ); ?></h2>
        <?php endif; ?>
        <?php if ( $body ) : ?>
            <p class="svc-fcp-body"><?php echo esc_html( $body ); ?></p>
        <?php endif; ?>
        <?php if ( $punch ) : ?>
            <p class="svc-fcp-punch"><?php echo esc_html( $punch ); ?></p>
        <?php endif; ?>

        <?php if ( $screenshot_id ) : ?>
            <figure class="svc-fcp-figure svc-fcp-figure--desktop">
                <?php echo wp_get_attachment_image( $screenshot_id, 'large', false, array(
                    'class'   => 'svc-fcp-image',
                    'alt'     => esc_attr( $headline ),
                    'loading' => 'lazy',
                ) ); ?>
            </figure>
        <?php endif; ?>

        <?php if ( $mobile_id ) : ?>
            <figure class="svc-fcp-figure svc-fcp-figure--mobile">
                <?php echo wp_get_attachment_image( $mobile_id, 'large', false, array(
                    'class'   => 'svc-fcp-image',
                    'alt'     => esc_attr( $headline ),
                    'loading' => 'lazy',
                ) ); ?>
            </figure>
        <?php endif; ?>

        <?php if ( $tst_show && $tst_quote ) : ?>
            <figure class="svc-fcp-tst">
                <div class="svc-fcp-tst-stars" aria-hidden="true">
                    <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                </div>
                <blockquote class="svc-fcp-tst-quote"><?php echo esc_html( $tst_quote ); ?></blockquote>
                <?php if ( $tst_name || $tst_role ) : ?>
                    <figcaption class="svc-fcp-tst-cite">
                        <?php if ( $tst_photo ) : ?>
                            <span class="svc-fcp-tst-photo">
                                <?php echo wp_get_attachment_image( $tst_photo, 'thumbnail', false, array(
                                    'alt'     => esc_attr( $tst_name ),
                                    'loading' => 'lazy',
                                ) ); ?>
                            </span>
                        <?php endif; ?>
                        <span class="svc-fcp-tst-meta">
                            <?php if ( $tst_name ) : ?>
                                <span class="svc-fcp-tst-name"><?php echo esc_html( $tst_name ); ?></span>
                            <?php endif; ?>
                            <?php if ( $tst_role ) : ?>
                                <span class="svc-fcp-tst-role"><?php echo esc_html( $tst_role ); ?></span>
                            <?php endif; ?>
                        </span>
                    </figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <?php if ( $closing ) : ?>
            <p class="svc-fcp-closing"><?php echo esc_html( $closing ); ?></p>
        <?php endif; ?>

        <?php if ( $prestats ) : ?>
            <p class="svc-fcp-prestats"><?php echo esc_html( $prestats ); ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $stats ) ) : ?>
            <div class="svc-fcp-stats">
                <?php foreach ( $stats as $stat ) :
                    $value = $stat['value'] ?? '';
                    $label = $stat['label'] ?? '';
                    if ( ! $value && ! $label ) continue; ?>
                    <div class="svc-fcp-stat">
                        <?php if ( $value ) : ?>
                            <span class="svc-fcp-stat-value"><?php echo esc_html( $value ); ?></span>
                        <?php endif; ?>
                        <?php if ( $label ) : ?>
                            <span class="svc-fcp-stat-label"><?php echo esc_html( $label ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
