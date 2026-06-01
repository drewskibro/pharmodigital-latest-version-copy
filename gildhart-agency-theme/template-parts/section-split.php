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
$problem_title    = gh_field( 'split_problem_title', 'Patients aren\'t searching Google the way they used to.' );
$problem_lines    = gh_field( 'split_problem_lines', array() );
if ( empty( $problem_lines ) ) {
    $problem_lines = array(
        array( 'text' => "They're asking ChatGPT. They're asking Claude. They're reading Google's AI Overview before they ever click a website." ),
        array( 'text' => "And AI doesn't return ten blue links. It returns <strong>three recommendations</strong>. That's the whole market." ),
        array( 'text' => "If your practice isn't one of the three, it doesn't matter how good your website looks. You're invisible." ),
    );
}

$solution_eyebrow = gh_field( 'split_solution_eyebrow', 'THE SOLUTION' );
$cards            = gh_field( 'split_cards', array() );
if ( empty( $cards ) ) {
    $cards = array(
        array( 'title' => 'Built On Claude Code',  'body' => 'Every site we build is architected on the same AI infrastructure that powers the most advanced content systems in the world.' ),
        array( 'title' => 'Pillar Domination',     'body' => 'Each high-revenue service gets a content pillar mapped to the exact questions patients are asking AI right now.' ),
        array( 'title' => 'Indexed Everywhere',    'body' => 'Google, Bing, ChatGPT, Claude, Perplexity. We get you found in every AI platform patients use to choose their providers.' ),
        array( 'title' => 'Compounding Authority', 'body' => 'Every piece of content reinforces every other. Rankings climb. Citations follow. The system gets stronger every month.' ),
    );
}

$cta_text  = gh_field( 'split_cta_text',  'Run the playbook yourself, or let us deploy it for you.' );
$cta_label = gh_field( 'split_cta_label', 'See How It Works →' );
$cta_url   = gh_field( 'split_cta_url',   '#get-started' );

// Always render — defaults carry the section without ACF data.

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
                        $title = $card['title'] ?? '';
                        $text  = $card['text']  ?? '';
                        ?>
                        <div class="split-card">
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
