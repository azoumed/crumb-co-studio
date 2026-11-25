<?php
/**
 * Title: Featured digital products
 * Slug: crumb-co/featured-products
 * Categories: crumb-co, woo-commerce
 * Keywords: products, featured, shop
 * Viewport width: 1400
 * Description: Section heading with the shop's products (newest four by default).
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"ccs-section ccs-featured","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull ccs-section ccs-featured"><!-- wp:group {"align":"wide","className":"ccs-section__head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group alignwide ccs-section__head"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Four focused tools. No fluff.', 'crumb-co' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"ccs-link-arrow"} -->
<p class="ccs-link-arrow"><a href="<?php echo esc_url( crumb_co_page_url( 'shop' ) ); ?>"><?php esc_html_e( 'See all products', 'crumb-co' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"ccs-products-wrap","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide ccs-products-wrap"><!-- wp:shortcode -->
[products limit="4" columns="4" orderby="menu_order" order="ASC"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
