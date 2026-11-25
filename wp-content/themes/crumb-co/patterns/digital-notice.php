<?php
/**
 * Title: Digital download notice band
 * Slug: crumb-co/digital-notice
 * Categories: crumb-co
 * Keywords: digital, download, shipping, notice
 * Description: Explains that products are digital downloads, how delivery works and where to get help.
 */
?>
<?php echo crumb_co_section_open( 'ccs-digital-band' ); // phpcs:ignore ?>
<!-- wp:group {"align":"wide","className":"ccs-digital-band__inner","layout":{"type":"grid","minimumColumnWidth":"14rem"}} -->
<div class="wp-block-group alignwide ccs-digital-band__inner"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><?php echo crumb_co_h( __( 'Digital downloads only', 'crumb-co' ), 3 ); // phpcs:ignore ?><?php echo crumb_co_p( __( 'Every product is a file you download. Nothing physical is printed or shipped.', 'crumb-co' ) ); // phpcs:ignore ?></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><?php echo crumb_co_h( __( 'Instant access', 'crumb-co' ), 3 ); // phpcs:ignore ?><?php echo crumb_co_p( __( 'Download links appear on your order confirmation, in your email and in My Account → Downloads.', 'crumb-co' ) ); // phpcs:ignore ?></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><?php echo crumb_co_h( __( 'Help when you need it', 'crumb-co' ), 3 ); // phpcs:ignore ?><?php echo crumb_co_p( sprintf( /* translators: %s: contact page URL */ __( 'Trouble downloading or opening a file? <a href="%s">Contact support</a> and include your order number.', 'crumb-co' ), esc_url( crumb_co_page_url( 'contact' ) ) ) ); // phpcs:ignore ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php echo crumb_co_section_close(); // phpcs:ignore ?>
