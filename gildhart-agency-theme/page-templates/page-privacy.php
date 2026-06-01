<?php
/**
 * Template Name: Privacy Policy
 *
 * Long-form privacy/legal page on the Gildhart design system.
 * Four sections (green hero → cream policy → cream reCAPTCHA notice
 * → green closing), no header-nav entry — accessed via the footer
 * Privacy Policy link and direct URL.
 *
 * The policy body renders from a single WYSIWYG ACF field
 * (privacy_content) so headings, sub-headings, paragraphs, bullets,
 * and links can all be edited in WP Admin without touching code. The
 * default value below is the full policy text marked up as HTML; CSS
 * in privacy.css styles every native element under .privacy-content.
 * Hero, reCAPTCHA notice, and closing strap are individual editable
 * ACF fields.
 *
 * @package Gildhart
 */

get_header();

$hero_label    = gh_field( 'privacy_hero_label',    'Legal' );
$hero_headline = gh_field( 'privacy_hero_headline', 'Your Privacy. Handled With The Same Precision As Everything Else We Build.' );
$hero_updated  = gh_field( 'privacy_hero_updated',  'Last updated: May 2026' );

$policy_content = gh_field( 'privacy_content', gildhart_privacy_default_content() );

$recaptcha_text = gh_field(
    'privacy_recaptcha_text',
    sprintf(
        /* translators: %1$s and %2$s are anchor tags wrapping link text. */
        'This site is protected by reCAPTCHA and the Google %1$s and %2$s apply.',
        '<a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">Privacy Policy</a>',
        '<a href="https://policies.google.com/terms" target="_blank" rel="noopener noreferrer">Terms of Service</a>'
    )
);

$closing_text = gh_field(
    'privacy_closing_text',
    'Questions about this policy? Contact us at <a href="mailto:bookings@gildhart.com">bookings@gildhart.com</a>'
);
?>

<main id="main" class="site-main privacy-page">

    <?php /* ───────────── HERO ───────────── */ ?>
    <section class="privacy-hero">
        <div class="privacy-hero-inner">
            <?php if ( $hero_label ) : ?>
                <p class="privacy-eyebrow"><?php echo esc_html( $hero_label ); ?></p>
            <?php endif; ?>
            <?php if ( $hero_headline ) : ?>
                <h1 class="privacy-hero-headline"><?php echo esc_html( $hero_headline ); ?></h1>
            <?php endif; ?>
            <?php if ( $hero_updated ) : ?>
                <p class="privacy-hero-updated"><?php echo esc_html( $hero_updated ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <?php /* ───────────── POLICY CONTENT ───────────── */ ?>
    <section class="privacy-content-section">
        <div class="privacy-content">
            <?php echo wp_kses_post( $policy_content ); ?>
        </div>
    </section>

    <?php /* ───────────── RECAPTCHA NOTICE ───────────── */ ?>
    <section class="privacy-recaptcha">
        <p class="privacy-recaptcha-text"><?php echo wp_kses(
            $recaptcha_text,
            array(
                'a' => array(
                    'href'   => array(),
                    'target' => array(),
                    'rel'    => array(),
                ),
            )
        ); ?></p>
    </section>

    <?php /* ───────────── CLOSING ───────────── */ ?>
    <section class="privacy-closing">
        <p class="privacy-closing-text"><?php echo wp_kses(
            $closing_text,
            array(
                'a' => array(
                    'href'   => array(),
                    'target' => array(),
                    'rel'    => array(),
                ),
            )
        ); ?></p>
    </section>

</main>

<?php get_footer();
