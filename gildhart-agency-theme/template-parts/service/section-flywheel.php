<?php
/**
 * Service: Content Flywheel section.
 *
 * Dark navy gradient section. Centred header with gold eyebrow,
 * multi-line H2, and descriptor. Below it, a 2×2 card grid with a
 * pulsing gold "continuous loop" ring in the centre column —
 * connecting lines fade up and down from the centre to the cards
 * on each row.
 *
 * The grid expects four cards. Each card carries a numbered tag in
 * the corner, a tonal icon (kind picked via ACF select — capture /
 * intel / content / rank), title, and body. Mobile collapses to a
 * single column with the centre loop floated to the top.
 *
 * Closing line below the grid (with a gold em-accent), then a small
 * caps pill with a rotating arrow.
 *
 * Reads from per-section ACF group `Service · Content Flywheel`.
 * Returns early when the show toggle is off. Falls back to The Agent
 * copy from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_flywheel_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_flywheel_eyebrow',  'The Content Flywheel' );
$headline = gh_field( 'service_flywheel_headline', "Your Patients Write Your Marketing For You.\nThen It Brings You More Patients." );
$desc     = gh_field( 'service_flywheel_desc',     'Every question a patient asks your agent becomes content that ranks in Google, ChatGPT, and Claude. That content brings new patients. Those patients ask new questions. The machine feeds itself.' );

$cards = get_field( 'service_flywheel_cards' );
if ( empty( $cards ) ) {
    $cards = array(
        array( 'icon_kind' => 'capture', 'title' => 'Patients Tell You What They Want',  'text' => 'Real questions. Real language. Real buying intent — captured automatically, 24/7.' ),
        array( 'icon_kind' => 'intel',   'title' => 'We Find the Gold',                  'text' => "The high-value questions your competitors haven't answered yet. We surface them. You own them." ),
        array( 'icon_kind' => 'content', 'title' => 'Content That Actually Converts',    'text' => 'Articles and service pages built from real patient language — not keyword stuffing. Real intent. Real results.' ),
        array( 'icon_kind' => 'rank',    'title' => 'You Show Up Everywhere',            'text' => 'Google. ChatGPT. Claude. AI Overviews. New patients find you, ask questions, and the whole thing accelerates.' ),
    );
}

$loop_label = gh_field( 'service_flywheel_loop_label', 'Continuous Loop' );
$loop_pill  = gh_field( 'service_flywheel_loop_pill',  'Accelerates over time — the longer you run it, the wider the gap' );
$closing    = gh_field( 'service_flywheel_closing',    'Your competitors are guessing what patients want. Your patients are <em>telling</em> you. Every single day.' );

$icon_glyph = function( $kind ) {
    return array(
        'capture' => '💬',
        'intel'   => '🧠',
        'content' => '📄',
        'rank'    => '🔍',
    )[ $kind ] ?? '💬';
};

$headline_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $headline ) ) );
?>

<section class="svc-flywheel">
    <div class="svc-flywheel-inner">
        <div class="svc-flywheel-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-flywheel-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $headline_lines ) ) : ?>
                <h2 class="svc-flywheel-headline">
                    <?php echo implode( '<br />', array_map( 'esc_html', $headline_lines ) ); ?>
                </h2>
            <?php endif; ?>
            <?php if ( $desc ) : ?>
                <p class="svc-flywheel-desc"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $cards ) ) : ?>
            <div class="svc-flywheel-grid">
                <?php foreach ( $cards as $i => $card ) :
                    if ( $i >= 4 ) break;
                    $kind  = $card['icon_kind'] ?? 'capture';
                    $title = $card['title']     ?? '';
                    $text  = $card['text']      ?? '';
                    $num   = sprintf( '%02d', $i + 1 );
                ?>
                    <article class="svc-flywheel-card svc-flywheel-card--<?php echo esc_attr( $i + 1 ); ?>">
                        <span class="svc-flywheel-card-num" aria-hidden="true"><?php echo esc_html( $num ); ?></span>
                        <div class="svc-flywheel-card-icon svc-flywheel-card-icon--<?php echo esc_attr( $kind ); ?>" aria-hidden="true"><?php echo esc_html( $icon_glyph( $kind ) ); ?></div>
                        <?php if ( $title ) : ?>
                            <h3 class="svc-flywheel-card-title"><?php echo esc_html( $title ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $text ) : ?>
                            <p class="svc-flywheel-card-text"><?php echo esc_html( $text ); ?></p>
                        <?php endif; ?>
                    </article>

                    <?php // After the 2nd card, inject the centre loop graphic so it sits in grid column 2. ?>
                    <?php if ( 1 === $i ) : ?>
                        <div class="svc-flywheel-centre" aria-hidden="true">
                            <div class="svc-flywheel-loop-ring">
                                <span class="svc-flywheel-loop-icon">↻</span>
                            </div>
                            <?php if ( $loop_label ) : ?>
                                <p class="svc-flywheel-loop-label"><?php echo wp_kses_post( $loop_label ); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $loop_pill ) : ?>
            <div class="svc-flywheel-pill">
                <div class="svc-flywheel-pill-inner">
                    <span class="svc-flywheel-pill-arrow" aria-hidden="true">↻</span> <?php echo esc_html( $loop_pill ); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( $closing ) : ?>
            <p class="svc-flywheel-closing"><?php echo wp_kses_post( $closing ); ?></p>
        <?php endif; ?>
    </div>
</section>
