<?php
/**
 * Search & sharing, following Google Search Central guidance.
 *
 * Always active (safe alongside any SEO plugin):
 * - Product structured data: brand + return policy (merchant listings),
 * - Organization structured data enrichment for Yoast (return policy, social profiles),
 * - robots.txt rules that keep crawlers out of cart actions and sorted/filtered duplicates,
 * - noindex for internal search, product-tag, author and date archives and filtered URLs,
 * - cleaner core XML sitemap (no user or tag sitemaps),
 * - translated image alt text for product images,
 * - Search Console / Bing verification tags.
 *
 * Fallback, only when NO SEO plugin is active (Yoast, Rank Math, The SEO Framework, AIOSEO, SEOPress, Slim SEO):
 * - meta description, canonical for archives, Open Graph + X/Twitter cards,
 * - Organization + WebSite JSON-LD on the front page,
 * - an editable "Search description" box on pages, posts and products.
 *
 * @package CrumbCoToolkit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Is a dedicated SEO plugin handling titles, descriptions and social tags?
 *
 * @return bool
 */
function ccs_seo_plugin_active() {
	$active = defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath' )
		|| defined( 'THE_SEO_FRAMEWORK_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'SLIM_SEO_VER' );
	return (bool) apply_filters( 'ccs_seo_plugin_active', $active );
}

/**
 * Meta keys used by popular SEO plugins for the description, so starter content is picked up by whichever one you install.
 *
 * @return string[]
 */
function ccs_description_meta_keys() {
	return array( '_ccs_meta_description', '_yoast_wpseo_metadesc', 'rank_math_description', '_genesis_description', '_seopress_titles_desc' );
}

/**
 * Store a description for a post (only fills empty fields — never overwrites your edits).
 *
 * @param int    $post_id Post ID.
 * @param string $text    Description.
 */
function ccs_seed_description( $post_id, $text ) {
	$text = ccs_trim_description( $text );
	if ( '' === $text ) {
		return;
	}
	foreach ( ccs_description_meta_keys() as $key ) {
		if ( '' === (string) get_post_meta( $post_id, $key, true ) ) {
			update_post_meta( $post_id, $key, $text );
		}
	}
}

/**
 * Plain text, max ~155 characters, cut on a word boundary.
 *
 * @param string $text Text.
 * @param int    $max  Max length.
 * @return string
 */
function ccs_trim_description( $text, $max = 155 ) {
	$text = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( strip_shortcodes( (string) $text ) ) ) );
	if ( mb_strlen( $text ) <= $max ) {
		return $text;
	}
	$cut   = mb_substr( $text, 0, $max - 1 );
	$space = mb_strrpos( $cut, ' ' );
	if ( $space > 80 ) {
		$cut = mb_substr( $cut, 0, $space );
	}
	return rtrim( $cut, " ,;:—-" ) . '…';
}

/**
 * Social profile URLs from settings.
 *
 * @return string[]
 */
function ccs_social_profiles() {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', ccs_option( 'social_profiles' ) ) ) ) );
}

/**
 * MerchantReturnPolicy structured data, or null when not configured.
 *
 * @return array|null
 */
function ccs_return_policy_schema() {
	$category  = ccs_option( 'return_policy' );
	$countries = array_values( array_filter(
		array_map( 'strtoupper', array_map( 'trim', explode( ',', ccs_option( 'return_countries' ) ) ) ),
		function ( $c ) {
			return (bool) preg_match( '/^[A-Z]{2}$/', $c );
		}
	) );
	if ( ! $category || ! $countries ) {
		return null;
	}
	$policy = array(
		'@type'                => 'MerchantReturnPolicy',
		'applicableCountry'    => 1 === count( $countries ) ? $countries[0] : $countries,
		'returnPolicyCategory' => 'https://schema.org/' . $category,
	);
	if ( 'MerchantReturnFiniteReturnWindow' === $category ) {
		$days = (int) ccs_option( 'return_days' );
		if ( $days < 1 ) {
			return null;
		}
		$policy['merchantReturnDays'] = $days;
	}
	$link = function_exists( 'crumb_co_page_url' ) ? crumb_co_page_url( 'refund-policy' ) : '';
	if ( $link ) {
		$policy['merchantReturnLink'] = $link;
	}
	return $policy;
}

/**
 * Brand / organization name.
 *
 * @return string
 */
function ccs_brand_name() {
	$name = ccs_option( 'business_name' );
	return $name ? $name : get_bloginfo( 'name' );
}

/* =========================================================================
 * Always on
 * ====================================================================== */

// Product structured data: brand and return policy (Google merchant listings).
add_filter( 'woocommerce_structured_data_product', function ( $markup, $product ) {
	if ( empty( $markup['brand'] ) ) {
		$markup['brand'] = array( '@type' => 'Brand', 'name' => ccs_brand_name() );
	}
	$policy = ccs_return_policy_schema();
	if ( $policy && ! empty( $markup['offers'] ) && is_array( $markup['offers'] ) ) {
		foreach ( $markup['offers'] as $i => $offer ) {
			if ( is_array( $offer ) && empty( $offer['hasMerchantReturnPolicy'] ) ) {
				$markup['offers'][ $i ]['hasMerchantReturnPolicy'] = $policy;
			}
		}
	}
	return $markup;
}, 10, 2 );

// Yoast: add return policy + social profiles to its Organization piece.
add_filter( 'wpseo_schema_organization', function ( $data ) {
	$policy = ccs_return_policy_schema();
	if ( $policy && empty( $data['hasMerchantReturnPolicy'] ) ) {
		$data['hasMerchantReturnPolicy'] = $policy;
	}
	$profiles = ccs_social_profiles();
	if ( $profiles ) {
		$data['sameAs'] = array_values( array_unique( array_merge( isset( $data['sameAs'] ) ? (array) $data['sameAs'] : array(), $profiles ) ) );
	}
	return $data;
} );

// noindex for thin or duplicate pages (they are still followed).
add_filter( 'wp_robots', function ( $robots ) {
	$noindex = is_search() || is_author() || is_date() || is_tax( 'product_tag' ) || is_tag();
	foreach ( array_keys( $_GET ) as $param ) { // phpcs:ignore WordPress.Security.NonceVerification
		if ( in_array( $param, array( 'min_price', 'max_price', 'orderby', 'rating_filter' ), true ) || 0 === strpos( $param, 'filter_' ) ) {
			$noindex = true;
		}
	}
	if ( $noindex ) {
		unset( $robots['index'] );
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	return $robots;
} );

// robots.txt: keep crawlers out of add-to-cart links and sorted/filtered duplicates (Google's faceted navigation advice).
add_filter( 'robots_txt', function ( $output, $public ) {
	if ( ! $public ) {
		return $output;
	}
	return rtrim( $output ) . "\n\n# Crumb & Co. Toolkit\nUser-agent: *\nDisallow: /*?*add-to-cart=\nDisallow: /*?*orderby=\nDisallow: /*?*min_price=\nDisallow: /*?*max_price=\n";
}, 20, 2 );

// Core XML sitemap (used when no SEO plugin provides one): no author or tag sitemaps.
add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
	return 'users' === $name ? false : $provider;
}, 10, 2 );
add_filter( 'wp_sitemaps_taxonomies', function ( $taxonomies ) {
	unset( $taxonomies['product_tag'], $taxonomies['post_tag'], $taxonomies['post_format'] );
	return $taxonomies;
} );

// Product images: alt text in the visitor's language (images are shared between translations).
add_filter( 'wp_get_attachment_image_attributes', function ( $attr, $attachment ) {
	global $product;
	if ( ! ( $product instanceof WC_Product ) || ! $attachment ) {
		return $attr;
	}
	$ids = array_map( 'intval', array_merge( array( $product->get_image_id() ), $product->get_gallery_image_ids() ) );
	if ( in_array( (int) $attachment->ID, $ids, true ) ) {
		$alt = $product->get_meta( '_ccs_image_alt' );
		if ( $alt ) {
			$attr['alt'] = $alt;
		}
	}
	return $attr;
}, 10, 2 );

// Ownership verification tags (front page only, as the tools expect).
add_action( 'wp_head', function () {
	if ( ! is_front_page() ) {
		return;
	}
	foreach ( array( 'google_verification' => 'google-site-verification', 'bing_verification' => 'msvalidate.01' ) as $key => $name ) {
		$code = ccs_option( $key );
		if ( $code ) {
			echo '<meta name="' . esc_attr( $name ) . '" content="' . esc_attr( $code ) . '" />' . "\n";
		}
	}
}, 1 );

/* =========================================================================
 * Fallback (no SEO plugin installed)
 * ====================================================================== */

/**
 * Description for the current request.
 *
 * @return string
 */
function ccs_current_description() {
	if ( is_singular() ) {
		$id   = get_queried_object_id();
		$desc = (string) get_post_meta( $id, '_ccs_meta_description', true );
		if ( '' === $desc ) {
			$post = get_post( $id );
			if ( $post && 'product' === $post->post_type ) {
				$desc = $post->post_excerpt;
			} elseif ( $post ) {
				$desc = has_excerpt( $id ) ? $post->post_excerpt : excerpt_remove_blocks( $post->post_content );
			}
		}
		return ccs_trim_description( $desc );
	}
	if ( is_tax() || is_category() ) {
		$term = get_queried_object();
		return $term ? ccs_trim_description( $term->description ) : '';
	}
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		return ccs_trim_description( __( 'Editable digital templates for home bakers: order trackers, cost calculators, launch documents and content planners. Instant download — nothing is shipped.', 'crumb-co-toolkit' ) );
	}
	return ccs_trim_description( get_bloginfo( 'description' ) );
}

/**
 * Canonical URL for archives (WordPress core already prints it for single pages).
 *
 * @return string
 */
function ccs_archive_canonical() {
	if ( is_singular() || is_search() || is_404() ) {
		return '';
	}
	$url = '';
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		$url = ccs_shop_url();
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$link = get_term_link( get_queried_object() );
		$url  = is_wp_error( $link ) ? '' : $link;
	}
	$paged = max( 1, (int) get_query_var( 'paged' ) );
	if ( $url && $paged > 1 ) {
		$url = user_trailingslashit( trailingslashit( $url ) . 'page/' . $paged, 'paged' );
	}
	return $url;
}

/**
 * Image for social sharing: [url, width, height].
 *
 * @return array
 */
function ccs_share_image() {
	$id = 0;
	if ( is_singular() && has_post_thumbnail() ) {
		$id = get_post_thumbnail_id();
	} elseif ( is_tax( 'product_cat' ) ) {
		$id = (int) get_term_meta( get_queried_object_id(), 'thumbnail_id', true );
	}
	if ( $id ) {
		$src = wp_get_attachment_image_src( $id, 'large' );
		if ( $src ) {
			return array( $src[0], (int) $src[1], (int) $src[2] );
		}
	}
	$custom = ccs_option( 'share_image_url' );
	return $custom ? array( $custom, 0, 0 ) : array( CCS_URL . 'assets/images/share-default.jpg', 1200, 630 );
}

/**
 * Open Graph locale for a language slug.
 *
 * @param string $slug Language slug.
 * @return string
 */
function ccs_og_locale( $slug ) {
	$map = array( 'en' => 'en_US', 'ar' => 'ar_AR', 'fr' => 'fr_FR', 'es' => 'es_ES' );
	return isset( $map[ $slug ] ) ? $map[ $slug ] : 'en_US';
}

add_action( 'wp_head', function () {
	if ( ccs_seo_plugin_active() || is_feed() || is_404() ) {
		return;
	}
	$desc  = ccs_current_description();
	$canon = ccs_archive_canonical();
	$url   = is_singular() ? get_permalink() : ( $canon ? $canon : home_url( '/' ) );
	$image = ccs_share_image();
	$lang  = ccs_current_lang();
	$type  = is_singular( 'product' ) ? 'product' : ( is_singular( 'post' ) ? 'article' : 'website' );

	$out = '';
	if ( $desc ) {
		$out .= '<meta name="description" content="' . esc_attr( $desc ) . '" />' . "\n";
	}
	if ( $canon ) {
		$out .= '<link rel="canonical" href="' . esc_url( $canon ) . '" />' . "\n";
	}
	$og = array(
		'og:site_name' => get_bloginfo( 'name' ),
		'og:locale'    => ccs_og_locale( $lang ),
		'og:type'      => $type,
		'og:title'     => wp_get_document_title(),
		'og:url'       => $url,
	);
	if ( $desc ) {
		$og['og:description'] = $desc;
	}
	foreach ( $og as $prop => $content ) {
		$out .= '<meta property="' . esc_attr( $prop ) . '" content="' . esc_attr( $content ) . '" />' . "\n";
	}
	if ( function_exists( 'pll_languages_list' ) ) {
		foreach ( (array) pll_languages_list( array( 'fields' => 'slug' ) ) as $other ) {
			if ( $other !== $lang ) {
				$out .= '<meta property="og:locale:alternate" content="' . esc_attr( ccs_og_locale( $other ) ) . '" />' . "\n";
			}
		}
	}
	$out .= '<meta property="og:image" content="' . esc_url( $image[0] ) . '" />' . "\n";
	if ( $image[1] && $image[2] ) {
		$out .= '<meta property="og:image:width" content="' . (int) $image[1] . '" /><meta property="og:image:height" content="' . (int) $image[2] . '" />' . "\n";
	}
	$out .= '<meta name="twitter:card" content="summary_large_image" />' . "\n";

	if ( is_front_page() ) {
		$org = array(
			'@type' => 'Organization',
			'@id'   => home_url( '/#organization' ),
			'name'  => ccs_brand_name(),
			'url'   => home_url( '/' ),
		);
		$logo_id = (int) get_theme_mod( 'custom_logo' );
		$logo_id = $logo_id ? $logo_id : (int) get_option( 'site_icon' );
		$logo    = $logo_id ? wp_get_attachment_image_src( $logo_id, 'full' ) : false;
		if ( $logo ) {
			$org['logo'] = $logo[0];
		}
		if ( is_email( ccs_option( 'support_email' ) ) ) {
			$org['email'] = ccs_option( 'support_email' );
		}
		if ( ccs_social_profiles() ) {
			$org['sameAs'] = ccs_social_profiles();
		}
		$policy = ccs_return_policy_schema();
		if ( $policy ) {
			$org['hasMerchantReturnPolicy'] = $policy;
		}
		// Google retired the sitelinks search box in 2024, so no SearchAction is added.
		$site = array(
			'@type'      => 'WebSite',
			'@id'        => home_url( '/#website' ),
			'url'        => home_url( '/' ),
			'name'       => get_bloginfo( 'name' ),
			'inLanguage' => str_replace( '_', '-', determine_locale() ),
			'publisher'  => array( '@id' => home_url( '/#organization' ) ),
		);
		$out .= '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => array( $org, $site ) ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG ) . '</script>' . "\n";
	}
	echo $out; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above.
}, 2 );

// Editable search description (only shown when no SEO plugin is active — otherwise use that plugin's box).
add_action( 'add_meta_boxes', function () {
	if ( ccs_seo_plugin_active() ) {
		return;
	}
	foreach ( array( 'page', 'post', 'product' ) as $type ) {
		add_meta_box( 'ccs-seo', __( 'Search description', 'crumb-co-toolkit' ), 'ccs_render_seo_box', $type, 'side', 'default' );
	}
} );

/**
 * Meta box.
 *
 * @param WP_Post $post Post.
 */
function ccs_render_seo_box( $post ) {
	wp_nonce_field( 'ccs_seo_box', 'ccs_seo_nonce' );
	$val = get_post_meta( $post->ID, '_ccs_meta_description', true );
	echo '<textarea name="ccs_meta_description" rows="5" style="width:100%" maxlength="300">' . esc_textarea( $val ) . '</textarea>';
	echo '<p class="description">' . esc_html__( 'Shown under the title in Google results. Aim for 120–155 characters that describe this page honestly. Installing an SEO plugin replaces this box.', 'crumb-co-toolkit' ) . '</p>';
}

add_action( 'save_post', function ( $post_id ) {
	if ( ! isset( $_POST['ccs_seo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ccs_seo_nonce'] ) ), 'ccs_seo_box' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['ccs_meta_description'] ) ) {
		update_post_meta( $post_id, '_ccs_meta_description', sanitize_textarea_field( wp_unslash( $_POST['ccs_meta_description'] ) ) );
	}
} );
