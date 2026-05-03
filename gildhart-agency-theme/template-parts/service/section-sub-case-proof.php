<?php
/**
 * Service: Sub-case Proof section (Search Console screenshots).
 *
 * Cream section directly below "What You Get" — proves the system with
 * raw Google Search Console screenshots. 2-column card grid, each card
 * = fixed-height image + a caption block (gold-dot + name, result with
 * inline <strong>, mono data line). Footer mono caps line below.
 *
 * Reads from per-section ACF group `Service · Sub-case Proof`. Returns
 * early when the show toggle is off. Falls back to The Playbook copy
 * from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_sub_case_show', 1 ) ) {
    return;
}

$eyebrow     = gh_field( 'service_sub_case_eyebrow',     'The Proof' );
$headline    = gh_field( 'service_sub_case_headline',    'Real Traffic. Real Results. Real Data.' );
$subheadline = gh_field( 'service_sub_case_subheadline', 'Google Search Console screenshots from clients who used this system.' );
$footer      = gh_field( 'service_sub_case_footer',      'Verified Search Console data. No invented numbers. Just results.' );

$cards = get_field( 'service_sub_case_cards' );
if ( empty( $cards ) ) {
    $cards = array(
        array(
            'name'   => 'Ealing Travel Clinic',
            'image'  => 0,
            'result' => 'Outranked Boots & Superdrug. <strong>300% revenue growth</strong> in 3 months from organic search alone.',
            'data'   => '5.93K clicks · 1.07M impressions · 3 months',
        ),
        array(
            'name'   => 'Miles Clinic',
            'image'  => 0,
            'result' => 'Record-breaking revenue. <strong>Four-figure months</strong> from organic search alone — zero ad spend.',
            'data'   => '82.1K clicks · 14.5M impressions',
        ),
    );
}
?>

<section class="svc-sc-proof">
    <div class="svc-sc-proof-inner">
        <div class="svc-sc-proof-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-sc-proof-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-sc-proof-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $subheadline ) : ?>
                <p class="svc-sc-proof-subheadline"><?php echo esc_html( $subheadline ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $cards ) ) : ?>
            <div class="svc-sc-proof-grid">
                <?php foreach ( $cards as $card ) :
                    $name     = $card['name']   ?? '';
                    $image_id = $card['image']  ?? 0;
                    $result   = $card['result'] ?? '';
                    $data_ln  = $card['data']   ?? '';
                ?>
                    <article class="svc-sc-proof-card">
                        <div class="svc-sc-proof-img-wrap">
                            <?php if ( $image_id ) : ?>
                                <?php echo wp_get_attachment_image( $image_id, 'large', false, array(
                                    'class'   => 'svc-sc-proof-img',
                                    'alt'     => esc_attr( $name . ' — Google Search Console results' ),
                                    'loading' => 'lazy',
                                ) ); ?>
                            <?php else : ?>
                                <div class="svc-sc-proof-img-placeholder" aria-hidden="true">
                                    <span>Insert <?php echo esc_html( $name ?: 'Search Console' ); ?> Screenshot</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="svc-sc-proof-caption">
                            <?php if ( $name ) : ?>
                                <div class="svc-sc-proof-caption-header">
                                    <span class="svc-sc-proof-dot" aria-hidden="true"></span>
                                    <span class="svc-sc-proof-caption-name"><?php echo esc_html( $name ); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ( $result ) : ?>
                                <p class="svc-sc-proof-caption-result"><?php echo wp_kses_post( $result ); ?></p>
                            <?php endif; ?>
                            <?php if ( $data_ln ) : ?>
                                <p class="svc-sc-proof-caption-data"><?php echo esc_html( $data_ln ); ?></p>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $footer ) : ?>
            <div class="svc-sc-proof-footer">
                <p><?php echo esc_html( $footer ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
