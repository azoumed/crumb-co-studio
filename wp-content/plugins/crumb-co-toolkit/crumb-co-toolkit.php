<?php
/**
 * Plugin Name:       Crumb & Co. Toolkit
 * Plugin URI:        https://example.com/
 * Description:       Shop features for Crumb & Co. Studio: one-click starter content (pages, digital products, menus) in English, Arabic, French and Spanish, digital-download notices, editable product details and FAQs, email signup with a free sample, contact form, and Polylang + WooCommerce glue.
 * Version:           1.0.0
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Requires Plugins:  woocommerce
 * Author:            Crumb & Co. Studio
 * License:           GPL-2.0-or-later
 * Text Domain:       crumb-co-toolkit
 * Domain Path:       /languages
 * WC requires at least: 9.0
 *
 * @package CrumbCoToolkit
 */

defined( 'ABSPATH' ) || exit;

define( 'CCS_VERSION', '1.0.0' );
define( 'CCS_FILE', __FILE__ );
define( 'CCS_DIR', plugin_dir_path( __FILE__ ) );
define( 'CCS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Languages this shop ships with: Polylang slug => WordPress locale.
 *
 * @return array<string,string>
 */
function ccs_supported_languages() {
	return apply_filters( 'ccs_supported_languages', array(
		'en' => 'en_US',
		'ar' => 'ar',
		'fr' => 'fr_FR',
		'es' => 'es_ES',
	) );
}

require_once CCS_DIR . 'includes/helpers.php';
require_once CCS_DIR . 'includes/settings.php';
require_once CCS_DIR . 'includes/multilingual.php';
require_once CCS_DIR . 'includes/digital.php';
require_once CCS_DIR . 'includes/product-fields.php';
require_once CCS_DIR . 'includes/forms.php';
require_once CCS_DIR . 'includes/seo.php';
if ( is_admin() ) {
	require_once CCS_DIR . 'includes/setup.php';
}

add_action( 'init', function () {
	load_plugin_textdomain( 'crumb-co-toolkit', false, dirname( plugin_basename( CCS_FILE ) ) . '/languages' );
}, 1 );

// Declare compatibility with WooCommerce High-Performance Order Storage and cart/checkout blocks.
add_action( 'before_woocommerce_init', function () {
	if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', CCS_FILE, true );
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', CCS_FILE, true );
	}
} );

add_action( 'wp_enqueue_scripts', function () {
	// Only needed when the Crumb & Co. theme is not active (the theme already styles these components).
	if ( 'crumb-co' !== get_template() ) {
		wp_enqueue_style( 'ccs-toolkit', CCS_URL . 'assets/css/toolkit.css', array(), CCS_VERSION );
	}
} );

/**
 * Admin menu: Crumb & Co. → Setup / Settings / Subscribers.
 */
add_action( 'admin_menu', function () {
	add_menu_page(
		__( 'Crumb & Co.', 'crumb-co-toolkit' ),
		__( 'Crumb & Co.', 'crumb-co-toolkit' ),
		'manage_woocommerce',
		'ccs-setup',
		'ccs_render_setup_page',
		'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="#a7aaad" d="M3 9h14v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2zm1-4h12v3H4zm6-4c1 0 2 1 2 2h-4c0-1 1-2 2-2z"/></svg>' ),
		56
	);
	add_submenu_page( 'ccs-setup', __( 'Starter content', 'crumb-co-toolkit' ), __( 'Starter content', 'crumb-co-toolkit' ), 'manage_woocommerce', 'ccs-setup', 'ccs_render_setup_page' );
	add_submenu_page( 'ccs-setup', __( 'Shop settings', 'crumb-co-toolkit' ), __( 'Shop settings', 'crumb-co-toolkit' ), 'manage_woocommerce', 'ccs-settings', 'ccs_render_settings_page' );
}, 9 );
