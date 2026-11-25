<?php
/**
 * Shared helpers.
 *
 * @package CrumbCoToolkit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Current language slug (en, ar, fr, es). During setup the language being generated wins.
 *
 * @return string
 */
function ccs_current_lang() {
	if ( ! empty( $GLOBALS['ccs_seed_lang'] ) ) {
		return $GLOBALS['ccs_seed_lang'];
	}
	if ( function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language( 'slug' );
		if ( $lang ) {
			return $lang;
		}
		if ( function_exists( 'pll_default_language' ) && pll_default_language() ) {
			return pll_default_language();
		}
	}
	return ccs_locale_to_slug( determine_locale() );
}

/**
 * Map a WordPress locale to one of our language slugs.
 *
 * @param string $locale Locale.
 * @return string
 */
function ccs_locale_to_slug( $locale ) {
	$short = strtolower( substr( (string) $locale, 0, 2 ) );
	return array_key_exists( $short, ccs_supported_languages() ) ? $short : 'en';
}

/**
 * IDs created by the setup tool. Structure: [ group ][ key ][ lang ] => id.
 *
 * @param string $group pages|products|cats|tags|menus.
 * @param string $key   Item key.
 * @param string $lang  Language slug (defaults to current).
 * @return int
 */
function ccs_seeded_id( $group, $key, $lang = '' ) {
	$map  = get_option( 'ccs_seeded', array() );
	$lang = $lang ? $lang : ccs_current_lang();
	if ( isset( $map[ $group ][ $key ][ $lang ] ) ) {
		return (int) $map[ $group ][ $key ][ $lang ];
	}
	// Fall back to the default language version.
	$default = function_exists( 'pll_default_language' ) && pll_default_language() ? pll_default_language() : 'en';
	return isset( $map[ $group ][ $key ][ $default ] ) ? (int) $map[ $group ][ $key ][ $default ] : 0;
}

/**
 * Plugin option with default.
 *
 * @param string $key Key.
 * @return string
 */
function ccs_option( $key ) {
	$opts     = get_option( 'ccs_settings', array() );
	$defaults = array(
		'business_name'     => '',
		'support_email'     => '',
		'announcement'      => '',
		'footer_blurb'      => '',
		'contact_recipient' => '',
		'free_sample_url'   => '',
		'simplify_checkout' => '1',
	);
	$value = isset( $opts[ $key ] ) ? $opts[ $key ] : ( isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
	return is_string( $value ) ? $value : '';
}

/**
 * Translatable option: uses Polylang string translations when available.
 *
 * @param string $key Key.
 * @return string
 */
function ccs_option_t( $key ) {
	$value = ccs_option( $key );
	if ( '' !== $value && function_exists( 'pll__' ) ) {
		$value = pll__( $value );
	}
	return $value;
}

/**
 * Support email (falls back to the site admin email).
 *
 * @return string
 */
function ccs_support_email() {
	$email = ccs_option( 'support_email' );
	return is_email( $email ) ? $email : get_option( 'admin_email' );
}

/**
 * Small inline SVG icons.
 *
 * @param string $name download|info.
 * @return string
 */
function ccs_icon( $name ) {
	$paths = array(
		'download' => '<path d="M12 4v11M7 10l5 5 5-5M5 19h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
		'info'     => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 11v5M12 8h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
	);
	return '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">' . ( isset( $paths[ $name ] ) ? $paths[ $name ] : '' ) . '</svg>';
}
