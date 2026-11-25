<?php
/**
 * Crumb & Co. Studio theme functions.
 *
 * Most visual settings live in theme.json. This file adds:
 * - translations (English, Arabic, French, Spanish) and RTL-aware styles,
 * - classic menu locations (so Polylang can assign one menu per language),
 * - small shortcodes used by the header/footer template parts,
 * - WooCommerce layout tweaks.
 *
 * @package CrumbCo
 */

defined( 'ABSPATH' ) || exit;

define( 'CRUMB_CO_VERSION', '1.0.0' );

require_once get_template_directory() . '/inc/block-markup.php';
require_once get_template_directory() . '/inc/shop-filters.php';
require_once get_template_directory() . '/inc/task-picker.php';

/**
 * Theme setup.
 */
function crumb_co_setup() {
	load_theme_textdomain( 'crumb-co', get_template_directory() . '/languages' );

	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 600,
		'single_image_width'    => 900,
		'product_grid'          => array( 'default_columns' => 3, 'min_columns' => 1, 'max_columns' => 4 ),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'menus' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/theme.css' );

	register_nav_menus( array(
		'primary'     => __( 'Main navigation', 'crumb-co' ),
		'footer_shop' => __( 'Footer: Shop', 'crumb-co' ),
		'footer_help' => __( 'Footer: Help & policies', 'crumb-co' ),
	) );
}
add_action( 'after_setup_theme', 'crumb_co_setup' );

/**
 * Styles and the tiny navigation script.
 */
function crumb_co_assets() {
	wp_enqueue_style( 'crumb-co', get_theme_file_uri( 'assets/css/theme.css' ), array(), CRUMB_CO_VERSION );
	wp_enqueue_script( 'crumb-co-nav', get_theme_file_uri( 'assets/js/nav.js' ), array(), CRUMB_CO_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
}
add_action( 'wp_enqueue_scripts', 'crumb_co_assets', 20 );

/**
 * Pattern categories.
 */
function crumb_co_pattern_categories() {
	register_block_pattern_category( 'crumb-co', array( 'label' => __( 'Crumb & Co. sections', 'crumb-co' ) ) );
	register_block_pattern_category( 'crumb-co-pages', array( 'label' => __( 'Crumb & Co. pages', 'crumb-co' ) ) );
}
add_action( 'init', 'crumb_co_pattern_categories' );

/* -------------------------------------------------------------------------
 * Helpers
 * ---------------------------------------------------------------------- */

/**
 * URL of a site page by key (shop, about, faq, contact, refund-policy, privacy-policy, terms, my-account, cart,
 * or cat:<category-key>). The Crumb & Co. Toolkit plugin filters this to return the page in the current language.
 *
 * @param string $key Page key.
 * @return string
 */
function crumb_co_page_url( $key ) {
	$url = apply_filters( 'crumb_co_page_url', '', $key );
	if ( $url ) {
		return $url;
	}
	if ( function_exists( 'wc_get_page_permalink' ) && in_array( $key, array( 'shop', 'cart', 'checkout', 'myaccount', 'my-account' ), true ) ) {
		return wc_get_page_permalink( 'my-account' === $key ? 'myaccount' : $key );
	}
	if ( 0 === strpos( $key, 'cat:' ) ) {
		$term = get_term_by( 'slug', substr( $key, 4 ), 'product_cat' );
		return ( $term && ! is_wp_error( $term ) ) ? get_term_link( $term ) : home_url( '/' );
	}
	$page = get_page_by_path( $key );
	return $page ? get_permalink( $page ) : home_url( '/' . $key . '/' );
}

/**
 * Editable text option. The plugin's settings screen overrides these defaults
 * (and makes them translatable per language with Polylang).
 *
 * @param string $key Option key.
 * @return string
 */
function crumb_co_text( $key ) {
	$defaults = array(
		'announcement'  => __( 'Digital tools for your home bakery — instant download, nothing shipped.', 'crumb-co' ),
		'footer_blurb'  => __( 'Practical, editable templates that help home bakers organise orders, cost their bakes and share their work.', 'crumb-co' ),
		'business_name' => __( 'Crumb & Co. Studio', 'crumb-co' ),
	);
	$value = apply_filters( 'crumb_co_text', '', $key );
	if ( '' !== $value && null !== $value ) {
		return $value;
	}
	return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
}

/**
 * Theme image URL.
 *
 * @param string $file File name in assets/images.
 * @return string
 */
function crumb_co_image( $file ) {
	return get_theme_file_uri( 'assets/images/' . $file );
}

/* -------------------------------------------------------------------------
 * Shortcodes used by template parts (so header/footer text stays translatable)
 * ---------------------------------------------------------------------- */

add_shortcode( 'crumb_announcement', function () {
	return '<p class="ccs-announcement__text">' . esc_html( crumb_co_text( 'announcement' ) ) . '</p>';
} );

add_shortcode( 'crumb_footer_blurb', function () {
	return '<p class="ccs-footer__blurb">' . esc_html( crumb_co_text( 'footer_blurb' ) ) . '</p>';
} );

add_shortcode( 'crumb_copyright', function () {
	return '<p class="ccs-footer__legal">&copy; ' . esc_html( wp_date( 'Y' ) . ' ' . crumb_co_text( 'business_name' ) ) . ' &middot; '
		. esc_html__( 'All products are digital downloads. No physical items are shipped.', 'crumb-co' ) . '</p>';
} );

/**
 * Language switcher (Polylang). Renders nothing when Polylang is not active.
 */
add_shortcode( 'crumb_languages', function () {
	if ( ! function_exists( 'pll_the_languages' ) ) {
		return '';
	}
	$langs = pll_the_languages( array( 'raw' => 1, 'hide_if_empty' => 0, 'hide_if_no_translation' => 0 ) );
	if ( empty( $langs ) || ! is_array( $langs ) ) {
		return '';
	}
	$out = '<nav class="ccs-langs" aria-label="' . esc_attr__( 'Choose language', 'crumb-co' ) . '"><ul>';
	foreach ( $langs as $lang ) {
		$current = ! empty( $lang['current_lang'] );
		$out    .= sprintf(
			'<li><a href="%1$s" hreflang="%2$s" lang="%2$s"%3$s>%4$s</a></li>',
			esc_url( $lang['url'] ),
			esc_attr( $lang['locale'] ? str_replace( '_', '-', $lang['locale'] ) : $lang['slug'] ),
			$current ? ' aria-current="true" class="is-current"' : '',
			esc_html( $lang['name'] )
		);
	}
	return $out . '</ul></nav>';
} );

/**
 * Main navigation with an accessible mobile toggle.
 */
add_shortcode( 'crumb_nav', function () {
	$menu = wp_nav_menu( array(
		'theme_location' => 'primary',
		'container'      => false,
		'menu_class'     => 'ccs-nav__list',
		'depth'          => 2,
		'echo'           => false,
		'fallback_cb'    => 'crumb_co_nav_fallback',
	) );
	return '<nav class="ccs-nav" aria-label="' . esc_attr__( 'Main', 'crumb-co' ) . '">'
		. '<button class="ccs-nav__toggle" type="button" aria-expanded="false" aria-controls="ccs-nav-panel">'
		. '<span class="ccs-nav__bars" aria-hidden="true"></span><span class="ccs-nav__label">' . esc_html__( 'Menu', 'crumb-co' ) . '</span></button>'
		. '<div class="ccs-nav__panel" id="ccs-nav-panel">' . $menu . '</div></nav>';
} );

/**
 * Fallback menu when no menu is assigned yet.
 *
 * @return string
 */
function crumb_co_nav_fallback() {
	$items = array(
		'shop'    => __( 'Shop', 'crumb-co' ),
		'about'   => __( 'About', 'crumb-co' ),
		'faq'     => __( 'FAQ', 'crumb-co' ),
		'contact' => __( 'Contact', 'crumb-co' ),
	);
	$out = '<ul class="ccs-nav__list">';
	foreach ( $items as $key => $label ) {
		$out .= '<li class="menu-item"><a href="' . esc_url( crumb_co_page_url( $key ) ) . '">' . esc_html( $label ) . '</a></li>';
	}
	return $out . '</ul>';
}

/**
 * Footer menu column: [crumb_footer_menu location="footer_shop"].
 */
add_shortcode( 'crumb_footer_menu', function ( $atts ) {
	$atts   = shortcode_atts( array( 'location' => 'footer_shop' ), $atts );
	$titles = array(
		'footer_shop' => __( 'Shop', 'crumb-co' ),
		'footer_help' => __( 'Help & policies', 'crumb-co' ),
	);
	$location = sanitize_key( $atts['location'] );
	$menu     = wp_nav_menu( array(
		'theme_location' => $location,
		'container'      => false,
		'menu_class'     => 'ccs-footer__menu',
		'depth'          => 1,
		'echo'           => false,
		'fallback_cb'    => '__return_empty_string',
	) );
	if ( ! $menu ) {
		$fallback = 'footer_help' === $location
			? array( 'faq' => __( 'FAQ', 'crumb-co' ), 'contact' => __( 'Contact', 'crumb-co' ), 'refund-policy' => __( 'Digital download & refund policy', 'crumb-co' ), 'privacy-policy' => __( 'Privacy policy', 'crumb-co' ), 'terms' => __( 'Terms', 'crumb-co' ) )
			: array( 'shop' => __( 'All products', 'crumb-co' ), 'about' => __( 'About', 'crumb-co' ), 'my-account' => __( 'My account & downloads', 'crumb-co' ) );
		$menu = '<ul class="ccs-footer__menu">';
		foreach ( $fallback as $key => $label ) {
			$menu .= '<li><a href="' . esc_url( crumb_co_page_url( $key ) ) . '">' . esc_html( $label ) . '</a></li>';
		}
		$menu .= '</ul>';
	}
	$title = isset( $titles[ $location ] ) ? $titles[ $location ] : '';
	return '<nav class="ccs-footer__nav" aria-label="' . esc_attr( $title ) . '"><h2 class="ccs-footer__title">' . esc_html( $title ) . '</h2>' . $menu . '</nav>';
} );

/**
 * Shop page / category / search heading band.
 */
add_shortcode( 'crumb_shop_header', function () {
	$title = __( 'The Toolkit', 'crumb-co' );
	$intro = __( 'Editable templates for the everyday jobs of a home bakery. Every product is a digital download — nothing is shipped.', 'crumb-co' );
	if ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) {
		$term  = get_queried_object();
		$title = $term ? $term->name : $title;
		$intro = ( $term && $term->description ) ? $term->description : $intro;
	} elseif ( is_search() ) {
		/* translators: %s: search terms */
		$title = sprintf( __( 'Results for “%s”', 'crumb-co' ), get_search_query() );
		$intro = '';
	}
	$out  = '<div class="ccs-shop-header">';
	$out .= '<h1 class="ccs-shop-header__title">' . esc_html( $title ) . '</h1>';
	if ( $intro ) {
		$out .= '<div class="ccs-shop-header__intro">' . wp_kses_post( wpautop( $intro ) ) . '</div>';
	}
	return $out . '</div>';
} );

/* -------------------------------------------------------------------------
 * WooCommerce layout tweaks
 * ---------------------------------------------------------------------- */

add_filter( 'woocommerce_show_page_title', '__return_false' );
add_filter( 'loop_shop_columns', function () {
	return 3;
} );
add_filter( 'loop_shop_per_page', function () {
	return 12;
} );
add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
	$args['posts_per_page'] = 3;
	$args['columns']        = 3;
	return $args;
} );
add_filter( 'woocommerce_breadcrumb_defaults', function ( $args ) {
	$args['delimiter']   = '<span class="ccs-crumb-sep" aria-hidden="true"> / </span>';
	$args['wrap_before'] = '<nav class="woocommerce-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'crumb-co' ) . '">';
	return $args;
} );

add_action( 'init', function () {
	// Our templates already provide the <main> landmark.
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	// Category description is shown in our own header band.
	remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
	remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
} );

/**
 * Skip link target + language attribute helpers.
 */
add_filter( 'body_class', function ( $classes ) {
	$classes[] = 'ccs-site';
	if ( is_rtl() ) {
		$classes[] = 'ccs-rtl';
	}
	return $classes;
} );

/**
 * Graceful fallbacks when the Crumb & Co. Toolkit plugin is not active.
 */
add_action( 'init', function () {
	foreach ( array( 'crumb_signup', 'crumb_contact', 'crumb_support_email' ) as $tag ) {
		if ( ! shortcode_exists( $tag ) ) {
			add_shortcode( $tag, '__return_empty_string' );
		}
	}
}, 99 );

add_shortcode( 'crumb_no_results', function () {
	return '<p>' . esc_html__( 'Nothing found. Try another search or browse the toolkit.', 'crumb-co' ) . '</p>'
		. '<p><a class="wp-element-button" href="' . esc_url( crumb_co_page_url( 'shop' ) ) . '">' . esc_html__( 'Browse the toolkit', 'crumb-co' ) . '</a></p>';
} );

/* -------------------------------------------------------------------------
 * Core Web Vitals (Google page experience)
 * ---------------------------------------------------------------------- */

/**
 * Theme images: add intrinsic width/height (prevents layout shift, CLS),
 * load the hero illustration with high priority (LCP) and lazy-load the rest.
 * Done at render time so the saved block markup stays untouched and editable.
 */
add_filter( 'render_block_core/image', function ( $html ) {
	if ( false === strpos( $html, '/crumb-co/assets/images/' ) || ! preg_match( '/<img\b[^>]*>/', $html, $m ) ) {
		return $html;
	}
	$img  = $m[0];
	$dims = array(
		'hero-illustration.svg' => array( 640, 560 ),
		'free-sample.jpg'       => array( 900, 900 ),
	);
	$file = preg_match( '#/assets/images/([a-z0-9._-]+)#', $img, $f ) ? $f[1] : '';
	$size = isset( $dims[ $file ] ) ? $dims[ $file ] : ( 0 === strpos( $file, 'icon-' ) ? array( 64, 64 ) : null );
	$new  = $img;
	if ( $size && false === strpos( $new, ' width=' ) ) {
		$new = str_replace( '<img ', '<img width="' . $size[0] . '" height="' . $size[1] . '" ', $new );
	}
	if ( false === strpos( $new, 'loading=' ) ) {
		$new = 'hero-illustration.svg' === $file
			? str_replace( '<img ', '<img fetchpriority="high" loading="eager" decoding="async" ', $new )
			: str_replace( '<img ', '<img loading="lazy" decoding="async" ', $new );
	}
	return str_replace( $img, $new, $html );
} );

/**
 * Preload the heading font used above the fold (Cairo for Arabic, Fraunces otherwise).
 */
add_action( 'wp_head', function () {
	$font = 0 === strpos( determine_locale(), 'ar' ) ? 'cairo-arabic-wght-normal.woff2' : 'fraunces-latin-wght-normal.woff2';
	echo '<link rel="preload" href="' . esc_url( get_theme_file_uri( 'assets/fonts/' . $font ) ) . '" as="font" type="font/woff2" crossorigin />' . "\n";
}, 1 );

// The emoji detection script is not needed (system emoji are used) — one less render-blocking request.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
