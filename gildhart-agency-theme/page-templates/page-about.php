<?php
/**
 * Template Name: About Gildhart
 *
 * The About page — four full-bleed sections built on the Gildhart
 * design system (forest green / gold / cream / navy, Outfit + Inter,
 * shared tokens). Hero (green) → Founder (cream) → Who We Work With
 * (green) → Closing CTA (green); the founder block is the editorial
 * centrepiece.
 *
 * All copy renders from PHP defaults via gh_field(), so the page is
 * complete the moment the template is assigned to a Page — the ACF
 * group `Page · About` (inc/acf-fields.php) lets every field be
 * overridden in the admin. Repeaters (results, audience cards) fall
 * back to the arrays below.
 *
 * Styles live in assets/css/about.css, enqueued on this template in
 * functions.php. No new design tokens — everything references the
 * variables in globals.css.
 *
 * @package Gildhart
 */

get_header();

/* ── Shared assets ── */
$crest_fallback = 'https://pharmodigital.kinsta.cloud/wp-content/uploads/2026/05/Gildhart-08-scaled.png';
$crest_id       = (int) get_field( 'about_crest_logo' );

/* Founder photo: prefer an About-specific upload, then reuse the
 * homepage founder image, then the guarantee Drew photo, so the
 * portrait renders without any extra wiring. */
$founder_img = (int) get_field( 'about_founder_image' );
if ( ! $founder_img ) { $founder_img = (int) get_field( 'founder_image' ); }
if ( ! $founder_img ) { $founder_img = (int) get_field( 'guarantee_drew_photo' ); }

$linkedin_url = gh_field( 'about_founder_linkedin_url' );
if ( ! $linkedin_url && function_exists( 'gh_option' ) ) {
    $linkedin_url = gh_option( 'social_linkedin' );
}

/* ── Section 1 — Hero ── */
$hero_label    = gh_field( 'about_hero_label',    'About Gildhart' );
$hero_headline = gh_field( 'about_hero_headline', 'The AI Infrastructure Company That Only Works In Healthcare.' );
$hero_intro    = gh_field( 'about_hero_intro',    'There are AI agencies. There are healthcare marketing agencies. There are very few people who understand both deeply enough to build systems that actually work in a regulated, clinically complex, patient-facing environment. Gildhart sits at that intersection deliberately.' );

/* ── Section 2 — The Founder ── */
$f_label    = gh_field( 'about_founder_label',    'The Founder' );
$f_headline = gh_field( 'about_founder_headline', 'Twenty Years In Healthcare. Built From The Inside.' );
$f_block_1  = gh_field( 'about_founder_block_1',  "I've spent my career inside healthcare. Not observing it from the outside. NHS campaigns. Bupa. Harley Street clinics. Bizitch Dental — one of the UK's largest dental groups. Twenty years working on the accounts that shaped how millions of patients find and choose their providers." );
$f_pullquote = gh_field( 'about_founder_pullquote', "Then AI search happened. And everything I'd learned about how patients make healthcare decisions became the foundation for something entirely new." );
$f_block_2  = gh_field( 'about_founder_block_2',  "ChatGPT doesn't search Google. It searches Bing. Google AI Overviews don't reward brand size. They reward clinical authority and content architecture. AI platforms trust the practices that speak their language. Most healthcare practices don't know what that language is yet." );
$f_block_3  = gh_field( 'about_founder_block_3',  "I do. And I've spent the last few years building the infrastructure that puts our clients at the top of every AI platform patients now use to make healthcare decisions." );
$f_name     = gh_field( 'about_founder_name',     'Drew' );
$f_title    = gh_field( 'about_founder_title',    'Founder, Gildhart' );
$f_linkedin_text = gh_field( 'about_founder_linkedin_text', 'Connect with me on LinkedIn — 5,000+ healthcare professionals follow our AI search insights.' );

$f_results = get_field( 'about_founder_results' );
if ( empty( $f_results ) ) {
    $f_results = array(
        array( 'text' => 'Superior Pharmacy is on track for £500k this year.' ),
        array( 'text' => 'Ealing Travel Clinic generates £100k from a single service.' ),
        array( 'text' => 'Southdowns captures 250+ extra private patient enquiries every month.' ),
    );
}

/* ── Section 3 — Who We Work With ── */
$ww_label    = gh_field( 'about_who_label',    'Who We Work With' );
$ww_headline = gh_field( 'about_who_headline', 'Built For The Practices Ready To Own Their Market.' );
$ww_subhead  = gh_field( 'about_who_subhead',  'We work with pharmacy groups, private clinic operators, and healthcare businesses that have made a decision. Not a consideration. They already understand that AI search is the most significant shift in patient acquisition in twenty years.' );

$ww_cards = get_field( 'about_who_cards' );
if ( empty( $ww_cards ) ) {
    $ww_cards = array(
        array(
            'stat'     => '£500k+',
            'label'    => 'Pharmacy Groups',
            'headline' => 'Independent pharmacy groups and multi-site operators ready to become the dominant practice in their market.',
            'body'     => 'Superior Pharmacy went from invisible to £500k annual revenue on AI search alone.',
            'featured' => 0,
        ),
        array(
            'stat'     => '300%',
            'label'    => 'Private Clinic Operators',
            'headline' => 'Private clinics with high-value services and the ambition to make AI search their primary patient acquisition channel.',
            'body'     => 'Ealing Travel Clinic generates £100k from a single service we built infrastructure around.',
            'featured' => 1,
        ),
        array(
            'stat'     => '250+',
            'label'    => 'Enterprise Healthcare',
            'headline' => 'Healthcare businesses operating at scale who understand that the window to build AI search dominance is open now.',
            'body'     => 'Southdowns went from zero digital presence to 250+ private patient enquiries a month across 13 services.',
            'featured' => 0,
        ),
    );
}

/* ── Section 5 — Closing CTA ── */
$cta_headline = gh_field( 'about_cta_headline', 'The system is already working. For practices exactly like yours.' );
$cta_subhead  = gh_field( 'about_cta_subhead',  'Start with the Playbook and run the system yourself. Or let us deploy it for you with The Agent. Both are working right now.' );
$cta_btn1_label = gh_field( 'about_cta_btn1_label', 'Get The Playbook' );
$cta_btn1_url   = gh_field( 'about_cta_btn1_url',   home_url( '/the-playbook/' ) );
$cta_btn2_label = gh_field( 'about_cta_btn2_label', 'See The Agent' );
$cta_btn2_url   = gh_field( 'about_cta_btn2_url',   home_url( '/the-agent/' ) );

/* Helper: render the gold crest. */
function gildhart_about_crest( $crest_id, $crest_fallback ) {
    echo '<div class="about-crest">';
    if ( $crest_id ) {
        echo wp_get_attachment_image( $crest_id, 'full', false, array( 'alt' => 'Gildhart', 'loading' => 'lazy' ) );
    } else {
        echo '<img src="' . esc_url( $crest_fallback ) . '" alt="Gildhart" loading="lazy" />';
    }
    echo '</div>';
}
?>

<main id="main" class="site-main about-page">

    <?php /* ───────────── SECTION 1 — HERO ───────────── */ ?>
    <section class="about-hero">
        <div class="about-hero-inner">
            <?php if ( $hero_label ) : ?>
                <p class="about-eyebrow about-eyebrow--centered"><?php echo esc_html( $hero_label ); ?></p>
            <?php endif; ?>
            <?php if ( $hero_headline ) : ?>
                <h1 class="about-hero-headline"><?php echo esc_html( $hero_headline ); ?></h1>
            <?php endif; ?>
            <?php if ( $hero_intro ) : ?>
                <p class="about-hero-intro"><?php echo esc_html( $hero_intro ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <?php /* ───────────── SECTION 2 — THE FOUNDER ───────────── */ ?>
    <section class="about-founder">
        <div class="about-founder-inner">

            <div class="about-founder-copy">
                <?php if ( $f_label ) : ?>
                    <p class="about-eyebrow"><?php echo esc_html( $f_label ); ?></p>
                <?php endif; ?>
                <?php if ( $f_headline ) : ?>
                    <h2 class="about-founder-headline"><?php echo esc_html( $f_headline ); ?></h2>
                <?php endif; ?>

                <?php if ( $f_block_1 ) : ?>
                    <p class="about-body"><?php echo esc_html( $f_block_1 ); ?></p>
                <?php endif; ?>

                <?php if ( $f_pullquote ) : ?>
                    <blockquote class="about-pullquote"><?php echo esc_html( $f_pullquote ); ?></blockquote>
                <?php endif; ?>

                <?php if ( $f_block_2 ) : ?>
                    <p class="about-body"><?php echo esc_html( $f_block_2 ); ?></p>
                <?php endif; ?>

                <?php if ( $f_block_3 ) : ?>
                    <p class="about-body about-body--strong"><?php echo esc_html( $f_block_3 ); ?></p>
                <?php endif; ?>

                <?php if ( ! empty( $f_results ) ) : ?>
                    <ul class="about-results">
                        <?php foreach ( $f_results as $r ) :
                            $rt = is_array( $r ) ? ( $r['text'] ?? '' ) : $r;
                            if ( ! $rt ) continue; ?>
                            <li class="about-result"><?php echo esc_html( $rt ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( $f_name || $f_title ) : ?>
                    <div class="about-signoff">
                        <?php if ( $f_name ) : ?>
                            <span class="about-signoff-name"><?php echo esc_html( $f_name ); ?></span>
                        <?php endif; ?>
                        <?php if ( $f_title ) : ?>
                            <span class="about-signoff-title"><?php echo esc_html( $f_title ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="about-founder-media">
                <?php if ( $founder_img ) : ?>
                    <div class="about-founder-photo">
                        <?php echo wp_get_attachment_image( $founder_img, 'large', false, array(
                            'alt'     => esc_attr( $f_name ),
                            'loading' => 'lazy',
                        ) ); ?>
                    </div>
                <?php endif; ?>
                <?php gildhart_about_crest( $crest_id, $crest_fallback ); ?>

                <?php if ( $linkedin_url && $f_linkedin_text ) : ?>
                    <a class="about-linkedin about-linkedin--media" href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#0A66C2" aria-hidden="true">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        <span><?php echo esc_html( $f_linkedin_text ); ?></span>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </section>

    <?php /* ───────────── SECTION 3 — WHO WE WORK WITH ───────────── */ ?>
    <section class="about-who">
        <div class="about-who-inner">
            <div class="about-who-header">
                <?php if ( $ww_label ) : ?>
                    <p class="about-eyebrow about-eyebrow--centered about-eyebrow--on-green"><?php echo esc_html( $ww_label ); ?></p>
                <?php endif; ?>
                <?php if ( $ww_headline ) : ?>
                    <h2 class="about-who-headline"><?php echo esc_html( $ww_headline ); ?></h2>
                <?php endif; ?>
                <?php if ( $ww_subhead ) : ?>
                    <p class="about-who-subhead"><?php echo esc_html( $ww_subhead ); ?></p>
                <?php endif; ?>
            </div>

            <div class="about-who-cards">
                <?php foreach ( $ww_cards as $card ) :
                    $stat     = $card['stat']     ?? '';
                    $label    = $card['label']    ?? '';
                    $headline = $card['headline'] ?? '';
                    $body     = $card['body']     ?? '';
                    $featured = ! empty( $card['featured'] );
                    if ( ! $stat && ! $headline ) continue; ?>
                    <article class="about-who-card<?php echo $featured ? ' about-who-card--featured' : ''; ?>">
                        <?php if ( $stat ) : ?>
                            <p class="about-who-card-stat"><?php echo esc_html( $stat ); ?></p>
                        <?php endif; ?>
                        <?php if ( $label ) : ?>
                            <p class="about-who-card-label"><?php echo esc_html( $label ); ?></p>
                        <?php endif; ?>
                        <?php if ( $headline ) : ?>
                            <h3 class="about-who-card-headline"><?php echo esc_html( $headline ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $body ) : ?>
                            <p class="about-who-card-body"><?php echo esc_html( $body ); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php /* ───────────── SECTION 4 — CLOSING CTA ───────────── */ ?>
    <section class="about-cta">
        <div class="about-cta-inner">
            <?php gildhart_about_crest( $crest_id, $crest_fallback ); ?>
            <?php if ( $cta_headline ) : ?>
                <h2 class="about-cta-headline"><?php echo esc_html( $cta_headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $cta_subhead ) : ?>
                <p class="about-cta-subhead"><?php echo esc_html( $cta_subhead ); ?></p>
            <?php endif; ?>
            <div class="about-cta-buttons">
                <?php if ( $cta_btn1_label ) : ?>
                    <a href="<?php echo esc_url( $cta_btn1_url ); ?>" class="btn btn-primary about-cta-btn"><?php echo esc_html( $cta_btn1_label ); ?></a>
                <?php endif; ?>
                <?php if ( $cta_btn2_label ) : ?>
                    <a href="<?php echo esc_url( $cta_btn2_url ); ?>" class="btn about-btn-ghost about-cta-btn"><?php echo esc_html( $cta_btn2_label ); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
