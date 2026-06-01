<?php
/**
 * Section: The Shift (homepage)
 *
 * Header + two-column comparison (Google search mockup vs ChatGPT mockup) +
 * row of three "client result" proof cards. Mockup decoration (fake search-
 * result bars, AI bubble structure) is hardcoded; only the editable copy
 * (queries, captions, recommendations) is ACF-driven.
 *
 * @package Gildhart
 */

$eyebrow      = gh_field( 'shift_eyebrow', 'The Shift' );
$headline     = gh_field( 'shift_headline', 'The biggest change in patient acquisition in twenty years just happened. Quietly.' );
$subheadline  = gh_field( 'shift_subheadline', "Patients used to scroll ten Google results. They now read three AI recommendations. Same intent, different game, completely different winners." );

$old_label    = gh_field( 'shift_old_label', 'The Old Game' );
$old_query    = gh_field( 'shift_old_query', 'Best Mounjaro provider' );
$old_caption  = gh_field( 'shift_old_caption', 'Ten results. Mostly ads. Patients scroll, compare, abandon. The model that built every digital marketing agency for two decades.' );

$new_label        = gh_field( 'shift_new_label', 'The New Reality' );
$new_logo_label   = gh_field( 'shift_new_logo_label', 'ChatGPT' );
$new_query        = gh_field( 'shift_new_query', 'Best Mounjaro provider UK?' );
$new_intro        = gh_field( 'shift_new_response_intro', 'Here are the top providers currently recommended for Mounjaro in the UK:' );
$recommendations  = gh_field( 'shift_new_recommendations', array() );
if ( empty( $recommendations ) ) {
    $recommendations = array(
        array( 'name' => 'Superior Pharmacy', 'detail' => 'Specialist weight-management clinic with same-day private prescriptions.' ),
        array( 'name' => 'Ealing Travel Clinic', 'detail' => 'GPhC-registered with senior pharmacist consultations.' ),
        array( 'name' => 'Puri Pharmacy',     'detail' => 'Independent pharmacy ranked #1 nationally for Mounjaro provision.' ),
    );
}
$shortlist_note   = gh_field( 'shift_new_shortlist_note', "AI gives 3–5 recommendations. That's the entire market." );
$new_caption      = gh_field( 'shift_new_caption', 'Three results. No ads. The decision is essentially made before the patient ever clicks a website.' );

$proof_cards = gh_field( 'shift_proof_cards', array() );
if ( empty( $proof_cards ) ) {
    $proof_cards = array(
        array( 'value' => '300%',  'label' => 'Ealing Travel Clinic revenue growth' ),
        array( 'value' => '50%',   'label' => 'Superior Pharmacy sales from ChatGPT' ),
        array( 'value' => '#1 UK', 'label' => 'Puri Pharmacy for Mounjaro nationally' ),
    );
}

// Always render — defaults carry the section without ACF data.

$allowed_inline = array( 'strong' => array(), 'em' => array(), 'br' => array() );

// Hardcoded width sets for the 8 fake Google result bars (mirrors the
// static design's randomised look). Decorative only.
$google_widths = array(
    array( 'url' => 42, 'title' => 78, 'snippet' => 100 ),
    array( 'url' => 38, 'title' => 85, 'snippet' => 80 ),
    array( 'url' => 50, 'title' => 70, 'snippet' => 92 ),
    array( 'url' => 44, 'title' => 75, 'snippet' => 86 ),
    array( 'url' => 33, 'title' => 82, 'snippet' => 74 ),
    array( 'url' => 48, 'title' => 65, 'snippet' => 88 ),
    array( 'url' => 37, 'title' => 72, 'snippet' => 84 ),
    array( 'url' => 41, 'title' => 79, 'snippet' => 91 ),
);
?>

<section class="shift-section" id="the-shift">
    <div class="shift-inner">

        <div class="shift-header">
            <?php if ( $eyebrow ) : ?>
                <p class="shift-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="shift-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $subheadline ) : ?>
                <p class="shift-subheadline"><?php echo esc_html( $subheadline ); ?></p>
            <?php endif; ?>
        </div>

        <div class="shift-comparison">

            <!-- Left: The Old Game -->
            <div class="shift-col shift-col-old">
                <div class="shift-col-label"><?php echo esc_html( $old_label ); ?></div>
                <div class="shift-col-visual">
                    <div class="google-mockup">
                        <div class="google-mockup-bar">
                            <span class="google-mockup-search-icon">🔍</span>
                            <span class="google-mockup-query"><?php echo esc_html( $old_query ); ?></span>
                        </div>
                        <?php foreach ( $google_widths as $i => $w ) :
                            $is_last = ( $i === count( $google_widths ) - 1 );
                            ?>
                            <div class="google-result"<?php echo $is_last ? ' style="border-bottom:none"' : ''; ?>>
                                <div class="google-result-url" style="width:<?php echo (int) $w['url']; ?>%"></div>
                                <div class="google-result-title" style="width:<?php echo (int) $w['title']; ?>%"></div>
                                <div class="google-result-snippet" style="width:<?php echo (int) $w['snippet']; ?>%"></div>
                            </div>
                        <?php endforeach; ?>
                        <div class="google-page-indicator">
                            <div class="google-page-dot active-page">1</div>
                            <div class="google-page-dot">2</div>
                            <div class="google-page-dot">3</div>
                            <div class="google-page-dot">4</div>
                            <span style="font-size:0.65rem;color:var(--gray-400);margin-left:0.25rem">→ Page 2</span>
                        </div>
                        <div class="google-scroll-hint">
                            <span>↓ Scroll for more results</span>
                        </div>
                    </div>
                </div>
                <?php if ( $old_caption ) : ?>
                    <div class="shift-col-caption"><?php echo wp_kses( $old_caption, $allowed_inline ); ?></div>
                <?php endif; ?>
            </div>

            <!-- Right: The New Reality -->
            <div class="shift-col shift-col-new">
                <div class="shift-col-label"><?php echo esc_html( $new_label ); ?></div>
                <div class="shift-col-visual">
                    <div class="ai-mockup">
                        <div class="ai-mockup-header">
                            <div class="ai-mockup-logo">AI</div>
                            <span class="ai-mockup-name"><?php echo esc_html( $new_logo_label ); ?></span>
                        </div>
                        <div class="ai-user-bubble"><?php echo esc_html( $new_query ); ?></div>
                        <?php if ( $new_intro ) : ?>
                            <p class="ai-response-intro"><?php echo esc_html( $new_intro ); ?></p>
                        <?php endif; ?>
                        <?php foreach ( $recommendations as $i => $rec ) :
                            $rank = $i + 1;
                            $name = $rec['name']   ?? '';
                            $det  = $rec['detail'] ?? '';
                            $checkmark = ( 1 === $rank ) ? ' ✓' : '';
                            ?>
                            <div class="ai-recommendation">
                                <div class="ai-rec-rank"><?php echo (int) $rank; ?></div>
                                <div>
                                    <?php if ( $name ) : ?>
                                        <div class="ai-rec-name"><?php echo esc_html( $name . $checkmark ); ?></div>
                                    <?php endif; ?>
                                    <?php if ( $det ) : ?>
                                        <div class="ai-rec-detail"><?php echo esc_html( $det ); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if ( $shortlist_note ) : ?>
                            <p class="ai-shortlist-note"><?php echo esc_html( $shortlist_note ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ( $new_caption ) : ?>
                    <div class="shift-col-caption"><?php echo wp_kses( $new_caption, $allowed_inline ); ?></div>
                <?php endif; ?>
            </div>

        </div>

        <?php if ( ! empty( $proof_cards ) ) : ?>
            <div class="shift-proof">
                <?php foreach ( $proof_cards as $card ) :
                    $label = $card['label'] ?? 'CLIENT RESULT';
                    $name  = $card['name']  ?? '';
                    $win   = $card['win']   ?? '';
                    $stat  = $card['stat']  ?? '';
                    ?>
                    <div class="shift-proof-card">
                        <p class="shift-proof-label"><?php echo esc_html( $label ); ?></p>
                        <?php if ( $name ) : ?>
                            <p class="shift-proof-name"><?php echo esc_html( $name ); ?></p>
                        <?php endif; ?>
                        <?php if ( $win ) : ?>
                            <p class="shift-proof-win"><?php echo esc_html( $win ); ?></p>
                        <?php endif; ?>
                        <?php if ( $stat ) : ?>
                            <p class="shift-proof-stat"><?php echo esc_html( $stat ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
