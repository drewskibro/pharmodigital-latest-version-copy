<?php
/**
 * Section: Split — Problem / Solution (homepage)
 *
 * Two-column section: dark navy "Problem" copy on the left, warm gradient
 * "Solution" with a card grid on the right. Bottom: full-width green CTA
 * strip. Adds .split-visible via IntersectionObserver in home.js to
 * trigger the staggered reveal animations.
 *
 * @package Gildhart
 */

$problem_eyebrow  = gh_field( 'split_problem_eyebrow', 'THE PROBLEM' );
$problem_title    = gh_field( 'split_problem_title' );
$problem_lines    = gh_field( 'split_problem_lines', array() );

$solution_eyebrow = gh_field( 'split_solution_eyebrow', 'THE SOLUTION' );
$cards            = gh_field( 'split_cards', array() );

$cta_text  = gh_field( 'split_cta_text' );
$cta_label = gh_field( 'split_cta_label', 'Get The System →' );
$cta_url   = gh_field( 'split_cta_url', '#contact' );

if ( ! $problem_title && empty( $problem_lines ) && empty( $cards ) ) {
    return;
}

$allowed_inline = array( 'strong' => array(), 'em' => array(), 'br' => array() );
?>

<section>
    <div class="split-section">
        <div class="split-problem">
            <?php if ( $problem_eyebrow ) : ?>
                <p class="split-problem-eyebrow"><?php echo esc_html( $problem_eyebrow ); ?></p>
            <?php endif; ?>

            <?php if ( $problem_title ) : ?>
                <h2 class="split-problem-title"><?php echo esc_html( $problem_title ); ?></h2>
            <?php endif; ?>

            <?php foreach ( $problem_lines as $line ) :
                if ( empty( $line['text'] ) ) continue; ?>
                <p class="split-problem-text"><?php echo wp_kses( $line['text'], $allowed_inline ); ?></p>
            <?php endforeach; ?>
        </div>

        <div class="split-solution">
            <?php if ( $solution_eyebrow ) : ?>
                <p class="split-solution-eyebrow"><?php echo esc_html( $solution_eyebrow ); ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $cards ) ) : ?>
                <div class="split-cards">
                    <?php foreach ( $cards as $card ) :
                        $icon  = ! empty( $card['icon'] ) ? gh_fa_class( 'fa-' . ltrim( $card['icon'], 'fa-' ) ) : 'fas fa-circle-check';
                        $title = $card['title'] ?? '';
                        $text  = $card['text']  ?? '';
                        ?>
                        <div class="split-card">
                            <div class="split-card-icon"><i class="<?php echo esc_attr( $icon ); ?>"></i></div>
                            <?php if ( $title ) : ?>
                                <h3 class="split-card-title"><?php echo esc_html( $title ); ?></h3>
                            <?php endif; ?>
                            <?php if ( $text ) : ?>
                                <p class="split-card-text"><?php echo esc_html( $text ); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ( $cta_text || $cta_label ) : ?>
        <div class="split-cta">
            <?php if ( $cta_text ) : ?>
                <p class="split-cta-text"><?php echo esc_html( $cta_text ); ?></p>
            <?php endif; ?>
            <?php if ( $cta_label ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="split-cta-btn"><?php echo esc_html( $cta_label ); ?></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
