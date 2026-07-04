<?php
/**
 * Service: Playing Field section.
 *
 * Cream section that frames the underlying market shift: AI search has
 * killed the brand-authority moat. Renders a single full-width
 * editorial narrative in a centred 780px reading column — clean prose
 * on the section background, no card or box.
 *
 * Narrative treatment (parsed from the `service_playing_field_narrative`
 * textarea, paragraphs split on blank lines):
 *   - A paragraph wrapped in **double asterisks** becomes the bold
 *     pivot line — the hinge of the argument.
 *   - The last paragraph auto-italicises as the closing verdict.
 *
 * The legacy two-column "Old Game vs New Reality" comparison + the
 * navy conclusion callout were retired in favour of the narrative;
 * their ACF fields (old_rows / new_rows / captions / callout) remain
 * registered but dormant so historical data isn't orphaned.
 *
 * Reads from per-section ACF group `Service · Playing Field`. Returns
 * early when the show toggle is off.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_playing_field_show', 1 ) ) {
    return;
}

$eyebrow     = gh_field( 'service_playing_field_eyebrow',     'The Shift Nobody Told You About' );
$headline    = gh_field( 'service_playing_field_headline',    "AI Search Doesn't Care How Big Your Budget Is." );
$subheadline = gh_field( 'service_playing_field_subheadline', 'Traditional search was rigged. Boots spent years building a domain authority you were never going to compete with. Then AI search arrived — and stopped caring about any of it.' );

$narrative = gh_field( 'service_playing_field_narrative', "For fifty years, Boots won because they could afford to. Six-figure ad spend. Decades of link-building. A brand name that Google trusted on sight. You were always starting five years behind.\n\n**Then AI search arrived. And it doesn't know who Boots is.**\n\nIt knows who answered the question best. Who structured their content correctly. Who built their pages the way AI actually reads them.\n\nEaling Travel Clinic did that. Six weeks later they were above Boots across London. Above Superdrug. Above NHS.uk. Sachin hadn't changed his services, his prices, or his location. He'd changed the infrastructure.\n\nThat's the only thing that changed. And it changed everything." );

// Split the narrative on blank lines. Each paragraph renders as its
// own <p>; the last one italicises as the closing verdict, and any
// paragraph fully wrapped in **double asterisks** becomes the bold
// pivot line (markers stripped).
$narrative_paras = $narrative
    ? array_values( array_filter( array_map( 'trim', preg_split( '/\r\n\r\n|\r\r|\n\n/', $narrative ) ) ) )
    : array();
$last_index = count( $narrative_paras ) - 1;
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

        <?php if ( ! empty( $narrative_paras ) ) : ?>
            <div class="svc-pf-narrative">
                <div class="svc-pf-narrative-inner">
                    <?php foreach ( $narrative_paras as $i => $para ) :
                        $is_pivot   = ( '**' === substr( $para, 0, 2 ) && '**' === substr( $para, -2 ) );
                        $is_verdict = ( $i === $last_index );
                        if ( $is_pivot ) {
                            $para = trim( substr( $para, 2, -2 ) );
                        }
                        $class = 'svc-pf-narrative-p';
                        if ( $is_pivot )   $class .= ' is-pivot';
                        if ( $is_verdict ) $class .= ' is-verdict';
                        ?>
                        <p class="<?php echo esc_attr( $class ); ?>"><?php echo esc_html( $para ); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
