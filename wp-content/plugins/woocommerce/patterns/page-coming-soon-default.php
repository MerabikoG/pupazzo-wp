<?php
/**
 * Title: Default Coming Soon
 * Slug: woocommerce/page-coming-soon-default
 * Categories: WooCommerce
 * Template Types: coming-soon
 * Inserter: false
 * Feature Flag: coming-soon-newsletter-template
 */

$current_theme     = wp_get_theme()->get_stylesheet();
$inter_font_family = 'inter';
$cardo_font_family = 'cardo';

if ( 'twentytwentyfour' === $current_theme ) {
	$inter_font_family = 'body';
	$cardo_font_family = 'heading';
}
?>

<!-- wp:woocommerce/coming-soon {"comingSoonPatternId":"page-coming-soon-default","className":"woocommerce-coming-soon-entire-site","style":{"color":{"background":"#bea0f2"}}} -->
<div class="wp-block-woocommerce-coming-soon woocommerce-coming-soon-entire-site has-background" style="background-color:#bea0f2"><!-- wp:cover {"minHeight":100,"minHeightUnit":"vh","isDark":false,"className":"coming-soon-is-vertically-aligned-center coming-soon-cover","layout":{"type":"default"}} --><div class="wp-block-cover is-light coming-soon-is-vertically-aligned-center coming-soon-cover" style="min-height:100vh"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style=""></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"woocommerce-coming-soon-banner-container","layout":{"type":"default"}} -->
<div class="wp-block-group woocommerce-coming-soon-banner-container"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"10px","bottom":"14px"}}},"className":"woocommerce-coming-soon-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide woocommerce-coming-soon-header has-background" style="padding-top:10px;padding-bottom:14px"><!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"},"layout":{"selfStretch":"fit","flexSize":null}},"layout":{"type":"flex"}} -->
<div class="wp-block-group"><!-- wp:site-logo {"width":60} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"0px"}}} -->
<div class="wp-block-group"><!-- wp:site-title {"level":0,"fontFamily":"<?php echo esc_html( $inter_font_family ); ?>"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"48px"}},"className":"woocommerce-coming-soon-social-login","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group woocommerce-coming-soon-social-login">
<!-- wp:template-part {"slug":"coming-soon-social-links","theme":"woocommerce/woocommerce","tagName":"div"} /-->
<!-- wp:loginout {"style":{"elements":{"link":{"color":{"text":"#ffffff"}}},"color":{"background":"#000000"}},"fontFamily":"<?php echo esc_html( $inter_font_family ); ?>"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":1,"align":"wide","className":"woocommerce-coming-soon-banner","fontFamily":"<?php echo esc_html( $cardo_font_family ); ?>"} -->
<h1 class="wp-block-heading alignwide has-text-align-center woocommerce-coming-soon-banner has-<?php echo esc_html( $cardo_font_family ); ?>-font-family"><?php echo esc_html__( "Pardon our dust! We're working on something amazing — check back soon!", 'woocommerce' ); ?></h1>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|10"}}},"className":"woocommerce-coming-soon-powered-by-woo","layout":{"type":"constrained"}} -->
<div class="wp-block-group woocommerce-coming-soon-powered-by-woo" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--10)"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"0"}}}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast-2","fontSize":"small"} -->
<p class="has-text-align-center has-contrast-2-color has-text-color has-link-color has-small-font-size">&nbsp;</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:woocommerce/coming-soon -->
