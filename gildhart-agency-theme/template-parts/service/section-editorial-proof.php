<?php
/**
 * Service: Editorial Proof section.
 *
 * Two-part section:
 *   1. Cream-gradient header wrap with a gold caps eyebrow, dark H2,
 *      and a sub paragraph (allows inline <strong>).
 *   2. A vertical stack of full-bleed editorial panels — each panel
 *      is its own coloured row (alternating #f5f0e8 / #ede8df) with
 *      a 3-column grid: huge gold stat number on the left, a gold
 *      vertical divider in the middle, and a content block on the
 *      right (gold caps label + green descriptor + body text).
 *
 * Visually distinct from the dark navy stats grids — magazine-style
 * editorial panels designed to slow the reader down at the proof
 * stage.
 *
 * Reads from per-section ACF group `Service · Editorial Proof`.
 * Returns early when the show toggle is off. Falls back to The Agent
 * copy from the static spec when ACF fields are empty.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_editorial_proof_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_editorial_proof_eyebrow',  'The Numbers' );
$headline = gh_field( 'service_editorial_proof_headline', '10:47pm. A Patient Has A Question. Your Website Has Nothing To Say.' );
$sub      = gh_field( 'service_editorial_proof_sub',      'Not rankings. Not traffic. <strong>Revenue.</strong> Here&rsquo;s what it looks like in practice.' );

$panels = get_field( 'service_editorial_proof_panels' );
if ( empty( $panels ) ) {
    $panels = array(
        array(
            'number'     => '£200k',
            'label'      => 'Southdowns Pharmacy Group',
            'descriptor' => 'Annual revenue run rate from The Agent alone.',
            'text'       => 'Ear wax removal at 9pm. Needle stick injury vaccines on a Saturday. Wegovy questions at midnight. Every enquiry captured. Every one converted. None of it requiring a single member of staff.',
        ),
        array(
            'number'     => '50%',
            'label'      => 'Superior Pharmacy',
            'descriptor' => 'Of all weight loss sales now closed through The Agent.',
            'text'       => 'Mounjaro questions at 2am. Eligibility checks on Sunday afternoons. Medication queries that used to go unanswered. The Agent handles every one — and converts at a rate no static website ever will.',
        ),
        array(
            'number'     => '25%',
            'label'      => 'Ealing Travel Clinic',
            'descriptor' => 'Conversion rate across all AI agent enquiries.',
            'text'       => 'One in four conversations becomes a booked appointment. The other three become patient intent data — the exact language, the exact questions, the exact services that drive content that ranks and compounds every month.',
        ),
        array(
            'number'     => '100,000+',
            'label'      => 'Across Our Client Network',
            'descriptor' => 'Real patient conversations handled across our network.',
            'text'       => 'Every conversation is a data point on what patients want, when they want it, and what makes them book. That intelligence builds clinical authority no competitor starting today can replicate.',
        ),
    );
}
?>

<section class="svc-editorial-proof">
    <div class="svc-editorial-proof-header-wrap">
        <div class="svc-editorial-proof-inner">
            <div class="svc-editorial-proof-header">
                <?php if ( $eyebrow ) : ?>
                    <p class="svc-editorial-proof-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="svc-editorial-proof-headline"><?php echo esc_html( $headline ); ?></h2>
                <?php endif; ?>
                <?php if ( $sub ) : ?>
                    <p class="svc-editorial-proof-sub"><?php echo wp_kses_post( $sub ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ( ! empty( $panels ) ) : ?>
        <div class="svc-editorial-proof-panels">
            <?php foreach ( $panels as $panel ) :
                $number     = $panel['number']     ?? '';
                $label      = $panel['label']      ?? '';
                $descriptor = $panel['descriptor'] ?? '';
                $text       = $panel['text']       ?? '';
                if ( ! $number && ! $label && ! $descriptor && ! $text ) continue;
            ?>
                <div class="svc-editorial-proof-panel">
                    <div class="svc-editorial-proof-panel-inner">
                        <div class="svc-editorial-proof-panel-stat">
                            <?php if ( $number ) : ?>
                                <span class="svc-editorial-proof-panel-number"><?php echo esc_html( $number ); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="svc-editorial-proof-panel-divider" aria-hidden="true"></div>
                        <div class="svc-editorial-proof-panel-content">
                            <?php if ( $label ) : ?>
                                <span class="svc-editorial-proof-panel-label"><?php echo esc_html( $label ); ?></span>
                            <?php endif; ?>
                            <?php if ( $descriptor ) : ?>
                                <p class="svc-editorial-proof-panel-descriptor"><?php echo esc_html( $descriptor ); ?></p>
                            <?php endif; ?>
                            <?php if ( $text ) : ?>
                                <p class="svc-editorial-proof-panel-text"><?php echo esc_html( $text ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
