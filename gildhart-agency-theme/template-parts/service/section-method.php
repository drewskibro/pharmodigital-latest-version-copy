<?php
/**
 * Service: The Playbook section (formerly "Method").
 *
 * Dark navy section that walks through the four-step DIY system the
 * Playbook customer runs themselves. Centred header (eyebrow + H2 +
 * subtext + gold anchor stat) sits above an alternating two-column
 * step grid: step 01 = text left / visual right, step 02 = text
 * right / visual left, and so on.
 *
 * Each step block carries:
 *   - Big gold display number
 *   - Bold white title
 *   - Body copy
 *   - Optional proof pill
 *   - A paired visual (ACF image — falls back to a styled intentional
 *     placeholder when no image is uploaded yet)
 *
 * Reads from per-section ACF group `Service · Method`. Steps reveal
 * on scroll via svcReveal('.svc-method-step', 'is-visible') — JS
 * unchanged from the previous timeline build, so the existing reveal
 * + observer keeps working without re-wiring.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_method_show', 1 ) ) {
    return;
}

$eyebrow      = gh_field( 'service_method_eyebrow',      'The Playbook' );
$headline     = gh_field( 'service_method_headline',     'The System Behind the Results.' );
$subtext      = gh_field( 'service_method_proof_line',   "Sachin went from 8 HPV bookings to 55 a month. Superior Pharmacy appeared in ChatGPT within 4 weeks. Ealing Travel Clinic outranked Boots. Different clinics. Different specialisms. Same four steps. Yours to execute. The Playbook gives you the system. You run it." );

$anchor_num   = gh_field( 'service_method_anchor_stat_value', '55' );
$anchor_label = gh_field( 'service_method_anchor_stat_label', "Bookings per month — Sachin's Playbook result" );

$steps = get_field( 'service_method_steps' );
if ( empty( $steps ) ) {
    $steps = array(
        array(
            'title'       => 'Find What Your Patients Are Already Asking',
            'text'        => "Right now, patients in your area are typing questions into ChatGPT, Google AI, and Perplexity. About Mounjaro. About travel vaccines. About HPV. About weight loss injections. About conditions they're too embarrassed to ask their GP. Those questions are getting answered — by someone. In this step you find the exact questions, and map a content architecture that makes that someone you.",
            'text_mobile' => 'Patients in your area are already asking questions in ChatGPT, Google AI, and Perplexity — about Mounjaro, travel vaccines, HPV, and weight loss. This step finds those exact questions and maps a content architecture that makes you the one who answers them.',
            'proof_pill'  => '',
            'image'       => 0,
            'mobile_image' => 0,
            'visual_kind' => 'intent',
        ),
        array(
            'title'       => "Build the Content That Makes Them Call Before They've Even Met You",
            'text'        => "Ealing went from invisible to above Boots in six weeks — no ads, no agency, no cold outreach. The content did it. It's the same reason an IVF referral coordinator found Sachin through a blog post and started sending patients: the right content sells without selling. You'll learn the exact formats that AI platforms trust, that patients read for 6 minutes instead of 30 seconds, and that turn a search into a booked appointment.",
            'text_mobile' => "Ealing went from invisible to above Boots in six weeks — no ads, no agency. The content did it. This step covers the exact formats that AI platforms trust — content patients read for 6 minutes instead of 30 seconds, that turns a search into a booked appointment.",
            'proof_pill'  => 'Ealing Travel Clinic: avg. 6m 40s session duration',
            'image'       => 0,
            'mobile_image' => 0,
            'visual_kind' => 'dwell',
        ),
        array(
            'title'       => 'Make It Readable by Humans and AI Simultaneously',
            'text'        => "A well-written page that AI can't parse doesn't get cited. You'll structure entity relationships, schema markup, citation density, and the formatting patterns that make Claude, ChatGPT, and Google AI Overviews pull from your content instead of your competitor's. It's not technical for the sake of it. It's the difference between existing and being recommended.",
            'text_mobile' => "A well-written page that AI can't parse doesn't get cited. This step covers the structure, schema, and formatting patterns that make ChatGPT, Claude, and Google AI Overviews pull from your content instead of your competitor's.",
            'proof_pill'  => '',
            'image'       => 0,
            'mobile_image' => 0,
            'visual_kind' => 'schema',
        ),
        array(
            'title'       => 'Get Indexed. Appear. Know the Moment It Happens.',
            'text'        => "Standard publishing waits weeks to get crawled. You'll cut that window. Then you'll monitor every AI platform so you see the exact moment your clinic gets recommended — and what to do next to compound it.",
            'text_mobile' => 'Standard publishing waits weeks to get crawled. This step cuts that window — then shows you how to monitor every AI platform so you see the exact moment your clinic gets recommended.',
            'proof_pill'  => 'Superior Pharmacy: ChatGPT results within 4 weeks of publishing',
            'image'       => 0,
            'mobile_image' => 0,
            'visual_kind' => 'dashboard',
        ),
    );
}
?>

<section class="svc-method" id="method">
    <div class="svc-method-inner">
        <header class="svc-method-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-method-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-method-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $subtext ) : ?>
                <p class="svc-method-subtext"><?php echo esc_html( $subtext ); ?></p>
            <?php endif; ?>
            <?php if ( $anchor_num || $anchor_label ) : ?>
                <div class="svc-method-anchor-stat">
                    <?php if ( $anchor_num ) : ?>
                        <span class="svc-method-anchor-num"><?php echo esc_html( $anchor_num ); ?></span>
                    <?php endif; ?>
                    <?php if ( $anchor_label ) : ?>
                        <span class="svc-method-anchor-label"><?php echo esc_html( $anchor_label ); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </header>

        <div class="svc-method-rows">
            <?php foreach ( $steps as $i => $step ) :
                $title          = $step['title']        ?? '';
                $text           = $step['text']         ?? '';
                $text_mobile    = $step['text_mobile']  ?? '';
                $proof_pill     = $step['proof_pill']   ?? '';
                $image_id       = (int) ( $step['image']        ?? 0 );
                $mobile_image_id = (int) ( $step['mobile_image'] ?? 0 );
                $visual_kind    = $step['visual_kind']  ?? 'intent';
                $num            = sprintf( '%02d', $i + 1 );
                // Empty mobile body falls back to the desktop copy so a step
                // with a single text field still renders something on phones.
                $mobile_body    = $text_mobile !== '' ? $text_mobile : $text;
                // Alternate sides — odd rows put visual on the right, even
                // rows put it on the left. Mobile collapses both into the
                // same stack order regardless.
                $orient         = ( 0 === $i % 2 ) ? 'text-left' : 'text-right'; ?>
                <article class="svc-method-step svc-method-row svc-method-row--<?php echo esc_attr( $orient ); ?>">
                    <div class="svc-method-row-headline">
                        <span class="svc-method-step-num"><?php echo esc_html( $num ); ?></span>
                        <?php if ( $title ) : ?>
                            <h3 class="svc-method-step-title"><?php echo esc_html( $title ); ?></h3>
                        <?php endif; ?>
                    </div>
                    <div class="svc-method-row-visual svc-method-row-visual--<?php echo esc_attr( $visual_kind ); ?>">
                        <?php if ( $image_id ) : ?>
                            <?php echo wp_get_attachment_image( $image_id, 'large', false, array(
                                'class'   => 'svc-method-visual-img',
                                'alt'     => esc_attr( $title ),
                                'loading' => 'lazy',
                            ) ); ?>
                        <?php else : ?>
                            <div class="svc-method-visual-placeholder" aria-hidden="true">
                                <span class="svc-method-visual-placeholder-num"><?php echo esc_html( $num ); ?></span>
                                <span class="svc-method-visual-placeholder-label">Insert visual</span>
                            </div>
                        <?php endif; ?>
                        <?php // Proof pill overlay sits inside the visual for steps 02 + 04 on desktop. ?>
                        <?php if ( $proof_pill ) : ?>
                            <span class="svc-method-visual-pill"><?php echo esc_html( $proof_pill ); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php // Phone-framed mobile image — only renders if a mobile
                          // image is uploaded. CSS hides the entire figure on
                          // desktop and shows it as a 280px portrait card on
                          // ≤900px. ?>
                    <?php if ( $mobile_image_id ) : ?>
                        <figure class="svc-method-mobile-image">
                            <?php echo wp_get_attachment_image( $mobile_image_id, 'large', false, array(
                                'alt'     => esc_attr( $title ),
                                'loading' => 'lazy',
                            ) ); ?>
                        </figure>
                    <?php endif; ?>
                    <div class="svc-method-row-body">
                        <?php if ( $text ) : ?>
                            <p class="svc-method-step-text svc-method-step-text--desktop"><?php echo esc_html( $text ); ?></p>
                        <?php endif; ?>
                        <?php if ( $mobile_body ) : ?>
                            <p class="svc-method-step-text svc-method-step-text--mobile"><?php echo esc_html( $mobile_body ); ?></p>
                        <?php endif; ?>
                        <?php // Mobile-only proof pill mirrors the desktop visual
                              // overlay so the pill still appears on phones, below
                              // the body copy. CSS hides this on desktop. ?>
                        <?php if ( $proof_pill ) : ?>
                            <span class="svc-method-step-proof svc-method-step-proof--mobile"><?php echo esc_html( $proof_pill ); ?></span>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
