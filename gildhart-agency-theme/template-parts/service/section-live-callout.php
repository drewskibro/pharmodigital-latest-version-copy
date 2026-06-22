<?php
/**
 * Service: Live Carousel Callout — "On Any Given Day" editorial moment.
 *
 * Standalone cream-bg section, dropped into the roster wherever the
 * editorial vignettes earn their place — currently slotted between
 * the testimonial and Why This Exists on The Agent so the visual →
 * human → editorial proof escalation completes BEFORE the page
 * pivots into the problem framing.
 *
 * Reads from per-section ACF group `Service · Live Clients` so editors
 * configure the carousel + callout copy in one block instead of two:
 *   - service_live_clients_callout_eyebrow (default "On Any Given Day")
 *   - service_live_clients_footnote        (prose + optional blank-
 *                                            line-separated closer)
 *
 * Returns early when both the show toggle is off AND the prose body is
 * empty. The standalone eyebrow alone is not enough to render — there
 * has to be at least one paragraph of vignette copy.
 *
 * Editor controls:
 *   - Wrap key beats in **double-asterisks** to render them as gold-
 *     weighted spans inline. Use this on the temporal spine words —
 *     "midnight", "Sunday afternoon", "morning" — so the rhythm of
 *     the vignettes pops out of the italic prose.
 *   - Use a blank line in the footnote field to split off a closing
 *     line. The last paragraph becomes a forest-green climax beneath
 *     a three-dot gold ornament, and any internal sentence terminators
 *     inside that closer become hard line breaks for the exhale-pause
 *     rhythm (e.g. "The building is dark." / "The revenue isn't.").
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_live_clients_show', 1 ) ) {
    return;
}

$callout_eyebrow = gh_field( 'service_live_clients_callout_eyebrow', 'On Any Given Day' );
$footnote        = gh_field( 'service_live_clients_footnote', '' );

if ( ! $footnote ) {
    return;
}

// Split the footnote on blank-line paragraph breaks. If editors leave
// the final beat ("The building is dark. The revenue isn't.") on its
// own paragraph it renders as a forest-green climax with a gold
// three-dot ornament above; otherwise the whole thing reads as a
// single prose block.
$footnote_paras  = array();
$footnote_closer = '';
$paras = array_values( array_filter( array_map( 'trim', preg_split( '/\r\n\r\n|\r\r|\n\n/', $footnote ) ) ) );
if ( count( $paras ) > 1 ) {
    $footnote_closer = array_pop( $paras );
    $footnote_paras  = $paras;
} else {
    $footnote_paras  = $paras;
}

if ( empty( $footnote_paras ) && ! $footnote_closer ) {
    return;
}
?>

<section class="svc-live-clients-callout">
    <div class="svc-live-clients-callout-inner">
        <?php if ( $callout_eyebrow ) : ?>
            <p class="svc-live-clients-callout-eyebrow"><?php echo esc_html( $callout_eyebrow ); ?></p>
        <?php endif; ?>
        <?php foreach ( $footnote_paras as $para ) :
            // Promote **double-asterisk** beats — the temporal spine
            // words ("midnight", "Sunday afternoon", "morning") — into
            // gold-weighted spans inline. Escape first, then splice in
            // the trusted markup so user content stays HTML-safe.
            $prose_html = preg_replace(
                '/\*\*(.+?)\*\*/',
                '<span class="svc-live-clients-callout-mark">$1</span>',
                esc_html( $para )
            );
            ?>
            <p class="svc-live-clients-callout-prose"><?php echo $prose_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — pre-escaped above, mark spans intentional. ?></p>
        <?php endforeach; ?>
        <?php if ( $footnote_closer ) :
            // Each sentence in the closer drops onto its own line so
            // "The building is dark." and "The revenue isn't." breathe
            // as separate beats rather than running together.
            $closer_lines = array_values( array_filter( array_map( 'trim', preg_split( '/(?<=[.!?])\s+/', $footnote_closer ) ) ) );
            ?>
            <div class="svc-live-clients-callout-divider" aria-hidden="true">
                <span></span><span></span><span></span>
            </div>
            <p class="svc-live-clients-callout-closer">
                <?php foreach ( $closer_lines as $line ) : ?>
                    <span><?php echo esc_html( $line ); ?></span>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>
    </div>
</section>
