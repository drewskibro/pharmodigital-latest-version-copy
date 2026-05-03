<?php
/**
 * Service: FAQ section.
 *
 * Dark navy section with an accordion list of question/answer pairs.
 * Each .svc-faq-item carries a numbered gold pill (hidden on mobile),
 * a question line, and a [+] icon that rotates to a gold ✕ when the
 * item opens. service.js wires the click toggle on .svc-faq-question.
 *
 * Below the list, an optional bottom-CTA strip with a tag line and
 * green button echoing the buy-now anchor.
 *
 * Reads from per-section ACF group `Service · FAQ`. Returns early
 * when the show toggle is off. Falls back to The Playbook copy from
 * the static spec when ACF fields are empty. Answers accept inline
 * <strong> via wp_kses_post.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_faq_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_faq_eyebrow',  'No Surprises' );
$headline = gh_field( 'service_faq_headline', "Questions You're Asking" );

$items = get_field( 'service_faq_items' );
if ( empty( $items ) ) {
    $items = array(
        array(
            'question' => "\"I'm not technical. Can I do this?\"",
            'answer'   => "If you can copy and paste, yes. Module 1 walks you through setup step by step. All prompts are written — you paste them in. And if you can't figure it out after the modules, <strong>I'll personally walk you through it on a call.</strong>",
        ),
        array(
            'question' => '"Will this work for my specialty?"',
            'answer'   => 'Yes. Ealing is a travel clinic. Superior is a pharmacy. Works for <strong>private clinics, IVF clinics, dental practices, specialist consultants, private hospitals</strong> — any private healthcare where patients search online. The method is identical. Only the keywords change.',
        ),
        array(
            'question' => '"How long until I see results?"',
            'answer'   => 'Ealing: <strong>6 weeks to first Google AI Overview feature</strong>. Superior: <strong>first ChatGPT sale in 48 hours</strong>. Typical range: 6–12 weeks for solid AI presence. Some practices see features in 2–4 weeks. Depends on how competitive your niche is and how quickly you publish.',
        ),
        array(
            'question' => '"I don\'t have time."',
            'answer'   => "1 hour per week. One pillar. Four clusters. Five pieces. The prompts are written — you're not starting from scratch. If you can't find 1 hour per week, the done-for-you option (starting at £5k/month) might suit you better.",
        ),
        array(
            'question' => '"What if AI platforms change their algorithm?"',
            'answer'   => "Monthly calls cover this. ChatGPT updates. Google changes. Claude features. <strong>You'll know what to adjust before your competitors do.</strong> Every call is recorded so you never miss an update.",
        ),
        array(
            'question' => '"Can I use this for multiple practices?"',
            'answer'   => 'Yes. You own it. <strong>One practice or fifty. No limits.</strong> The prompts work across any healthcare specialty. One purchase covers everything.',
        ),
        array(
            'question' => '"Why not just hire you to do it?"',
            'answer'   => 'You can. Done-for-you starts at £5k/month. But if you want to own the system — no ongoing fees, no dependency on an agency — this is for you. <strong>£497 once vs £60k/year.</strong> Same results.',
        ),
        array(
            'question' => '"Is there a refund policy?"',
            'answer'   => "No refunds — because this works. It's documented. The screenshots don't lie. But if you go through all 5 modules and still don't understand how to implement it, <strong>I'll personally walk you through it on a 1-on-1 call at no extra charge.</strong> You're not buying a course. You're getting a system that works.",
        ),
    );
}

$cta_show  = gh_field( 'service_faq_cta_show',  1 );
$cta_text  = gh_field( 'service_faq_cta_text',  'Still have questions? <strong>Get the system now and ask me directly on the monthly calls.</strong>' );
$cta_label = gh_field( 'service_faq_cta_label', 'Get Instant Access — £497' );
$cta_url   = gh_field( 'service_faq_cta_url',   '#buy-now' );
?>

<section class="svc-faq">
    <div class="svc-faq-inner">
        <div class="svc-faq-header">
            <?php if ( $eyebrow ) : ?>
                <p class="svc-faq-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-faq-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $items ) ) : ?>
            <div class="svc-faq-list">
                <?php foreach ( $items as $i => $item ) :
                    $q = $item['question'] ?? '';
                    $a = $item['answer']   ?? '';
                    if ( ! $q && ! $a ) continue;
                    $num = sprintf( '%02d', $i + 1 );
                    ?>
                    <div class="svc-faq-item">
                        <button class="svc-faq-question" type="button" aria-expanded="false">
                            <span class="svc-faq-question-left">
                                <span class="svc-faq-question-num" aria-hidden="true"><?php echo esc_html( $num ); ?></span>
                                <span class="svc-faq-question-text"><?php echo esc_html( $q ); ?></span>
                            </span>
                            <span class="svc-faq-icon" aria-hidden="true">+</span>
                        </button>
                        <div class="svc-faq-answer">
                            <p class="svc-faq-answer-inner"><?php echo wp_kses_post( $a ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $cta_show && ( $cta_text || $cta_label ) ) : ?>
            <div class="svc-faq-bottom-cta">
                <?php if ( $cta_text ) : ?>
                    <p><?php echo wp_kses_post( $cta_text ); ?></p>
                <?php endif; ?>
                <?php if ( $cta_label ) : ?>
                    <a href="<?php echo esc_url( $cta_url ); ?>">
                        <?php echo esc_html( $cta_label ); ?>
                        <span class="svc-btn-arrow" aria-hidden="true">→</span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
