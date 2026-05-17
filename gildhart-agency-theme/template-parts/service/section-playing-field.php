<?php
/**
 * Service: Playing Field section.
 *
 * Cream section that frames the underlying market shift: AI search has
 * killed the brand-authority moat. Two side-by-side comparison columns
 * — "The Old Game" vs "The New Reality" — with bullet rows + a closing
 * caption per column. A dark navy callout strip below carries the
 * "level playing field" rallying line with a gold-highlighted second
 * line.
 *
 * Reads from per-section ACF group `Service · Playing Field`. Returns
 * early when the show toggle is off. Falls back to The Playbook copy
 * from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_playing_field_show', 1 ) ) {
    return;
}

$eyebrow     = gh_field( 'service_playing_field_eyebrow',     'The Shift Nobody Told You About' );
$headline    = gh_field( 'service_playing_field_headline',    "AI Search Doesn't Care How Big Your Budget Is." );
$subheadline = gh_field( 'service_playing_field_subheadline', 'Traditional search was rigged. Boots spent years building a domain authority you were never going to compete with. Then AI search arrived — and stopped caring about any of it.' );

$old_label   = gh_field( 'service_playing_field_old_label',   'The Old Game' );
$old_caption = gh_field( 'service_playing_field_old_caption', "Boots, Bupa, Superdrug — they own traditional search. You were never going to win that game. Nobody told you there was a different one." );
$old_rows    = get_field( 'service_playing_field_old_rows' );
if ( empty( $old_rows ) ) {
    $old_rows = array(
        array( 'text' => "Boots wins. You don't. Budget decides." ),
        array( 'text' => 'Six-figure ad spend just to stay visible' ),
        array( 'text' => "Decades of link-building you'll never catch up on" ),
        array( 'text' => "Superdrug's name does the ranking for them" ),
        array( 'text' => "Five years minimum before you're competitive" ),
    );
}

$new_label   = gh_field( 'service_playing_field_new_label',   'The New Reality' );
$new_caption = gh_field( 'service_playing_field_new_caption', 'Ealing Travel Clinic outranked Boots in 6 weeks. No ad spend. No legacy domain. Just the right content — built the right way.' );
$new_rows    = get_field( 'service_playing_field_new_rows' );
if ( empty( $new_rows ) ) {
    $new_rows = array(
        array( 'text' => 'Whoever answers best gets cited — full stop' ),
        array( 'text' => 'One well-structured page beats a decade of backlinks' ),
        array( 'text' => "Google's AI reads your content, not your company age" ),
        array( 'text' => 'The most useful clinic wins, not the biggest one' ),
        array( 'text' => 'Ealing went from nothing to cited in 6 weeks' ),
    );
}

$callout_main      = gh_field( 'service_playing_field_callout_text',      "Same foundation Ealing used. Same foundation Superior used. Same foundation you're about to have. The playing field didn't level itself — but it levelled." );
$callout_highlight = gh_field( 'service_playing_field_callout_highlight', '' );
?>

<section class="svc-playing-field">
    <div class="svc-pf-inner">
        <div class="svc-pf-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-pf-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-pf-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $subheadline ) : ?>
                <p class="svc-pf-subheadline"><?php echo esc_html( $subheadline ); ?></p>
            <?php endif; ?>
        </div>

        <div class="svc-pf-compare">
            <div class="svc-pf-col svc-pf-col--old">
                <?php if ( $old_label ) : ?>
                    <div class="svc-pf-col-label"><?php echo esc_html( $old_label ); ?></div>
                <?php endif; ?>
                <div class="svc-pf-col-body">
                    <?php foreach ( $old_rows as $row ) :
                        $text = $row['text'] ?? '';
                        if ( ! $text ) continue; ?>
                        <div class="svc-pf-row">
                            <span class="svc-pf-dot" aria-hidden="true"></span>
                            <p class="svc-pf-row-text"><?php echo esc_html( $text ); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ( $old_caption ) : ?>
                    <div class="svc-pf-col-caption"><?php echo wp_kses_post( $old_caption ); ?></div>
                <?php endif; ?>
            </div>

            <div class="svc-pf-col svc-pf-col--new">
                <?php if ( $new_label ) : ?>
                    <div class="svc-pf-col-label"><?php echo esc_html( $new_label ); ?></div>
                <?php endif; ?>
                <div class="svc-pf-col-body">
                    <?php foreach ( $new_rows as $row ) :
                        $text = $row['text'] ?? '';
                        if ( ! $text ) continue; ?>
                        <div class="svc-pf-row">
                            <span class="svc-pf-dot" aria-hidden="true"></span>
                            <p class="svc-pf-row-text"><?php echo esc_html( $text ); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ( $new_caption ) : ?>
                    <div class="svc-pf-col-caption"><?php echo wp_kses_post( $new_caption ); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( $callout_main || $callout_highlight ) : ?>
            <p class="svc-pf-conclusion">
                <?php if ( $callout_main ) : ?>
                    <?php echo esc_html( $callout_main ); ?>
                <?php endif; ?>
                <?php if ( $callout_main && $callout_highlight ) : ?> <?php endif; ?>
                <?php if ( $callout_highlight ) : ?>
                    <span><?php echo esc_html( $callout_highlight ); ?></span>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>
</section>
