<?php
/**
 * Service: The Window section (Playbook).
 *
 * Long-form opening frame that sets the "SEO in 2006 / mother of all
 * second chances" positioning. Single full-width section over the
 * hero's cream/peach/mint gradient — eyebrow, H2, gold italic subhead,
 * five body paragraphs, and a bold dark-navy closing line. Sits
 * directly above the Playbook Checkout section.
 *
 * Returns early when the show toggle is off. Falls back to the
 * Playbook spec copy when ACF fields are empty.
 *
 * NOTE: This section file was previously a four-part block (Window
 * → Value Stack → Outcomes → Price/CTA). Parts 02–04 were removed
 * once the dedicated Playbook Checkout section took over the offer
 * mechanics — the Window now stands alone as a long-form copy beat.
 * The slug ('early-buyers') and ACF group key
 * ('group_gh_service_early_buyers') were preserved so historical
 * saved data and the metabox position don't get orphaned.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_early_buyers_show', 1 ) ) {
    return;
}

$window_eyebrow  = gh_field( 'service_offer_window_eyebrow',  'The Window' );
$window_headline = gh_field( 'service_offer_window_headline', 'This Is the Mother of All Second Chances.' );
$window_subhead  = gh_field( 'service_offer_window_subhead',  'If You Want the "SEO in 2006" Experience — This Is It. Times Ten.' );
$window_paras    = get_field( 'service_offer_window_paragraphs' );
if ( empty( $window_paras ) ) {
    $window_paras = array(
        array( 'text' => 'In 2006 you could rank a healthcare website in Google in weeks. Build a few pages before the national chains caught up and slammed it shut.' ),
        array( 'text' => "This window converts 300–800% better than that one ever did. Enterprise brands are paying thousands a month just to monitor whether they're appearing in AI search — without a system to actually get them there. This gives you the system. AI search doesn't show ten results. It picks one. And right now — before Boots, Bupa, and Superdrug have figured out how to game it — that one can be you." ),
        array( 'text' => 'The shortlist is being built right now. Not next year. Now.' ),
        array( 'text' => "Ealing got on it in 6 weeks. Superior got on it in 48 hours. Both moved before their competitors noticed. Their competitors have noticed now. They're already six months behind." ),
        array( 'text' => 'Every week you wait, someone in your area is claiming the spot you should own.' ),
    );
}
$window_closer = gh_field( 'service_offer_window_closer', 'The practices moving now will own the shortlist. The ones waiting will find it already full.' );
?>

<section class="svc-offer" id="the-window">
    <div class="svc-offer-inner">
        <div class="svc-offer-part svc-offer-window">
            <?php if ( $window_eyebrow ) : ?>
                <p class="svc-offer-eyebrow"><?php echo esc_html( $window_eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $window_headline ) : ?>
                <h2 class="svc-offer-headline"><?php echo esc_html( $window_headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $window_subhead ) : ?>
                <p class="svc-offer-window-subhead"><?php echo esc_html( $window_subhead ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $window_paras ) ) : ?>
                <div class="svc-offer-window-body">
                    <?php foreach ( $window_paras as $para ) :
                        $text = $para['text'] ?? '';
                        if ( ! $text ) continue; ?>
                        <p><?php echo wp_kses_post( $text ); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if ( $window_closer ) : ?>
                <p class="svc-offer-window-closer"><?php echo esc_html( $window_closer ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
