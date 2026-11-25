<?php
/**
 * Title: Shop by category
 * Slug: crumb-co/category-grid
 * Categories: crumb-co, woo-commerce
 * Keywords: categories, shop
 * Viewport width: 1400
 * Description: Product category tiles (pulls categories live from WooCommerce).
 */
?>
<?php echo crumb_co_section_open( 'ccs-categories' ); // phpcs:ignore ?>
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Shop by task', 'crumb-co' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"wide","className":"ccs-products-wrap","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide ccs-products-wrap"><!-- wp:shortcode -->
[product_categories columns="4" hide_empty="1" parent="0"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
<?php echo crumb_co_section_close(); // phpcs:ignore ?>
