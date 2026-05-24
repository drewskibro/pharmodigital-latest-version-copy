<?php
/**
 * Service: Guarantee section.
 *
 * Dark navy section centred on the page. A gold pill badge with a
 * shield SVG sits above the headline. Below the headline, a bordered
 * guarantee panel (gold left-border accent) holds three body
 * paragraphs and a separately-styled three-line closing statement —
 * the founder's personal-implementation promise.
 *
 * The proof stat cards (Ealing / Superior / South Downs) were removed
 * in favour of the longer-form guarantee copy; the headline now sits
 * above the panel rather than above a stat grid.
 *
 * Reads from per-section ACF group `Service · Guarantee`. Returns
 * early when the show toggle is off. Falls back to The Playbook copy
 * from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_guarantee_show', 1 ) ) {
    return;
}

$badge_text = gh_field( 'service_guarantee_badge_text', 'Personal Implementation Guarantee' );
$headline   = gh_field( 'service_guarantee_headline',   'This System Has Already Worked. For Practices Exactly Like Yours.' );

$paragraphs = get_field( 'service_guarantee_paragraphs' );
if ( empty( $paragraphs ) ) {
    $paragraphs = array(
        array( 'text' => 'Ealing Travel Clinic. Superior Pharmacy. Puri Pharmacy. Three independent practices. Three different specialisms. All now appearing in Google AI Overviews, ChatGPT, and Perplexity ahead of national chains. Not because they got fortunate. Because the system works when it\'s implemented correctly.' ),
        array( 'text' => "If you implement this and aren't seeing results — I get on a call with you personally. Not a support ticket. Not a help doc. Me. One-on-one. Until it's working." ),
        array( 'text' => "And consider what you're weighing this against. Every week without this system is another week a practice in your area is building an AI presence you'll have to displace. Early positions compound. Late entry costs more than £995 — it costs the months of momentum you don't get back." ),
    );
}

// Closing statement — newline-separated lines. The final line picks up
// a gold accent so it lands as the section's last beat.
$closing = gh_field( 'service_guarantee_closing', "One purchase.\nA system that works.\nAnd my direct involvement if it doesn't." );
$closing_lines = array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $closing ) ) ) );
$closing_last  = count( $closing_lines ) - 1;
?>

<section class="svc-guarantee">
    <div class="svc-guarantee-inner">
        <?php if ( $badge_text ) : ?>
            <div class="svc-guarantee-badge">
                <span class="svc-guarantee-badge-icon" aria-hidden="true">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </span>
                <span class="svc-guarantee-badge-text"><?php echo esc_html( $badge_text ); ?></span>
            </div>
        <?php endif; ?>

        <?php if ( $headline ) : ?>
            <h2 class="svc-guarantee-headline"><?php echo esc_html( $headline ); ?></h2>
        <?php endif; ?>

        <?php if ( ! empty( $paragraphs ) || ! empty( $closing_lines ) ) : ?>
            <div class="svc-guarantee-panel">
                <?php if ( ! empty( $paragraphs ) ) : ?>
                    <div class="svc-guarantee-panel-body">
                        <?php foreach ( $paragraphs as $para ) :
                            $text = $para['text'] ?? '';
                            if ( ! $text ) continue; ?>
                            <p class="svc-guarantee-panel-para"><?php echo wp_kses_post( $text ); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $closing_lines ) ) : ?>
                    <p class="svc-guarantee-closing">
                        <?php foreach ( $closing_lines as $i => $line ) :
                            $line_class = 'svc-guarantee-closing-line' . ( $i === $closing_last ? ' svc-guarantee-closing-line--gold' : '' ); ?>
                            <span class="<?php echo esc_attr( $line_class ); ?>"><?php echo esc_html( $line ); ?></span>
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
