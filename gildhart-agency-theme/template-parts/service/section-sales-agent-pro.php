<?php
/**
 * Service: SalesAgent Pro stats section.
 *
 * Dark navy gradient section. Five stacked blocks:
 *   1. Header — gold-line eyebrow + multi-line H2
 *   2. Two-column story grid: cinematic left-bordered story (each row
 *      is a "line", "break" spacer, or bold "punchline") + product
 *      image on the right with a green radial glow
 *   3. Three stat cards — each card's "kind" picks the body shape:
 *        - simple:  big gold number + label + descriptor
 *        - compare: number + label + two comparison bars + attribution
 *        - text:    headline phrase (smaller font) + descriptor
 *   4. Revenue dashboard — 3-up grid of marquee stats (£200k+ etc.)
 *   5. Single forest-green CTA below the dashboard
 *
 * Comparison bar widths are set inline via the row's fill_pct value
 * (0–100). service.js IntersectionObserver swaps the start width to
 * the real percentage once the section enters the viewport so the
 * bars animate from 0 — pure visual polish, the markup is identical.
 *
 * Reads from per-section ACF group `Service · SalesAgent Pro`.
 * Returns early when the show toggle is off. Falls back to The Agent
 * copy from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_sa_pro_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_sa_pro_eyebrow',  'The Agent' );
$headline = gh_field( 'service_sa_pro_headline', "ChatGPT Recommended You.\nThe Patient Had Questions.\nYour Competitor's AI Agent Answered First." );

$story = get_field( 'service_sa_pro_story' );
if ( empty( $story ) ) {
    $story = array(
        array( 'type' => 'line',      'text' => 'Tuesday · 10:47 PM' ),
        array( 'type' => 'line',      'text' => 'A patient Googles weight loss injections. ChatGPT recommends <em>your clinic.</em>' ),
        array( 'type' => 'line',      'text' => 'She clicks through. Lands on your site. Reads the services page.' ),
        array( 'type' => 'break',     'text' => '' ),
        array( 'type' => 'line',      'text' => 'She has a question about Mounjaro dosing and her blood pressure medication.' ),
        array( 'type' => 'line',      'text' => "Your website says: <strong>'Call us Monday to Friday, 9–5.'</strong>" ),
        array( 'type' => 'break',     'text' => '' ),
        array( 'type' => 'line',      'text' => 'She goes back to ChatGPT. Clicks the next recommendation.' ),
        array( 'type' => 'line',      'text' => 'That site has an AI agent. It answers her in <em>11 seconds.</em>' ),
        array( 'type' => 'line',      'text' => 'She books. Pays. <strong>Never comes back to you.</strong>' ),
        array( 'type' => 'break',     'text' => '' ),
        array( 'type' => 'punchline', 'text' => "We've generated <em>100,000+ patient conversations</em> across our network. Every one of them would have bounced from a static site." ),
    );
}

$story_image = get_field( 'service_sa_pro_image' );

$stats = get_field( 'service_sa_pro_stats' );
if ( empty( $stats ) ) {
    $stats = array(
        array(
            'kind'         => 'compare',
            'client'       => 'Southdowns Pharmacy Group',
            'num'          => '25%',
            'label'        => 'Conversion rate',
            'sub'          => 'Patients who reach The Agent convert at five to twelve times the practice\'s typical site rate — same traffic, different surface area.',
            'compare_rows' => array(
                array( 'label' => 'Industry', 'fill_pct' => 20,  'value' => '2–5%', 'is_us' => 0 ),
                array( 'label' => 'Ours',     'fill_pct' => 100, 'value' => '25%',  'is_us' => 1 ),
            ),
        ),
        array(
            'kind'   => 'simple',
            'client' => 'Medihub',
            'num'    => '£200K+',
            'label'  => 'Annual revenue run rate',
            'sub'    => 'Generated after hours by The Agent. No night staff, no missed bookings — booking flow that previously dropped at 9pm now runs through the night.',
        ),
        array(
            'kind'   => 'simple',
            'client' => 'Superior Pharmacy',
            'num'    => '50%',
            'label'  => 'Weight loss sales via AI',
            'sub'    => 'Half of all weight-loss revenue at this branch now arrives via The Agent — patients qualify, book, and pay without speaking to staff.',
        ),
    );
}

$cta_label = gh_field( 'service_sa_pro_cta_label', 'See The System' );
$cta_url   = gh_field( 'service_sa_pro_cta_url',   '#eligibility' );

$headline_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $headline ) ) );
?>

<section class="svc-sa-pro">
    <div class="svc-sa-pro-inner">
        <div class="svc-sa-pro-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-sa-pro-eyebrow"><span><?php echo esc_html( $eyebrow ); ?></span></p>
            <?php endif; ?>
            <?php if ( ! empty( $headline_lines ) ) : ?>
                <h2 class="svc-sa-pro-headline">
                    <?php echo implode( '<br />', array_map( 'esc_html', $headline_lines ) ); ?>
                </h2>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $story ) || $story_image ) : ?>
            <div class="svc-sa-pro-story-grid">
                <?php if ( ! empty( $story ) ) : ?>
                    <div class="svc-sa-pro-story">
                        <?php foreach ( $story as $idx => $row ) :
                            $type = $row['type'] ?? 'line';
                            $text = $row['text'] ?? '';

                            // First row is promoted into the cinematic
                            // timestamp opener regardless of its repeater
                            // type. HTML is stripped (CSS handles the
                            // mono-uppercase typography); break rows in
                            // index 0 still get skipped to "" so an empty
                            // first row collapses cleanly.
                            if ( 0 === $idx ) {
                                $opener = trim( wp_strip_all_tags( $text ) );
                                if ( '' !== $opener ) : ?>
                                    <div class="svc-sa-pro-story-timestamp"><?php echo esc_html( $opener ); ?></div>
                                <?php endif;
                                continue;
                            }

                            if ( 'break' === $type ) : ?>
                                <div class="svc-sa-pro-story-break" aria-hidden="true"></div>
                            <?php elseif ( 'punchline' === $type && $text ) : ?>
                                <p class="svc-sa-pro-story-punchline"><?php echo wp_kses_post( $text ); ?></p>
                            <?php elseif ( $text ) : ?>
                                <p class="svc-sa-pro-story-line"><?php echo wp_kses_post( $text ); ?></p>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $story_image ) : ?>
                    <div class="svc-sa-pro-story-image">
                        <div class="svc-sa-pro-story-image-inner">
                            <?php echo wp_get_attachment_image( $story_image, 'large', false, array(
                                'alt'     => 'SalesAgent Pro — booking notification preview',
                                'loading' => 'lazy',
                            ) ); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $stats ) ) : ?>
            <div class="svc-sa-pro-stats">
                <?php foreach ( $stats as $stat ) :
                    $kind   = $stat['kind']   ?? 'simple';
                    $client = $stat['client'] ?? '';
                    $num    = $stat['num']    ?? '';
                    $label  = $stat['label']  ?? '';
                    $sub    = $stat['sub']    ?? '';
                    $rows   = $stat['compare_rows'] ?? array();
                    $card_classes = 'svc-sa-pro-stat svc-sa-pro-stat--' . esc_attr( $kind );
                ?>
                    <article class="<?php echo esc_attr( $card_classes ); ?>">
                        <?php if ( $client ) : ?>
                            <div class="svc-sa-pro-stat-client" aria-hidden="true">
                                <span class="svc-sa-pro-stat-client-dot"></span>
                                <span class="svc-sa-pro-stat-client-name"><?php echo esc_html( $client ); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ( $num ) : ?>
                            <p class="svc-sa-pro-stat-num"><?php echo esc_html( $num ); ?></p>
                        <?php endif; ?>
                        <?php if ( $label ) : ?>
                            <p class="svc-sa-pro-stat-label"><?php echo esc_html( $label ); ?></p>
                        <?php endif; ?>

                        <?php if ( 'compare' === $kind && ! empty( $rows ) ) : ?>
                            <div class="svc-sa-pro-stat-compare">
                                <?php foreach ( $rows as $row ) :
                                    $r_label = $row['label']    ?? '';
                                    $r_pct   = max( 0, min( 100, intval( $row['fill_pct'] ?? 0 ) ) );
                                    $r_value = $row['value']    ?? '';
                                    $is_us   = ! empty( $row['is_us'] );
                                    $fill_cls = 'svc-sa-pro-stat-compare-fill ' . ( $is_us ? 'svc-sa-pro-stat-compare-fill--us' : 'svc-sa-pro-stat-compare-fill--them' );
                                    $val_cls  = 'svc-sa-pro-stat-compare-val' . ( $is_us ? ' svc-sa-pro-stat-compare-val--us' : '' );
                                ?>
                                    <div class="svc-sa-pro-stat-compare-row">
                                        <span class="svc-sa-pro-stat-compare-label"><?php echo esc_html( $r_label ); ?></span>
                                        <div class="svc-sa-pro-stat-compare-track">
                                            <div class="<?php echo esc_attr( $fill_cls ); ?>" data-fill-pct="<?php echo esc_attr( $r_pct ); ?>"></div>
                                        </div>
                                        <span class="<?php echo esc_attr( $val_cls ); ?>"><?php echo esc_html( $r_value ); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $sub ) : ?>
                            <p class="svc-sa-pro-stat-sub"><?php echo wp_kses_post( $sub ); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $cta_label ) : ?>
            <div class="svc-sa-pro-cta">
                <a href="<?php echo esc_url( $cta_url ); ?>" class="svc-btn svc-btn-primary">
                    <?php echo esc_html( $cta_label ); ?>
                    <span class="svc-btn-arrow" aria-hidden="true">→</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
