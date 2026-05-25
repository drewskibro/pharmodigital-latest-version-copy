<?php
/**
 * Service: Hero section.
 *
 * Two-column hero — content (eyebrow, title, subtitle, stats row, dual CTAs)
 * left, image right. Stats row separates the headline lockup from the CTAs
 * with a hairline divider. Mobile drops the image and stacks the stats.
 *
 * Reads from per-section ACF group `Service · Hero` registered against the
 * service CPT. Returns early when the show toggle is off. Falls back to The
 * Playbook copy from the static spec when ACF fields are empty so a freshly
 * published service entry renders complete with no manual data entry.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_hero_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_hero_eyebrow',  'The AI Search Playbook' );
$title    = gh_field( 'service_hero_title',    "While You're Reading This, ChatGPT Is Recommending Your Competitors." );
$subtitle = gh_field( 'service_hero_subtitle', 'Rahul at Puri Pharmacy is now on that shortlist. So is Raman at Superior Pharmacy and Sachin at Ealing Travel Clinic. One playbook. Three practices. No ad spend.' );

$stats = get_field( 'service_hero_stats' );
if ( empty( $stats ) ) {
    $stats = array(
        array( 'number' => '300%',  'label' => 'Ealing Travel Clinic revenue growth' ),
        array( 'number' => '50%',   'label' => 'Superior Pharmacy sales from ChatGPT' ),
        array( 'number' => '£100k', 'label' => 'Puri Pharmacy from Mounjaro alone' ),
    );
}

$cta_primary_label   = gh_field( 'service_hero_cta_primary_label',   'Get The Playbook — £995' );
$cta_primary_url     = gh_field( 'service_hero_cta_primary_url',     '#your-turn' );
$cta_secondary_label = gh_field( 'service_hero_cta_secondary_label', "See What's Inside" );
$cta_secondary_url   = gh_field( 'service_hero_cta_secondary_url',   '#the-shift' );

$image_id = get_field( 'service_hero_image' );
?>

<section class="svc-hero">
    <div class="svc-hero-inner<?php echo $image_id ? '' : ' svc-hero-inner--no-image'; ?>">
        <div class="svc-hero-content">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-hero-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>

            <?php if ( $title ) :
                // Split on newlines so multi-line titles (Agent: 3 stacked
                // lines with progressive sizing) work alongside single-line
                // titles (Playbook). CSS handles per-line sizing via
                // .svc-hero-title-line:nth-child().
                $title_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $title ) ) ); ?>
                <h1 class="svc-hero-title<?php echo count( $title_lines ) > 1 ? ' svc-hero-title--stacked' : ''; ?>">
                    <?php foreach ( $title_lines as $line ) : ?>
                        <span class="svc-hero-title-line"><?php echo esc_html( $line ); ?></span>
                    <?php endforeach; ?>
                </h1>
            <?php endif; ?>

            <?php if ( $subtitle ) :
                // Split on blank lines so multi-paragraph subtitles (Agent
                // hero) render as separate <p> tags. Single-paragraph
                // subtitles (Playbook) render as a single <p> unchanged.
                $subtitle_paras = array_filter( array_map( 'trim', preg_split( '/\r\n\r\n|\r\r|\n\n/', $subtitle ) ) ); ?>
                <div class="svc-hero-subtitle">
                    <?php foreach ( $subtitle_paras as $para ) : ?>
                        <p><?php echo esc_html( $para ); ?></p>
                    <?php endforeach; ?>
                </div>
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
