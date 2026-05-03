<?php
/**
 * Service: Guarantee section.
 *
 * Dark navy section centred on the page. A gold pill badge with a
 * shield SVG sits above the headline; below the body, three proof
 * cards in a row recap the marquee numbers; a personal-callout block
 * closes the section with the founder's promise.
 *
 * Reads from per-section ACF group `Service · Guarantee`. Returns
 * early when the show toggle is off. Falls back to The Playbook copy
 * from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_guarantee_show', 1 ) ) {
    return;
}

$badge_text   = gh_field( 'service_guarantee_badge_text', 'Personal Implementation Guarantee' );
$headline     = gh_field( 'service_guarantee_headline',   'If You Implement This, It Works' );
$body         = gh_field( 'service_guarantee_body',       "This isn't a promise. It's a documented fact. Three practices. Three different specialties. Same system. Same result." );

$proof = get_field( 'service_guarantee_proof' );
if ( empty( $proof ) ) {
    $proof = array(
        array( 'client' => 'Ealing Travel Clinic',  'stat' => '300%', 'desc' => '#1 in Google AI Overviews. Revenue growth in 3 months.' ),
        array( 'client' => 'Superior Pharmacy',     'stat' => '50%',  'desc' => 'Of all sales from ChatGPT. First sale in 48 hours from launch.' ),
        array( 'client' => 'South Downs Pharmacy',  'stat' => '100+', 'desc' => 'Monthly patients. 25% conversion rate. On autopilot.' ),
    );
}

$personal_text = gh_field( 'service_guarantee_personal_text', "Go through all 5 modules. Follow the system. If you still don't understand how to implement it, <strong>I'll personally walk you through it on a 1-on-1 call.</strong> You're not buying a course. You're getting a system that works — and I'll make sure you know how to use it." );
?>

<section class="svc-guarantee">
    <div class="svc-guarantee-inner">
        <?php if ( $badge_text ) : ?>
            <div class="svc-guarantee-badge">
                <span class="svc-guarantee-badge-icon" aria-hidden="true">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </span>
                <span class="svc-guarantee-badge-text"><?php echo esc_html( $badge_text ); ?></span>
            </div>
        <?php endif; ?>

        <?php if ( $headline ) : ?>
            <h2 class="svc-guarantee-headline"><?php echo esc_html( $headline ); ?></h2>
        <?php endif; ?>

        <?php if ( $body ) : ?>
            <p class="svc-guarantee-body"><?php echo esc_html( $body ); ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $proof ) ) : ?>
            <div class="svc-guarantee-proof-grid">
                <?php foreach ( $proof as $card ) :
                    $client = $card['client'] ?? '';
                    $stat   = $card['stat']   ?? '';
                    $desc   = $card['desc']   ?? '';
                    if ( ! $client && ! $stat && ! $desc ) continue; ?>
                    <article class="svc-guarantee-proof-card">
                        <?php if ( $client ) : ?>
                            <p class="svc-guarantee-proof-client"><?php echo esc_html( $client ); ?></p>
                        <?php endif; ?>
                        <?php if ( $stat ) : ?>
                            <p class="svc-guarantee-proof-stat"><?php echo esc_html( $stat ); ?></p>
                        <?php endif; ?>
                        <?php if ( $desc ) : ?>
                            <p class="svc-guarantee-proof-desc"><?php echo esc_html( $desc ); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $personal_text ) : ?>
            <div class="svc-guarantee-personal">
                <p class="svc-guarantee-personal-text"><?php echo wp_kses_post( $personal_text ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
