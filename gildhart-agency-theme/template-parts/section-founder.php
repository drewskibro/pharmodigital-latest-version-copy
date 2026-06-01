<?php
/**
 * Section: Founder (homepage)
 *
 * Two-column section: portrait on the left (with a soft cream-fade
 * gradient at the bottom of the photo so the natural crop looks
 * intentional), founder copy on the right with eyebrow, headline,
 * sequential paragraphs, name + LinkedIn link.
 *
 * Reveal staggers via .founder-visible (added by home.js when the
 * section enters the viewport).
 *
 * @package Gildhart
 */

$image_id     = gh_field( 'founder_image' );
$eyebrow      = gh_field( 'founder_eyebrow', 'The Person Behind The Results' );
$headline     = gh_field( 'founder_headline', "Twenty Years In Healthcare. Built From The Inside." );
$paragraphs   = gh_field( 'founder_paragraphs', array() );
if ( empty( $paragraphs ) ) {
    $paragraphs = array(
        array( 'text' => "I've spent my career inside healthcare. NHS campaigns. Bupa. Harley Street clinics. Bizitch Dental — one of the UK's largest dental groups. Twenty years working on the accounts that shaped how millions of patients find and choose their providers." ),
        array( 'text' => "Then AI search happened. And everything I'd learned about how patients make healthcare decisions became the foundation for something entirely new." ),
        array( 'text' => "ChatGPT doesn't search Google. It searches Bing. Google AI Overviews reward clinical authority and content architecture. Most healthcare practices don't know what that language is yet. I do — and I've spent the last few years building the infrastructure that puts our clients at the top of every AI platform patients now use." ),
    );
}
$name         = gh_field( 'founder_name', 'Drew' );
$title        = gh_field( 'founder_title', 'Founder, Gildhart' );
$linkedin_url = gh_field( 'founder_linkedin_url' );
if ( ! $linkedin_url && function_exists( 'gh_option' ) ) {
    $linkedin_url = gh_option( 'social_linkedin' );
}
$linkedin_txt = gh_field( 'founder_linkedin_text', 'Connect with me on LinkedIn — 5,000+ healthcare professionals follow our AI search insights.' );

// Always render — defaults above carry the section even when ACF is
// empty. The image still falls through when not set; the rest of the
// content holds the layout on its own.
?>

<section class="founder-section">
    <div class="founder-inner">

        <?php if ( $image_id ) : ?>
            <div class="founder-image">
                <?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'loading' => 'lazy' ) ); ?>
            </div>
        <?php endif; ?>

        <div class="founder-copy">
            <?php if ( $eyebrow ) : ?>
                <p class="founder-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>

            <?php if ( $headline ) : ?>
                <h2 class="founder-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>

            <?php
            // Render the body. The static design uses one <p> with <span class="founder-body-break">
            // for the second/third paragraphs so they share styling cascade rules. We mimic by
            // rendering the first paragraph as a normal <p> and any subsequent paragraphs as
            // <span class="founder-body-break"> inside that same <p>.
            if ( ! empty( $paragraphs ) ) :
                $first = true;
                foreach ( $paragraphs as $i => $para ) :
                    $text = $para['text'] ?? '';
                    if ( ! $text ) continue;
                    if ( $first ) :
                        ?>
                        <p class="founder-body">
                            <?php echo esc_html( $text ); ?>
                        <?php
                        $first = false;
                    else : ?>
                            <span class="founder-body-break"><?php echo esc_html( $text ); ?></span>
                        <?php
                    endif;
                endforeach;
                if ( ! $first ) {
                    echo '</p>';
                }
            endif;
            ?>

            <?php if ( $name || $title || $linkedin_url ) : ?>
                <div class="founder-name">
                    <?php if ( $name ) : ?>
                        <span class="founder-name-text"><?php echo esc_html( $name ); ?></span>
                    <?php endif; ?>
                    <?php if ( $title ) : ?>
                        <span class="founder-title-text"><?php echo esc_html( $title ); ?></span>
                    <?php endif; ?>
                    <?php if ( $linkedin_url ) : ?>
                        <a href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" rel="noopener noreferrer" class="founder-linkedin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#0A66C2" aria-hidden="true">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            <?php echo esc_html( $linkedin_txt ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
