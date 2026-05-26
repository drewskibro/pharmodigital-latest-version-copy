<?php
/**
 * Service: WebPro Elite — Portfolio Showcase.
 *
 * Centred header, then a stack of alternating two-column cards: a
 * browser-chrome preview (traffic-light dots + URL bar + live-site
 * screenshot) on one side, client outcome copy on the other. Even
 * cards lead with the preview, odd cards reverse so the eye zig-zags.
 *
 * Each card's screenshot is an ACF image; when none is set the browser
 * frame renders a tasteful gold-tinted placeholder so the layout never
 * breaks (mirrors the why-this-exists card-image pattern). Text content
 * bakes in as defaults; populate the ACF repeater to override and to
 * attach real Media Library screenshots.
 *
 * Reads from per-section ACF group `Service · WPE Portfolio`. Returns
 * early when the show toggle is off.
 *
 * @package Gildhart
 */

if ( ! gh_field( 'service_wpe_portfolio_show', 1 ) ) {
    return;
}

$eyebrow  = gh_field( 'service_wpe_portfolio_eyebrow',  'The Builds Behind The Results' );
$headline = gh_field( 'service_wpe_portfolio_headline', "£500k. £100k From One Service. #1 For Mounjaro Nationally. Here's What Built That." );
$subhead  = gh_field( 'service_wpe_portfolio_subhead',  'Every site below is currently ranking on Google, featured in ChatGPT, and generating revenue. Built once. Compounding every month.' );

$cards = get_field( 'service_wpe_portfolio_cards' );
if ( empty( $cards ) ) {
    $cards = array(
        array(
            'tag'        => 'Multi-Site Pharmacy Group',
            'name'       => 'Chiselhurst Pharmacy Group',
            'url_label'  => 'chislehurstpharmacygroup.co.uk',
            'url'        => 'https://chislehurstpharmacygroup.co.uk',
            'image'      => 0,
            'outcome'    => 'Two locations. Twenty services. Built on Claude Code from the ground up. Chiselhurst Pharmacy Group now has the AI search infrastructure that most established pharmacy groups spend years trying to build — and never quite get right.',
            'highlights' => array(
                'Pillar Domination Framework™ — every service page architected for AI search',
                'The HPV vaccine page alone contains more clinically verified content than most NHS trust pages on the same topic. That\'s what AI search rewards.',
                'AI-indexed from day one — Google, ChatGPT, Claude, Perplexity',
            ),
        ),
        array(
            'tag'        => 'Private Clinic & Pharmacy',
            'name'       => 'Easy Clinic',
            'url_label'  => 'theeasyclinic.co.uk',
            'url'        => 'https://theeasyclinic.co.uk',
            'image'      => 0,
            'outcome'    => "Every post medically verified. Every service page built for clinical authority. Easy Clinic's content isn't just accurate. It's structured so Google, ChatGPT, and Claude treat it as a trusted source. That's what EEAT compliance built into the architecture actually looks like.",
            'highlights' => array(
                'Named medical verification on every piece of content',
                'EEAT-compliant architecture built for AI platform trust',
                'AI agent embedded and converting visitors around the clock',
            ),
        ),
        array(
            'tag'        => 'Superior Pharmacy',
            'name'       => 'Page One. Beating National Chains. Zero Ad Spend.',
            'url_label'  => 'superiorpharmacy.co.uk',
            'url'        => 'https://superiorpharmacy.co.uk',
            'image'      => 0,
            'outcome'    => 'Superior Pharmacy ranks page one on Google for "best Mounjaro provider UK" — ahead of Med Express and major national operators. Built on WebPro Elite. First ChatGPT sale within 48 hours of launch. Now on track for £500k this year. Two-person team. No ads. No agency retainer.',
            'highlights' => array(
                'Page one Google — "best Mounjaro provider UK"',
                '50% of all revenue now from AI search',
                'On track for £500k this year — zero ad spend',
            ),
        ),
    );
}
?>

<section class="svc-wpe-portfolio" id="portfolio">
    <div class="svc-wpe-portfolio-inner">

        <div class="svc-wpe-portfolio-header">
            <?php if ( $eyebrow ) : ?>
                <span class="svc-wpe-portfolio-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="svc-wpe-portfolio-headline"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
            <?php if ( $subhead ) : ?>
                <p class="svc-wpe-portfolio-subhead"><?php echo esc_html( $subhead ); ?></p>
            <?php endif; ?>
        </div>

        <?php foreach ( $cards as $i => $card ) :
            $tag        = $card['tag']        ?? '';
            $name       = $card['name']       ?? '';
            $url_label  = $card['url_label']  ?? '';
            $url        = $card['url']        ?? '';
            $image_id   = (int) ( $card['image'] ?? 0 );
            $outcome    = $card['outcome']    ?? '';
            $highlights = $card['highlights'] ?? array();
            // Highlights may arrive as a newline string from an ACF textarea.
            if ( is_string( $highlights ) ) {
                $highlights = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $highlights ) ) );
            }
            $reversed = ( $i % 2 === 1 );
            ?>
            <div class="svc-wpe-portfolio-card<?php echo $reversed ? ' svc-wpe-portfolio-card--reversed' : ''; ?>">

                <div class="svc-wpe-portfolio-preview">
                    <div class="svc-wpe-preview-browser">
                        <div class="svc-wpe-preview-bar">
                            <span class="svc-wpe-preview-dot svc-wpe-preview-dot--red"></span>
                            <span class="svc-wpe-preview-dot svc-wpe-preview-dot--amber"></span>
                            <span class="svc-wpe-preview-dot svc-wpe-preview-dot--green"></span>
                            <?php if ( $url_label ) : ?>
                                <span class="svc-wpe-preview-url"><?php echo esc_html( $url_label ); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ( $image_id ) : ?>
                            <?php echo wp_get_attachment_image( $image_id, 'large', false, array(
                                'class'   => 'svc-wpe-preview-shot',
                                'alt'     => esc_attr( $name . ' website' ),
                                'loading' => 'lazy',
                            ) ); ?>
                        <?php else : ?>
                            <div class="svc-wpe-preview-placeholder" aria-hidden="true">
                                <span><?php echo esc_html( $url_label ?: $name ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="svc-wpe-portfolio-info">
                    <?php if ( $tag ) : ?>
                        <span class="svc-wpe-portfolio-tag"><?php echo esc_html( $tag ); ?></span>
                    <?php endif; ?>
                    <?php if ( $name ) : ?>
                        <h3 class="svc-wpe-portfolio-name"><?php echo esc_html( $name ); ?></h3>
                    <?php endif; ?>
                    <?php if ( $outcome ) : ?>
                        <p class="svc-wpe-portfolio-outcome"><?php echo esc_html( $outcome ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $highlights ) ) : ?>
                        <div class="svc-wpe-portfolio-highlights">
                            <?php foreach ( $highlights as $hl ) : ?>
                                <div class="svc-wpe-portfolio-highlight">
                                    <span class="svc-wpe-portfolio-highlight-icon" aria-hidden="true">✓</span>
                                    <span><?php echo esc_html( $hl ); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( $url ) : ?>
                        <a class="svc-wpe-portfolio-link" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
                            View Live Site <span aria-hidden="true">↗</span>
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>

    </div>
</section>
