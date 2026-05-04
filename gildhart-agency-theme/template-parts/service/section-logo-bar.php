<?php
/**
 * Service: Logo Bar section.
 *
 * Cream-warm strip directly below the hero. Optional caption above an
 * infinite horizontal scroll of client logos.
 *
 * The track needs total width > 2× viewport for translateX(-50%) to
 * loop seamlessly. We tile each unique logo enough times so a single
 * "set" has at least MIN_PER_SET items, then render the whole set
 * twice. Soft cream gradients fade the left/right edges.
 *
 * Reads from per-section ACF group `Service · Logo Bar`. Returns
 * early when the show toggle is off OR no logos are populated.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_logo_bar_show', 1 ) ) {
    return;
}

$label = gh_field( 'service_logo_bar_label', 'Every practice live is generating enquiries they never had before' );
$logos = get_field( 'service_logo_bar_logos' );

if ( empty( $logos ) ) {
    return; // No logos = no section
}

// Tile each unique logo enough times so a single set has MIN_PER_SET
// items — then render the whole set twice for the seamless loop. With
// fewer than MIN_PER_SET unique logos the tiling still produces a
// scroller wider than 2× a typical viewport, so translateX(-50%)
// always loops without an empty edge.
$MIN_PER_SET = 9;
$count       = max( 1, count( $logos ) );
$repeats     = (int) ceil( $MIN_PER_SET / $count );
?>

<section class="svc-logo-bar">
    <?php if ( $label ) : ?>
        <p class="svc-logo-bar-label"><?php echo esc_html( $label ); ?></p>
    <?php endif; ?>
    <div class="svc-logo-bar-track">
        <div class="svc-logo-bar-scroller">
            <?php
            for ( $pass = 0; $pass < 2; $pass++ ) {
                for ( $rep = 0; $rep < $repeats; $rep++ ) {
                    foreach ( $logos as $idx => $logo ) {
                        if ( empty( $logo['ID'] ) ) {
                            continue;
                        }
                        // Only the first set carries real alt text — the rest
                        // are aria-hidden duplicates so screen readers don't
                        // re-announce each logo for every tile.
                        $is_first = ( 0 === $pass && 0 === $rep );
                        $alt      = $is_first
                            ? ( ! empty( $logo['alt'] ) ? $logo['alt'] : ( ! empty( $logo['title'] ) ? $logo['title'] : '' ) )
                            : '';
                        $extra    = $is_first ? array() : array( 'aria-hidden' => 'true' );
                        $args     = array_merge(
                            array(
                                'alt'     => esc_attr( $alt ),
                                'loading' => 'lazy',
                            ),
                            $extra
                        );
                        echo wp_get_attachment_image( $logo['ID'], 'medium', false, $args );
                    }
                }
            }
            ?>
        </div>
    </div>
</section>
