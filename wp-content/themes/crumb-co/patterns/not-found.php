<?php
/**
 * Title: 404 — page not found
 * Slug: crumb-co/not-found
 * Inserter: no
 */
?>
<?php echo crumb_co_section_open( 'ccs-404' ); // phpcs:ignore ?>
<!-- wp:heading {"level":1,"textAlign":"center"} -->
<h1 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'This page has crumbled', 'crumb-co' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><?php esc_html_e( 'The page you were looking for is not here. Try searching the toolkit or head back to the shop.', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"showLabel":false,"buttonUseIcon":true,"query":{"post_type":"product"},"align":"center","width":100,"widthUnit":"%"} /-->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( crumb_co_page_url( 'shop' ) ); ?>"><?php esc_html_e( 'Browse the toolkit', 'crumb-co' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<?php echo crumb_co_section_close(); // phpcs:ignore ?>
