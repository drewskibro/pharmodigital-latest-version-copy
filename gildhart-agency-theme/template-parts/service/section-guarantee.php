<?php
/**
 * Service: Guarantee section.
 *
 * Dark navy section centred on the page. A gold pill badge with a
 * shield SVG sits above a centred headline. Below it, a two-column
 * layout pairs THE PROOF (three named practice results, left) with
 * THE GUARANTEE (the founder's personal-implementation promise,
 * right). Both columns are boxed as a matched pair — the guarantee
 * column carries an additional 4px gold left-border accent to mark
 * it as the personal-commitment beat. A three-line closing statement
 * sits full-width below both columns, centred, last line in gold.
 *
 * On mobile the columns stack (proof above guarantee) and all body
 * copy stays left-aligned.
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

$badge_text   = gh_field( 'service_guarantee_badge_text', 'Personal Implementation Guarantee' );
$headline     = gh_field( 'service_guarantee_headline',   'This System Has Already Worked. For Practices Exactly Like Yours.' );

/* Left column — THE PROOF */
$proof_label  = gh_field( 'service_guarantee_proof_label', 'Three Practices. Three Specialisms. One Result.' );
$proof_blocks = get_field( 'service_guarantee_proof_blocks' );
if ( empty( $proof_blocks ) ) {
    $proof_blocks = array(
        array( 'name' => 'Ealing Travel Clinic', 'result' => '#1 in Google AI Overviews. 8 bookings became 55 a month. Then an IVF clinic started sending referrals.' ),
        array( 'name' => 'Superior Pharmacy',    'result' => '50% of all sales now come through ChatGPT. First booking within 48 hours of going live.' ),
        array( 'name' => 'Puri Pharmacy',        'result' => '£100k from Mounjaro alone. Outranking Boots nationally.' ),
    );
}

/* Right column — THE GUARANTEE */
$guarantee_label = gh_field( 'service_guarantee_guarantee_label', 'The Guarantee' );
$paragraphs      = get_field( 'service_guarantee_paragraphs' );
if ( empty( $paragraphs ) ) {
    $paragraphs = array(
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

        <div class="svc-guarantee-columns">
            <?php if ( ! empty( $proof_blocks ) ) : ?>
                <div class="svc-guarantee-col svc-guarantee-col--proof">
                    <?php if ( $proof_label ) : ?>
                        <p class="svc-guarantee-col-label"><?php echo esc_html( $proof_label ); ?></p>
                    <?php endif; ?>
                    <div class="svc-guarantee-proof-blocks">
                        <?php foreach ( $proof_blocks as $block ) :
                            $name   = $block['name']   ?? '';
                            $result = $block['result'] ?? '';
                            if ( ! $name && ! $result ) continue; ?>
                            <div class="svc-guarantee-proof-block">
                                <?php if ( $name ) : ?>
                                    <p class="svc-guarantee-proof-name"><?php echo esc_html( $name ); ?></p>
                                <?php endif; ?>
                                <?php if ( $result ) : ?>
                                    <p class="svc-guarantee-proof-result"><?php echo esc_html( $result ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $paragraphs ) ) : ?>
                <div class="svc-guarantee-col svc-guarantee-col--guarantee">
                    <?php if ( $guarantee_label ) : ?>
                        <p class="svc-guarantee-col-label"><?php echo esc_html( $guarantee_label ); ?></p>
                    <?php endif; ?>
                    <div class="svc-guarantee-col-body">
                        <?php foreach ( $paragraphs as $para ) :
                            $text = $para['text'] ?? '';
                            if ( ! $text ) continue; ?>
                            <p class="svc-guarantee-para"><?php echo wp_kses_post( $text ); ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $closing_lines ) ) : ?>
            <p class="svc-guarantee-closing">
                <?php foreach ( $closing_lines as $i => $line ) :
                    $line_class = 'svc-guarantee-closing-line' . ( $i === $closing_last ? ' svc-guarantee-closing-line--gold' : '' ); ?>
                    <span class="<?php echo esc_attr( $line_class ); ?>"><?php echo esc_html( $line ); ?></span>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>
    </div>
</section>
