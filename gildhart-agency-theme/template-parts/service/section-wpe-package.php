<?php
/**
 * Service: WebPro Elite — Package + Outcome Momentum Timeline.
 *
 * Forest-green section. Centred header, then two gold-bordered columns
 * (The Website / The Framework), each with a numbered header and a
 * ticked feature list. Below sits the Outcome Momentum Timeline — a
 * horizontal gold track whose connecting line draws itself and whose
 * milestones reveal in sequence once scrolled into view (the final
 * "destination" milestone pulses).
 *
 * Columns and milestones bake in as defaults so the section renders
 * complete with no data entry. Reveal handled in service.js
 * (.svc-wpe-delivery gains .is-active).
 *
 * Reads from per-section ACF group `Service · WPE Package`. Returns
 * early when the show toggle is off.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_wpe_package_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_wpe_package_eyebrow',  'What WebPro Elite Is' );
$headline = gh_field( 'service_wpe_package_headline', "Every Other Agency Builds You a Website.\nWe Build You a Patient Acquisition Engine." );
$subhead  = gh_field( 'service_wpe_package_subhead',  'Every other agency builds you a website. We build you a website that Google ranks, ChatGPT cites, and patients find. That\'s not a feature. That\'s the entire architecture.' );

$cols = get_field( 'service_wpe_package_cols' );
if ( empty( $cols ) ) {
    $cols = array(
        array(
            'num'   => '01',
            'title' => 'The Website',
            'sub'   => "Most healthcare websites are invisible to the platforms patients now use to make decisions. Every Gildhart build starts with Claude Code — the AI infrastructure that tells Google, ChatGPT, and Claude exactly what your practice does, who it serves, and why it should be recommended.",
            'items' => array(
                'Built on Claude Code — architected for AI search from day one',
                'Dedicated service pages for every revenue-generating offering',
                'GPhC-compliant throughout — no compromises on clinical standards',
            ),
        ),
        array(
            'num'   => '02',
            'title' => 'The Pillar Domination Framework™',
            'sub'   => "ChatGPT doesn't search Google. It searches Bing. Every day patients ask ChatGPT for a Mounjaro provider, a travel clinic, a private prescription service. Most practices have never touched Bing. That's why they're invisible. This framework fixes that — deliberately, specifically, permanently.",
            'items' => array(
                "Bing indexation protocol — the exact reason Superior appeared on ChatGPT's shortlist in 48 hours",
                'Google AI Overview optimisation for local and national queries',
                'Structured data and entity markup so AI platforms trust your content',
            ),
        ),
    );
}

$timeline_label = gh_field( 'service_wpe_timeline_label', 'Outcome Momentum' );

$milestones = get_field( 'service_wpe_package_milestones' );
if ( empty( $milestones ) ) {
    $milestones = array(
        array(
            'period' => 'Week 1',
            'body'   => 'We architect your site on Claude Code — every service page built for AI search from the first line of code.',
        ),
        array(
            'period' => 'Month 1',
            'body'   => 'Indexed across Google, Bing, ChatGPT, and Claude. The first AI-sourced enquiries start landing.',
        ),
        array(
            'period' => 'Month 3',
            'body'   => 'Rankings climb. Content compounds. Patients arrive pre-sold, around the clock, with zero ad spend.',
        ),
        array(
            'period'      => 'Month 6+',
            'body'        => 'A patient acquisition engine running on autopilot — compounding every month, owned forever.',
            'destination' => true,
        ),
    );
}

// subhead supports a ::emphasis:: marker -> wrapped <em>.
$subhead_html = '';
if ( $subhead ) {
    $parts = preg_split( '/::(.+?)::/', $subhead, -1, PREG_SPLIT_DELIM_CAPTURE );
    foreach ( $parts as $i => $part ) {
        $subhead_html .= ( $i % 2 === 1 )
            ? '<em>' . esc_html( $part ) . '</em>'
            : esc_html( $part );
    }
}

$headline_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $headline ) ) );
?>

<section class="svc-wpe-package" id="whats-included">
    <div class="svc-wpe-package-inner">

        <div class="svc-wpe-package-header">
            <?php if ( $eyebrow ) : ?>
                <span class="svc-wpe-package-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $headline_lines ) ) : ?>
                <h2 class="svc-wpe-package-headline">
                    <?php foreach ( $headline_lines as $line ) : ?>
                        <span><?php echo esc_html( $line ); ?></span>
                    <?php endforeach; ?>
                </h2>
            <?php endif; ?>
            <?php if ( $subhead_html ) : ?>
                <p class="svc-wpe-package-subhead"><?php echo wp_kses_post( $subhead_html ); ?></p>
            <?php endif; ?>
        </div>

        <div class="svc-wpe-package-cols">
            <?php foreach ( $cols as $ci => $col ) :
                $num   = $col['num']   ?? '';
                $title = $col['title'] ?? '';
                $sub   = $col['sub']   ?? '';
                $items = $col['items'] ?? array();
                if ( is_string( $items ) ) {
                    $items = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $items ) ) );
                }
                $dark = ( $ci % 2 === 1 );
                // Second column is the premium differentiator — gets the
                // featured treatment (heavier gold border + glow + padding).
                $featured = ( 1 === $ci );
                $col_class = 'svc-wpe-package-col';
                if ( $dark )     { $col_class .= ' svc-wpe-package-col--dark'; }
                if ( $featured ) { $col_class .= ' svc-wpe-package-col--featured'; }
                ?>
                <div class="<?php echo esc_attr( $col_class ); ?>">
                    <?php if ( $num ) : ?>
                        <p class="svc-wpe-package-col-num"><?php echo esc_html( $num ); ?></p>
                    <?php endif; ?>
                    <div class="svc-wpe-package-col-header">
                        <?php if ( $title ) : ?>
                            <h3 class="svc-wpe-package-col-title"><?php echo esc_html( $title ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $sub ) : ?>
                            <p class="svc-wpe-package-col-sub"><?php echo esc_html( $sub ); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if ( ! empty( $items ) ) : ?>
                        <ul class="svc-wpe-package-list">
                            <?php foreach ( $items as $item ) : ?>
                                <li>
                                    <span class="svc-wpe-pkg-check" aria-hidden="true">✓</span>
                                    <?php echo esc_html( $item ); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ( ! empty( $milestones ) ) : ?>
            <div class="svc-wpe-delivery">
                <?php if ( $timeline_label ) : ?>
                    <p class="svc-wpe-delivery-label"><?php echo esc_html( $timeline_label ); ?></p>
                <?php endif; ?>
                <div class="svc-wpe-timeline">
                    <?php foreach ( $milestones as $m ) :
                        $period = $m['period'] ?? '';
                        $body   = $m['body']   ?? '';
                        $dest   = ! empty( $m['destination'] );
                        if ( ! $period && ! $body ) {
                            continue;
                        } ?>
                        <div class="svc-wpe-milestone<?php echo $dest ? ' svc-wpe-milestone--destination' : ''; ?>">
                            <span class="svc-wpe-milestone-dot" aria-hidden="true"></span>
                            <div>
                                <?php if ( $period ) : ?>
                                    <p class="svc-wpe-milestone-month"><?php echo esc_html( $period ); ?></p>
                                <?php endif; ?>
                                <?php if ( $body ) : ?>
                                    <p class="svc-wpe-milestone-body"><?php echo esc_html( $body ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
