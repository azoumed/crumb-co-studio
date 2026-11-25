<?php
/**
 * One-click starter content: Crumb & Co. → Starter content.
 *
 * Creates (only what is missing — it never overwrites your edits):
 * - Polylang languages en / ar / fr / es (optional),
 * - product categories + format tags, the four digital products with protected download files and images,
 * - Home, About, FAQ, Contact, Refund policy, Privacy policy, Terms pages,
 * - translated Cart / Checkout / My Account pages,
 * - menus for each language, and digital-shop WooCommerce settings.
 *
 * Page text is rendered from the theme's translatable patterns in each language, so every page
 * is ordinary editable block content afterwards.
 *
 * @package CrumbCoToolkit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Admin screen.
 */
function ccs_render_setup_page() {
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}
	$has_wc    = class_exists( 'WooCommerce' );
	$has_theme = 'crumb-co' === get_template();
	$has_pll   = function_exists( 'pll_languages_list' );
	$log       = get_transient( 'ccs_setup_log' );
	delete_transient( 'ccs_setup_log' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Crumb & Co. starter content', 'crumb-co-toolkit' ); ?></h1>
		<p><?php esc_html_e( 'Creates the shop pages, four digital products with their download files, menus and recommended WooCommerce settings for a digital-only shop. It only creates what is missing, so it is safe to run again (for example after adding a language).', 'crumb-co-toolkit' ); ?></p>

		<?php if ( $log ) : ?>
			<div class="notice notice-info"><p><strong><?php esc_html_e( 'Setup log', 'crumb-co-toolkit' ); ?></strong></p><ul style="list-style:disc;padding-inline-start:20px">
				<?php foreach ( (array) $log as $line ) : ?><li><?php echo esc_html( $line ); ?></li><?php endforeach; ?>
			</ul></div>
		<?php endif; ?>

		<h2><?php esc_html_e( 'Checklist', 'crumb-co-toolkit' ); ?></h2>
		<table class="widefat striped" style="max-width:820px">
			<tbody>
				<tr><td><?php esc_html_e( 'WooCommerce active', 'crumb-co-toolkit' ); ?></td><td><?php echo $has_wc ? '✅' : '❌'; ?></td></tr>
				<tr><td><?php esc_html_e( 'Crumb & Co. Studio theme active', 'crumb-co-toolkit' ); ?></td><td><?php echo $has_theme ? '✅' : '❌'; ?></td></tr>
				<tr><td><?php esc_html_e( 'Polylang active (needed for Arabic, French and Spanish versions)', 'crumb-co-toolkit' ); ?></td><td><?php echo $has_pll ? '✅ ' . esc_html( implode( ', ', pll_languages_list( array( 'fields' => 'slug' ) ) ) ) : '— ' . esc_html__( 'optional: without it, content is created in the site language only', 'crumb-co-toolkit' ); ?></td></tr>
				<tr><td><?php esc_html_e( 'Payment provider', 'crumb-co-toolkit' ); ?></td><td><a href="<?php echo esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout' ) ); ?>"><?php esc_html_e( 'Configure in WooCommerce → Settings → Payments', 'crumb-co-toolkit' ); ?></a></td></tr>
			</tbody>
		</table>

		<?php if ( $has_wc && $has_theme ) : ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-top:20px">
				<input type="hidden" name="action" value="ccs_run_setup" />
				<?php wp_nonce_field( 'ccs_run_setup' ); ?>
				<?php if ( $has_pll ) : ?>
					<p><label><input type="checkbox" name="ccs_create_langs" value="1" checked /> <?php esc_html_e( 'Add any missing Polylang languages (English, العربية, Français, Español) and download their WordPress language packs', 'crumb-co-toolkit' ); ?></label></p>
				<?php endif; ?>
				<p><label><input type="checkbox" name="ccs_set_front" value="1" checked /> <?php esc_html_e( 'Use the new Home page as the front page', 'crumb-co-toolkit' ); ?></label></p>
				<p><label><input type="checkbox" name="ccs_wc_settings" value="1" checked /> <?php esc_html_e( 'Apply digital-shop WooCommerce settings (secure forced downloads, access after payment, shipping disabled)', 'crumb-co-toolkit' ); ?></label></p>
				<?php submit_button( __( 'Create starter content', 'crumb-co-toolkit' ), 'primary', 'submit', false ); ?>
			</form>
		<?php else : ?>
			<p><strong><?php esc_html_e( 'Activate WooCommerce and the Crumb & Co. Studio theme first.', 'crumb-co-toolkit' ); ?></strong></p>
		<?php endif; ?>

		<h2><?php esc_html_e( 'After setup', 'crumb-co-toolkit' ); ?></h2>
		<ol>
			<li><?php esc_html_e( 'Set real prices on each product (they start with placeholder prices).', 'crumb-co-toolkit' ); ?></li>
			<li><?php esc_html_e( 'Fill in every [placeholder] on the About, FAQ, Contact and policy pages.', 'crumb-co-toolkit' ); ?></li>
			<li><?php esc_html_e( 'Add your support email under Crumb & Co. → Shop settings, and your logo in Appearance → Editor.', 'crumb-co-toolkit' ); ?></li>
			<li><?php esc_html_e( 'Connect a payment provider and place a test order to check the download email.', 'crumb-co-toolkit' ); ?></li>
		</ol>
	</div>
	<?php
}

add_action( 'admin_post_ccs_run_setup', function () {
	if ( ! current_user_can( 'manage_woocommerce' ) || ! check_admin_referer( 'ccs_run_setup' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'crumb-co-toolkit' ) );
	}
	$log = ccs_run_setup( array(
		'create_langs' => ! empty( $_POST['ccs_create_langs'] ),
		'set_front'    => ! empty( $_POST['ccs_set_front'] ),
		'wc_settings'  => ! empty( $_POST['ccs_wc_settings'] ),
	) );
	set_transient( 'ccs_setup_log', $log, 10 * MINUTE_IN_SECONDS );
	wp_safe_redirect( admin_url( 'admin.php?page=ccs-setup' ) );
	exit;
} );

/* -------------------------------------------------------------------------
 * Runner
 * ---------------------------------------------------------------------- */

/**
 * Run the setup.
 *
 * @param array $args Options.
 * @return string[] Log lines.
 */
function ccs_run_setup( $args ) {
	$log = array();
	if ( ! class_exists( 'WooCommerce' ) || 'crumb-co' !== get_template() ) {
		return array( __( 'WooCommerce and the Crumb & Co. Studio theme must be active.', 'crumb-co-toolkit' ) );
	}
	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 300 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/nav-menu.php';

	$pll = function_exists( 'pll_languages_list' ) && function_exists( 'pll_set_post_language' );
	if ( $pll && ! empty( $args['create_langs'] ) ) {
		ccs_setup_polylang_languages( $log );
	}

	// Which languages to build.
	$supported = ccs_supported_languages();
	if ( $pll ) {
		$langs   = array_values( array_intersect( pll_languages_list( array( 'fields' => 'slug' ) ), array_keys( $supported ) ) );
		$default = pll_default_language();
		if ( ! $langs ) {
			$log[] = __( 'Polylang has no English, Arabic, French or Spanish language yet. Add one under Languages, then run setup again.', 'crumb-co-toolkit' );
			return $log;
		}
		if ( ! in_array( $default, $langs, true ) ) {
			$default = $langs[0];
		}
	} else {
		$default = ccs_locale_to_slug( get_locale() );
		$langs   = array( $default );
	}
	// Default language first.
	$langs = array_values( array_unique( array_merge( array( $default ), $langs ) ) );

	if ( ! empty( $args['wc_settings'] ) ) {
		ccs_setup_wc_settings( $log );
	}

	$files = ccs_setup_download_files( $log );
	$media = ccs_setup_media( $log );

	$map = get_option( 'ccs_seeded', array() );

	// Pass 1: taxonomy terms and empty page shells (so links between pages resolve in pass 2).
	foreach ( $langs as $lang ) {
		$catalog = ccs_load_catalog( $lang );
		foreach ( $catalog['categories'] as $key => $cat ) {
			$map = ccs_setup_term( $map, 'cats', 'product_cat', $key, $cat['name'], $cat['description'], $lang, $default, $pll, isset( $media[ $cat['image'] ] ) ? $media[ $cat['image'] ] : 0, $log );
		}
		foreach ( $catalog['tags'] as $key => $name ) {
			$map = ccs_setup_term( $map, 'tags', 'product_tag', $key, $name, '', $lang, $default, $pll, 0, $log );
		}
		foreach ( $catalog['pages'] as $key => $page ) {
			$map = ccs_setup_page_shell( $map, $key, $page, $lang, $default, $pll, $log );
		}
	}
	update_option( 'ccs_seeded', $map, false );
	if ( $pll ) {
		ccs_link_translations( $map, $langs );
		// Shop page belongs to the default language; the product archive itself is language-aware.
		$shop_id = (int) get_option( 'woocommerce_shop_page_id' );
		if ( $shop_id && ! pll_get_post_language( $shop_id ) ) {
			pll_set_post_language( $shop_id, $default );
		}
	}

	// Pass 2: products, page content, menus.
	foreach ( $langs as $lang ) {
		$catalog = ccs_load_catalog( $lang );
		foreach ( $catalog['products'] as $key => $product ) {
			$map = ccs_setup_product( $map, $key, $product, $lang, $default, $pll, $files, $media, $log );
		}
		update_option( 'ccs_seeded', $map, false );
		foreach ( $catalog['pages'] as $key => $page ) {
			ccs_fill_page_content( $map, $key, $page, $lang, $log );
		}
		ccs_seed_search_data( $map, $catalog, $lang );
		foreach ( $catalog['menus'] as $location => $menu ) {
			$map = ccs_setup_menu( $map, $location, $menu, $lang, $pll, $log );
		}
		update_option( 'ccs_seeded', $map, false );
	}
	ccs_restore_strings();

	if ( $pll ) {
		ccs_link_translations( $map, $langs );
	}
	ccs_link_related_products( $map, $langs );
	ccs_assign_menus( $map, $langs, $default, $pll );

	// Site options.
	$home = isset( $map['pages']['home'][ $default ] ) ? (int) $map['pages']['home'][ $default ] : 0;
	if ( ! empty( $args['set_front'] ) && $home ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home );
		$log[] = __( 'Home page set as the front page.', 'crumb-co-toolkit' );
	}
	if ( ! empty( $map['pages']['privacy-policy'][ $default ] ) ) {
		update_option( 'wp_page_for_privacy_policy', (int) $map['pages']['privacy-policy'][ $default ] );
	}
	if ( ! empty( $map['pages']['terms'][ $default ] ) ) {
		update_option( 'woocommerce_terms_page_id', (int) $map['pages']['terms'][ $default ] );
	}
	flush_rewrite_rules( false );

	$log[] = __( 'Done. Remember to replace the placeholder prices and [placeholder] text.', 'crumb-co-toolkit' );
	return $log;
}

/* -------------------------------------------------------------------------
 * Language helpers
 * ---------------------------------------------------------------------- */

/**
 * Load our theme + plugin translations for a language (independent of the admin's own language).
 *
 * @param string $lang Language slug.
 */
function ccs_use_strings( $lang ) {
	$GLOBALS['ccs_seed_lang'] = $lang;
	$locales = ccs_supported_languages();
	$locale  = isset( $locales[ $lang ] ) ? $locales[ $lang ] : 'en_US';
	$files   = array(
		'crumb-co'         => get_template_directory() . '/languages/' . $locale . '.mo',
		'crumb-co-toolkit' => CCS_DIR . 'languages/crumb-co-toolkit-' . $locale . '.mo',
	);
	foreach ( $files as $domain => $mo ) {
		unload_textdomain( $domain ); // Not reloadable: stops just-in-time loading of the admin's language.
		if ( 'en_US' !== $locale ) {
			load_textdomain( $domain, $mo, $locale );
		}
	}
}

/**
 * Restore normal translation loading after setup.
 */
function ccs_restore_strings() {
	unset( $GLOBALS['ccs_seed_lang'] );
	foreach ( array( 'crumb-co', 'crumb-co-toolkit' ) as $domain ) {
		unload_textdomain( $domain, true );
	}
	load_theme_textdomain( 'crumb-co', get_template_directory() . '/languages' );
	load_plugin_textdomain( 'crumb-co-toolkit', false, dirname( plugin_basename( CCS_FILE ) ) . '/languages' );
}

/**
 * Catalogue in a language.
 *
 * @param string $lang Language slug.
 * @return array
 */
function ccs_load_catalog( $lang ) {
	ccs_use_strings( $lang );
	return include CCS_DIR . 'content/catalog.php';
}

/**
 * Create missing Polylang languages.
 *
 * @param string[] $log Log.
 */
function ccs_setup_polylang_languages( &$log ) {
	if ( ! function_exists( 'PLL' ) || ! PLL() || empty( PLL()->model ) ) {
		return;
	}
	$model    = PLL()->model;
	$existing = pll_languages_list( array( 'fields' => 'slug' ) );
	$defs     = array(
		'en' => array( 'English', 'en_US', 0, 'us' ),
		'ar' => array( 'العربية', 'ar', 1, 'arab' ),
		'fr' => array( 'Français', 'fr_FR', 0, 'fr' ),
		'es' => array( 'Español', 'es_ES', 0, 'es' ),
	);
	$order    = 0;
	require_once ABSPATH . 'wp-admin/includes/translation-install.php';
	foreach ( $defs as $slug => $d ) {
		$order++;
		if ( in_array( $slug, $existing, true ) ) {
			continue;
		}
		$lang_args = array( 'name' => $d[0], 'slug' => $slug, 'locale' => $d[1], 'rtl' => $d[2], 'term_group' => $order, 'flag' => $d[3] );
		$result    = ccs_pll_add_language( $model, $lang_args );
		if ( is_wp_error( $result ) && false !== strpos( implode( ' ', $result->get_error_codes() ), 'flag' ) ) {
			$lang_args['flag'] = '';
			$result            = ccs_pll_add_language( $model, $lang_args );
		}
		if ( is_wp_error( $result ) || false === $result ) {
			/* translators: %s: language name */
			$log[] = sprintf( __( 'Could not add the language %s automatically. Add it under Languages, then run setup again.', 'crumb-co-toolkit' ), $d[0] );
			continue;
		}
		/* translators: %s: language name */
		$log[] = sprintf( __( 'Added language: %s', 'crumb-co-toolkit' ), $d[0] );
		if ( 'en_US' !== $d[1] && function_exists( 'wp_download_language_pack' ) && wp_can_install_language_pack() ) {
			wp_download_language_pack( $d[1] );
		}
	}
	if ( method_exists( $model, 'clean_languages_cache' ) ) {
		$model->clean_languages_cache();
	}
}

/**
 * Add a language with whichever Polylang API version is available.
 *
 * @param object $model     Polylang model.
 * @param array  $lang_args Language args.
 * @return mixed
 */
function ccs_pll_add_language( $model, $lang_args ) {
	if ( isset( $model->languages ) && is_object( $model->languages ) && method_exists( $model->languages, 'add' ) ) {
		return $model->languages->add( $lang_args );
	}
	if ( method_exists( $model, 'add_language' ) ) {
		return $model->add_language( $lang_args );
	}
	return new WP_Error( 'ccs_no_api', 'Polylang API not available' );
}

/**
 * Link translations of pages, products and terms in Polylang.
 *
 * @param array    $map   Seed map.
 * @param string[] $langs Languages.
 */
function ccs_link_translations( $map, $langs ) {
	foreach ( array( 'pages', 'products' ) as $group ) {
		if ( empty( $map[ $group ] ) ) {
			continue;
		}
		foreach ( $map[ $group ] as $ids ) {
			$set = array_filter( array_intersect_key( $ids, array_flip( $langs ) ) );
			if ( count( $set ) > 1 ) {
				pll_save_post_translations( array_map( 'intval', $set ) );
			}
		}
	}
	foreach ( array( 'cats', 'tags' ) as $group ) {
		if ( empty( $map[ $group ] ) ) {
			continue;
		}
		foreach ( $map[ $group ] as $ids ) {
			$set = array_filter( array_intersect_key( $ids, array_flip( $langs ) ) );
			if ( count( $set ) > 1 ) {
				pll_save_term_translations( array_map( 'intval', $set ) );
			}
		}
	}
}

/* -------------------------------------------------------------------------
 * WooCommerce settings, files and media
 * ---------------------------------------------------------------------- */

/**
 * Digital-shop settings.
 *
 * @param string[] $log Log.
 */
function ccs_setup_wc_settings( &$log ) {
	$settings = array(
		'woocommerce_file_download_method'                => 'force',
		'woocommerce_downloads_require_login'             => 'no',
		'woocommerce_downloads_grant_access_after_payment' => 'yes',
		'woocommerce_downloads_add_hash_to_filename'      => 'yes',
		'woocommerce_downloads_redirect_fallback_allowed' => 'no',
		'woocommerce_ship_to_countries'                   => 'disabled',
		'woocommerce_enable_signup_and_login_from_checkout' => 'yes',
		'woocommerce_enable_checkout_login_reminder'      => 'yes',
		'woocommerce_enable_myaccount_registration'       => 'yes',
	);
	foreach ( $settings as $key => $value ) {
		update_option( $key, $value );
	}
	$log[] = __( 'WooCommerce set up for digital products: forced (protected) downloads, access granted after payment, shipping disabled.', 'crumb-co-toolkit' );
}

/**
 * Copy download files into the protected woocommerce_uploads folder.
 *
 * @param string[] $log Log.
 * @return array<string,string> file name => URL.
 */
function ccs_setup_download_files( &$log ) {
	$upload = wp_upload_dir();
	$dir    = trailingslashit( $upload['basedir'] ) . 'woocommerce_uploads/crumb-co/';
	$url    = trailingslashit( $upload['baseurl'] ) . 'woocommerce_uploads/crumb-co/';
	wp_mkdir_p( $dir );
	if ( ! file_exists( $dir . 'index.html' ) ) {
		file_put_contents( $dir . 'index.html', '' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	}
	if ( ! file_exists( dirname( $dir ) . '/.htaccess' ) ) {
		file_put_contents( dirname( $dir ) . '/.htaccess', "deny from all\n" ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	}
	$out = array();
	foreach ( glob( CCS_DIR . 'assets/downloads/*' ) as $src ) {
		$name = basename( $src );
		if ( 0 === strpos( $name, 'free-' ) ) {
			continue; // The free sample stays public.
		}
		if ( ! file_exists( $dir . $name ) ) {
			copy( $src, $dir . $name );
		}
		$out[ $name ] = $url . $name;
	}
	// Approve the folder for downloads (WooCommerce 6.4+).
	try {
		if ( function_exists( 'wc_get_container' ) && class_exists( '\Automattic\WooCommerce\Internal\ProductDownloads\ApprovedDirectories\Register' ) ) {
			$register = wc_get_container()->get( \Automattic\WooCommerce\Internal\ProductDownloads\ApprovedDirectories\Register::class );
			if ( method_exists( $register, 'add_approved_directory' ) ) {
				$register->add_approved_directory( $url );
			}
		}
	} catch ( \Throwable $e ) {
		$log[] = __( 'Note: could not register the approved download folder automatically. Check WooCommerce → Settings → Products → Approved download directories.', 'crumb-co-toolkit' );
	}
	/* translators: %d: number of files */
	$log[] = sprintf( __( 'Download files ready in a protected folder: %d', 'crumb-co-toolkit' ), count( $out ) );
	return $out;
}

/**
 * Import product mockup images into the media library (once).
 *
 * @param string[] $log Log.
 * @return array<string,int> file name => attachment ID.
 */
function ccs_setup_media( &$log ) {
	$known = get_option( 'ccs_seeded_media', array() );
	$count = 0;
	foreach ( glob( CCS_DIR . 'assets/images/*.jpg' ) as $src ) {
		$name = basename( $src );
		if ( 0 === strpos( $name, 'share-' ) ) {
			continue; // Social share image is served from the plugin folder.
		}
		if ( ! empty( $known[ $name ] ) && get_post( $known[ $name ] ) ) {
			continue;
		}
		$tmp = wp_tempnam( $name );
		copy( $src, $tmp );
		$id = media_handle_sideload( array( 'name' => $name, 'tmp_name' => $tmp ), 0 );
		if ( is_wp_error( $id ) ) {
			@unlink( $tmp ); // phpcs:ignore
			/* translators: %s: file name */
			$log[] = sprintf( __( 'Image import failed: %s', 'crumb-co-toolkit' ), $name );
			continue;
		}
		$known[ $name ] = $id;
		$count++;
	}
	update_option( 'ccs_seeded_media', $known, false );
	if ( $count ) {
		/* translators: %d: number of images */
		$log[] = sprintf( __( 'Product images imported: %d', 'crumb-co-toolkit' ), $count );
	}
	return $known;
}

/* -------------------------------------------------------------------------
 * Terms, pages, products, menus
 * ---------------------------------------------------------------------- */

/**
 * Existing seeded post/term still there?
 *
 * @param array  $map   Map.
 * @param string $group Group.
 * @param string $key   Key.
 * @param string $lang  Lang.
 * @return int
 */
function ccs_existing( $map, $group, $key, $lang ) {
	if ( empty( $map[ $group ][ $key ][ $lang ] ) ) {
		return 0;
	}
	$id = (int) $map[ $group ][ $key ][ $lang ];
	if ( in_array( $group, array( 'cats', 'tags' ), true ) ) {
		return term_exists( $id ) ? $id : 0;
	}
	if ( 'menus' === $group ) {
		return wp_get_nav_menu_object( $id ) ? $id : 0;
	}
	$status = get_post_status( $id );
	return ( $status && 'trash' !== $status ) ? $id : 0;
}

/**
 * Create a product category / tag.
 */
function ccs_setup_term( $map, $group, $taxonomy, $key, $name, $description, $lang, $default, $pll, $thumb, &$log ) {
	if ( ccs_existing( $map, $group, $key, $lang ) ) {
		return $map;
	}
	$slug   = $lang === $default ? $key : $key . '-' . $lang;
	$exists = get_term_by( 'slug', $slug, $taxonomy );
	if ( $exists ) {
		$term_id = (int) $exists->term_id;
	} else {
		$res = wp_insert_term( $name, $taxonomy, array( 'slug' => $slug, 'description' => $description ) );
		if ( is_wp_error( $res ) ) {
			$log[] = $res->get_error_message();
			return $map;
		}
		$term_id = (int) $res['term_id'];
		if ( $thumb ) {
			update_term_meta( $term_id, 'thumbnail_id', $thumb );
		}
	}
	if ( $pll ) {
		pll_set_term_language( $term_id, $lang );
	}
	$map[ $group ][ $key ][ $lang ] = $term_id;
	return $map;
}

/**
 * Create an empty page (content is filled in pass 2). WooCommerce system pages are reused in the default language.
 */
function ccs_setup_page_shell( $map, $key, $page, $lang, $default, $pll, &$log ) {
	if ( ccs_existing( $map, 'pages', $key, $lang ) ) {
		return $map;
	}
	$wc_keys = array( 'cart' => 'woocommerce_cart_page_id', 'checkout' => 'woocommerce_checkout_page_id', 'my-account' => 'woocommerce_myaccount_page_id' );
	if ( isset( $wc_keys[ $key ] ) ) {
		$wc_id = (int) get_option( $wc_keys[ $key ] );
		if ( ! $wc_id || ! get_post( $wc_id ) || 'trash' === get_post_status( $wc_id ) ) {
			if ( class_exists( 'WC_Install' ) ) {
				WC_Install::create_pages();
			}
			$wc_id = (int) get_option( $wc_keys[ $key ] );
		}
		if ( $lang === $default ) {
			if ( $pll && $wc_id ) {
				pll_set_post_language( $wc_id, $lang );
			}
			$map['pages'][ $key ][ $lang ] = $wc_id;
			return $map;
		}
		// Translation: copy the original content (cart / checkout blocks or shortcode).
		$content = $wc_id ? get_post_field( 'post_content', $wc_id ) : '';
	} else {
		$content = '';
	}
	$slug = isset( $page[2][ $lang ] ) ? $page[2][ $lang ] : $key . '-' . $lang;
	$id   = wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => $page[0],
		'post_name'    => $slug,
		'post_content' => $content,
	), true );
	if ( is_wp_error( $id ) ) {
		$log[] = $id->get_error_message();
		return $map;
	}
	if ( $pll ) {
		pll_set_post_language( $id, $lang );
	}
	if ( 'home' === $key ) {
		update_post_meta( $id, '_ccs_is_home', 1 );
	}
	$map['pages'][ $key ][ $lang ] = (int) $id;
	/* translators: 1: page title, 2: language */
	$log[] = sprintf( __( 'Page created: %1$s (%2$s)', 'crumb-co-toolkit' ), $page[0], $lang );
	return $map;
}

/**
 * Render a theme pattern in the current seeding language.
 *
 * @param string $slug Pattern file name (without .php).
 * @return string
 */
function ccs_render_theme_pattern( $slug ) {
	$file = get_template_directory() . '/patterns/' . $slug . '.php';
	if ( ! $slug || ! file_exists( $file ) ) {
		return '';
	}
	ob_start();
	include $file;
	return trim( ob_get_clean() );
}

/**
 * Fill a new page with pattern content (only if it is still empty).
 */
function ccs_fill_page_content( $map, $key, $page, $lang, &$log ) {
	$id = ccs_existing( $map, 'pages', $key, $lang );
	if ( ! $id || empty( $page[1] ) ) {
		return;
	}
	if ( '' !== trim( (string) get_post_field( 'post_content', $id ) ) ) {
		return; // Never overwrite edited content.
	}
	$content = ccs_render_theme_pattern( $page[1] );
	if ( $content ) {
		wp_update_post( array( 'ID' => $id, 'post_content' => $content ) );
	}
}

/**
 * Search descriptions (read by Yoast, Rank Math, The SEO Framework, SEOPress or the built-in fallback)
 * and translated image alt text. Only empty fields are filled, so it is safe on existing sites.
 *
 * @param array  $map     Seed map.
 * @param array  $catalog Catalogue in this language.
 * @param string $lang    Language slug.
 */
function ccs_seed_search_data( $map, $catalog, $lang ) {
	foreach ( $catalog['pages'] as $key => $page ) {
		$id = ccs_existing( $map, 'pages', $key, $lang );
		if ( $id && ! empty( $page[3] ) ) {
			ccs_seed_description( $id, $page[3] );
		}
	}
	foreach ( $catalog['products'] as $key => $data ) {
		$id = ccs_existing( $map, 'products', $key, $lang );
		if ( ! $id ) {
			continue;
		}
		ccs_seed_description( $id, $data['short'] );
		if ( '' === (string) get_post_meta( $id, '_ccs_image_alt', true ) ) {
			update_post_meta( $id, '_ccs_image_alt', $data['image_alt'] );
		}
	}
}

/**
 * Create a product.
 */
function ccs_setup_product( $map, $key, $data, $lang, $default, $pll, $files, $media, &$log ) {
	if ( ccs_existing( $map, 'products', $key, $lang ) ) {
		return $map;
	}
	$product = new WC_Product_Simple();
	$product->set_name( $data['name'] );
	$product->set_slug( $lang === $default ? $data['slug'] : $data['slug'] . '-' . $lang );
	$product->set_status( 'publish' );
	$product->set_catalog_visibility( 'visible' );
	$product->set_virtual( true );
	$product->set_downloadable( true );
	$product->set_sold_individually( true );
	$product->set_regular_price( $data['price'] );
	$product->set_menu_order( (int) $data['menu_order'] );
	$product->set_reviews_allowed( false );
	$product->set_short_description( $data['short'] );

	$desc = '';
	foreach ( $data['description'] as $para ) {
		$desc .= '<p>' . esc_html( $para ) . "</p>\n";
	}
	$desc .= '<h3>' . esc_html__( 'What it helps you do', 'crumb-co-toolkit' ) . "</h3>\n<ul>\n";
	foreach ( $data['helps'] as $item ) {
		$desc .= '<li>' . esc_html( $item ) . "</li>\n";
	}
	$desc .= "</ul>\n";
	$product->set_description( $desc );

	$cat = ccs_seeded_id( 'cats', $data['category'], $lang );
	if ( $cat ) {
		$product->set_category_ids( array( $cat ) );
	}
	$tag_ids = array();
	foreach ( $data['tags'] as $tag ) {
		$tid = ccs_seeded_id( 'tags', $tag, $lang );
		if ( $tid ) {
			$tag_ids[] = $tid;
		}
	}
	$product->set_tag_ids( $tag_ids );

	$images = array();
	foreach ( $data['images'] as $img ) {
		if ( ! empty( $media[ $img ] ) ) {
			$images[] = (int) $media[ $img ];
		}
	}
	if ( $images ) {
		$product->set_image_id( array_shift( $images ) );
		$product->set_gallery_image_ids( $images );
		if ( $lang === $default ) {
			update_post_meta( $product->get_image_id(), '_wp_attachment_image_alt', $data['image_alt'] );
		}
	}

	if ( ! empty( $files[ $data['download']['file'] ] ) ) {
		$download = new WC_Product_Download();
		$url      = $files[ $data['download']['file'] ];
		$download->set_id( md5( $url ) );
		$download->set_name( $data['download']['name'] );
		$download->set_file( $url );
		$product->set_downloads( array( $download ) );
		$product->set_download_limit( -1 );
		$product->set_download_expiry( -1 );
	}

	$product->update_meta_data( '_ccs_for_who', $data['for_who'] );
	$product->update_meta_data( '_ccs_task', $data['task'] );
	$product->update_meta_data( '_ccs_format_label', $data['format'] );
	$product->update_meta_data( '_ccs_software', $data['software'] );
	$product->update_meta_data( '_ccs_files', implode( "\n", $data['files'] ) );
	$product->update_meta_data( '_ccs_howto', implode( "\n", $data['howto'] ) );
	$faq = array();
	foreach ( $data['faq'] as $qa ) {
		$faq[] = $qa[0] . "\n" . $qa[1];
	}
	$product->update_meta_data( '_ccs_faq', implode( "\n\n", $faq ) );
	$product->update_meta_data( '_ccs_price_placeholder', 1 );
	$product->update_meta_data( '_ccs_image_alt', $data['image_alt'] );

	try {
		$id = $product->save();
	} catch ( \Throwable $e ) {
		$log[] = $e->getMessage();
		return $map;
	}
	if ( ! $id ) {
		return $map;
	}
	if ( $pll ) {
		pll_set_post_language( $id, $lang );
	}
	$map['products'][ $key ][ $lang ] = (int) $id;
	/* translators: 1: product name, 2: language */
	$log[] = sprintf( __( 'Product created: %1$s (%2$s)', 'crumb-co-toolkit' ), $data['name'], $lang );
	return $map;
}

/**
 * Upsells (Launch Kit suggests the others) and cross-sells (each suggests the rest), per language.
 *
 * @param array    $map   Map.
 * @param string[] $langs Languages.
 */
function ccs_link_related_products( $map, $langs ) {
	if ( empty( $map['products'] ) ) {
		return;
	}
	foreach ( $langs as $lang ) {
		$ids = array();
		foreach ( $map['products'] as $key => $by_lang ) {
			if ( ! empty( $by_lang[ $lang ] ) ) {
				$ids[ $key ] = (int) $by_lang[ $lang ];
			}
		}
		foreach ( $ids as $key => $id ) {
			$product = wc_get_product( $id );
			if ( ! $product || $product->get_cross_sell_ids() ) {
				continue;
			}
			$others = array_values( array_diff( $ids, array( $id ) ) );
			$product->set_cross_sell_ids( $others );
			if ( 'launch-kit' !== $key && isset( $ids['launch-kit'] ) ) {
				$product->set_upsell_ids( array( $ids['launch-kit'] ) );
			}
			$product->save();
		}
	}
}

/**
 * Create a menu for one location + language.
 */
function ccs_setup_menu( $map, $location, $menu, $lang, $pll, &$log ) {
	if ( ccs_existing( $map, 'menus', $location, $lang ) ) {
		return $map;
	}
	$name    = $pll ? $menu['name'] . ' (' . strtoupper( $lang ) . ')' : $menu['name'];
	$menu_id = wp_create_nav_menu( $name );
	if ( is_wp_error( $menu_id ) ) {
		$obj     = wp_get_nav_menu_object( $name );
		$menu_id = $obj ? $obj->term_id : 0;
		if ( ! $menu_id ) {
			return $map;
		}
	}
	foreach ( $menu['items'] as $i => $item ) {
		$parent = ccs_add_menu_item( $menu_id, $item[0], $item[1], $lang, 0, $i );
		if ( $parent && ! empty( $item[2] ) ) {
			foreach ( $item[2] as $j => $child ) {
				ccs_add_menu_item( $menu_id, $child, '', $lang, $parent, $j );
			}
		}
	}
	$map['menus'][ $location ][ $lang ] = (int) $menu_id;
	return $map;
}

/**
 * Add one menu item.
 *
 * @return int Item ID.
 */
function ccs_add_menu_item( $menu_id, $key, $label, $lang, $parent, $position ) {
	$args = array( 'menu-item-status' => 'publish', 'menu-item-parent-id' => $parent, 'menu-item-position' => $position + 1 );
	if ( 'shop' === $key ) {
		$args += array( 'menu-item-type' => 'custom', 'menu-item-url' => ccs_shop_url( $lang ), 'menu-item-title' => $label );
	} elseif ( 0 === strpos( $key, 'cat:' ) ) {
		$tid = ccs_seeded_id( 'cats', substr( $key, 4 ), $lang );
		if ( ! $tid ) {
			return 0;
		}
		$args += array( 'menu-item-type' => 'taxonomy', 'menu-item-object' => 'product_cat', 'menu-item-object-id' => $tid );
		if ( $label ) {
			$args['menu-item-title'] = $label;
		}
	} else {
		$pid = ccs_seeded_id( 'pages', $key, $lang );
		if ( ! $pid ) {
			return 0;
		}
		$args += array( 'menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $pid, 'menu-item-title' => $label );
	}
	$id = wp_update_nav_menu_item( $menu_id, 0, $args );
	return is_wp_error( $id ) ? 0 : (int) $id;
}

/**
 * Assign menus to theme locations (per language with Polylang).
 */
function ccs_assign_menus( $map, $langs, $default, $pll ) {
	if ( empty( $map['menus'] ) ) {
		return;
	}
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$options   = $pll ? get_option( 'polylang', array() ) : array();
	$theme     = get_stylesheet();
	foreach ( $map['menus'] as $location => $by_lang ) {
		if ( ! empty( $by_lang[ $default ] ) && empty( $locations[ $location ] ) ) {
			$locations[ $location ] = (int) $by_lang[ $default ];
		}
		if ( $pll ) {
			foreach ( $langs as $lang ) {
				if ( ! empty( $by_lang[ $lang ] ) && empty( $options['nav_menus'][ $theme ][ $location ][ $lang ] ) ) {
					$options['nav_menus'][ $theme ][ $location ][ $lang ] = (int) $by_lang[ $lang ];
				}
			}
		}
	}
	set_theme_mod( 'nav_menu_locations', $locations );
	if ( $pll ) {
		update_option( 'polylang', $options );
	}
}
