<?php
/**
 * Footer — Gildhart Agency.
 *
 * Dark green 4-column layout, ACF-driven copy.
 *
 * @package Gildhart
 */

$logo_url           = gh_logo_url();
$agency_name        = gh_agency_name();
$tagline            = gh_option( 'footer_tagline', 'AI Infrastructure. Built Only For Healthcare.' );
$description        = gh_option( 'footer_description' );
$brand_link_label   = gh_option( 'footer_brand_link_label' );
$brand_link_url     = gh_option( 'footer_brand_link_url' );
$copyright_template = gh_option( 'footer_copyright', '© {year} ' . $agency_name . '. All rights reserved. Gildhart™ and Pillar Domination Framework™ are trademarks of Social Gains Limited, registered in England and Wales.' );
$copyright          = str_replace( '{year}', date_i18n( 'Y' ), $copyright_template );
$legal_links        = gh_option( 'footer_legal_links', array() );

// Contact email falls back to the brand address so the Contact column
// renders out of the box even before the agency_email option is set.
$email   = gh_email() ?: 'hello@gildhart.co.uk';
$linkedin_company = gh_option( 'social_linkedin', 'https://linkedin.com/company/gildhart' );
?>

<footer class="footer">
    <div class="footer-inner">
        <div class="footer-top">
            <div class="footer-brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-brand-name">
                    <?php if ( gh_has_uploaded_logo() ) : ?>
                        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $agency_name ); ?>">
                    <?php endif; ?>
                    <?php echo esc_html( $agency_name ); ?>
                </a>
                <?php if ( $tagline ) : ?>
                    <p class="footer-brand-tagline"><?php echo esc_html( $tagline ); ?></p>
                <?php endif; ?>
                <?php if ( $description ) : ?>
                    <p class="footer-brand-desc"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
                <?php if ( $brand_link_label && $brand_link_url ) : ?>
                    <a href="<?php echo esc_url( $brand_link_url ); ?>" class="footer-brand-link"><?php echo esc_html( $brand_link_label ); ?></a>
                <?php endif; ?>
            </div>

            <?php
            // Services column — uses 'footer-services' nav menu if assigned, else lists service CPTs.
            $has_services_menu = has_nav_menu( 'footer-services' );
            ?>
            <div class="footer-col">
                <h4>The Systems</h4>
                <?php if ( $has_services_menu ) : ?>
                    <?php wp_nav_menu( array(
                        'theme_location' => 'footer-services',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'walker'         => null,
                    ) ); ?>
                <?php else :
                    $svc_q = new WP_Query( array(
                        'post_type'      => 'service',
                        'posts_per_page' => 6,
                        'orderby'        => 'menu_order',
                        'order'          => 'ASC',
                    ) );
                    if ( $svc_q->have_posts() ) :
                        while ( $svc_q->have_posts() ) : $svc_q->the_post(); ?>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <?php endwhile;
                        wp_reset_postdata();
                    endif;
                endif; ?>
            </div>

            <?php $has_links_menu = has_nav_menu( 'footer-links' ); ?>
            <div class="footer-col">
                <h4>Company</h4>
                <?php if ( $has_links_menu ) : ?>
                    <?php wp_nav_menu( array(
                        'theme_location' => 'footer-links',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                    ) ); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a>
                    <a href="<?php echo esc_url( home_url( '/#revenue-results' ) ); ?>">The Proof</a>
                    <a href="<?php echo esc_url( $linkedin_company ); ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                <?php endif; ?>
            </div>

            <div class="footer-col">
                <h4>Contact</h4>
                <?php if ( $email ) : ?>
                    <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                <?php endif; ?>
                <span class="footer-contact-line">Blackpool, England</span>
                <span class="footer-contact-line footer-contact-line--fine">Registered in England &amp; Wales</span>
                <span class="footer-contact-line footer-contact-line--fine">Company No. [COMPANY NUMBER]</span>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-compliance">All systems and content produced to GPhC, GMC, GDC, and CQC regulatory standards.</p>
            <p><?php echo esc_html( $copyright ); ?></p>
            <?php if ( ! empty( $legal_links ) ) : ?>
                <div class="footer-legal">
                    <?php foreach ( $legal_links as $link ) : ?>
                        <a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
