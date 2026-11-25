<?php
/**
 * Digital-product experience: badges, notices on product / cart / checkout / thank-you / emails,
 * simplified checkout for digital-only carts and sensible admin defaults.
 *
 * @package CrumbCoToolkit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Is this product a digital download?
 *
 * @param WC_Product|null $product Product.
 * @return bool
 */
function ccs_is_digital( $product ) {
	return $product && ( $product->is_downloadable() || $product->is_virtual() );
}

/**
 * Notice markup.
 *
 * @param string $context product|cart|checkout|thankyou.
 * @return string
 */
function ccs_digital_notice( $context = 'product' ) {
	$account = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/' );
	switch ( $context ) {
		case 'cart':
		case 'checkout':
			$title = __( 'Your order contains digital downloads only', 'crumb-co-toolkit' );
			$text  = __( 'Nothing will be shipped, so there is no delivery charge. Your download links appear as soon as payment is confirmed: on the order confirmation page, in your email and in My Account → Downloads.', 'crumb-co-toolkit' );
			break;
		case 'thankyou':
			$title = __( 'Your files are ready', 'crumb-co-toolkit' );
			$text  = sprintf(
				/* translators: %s: My Account URL */
				__( 'Download them below. We have also emailed the links, and they stay available in <a href="%s">My Account → Downloads</a> if you created an account. Nothing will be shipped.', 'crumb-co-toolkit' ),
				esc_url( wc_get_account_endpoint_url( 'downloads' ) )
			);
			break;
		default:
			$title = __( 'Digital download — nothing is shipped', 'crumb-co-toolkit' );
			$text  = sprintf(
				/* translators: 1: My Account URL, 2: contact page URL */
				__( 'You will receive editable files, not a printed product. Download links appear right after payment, by email and in <a href="%1$s">My Account</a>. Problems with a file? <a href="%2$s">Contact support</a>.', 'crumb-co-toolkit' ),
				esc_url( $account ),
				esc_url( function_exists( 'crumb_co_page_url' ) ? crumb_co_page_url( 'contact' ) : home_url( '/contact/' ) )
			);
	}
	return '<div class="ccs-digital-notice ccs-digital-notice--' . esc_attr( $context ) . '" role="note"><span class="ccs-digital-notice__icon">' . ccs_icon( 'download' ) . '</span><div><strong>'
		. esc_html( $title ) . '</strong><p>' . wp_kses_post( $text ) . '</p></div></div>';
}

/* ---------- Shop loop ---------- */

add_action( 'woocommerce_before_shop_loop_item', function () {
	global $product;
	if ( ccs_is_digital( $product ) ) {
		echo '<span class="ccs-loop-badge">' . esc_html__( 'Digital download', 'crumb-co-toolkit' ) . '</span>';
	}
}, 5 );

add_action( 'woocommerce_after_shop_loop_item_title', function () {
	global $product;
	$format = $product ? $product->get_meta( '_ccs_format_label' ) : '';
	if ( $format ) {
		echo '<p class="ccs-loop-meta">' . esc_html( $format ) . '</p>';
	}
}, 4 );

/* ---------- Single product ---------- */

add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	$rows = array(
		'_ccs_for_who'      => __( 'Who it is for', 'crumb-co-toolkit' ),
		'_ccs_task'         => __( 'Helps with', 'crumb-co-toolkit' ),
		'_ccs_format_label' => __( 'Format', 'crumb-co-toolkit' ),
		'_ccs_software'     => __( 'Works with', 'crumb-co-toolkit' ),
	);
	$html = '';
	foreach ( $rows as $meta => $label ) {
		$val = $product->get_meta( $meta );
		if ( $val ) {
			$html .= '<div class="ccs-facts__row"><dt>' . esc_html( $label ) . '</dt><dd>' . esc_html( $val ) . '</dd></div>';
		}
	}
	if ( $html ) {
		echo '<dl class="ccs-facts">' . $html . '</dl>'; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above.
	}
}, 25 );

add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( ccs_is_digital( $product ) ) {
		echo ccs_digital_notice( 'product' ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
}, 35 );

// Digital licences are bought one at a time.
add_filter( 'woocommerce_is_sold_individually', function ( $sold, $product ) {
	return ccs_is_digital( $product ) ? true : $sold;
}, 10, 2 );

// Clearer button text for downloads.
add_filter( 'woocommerce_product_single_add_to_cart_text', function ( $text, $product ) {
	return ccs_is_digital( $product ) ? __( 'Add to cart — instant download', 'crumb-co-toolkit' ) : $text;
}, 10, 2 );

/* ---------- Cart & checkout (classic + blocks) ---------- */

/**
 * Whether the cart contains only digital items.
 *
 * @return bool
 */
function ccs_cart_is_digital_only() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart || WC()->cart->is_empty() ) {
		return false;
	}
	foreach ( WC()->cart->get_cart() as $item ) {
		if ( empty( $item['data'] ) || ! ccs_is_digital( $item['data'] ) ) {
			return false;
		}
	}
	return true;
}

add_action( 'woocommerce_before_cart', function () {
	if ( ccs_cart_is_digital_only() ) {
		echo ccs_digital_notice( 'cart' ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
} );
add_action( 'woocommerce_before_checkout_form', function () {
	if ( ccs_cart_is_digital_only() ) {
		echo ccs_digital_notice( 'checkout' ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
}, 5 );

add_filter( 'render_block', function ( $content, $block ) {
	if ( is_admin() || empty( $block['blockName'] ) ) {
		return $content;
	}
	if ( in_array( $block['blockName'], array( 'woocommerce/cart', 'woocommerce/checkout' ), true ) && ccs_cart_is_digital_only() ) {
		$ctx = 'woocommerce/cart' === $block['blockName'] ? 'cart' : 'checkout';
		return ccs_digital_notice( $ctx ) . $content;
	}
	if ( 'woocommerce/order-confirmation-downloads' === $block['blockName'] && '' !== trim( $content ) ) {
		return ccs_digital_notice( 'thankyou' ) . $content;
	}
	return $content;
}, 10, 2 );

// Classic thank-you page.
add_action( 'woocommerce_thankyou', function ( $order_id ) {
	$order = wc_get_order( $order_id );
	if ( $order && $order->has_downloadable_item() ) {
		echo ccs_digital_notice( 'thankyou' ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
}, 5 );

// Customer emails.
add_action( 'woocommerce_email_before_order_table', function ( $order, $sent_to_admin, $plain_text ) {
	if ( $sent_to_admin || ! $order || ! $order->has_downloadable_item() ) {
		return;
	}
	$msg = $order->is_download_permitted()
		? __( 'Your digital files are ready. Use the download links in this email or in My Account → Downloads. Nothing will be shipped.', 'crumb-co-toolkit' )
		: __( 'This order contains digital downloads. Your download links will be sent as soon as payment is confirmed. Nothing will be shipped.', 'crumb-co-toolkit' );
	if ( $plain_text ) {
		echo esc_html( $msg ) . "\n\n";
	} else {
		echo '<p style="padding:12px 16px;background:#E3EBDD;border-radius:8px;">' . esc_html( $msg ) . '</p>';
	}
}, 5, 3 );

/**
 * Classic checkout: drop street-address fields for digital-only carts (country is kept for tax).
 */
add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
	if ( '1' !== ccs_option( 'simplify_checkout' ) || ! ccs_cart_is_digital_only() ) {
		return $fields;
	}
	foreach ( array( 'billing_company', 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_state', 'billing_postcode' ) as $key ) {
		unset( $fields['billing'][ $key ] );
	}
	if ( isset( $fields['billing']['billing_phone'] ) ) {
		$fields['billing']['billing_phone']['required'] = false;
	}
	return $fields;
}, 20 );

/* ---------- Admin ---------- */

// New products start as virtual + downloadable.
add_action( 'admin_footer-post-new.php', function () {
	if ( 'product' !== get_post_type() && ( ! isset( $_GET['post_type'] ) || 'product' !== $_GET['post_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}
	echo "<script>jQuery(function($){ $('#_virtual,#_downloadable').prop('checked',true).trigger('change'); });</script>";
} );

// Reminder that seeded prices are placeholders.
add_action( 'admin_notices', function () {
	$screen = get_current_screen();
	if ( ! $screen || 'product' !== $screen->id ) {
		return;
	}
	global $post;
	if ( $post && get_post_meta( $post->ID, '_ccs_price_placeholder', true ) ) {
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'This product still has a placeholder price from the starter content. Set your real price (Product data → General) and update this product.', 'crumb-co-toolkit' ) . '</p></div>';
	}
} );
add_action( 'woocommerce_admin_process_product_object', function ( $product ) {
	if ( array_key_exists( 'regular_price', $product->get_changes() ) ) {
		$product->delete_meta_data( '_ccs_price_placeholder' );
	}
} );
