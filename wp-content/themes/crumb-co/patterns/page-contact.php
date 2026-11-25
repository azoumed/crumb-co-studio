<?php
/**
 * Title: Contact page
 * Slug: crumb-co/page-contact
 * Categories: crumb-co-pages
 * Post Types: page
 * Block Types: core/post-content
 * Description: Support details and a contact form (form requires the Crumb & Co. Toolkit plugin).
 */
echo crumb_co_p( __( 'Questions about a product, a download that will not open, or an idea for a new tool? Send us a message.', 'crumb-co' ), 'ccs-lead' );
?>
<!-- wp:columns {"className":"ccs-contact"} -->
<div class="wp-block-columns ccs-contact"><!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:shortcode -->
[crumb_contact]
<!-- /wp:shortcode --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"40%","className":"ccs-contact__aside"} -->
<div class="wp-block-column ccs-contact__aside" style="flex-basis:40%"><?php
echo crumb_co_h( __( 'Support', 'crumb-co' ), 3 );
echo crumb_co_p( __( 'Email:', 'crumb-co' ) . ' [crumb_support_email]' );
echo crumb_co_p( __( 'Usual reply time: [Placeholder — e.g. within 2 business days]', 'crumb-co' ) );
echo crumb_co_h( __( 'Help with an order', 'crumb-co' ), 3 );
echo crumb_co_list( array(
	__( 'Include your order number', 'crumb-co' ),
	__( 'Tell us which file and which software you are using', 'crumb-co' ),
	__( 'A screenshot of any error message helps', 'crumb-co' ),
) );
echo crumb_co_p( sprintf( /* translators: %s: my account URL */ __( 'Looking for your files? They are in <a href="%s">My Account → Downloads</a>.', 'crumb-co' ), esc_url( crumb_co_page_url( 'my-account' ) ) ) );
?></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
