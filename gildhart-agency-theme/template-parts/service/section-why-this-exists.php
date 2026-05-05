<?php
/**
 * Service: Why This Exists section.
 *
 * Cream-warm section with a 2-column editorial header (copy left,
 * product visual right) that collapses to a stacked centred layout
 * at <960px. Below the header sits a 3-column grid of feature cards
 * — each card carries an image area at the top (or a styled
 * placeholder when empty), a giant outlined number, the icon block
 * collapsed when an image is present, title, and bulleted list.
 *
 * Background carries two soft brand-tinted radial halos (forest
 * green top-left, gold bottom-right) so the cream sits on a deliberate
 * brand-coloured wash rather than a flat fill.
 *
 * Reads from per-section ACF group `Service · Why This Exists`.
 * Returns early when the show toggle is off. Falls back to The Agent
 * copy from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_why_show', 1 ) ) {
    return;
}

$eyebrow      = gh_field( 'service_why_eyebrow',   'Why This Exists' );
$headline     = gh_field( 'service_why_headline',  "Your Patients Are Asking Thousands of Clinical Questions.\nRight Now, They're Getting the Answers Somewhere Else." );
$lead         = gh_field( 'service_why_lead',      "Every day, patients land on your site with a specific clinical question. Mounjaro eligibility. Yellow fever. Southeast Asia vaccines for a child. When you can't answer them in that moment — they leave. They don't come back." );
$lead_stat    = gh_field( 'service_why_lead_stat', 'Their question gets answered. Just not by you.' );
$header_image = get_field( 'service_why_header_image' );

$blocks = get_field( 'service_why_blocks' );
if ( empty( $blocks ) ) {
    $blocks = array(
        array(
            'icon_kind' => 'instant',
            'image'     => 0,
            'title'     => 'Answers Every Question. Instantly.',
            'bullets'   => array(
                array( 'text' => 'Clinical depth of a qualified pharmacist, any hour, any question.' ),
                array( 'text' => 'Patients stay on your site. No dead ends, no "call us Monday to Friday."' ),
                array( 'text' => 'Engaged patients book with the practice that answered them first.' ),
            ),
        ),
        array(
            'icon_kind' => 'intelligence',
            'image'     => 0,
            'title'     => 'Every Conversation Becomes Intelligence.',
            'bullets'   => array(
                array( 'text' => 'Intent data on every interaction — exactly what patients ask, how they ask it, and when.' ),
                array( 'text' => 'Real patient language becomes articles that rank.' ),
                array( 'text' => 'Your practice becomes the authority. Not NHS.uk. Not Fit for Travel. You.' ),
            ),
        ),
        array(
            'icon_kind' => 'moat',
            'image'     => 0,
            'title'     => 'You Become Impossible to Displace.',
            'bullets'   => array(
                array( 'text' => 'Every patient conversation adds to your clinical authority.' ),
                array( 'text' => 'The agent learns your patients — what they ask, what they need, what makes them book.' ),
                array( 'text' => "Six months in, no competitor starting today can replicate what you've built." ),
            ),
        ),
    );
}

/** Inline SVG keyed by icon kind. Returns markup safe to print. */
$icon_svg = function( $kind ) {
    $icons = array(
        'instant'      => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>',
        'intelligence' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 20h20M5 20V10l7-7 7 7v10"/><path d="M9 20v-5h6v5"/></svg>',
        'moat'         => '<svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>',
    );
    return $icons[ $kind ] ?? $icons['instant'];
};

/** Placeholder hint per icon-kind so the empty state reads as designed. */
$placeholder_hint = function( $kind ) {
    $hints = array(
        'instant'      => 'Insert chat preview',
        'intelligence' => 'Insert dashboard / data viz',
        'moat'         => 'Insert search-result mockup',
    );
    return $hints[ $kind ] ?? 'Insert visual';
};

$headline_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $headline ) ) );
?>

<section class="svc-why">
    <div class="svc-why-inner">
        <div class="svc-why-header">
            <div class="svc-why-header-copy">
                <?php if ( $eyebrow ) : ?>
                    <span class="svc-why-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $headline_lines ) ) : ?>
                    <h2 class="svc-why-headline">
                        <?php echo implode( '<br />', array_map( 'esc_html', $headline_lines ) ); ?>
                    </h2>
                <?php endif; ?>
                <?php if ( $lead ) : ?>
                    <p class="svc-why-lead"><?php echo esc_html( $lead ); ?></p>
                <?php endif; ?>
                <?php if ( $lead_stat ) : ?>
                    <div class="svc-why-lead-stat-wrap">
                        <span class="svc-why-lead-stat"><?php echo esc_html( $lead_stat ); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="svc-why-header-visual">
                <?php if ( $header_image ) : ?>
                    <?php echo wp_get_attachment_image( $header_image, 'full', false, array(
                        'alt'     => 'Agent in conversation with a patient',
                        'loading' => 'eager',
                        'fetchpriority' => 'high',
                        'sizes'   => '(min-width: 960px) 600px, 100vw',
                    ) ); ?>
                <?php else : ?>
                    <div class="svc-why-header-visual-placeholder" aria-hidden="true">
                        <span>Insert product visual<br>e.g. agent mid-conversation</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( ! empty( $blocks ) ) : ?>
            <div class="svc-why-blocks">
                <?php foreach ( $blocks as $i => $block ) :
                    $kind     = $block['icon_kind'] ?? 'instant';
                    $image_id = $block['image']     ?? 0;
                    $title    = $block['title']     ?? '';
                    $bullets  = $block['bullets']   ?? array();
                    if ( ! $title && empty( $bullets ) ) continue;
                    $num      = sprintf( '%02d', $i + 1 );
                    $classes  = 'svc-why-block' . ( $image_id ? ' svc-why-block--has-image' : '' );
                ?>
                    <article class="<?php echo esc_attr( $classes ); ?>">
                        <div class="svc-why-block-accent" aria-hidden="true"></div>
                        <span class="svc-why-block-num" aria-hidden="true"><?php echo esc_html( $num ); ?></span>

                        <div class="svc-why-block-image">
                            <?php if ( $image_id ) : ?>
                                <?php echo wp_get_attachment_image( $image_id, 'large', false, array(
                                    'alt'     => esc_attr( $title ),
                                    'loading' => 'lazy',
                                    'sizes'   => '(min-width: 960px) 430px, 100vw',
                                ) ); ?>
                            <?php else : ?>
                                <div class="svc-why-block-image-placeholder" aria-hidden="true">
                                    <div class="svc-why-block-image-placeholder-icon">
                                        <?php echo $icon_svg( $kind ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — static SVG ?>
                                    </div>
                                    <span><?php echo esc_html( $placeholder_hint( $kind ) ); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ( $title ) : ?>
                            <h3 class="svc-why-block-title"><?php echo esc_html( $title ); ?></h3>
                        <?php endif; ?>
                        <?php if ( ! empty( $bullets ) ) : ?>
                            <ul class="svc-why-block-bullets">
                                <?php foreach ( $bullets as $bullet ) :
                                    $text = $bullet['text'] ?? '';
                                    if ( ! $text ) continue; ?>
                                    <li><?php echo wp_kses_post( $text ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
