<?php
/**
 * Service: Hero section.
 *
 * Two-column hero — content (eyebrow, title, subtitle, stats row, dual CTAs)
 * left, image right. Stats row separates the headline lockup from the CTAs
 * with a hairline divider. Mobile drops the image and stacks the stats.
 *
 * Renders inside the Flexible Content loop (have_rows('service_sections'))
 * so all field reads use gh_sub_field() / get_sub_field(). Falls back to
 * The Playbook copy from the static spec when ACF sub-fields are empty so
 * a freshly published service entry renders complete with no manual data.
 *
 * @package Gildhart
 */

$eyebrow  = gh_sub_field( 'eyebrow',  'The AI Search Playbook' );
$title    = gh_sub_field( 'title',    "While You're Reading This, ChatGPT Is Recommending Your Competitors." );
$subtitle = gh_sub_field( 'subtitle', 'Rahul at Puri Pharmacy is now on that shortlist. So is Raman at Superior Pharmacy and Sachin at Ealing Travel Clinic. One playbook. Three practices. No ad spend.' );

$stats = get_sub_field( 'stats' );
if ( empty( $stats ) ) {
    $stats = array(
        array( 'number' => '300%',  'label' => 'Ealing Travel Clinic revenue growth' ),
        array( 'number' => '50%',   'label' => 'Superior Pharmacy sales from ChatGPT' ),
        array( 'number' => '£100k', 'label' => 'Puri Pharmacy from Mounjaro alone' ),
    );
}

$cta_primary_label   = gh_sub_field( 'cta_primary_label',   'Get The Playbook — £497' );
$cta_primary_url     = gh_sub_field( 'cta_primary_url',     '#buy-now' );
$cta_secondary_label = gh_sub_field( 'cta_secondary_label', "See What's Inside" );
$cta_secondary_url   = gh_sub_field( 'cta_secondary_url',   '#what-you-get' );

$image_id = get_sub_field( 'image' );
?>

<section class="svc-hero">
    <div class="svc-hero-inner">
        <div class="svc-hero-content">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-hero-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>

            <?php if ( $title ) : ?>
                <h1 class="svc-hero-title"><?php echo esc_html( $title ); ?></h1>
            <?php endif; ?>

            <?php if ( $subtitle ) : ?>
                <p class="svc-hero-subtitle"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $stats ) ) : ?>
                <div class="svc-hero-stats">
                    <?php foreach ( $stats as $stat ) :
                        $num = $stat['number'] ?? '';
                        $lbl = $stat['label']  ?? '';
                        if ( ! $num && ! $lbl ) continue; ?>
                        <div class="svc-hero-stat">
                            <?php if ( $num ) : ?>
                                <div class="svc-hero-stat-num"><?php echo esc_html( $num ); ?></div>
                            <?php endif; ?>
                            <?php if ( $lbl ) : ?>
                                <div class="svc-hero-stat-label"><?php echo esc_html( $lbl ); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( $cta_primary_label || $cta_secondary_label ) : ?>
                <div class="svc-hero-cta">
                    <?php if ( $cta_primary_label ) : ?>
                        <a href="<?php echo esc_url( $cta_primary_url ); ?>" class="svc-btn svc-btn-primary">
                            <?php echo esc_html( $cta_primary_label ); ?>
                            <span class="svc-btn-arrow" aria-hidden="true">→</span>
                        </a>
                    <?php endif; ?>
                    <?php if ( $cta_secondary_label ) : ?>
                        <a href="<?php echo esc_url( $cta_secondary_url ); ?>" class="svc-btn svc-btn-outline">
                            <?php echo esc_html( $cta_secondary_label ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( $image_id ) : ?>
            <div class="svc-hero-image">
                <?php echo wp_get_attachment_image( $image_id, 'large', false, array(
                    'alt'     => esc_attr( $title ),
                    'loading' => 'eager',
                ) ); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
