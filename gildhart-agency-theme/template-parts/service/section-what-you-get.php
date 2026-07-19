<?php
/**
 * Service: The System section (cream/light Claude-badge variant).
 *
 * Cream-gradient section that lays out exactly what the buyer gets:
 * a header, a centred intro paragraph framing the Cowork Project
 * setup, then a grid of "What's Inside" cards. Cards render 2-up; a
 * card with the closer toggle spans full-width as the closing beat,
 * and an odd regular card that would otherwise orphan is promoted to
 * a full-width band automatically.
 *
 * Each card leads with an optional Claude product badge — now a
 * sub-field on the card itself, so reordering keeps badges attached
 * (they previously lived in separate top-level positional fields).
 * Below the header subtext, a centred "Built with Claude" badge
 * anchors the section to the underlying platform.
 *
 * Each card carries:
 *   - Claude product badge (per-card ACF image, omitted when empty)
 *   - Small forest-green caps step label
 *   - Bold dark-navy title
 *   - Italic muted-navy subtitle
 *   - Body copy
 *   - Gold-anchored stat line at the bottom
 *
 * Reads from per-section ACF group `Service · What You Get` (key
 * preserved so historical metabox position holds). Returns early
 * when the show toggle is off.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_what_you_get_show', 1 ) ) {
    return;
}

$eyebrow     = gh_field( 'service_what_you_get_eyebrow',     'The System' );
$headline    = gh_field( 'service_what_you_get_headline',    'It Runs While You See Patients.' );
$subheadline = gh_field( 'service_what_you_get_subheadline', "Ealing, Superior, and Rahul's weight loss clinic didn't brief writers, hire agencies, or manage campaigns. They selected their services. We built their knowledge base. They uploaded it to Cowork once. Claude has run the content cycle automatically every week since." );

// Header "Built with Claude" badge — centred under the subhead.
$built_with_id = (int) get_field( 'system_built_with_claude_badge' );

// Intro block — gold eyebrow + a weighted lead line (the reassurance
// promise, elevated out of the paragraph so a non-technical buyer meets
// it first) + the setup paragraph, between the header and the cards.
$intro_eyebrow = gh_field( 'system_intro_eyebrow', 'Everything You Get' );
$intro_lead    = gh_field( 'system_intro_lead', "It remembers where it left off. It knows your services, your pricing, your compliance requirements. You don't explain yourself every time. You just approve what it produces and let it run." );
$intro_body    = gh_field( 'system_intro_body', "This isn't a watch-and-hope course. We set up a dedicated Cowork Project on your computer for you — your clinical knowledge base loaded, your content system configured, your practice instructions written in before you run a single task — then five short modules and the monthly calls show you exactly how to run it. Every week, Claude works through your content autonomously inside that workspace: writing, structuring, publishing directly to your site." );

$modules = get_field( 'service_what_you_get_modules' );
if ( empty( $modules ) && function_exists( 'gh_service_system_default_modules' ) ) {
    $modules = gh_service_system_default_modules();
}

// The card grid is 2-up. An odd number of regular (non-closer) cards
// leaves one stranded beside an empty column, so the last regular card
// in that case is promoted to a full-width band. Track its index.
$non_closer_indices = array();
foreach ( (array) $modules as $mi => $m ) {
    if ( empty( $m['is_closer'] ) && ( ! empty( $m['title'] ) || ! empty( $m['body'] ) ) ) {
        $non_closer_indices[] = $mi;
    }
}
$orphan_index = ( count( $non_closer_indices ) % 2 === 1 ) ? (int) end( $non_closer_indices ) : -1;
?>

<section class="svc-system" id="what-you-get">
    <div class="svc-system-inner">
        <header class="svc-system-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-system-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-system-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $subheadline ) : ?>
                <p class="svc-system-subheadline"><?php echo esc_html( $subheadline ); ?></p>
            <?php endif; ?>
            <?php if ( $built_with_id ) : ?>
                <div class="svc-system-built-with">
                    <?php echo wp_get_attachment_image( $built_with_id, 'large', false, array(
                        'alt'     => 'Built with Claude',
                        'loading' => 'lazy',
                    ) ); ?>
                </div>
            <?php endif; ?>
        </header>

        <?php if ( $intro_eyebrow || $intro_body ) : ?>
            <div class="svc-system-intro">
                <?php if ( $intro_eyebrow ) : ?>
                    <p class="svc-system-intro-eyebrow"><?php echo esc_html( $intro_eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $intro_lead ) : ?>
                    <p class="svc-system-intro-lead"><?php echo esc_html( $intro_lead ); ?></p>
                <?php endif; ?>
                <?php if ( $intro_body ) : ?>
                    <p class="svc-system-intro-body"><?php echo esc_html( $intro_body ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $modules ) ) : ?>
            <div class="svc-system-modules">
                <?php foreach ( $modules as $i => $module ) :
                    $label           = $module['label']           ?? '';
                    $title           = $module['title']           ?? '';
                    $subtitle        = $module['subtitle']        ?? '';
                    $body            = $module['body']            ?? '';
                    $stat_value      = $module['stat_value']      ?? '';
                    $stat_descriptor = $module['stat_descriptor'] ?? '';
                    $is_closer       = ! empty( $module['is_closer'] );
                    $card_pos        = $i + 1;
                    $badge_id        = (int) ( $module['badge'] ?? 0 );
                    // Legacy fallback: badges used to live in top-level
                    // positional fields (system_card_0X_badge). Honour any
                    // set before the badge moved into the repeater, until
                    // the card is re-saved with its own badge.
                    if ( ! $badge_id && $card_pos <= 5 ) {
                        $badge_id = (int) get_post_meta( get_the_ID(), 'system_card_0' . $card_pos . '_badge', true );
                    }
                    if ( ! $title && ! $body ) continue;
                    $card_class = 'svc-system-module';
                    if ( $is_closer ) {
                        $card_class .= ' svc-system-module--closer';
                    } elseif ( $i === $orphan_index ) {
                        $card_class .= ' svc-system-module--wide';
                    }
                    ?>
                    <article class="<?php echo esc_attr( $card_class ); ?>">
                        <div class="svc-system-module-inner">
                            <?php if ( $badge_id ) : ?>
                                <div class="svc-system-module-badge">
                                    <?php echo wp_get_attachment_image( $badge_id, 'large', false, array(
                                        'alt'     => esc_attr( $title ),
                                        'loading' => 'lazy',
                                    ) ); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ( $label ) : ?>
                                <span class="svc-system-module-label"><?php echo esc_html( $label ); ?></span>
                            <?php endif; ?>
                            <?php if ( $title ) : ?>
                                <h3 class="svc-system-module-title"><?php echo esc_html( $title ); ?></h3>
                            <?php endif; ?>
                            <?php if ( $subtitle ) : ?>
                                <p class="svc-system-module-subtitle"><?php echo esc_html( $subtitle ); ?></p>
                            <?php endif; ?>
                            <?php if ( $body ) : ?>
                                <p class="svc-system-module-body"><?php echo esc_html( $body ); ?></p>
                            <?php endif; ?>
                            <?php if ( $stat_value || $stat_descriptor ) : ?>
                                <div class="svc-system-module-stat">
                                    <?php if ( $stat_value ) : ?>
                                        <span class="svc-system-module-stat-value"><?php echo esc_html( $stat_value ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $stat_descriptor ) : ?>
                                        <span class="svc-system-module-stat-descriptor"><?php echo esc_html( $stat_descriptor ); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
