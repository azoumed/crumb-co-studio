<?php
/**
 * Multilingual glue: Polylang + WooCommerce + theme links.
 *
 * Works without Polylang (single-language site). With Polylang (free) active:
 * - products, product categories and tags become translatable,
 * - cart / checkout / my account / terms resolve to the page in the visitor's language,
 * - theme links (crumb_co_page_url) point to the right language.
 *
 * For automatic price/stock syncing between product translations, consider
 * "Polylang for WooCommerce" or WPML + WooCommerce Multilingual (both paid).
 *
 * @package CrumbCoToolkit
 */

defined( 'ABSPATH' ) || exit;

// Make WooCommerce content translatable in Polylang.
add_filter( 'pll_get_post_types', function ( $types, $is_settings ) {
	$types['product'] = 'product';
	return $types;
}, 10, 2 );
add_filter( 'pll_get_taxonomies', function ( $taxonomies, $is_settings ) {
	$taxonomies['product_cat'] = 'product_cat';
	$taxonomies['product_tag'] = 'product_tag';
	return $taxonomies;
}, 10, 2 );

// WooCommerce system pages in the current language.
foreach ( array( 'cart', 'checkout', 'myaccount', 'terms' ) as $ccs_wc_page ) {
	add_filter( "woocommerce_get_{$ccs_wc_page}_page_id", 'ccs_translate_wc_page_id' );
}

/**
 * Translate a WooCommerce page ID to the current language.
 *
 * @param int $id Page ID.
 * @return int
 */
function ccs_translate_wc_page_id( $id ) {
	if ( $id > 0 && function_exists( 'pll_get_post' ) ) {
		$lang = ccs_current_lang();
		$tr   = pll_get_post( $id, $lang );
		if ( $tr ) {
			return (int) $tr;
		}
	}
	return $id;
}

/**
 * Shop (product archive) URL in a given language.
 *
 * @param string $lang Language slug.
 * @return string
 */
function ccs_shop_url( $lang = '' ) {
	$lang = $lang ? $lang : ccs_current_lang();
	$url  = get_post_type_archive_link( 'product' );
	if ( ! $url && function_exists( 'wc_get_page_permalink' ) ) {
		$url = wc_get_page_permalink( 'shop' );
	}
	if ( function_exists( 'PLL' ) && PLL() && isset( PLL()->links_model, PLL()->model ) && method_exists( PLL()->links_model, 'switch_language_in_link' ) ) {
		$language = PLL()->model->get_language( $lang );
		if ( $language ) {
			$url = PLL()->links_model->switch_language_in_link( $url, $language );
		}
	}
	return $url;
}

/**
 * Theme links resolve to the page created by the setup tool, in the right language.
 */
add_filter( 'crumb_co_page_url', function ( $url, $key ) {
	if ( 'shop' === $key ) {
		return ccs_shop_url();
	}
	if ( 0 === strpos( $key, 'cat:' ) ) {
		$id = ccs_seeded_id( 'cats', substr( $key, 4 ) );
		if ( $id ) {
			$link = get_term_link( $id, 'product_cat' );
			return is_wp_error( $link ) ? $url : $link;
		}
		return $url;
	}
	$key = 'myaccount' === $key ? 'my-account' : $key;
	$id  = ccs_seeded_id( 'pages', $key );
	if ( $id && 'publish' === get_post_status( $id ) ) {
		return get_permalink( $id );
	}
	if ( in_array( $key, array( 'cart', 'checkout', 'my-account' ), true ) && function_exists( 'wc_get_page_permalink' ) ) {
		return wc_get_page_permalink( 'my-account' === $key ? 'myaccount' : $key );
	}
	return $url;
}, 10, 2 );

/**
 * Keep the order language on the order, so emails can be resent in the right language later.
 */
add_action( 'woocommerce_checkout_create_order', function ( $order ) {
	$order->update_meta_data( '_ccs_lang', ccs_current_lang() );
} );
