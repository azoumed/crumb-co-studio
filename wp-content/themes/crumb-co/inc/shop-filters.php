<?php
/**
 * Shop sidebar: product search, categories, file-format filter, price range and help box.
 * Uses WooCommerce's built-in query vars (product_cat, product_tag, min_price, max_price, orderby),
 * so it works with the classic product archive and with Polylang language filtering.
 *
 * @package CrumbCo
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'crumb_shop_filters', 'crumb_co_shop_filters' );

/**
 * Render the sidebar.
 *
 * @return string
 */
function crumb_co_shop_filters() {
	if ( ! function_exists( 'wc_get_page_permalink' ) ) {
		return '';
	}
	$shop_url = crumb_co_page_url( 'shop' );
	$current  = get_queried_object();
	$base_url = ( $current instanceof WP_Term ) ? get_term_link( $current ) : $shop_url;
	if ( is_wp_error( $base_url ) ) {
		$base_url = $shop_url;
	}

	ob_start();
	?>
	<div class="ccs-filters">
		<button class="ccs-filters__toggle" type="button" aria-expanded="false" aria-controls="ccs-filters-panel"><?php esc_html_e( 'Search & filter', 'crumb-co' ); ?></button>
		<div class="ccs-filters__panel" id="ccs-filters-panel">

		<form role="search" method="get" class="ccs-filter ccs-filter--search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="ccs-filter__title" for="ccs-product-search"><?php esc_html_e( 'Search the toolkit', 'crumb-co' ); ?></label>
			<div class="ccs-filter__row">
				<input type="search" id="ccs-product-search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'e.g. order tracker', 'crumb-co' ); ?>" />
				<input type="hidden" name="post_type" value="product" />
				<?php if ( function_exists( 'pll_current_language' ) && pll_current_language() ) : ?>
					<input type="hidden" name="lang" value="<?php echo esc_attr( pll_current_language() ); ?>" />
				<?php endif; ?>
				<button type="submit" class="wp-element-button"><?php esc_html_e( 'Search', 'crumb-co' ); ?></button>
			</div>
		</form>

		<?php
		$cats = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
		if ( ! is_wp_error( $cats ) && $cats ) :
			?>
			<nav class="ccs-filter" aria-labelledby="ccs-filter-cats">
				<h2 class="ccs-filter__title" id="ccs-filter-cats"><?php esc_html_e( 'Shop by task', 'crumb-co' ); ?></h2>
				<ul class="ccs-filter__list">
					<li><a href="<?php echo esc_url( $shop_url ); ?>"<?php echo ( function_exists( 'is_shop' ) && is_shop() && ! is_search() ) ? ' aria-current="page"' : ''; ?>><?php esc_html_e( 'All products', 'crumb-co' ); ?></a></li>
					<?php foreach ( $cats as $cat ) : ?>
						<li><a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"<?php echo ( is_tax( 'product_cat', $cat->term_id ) ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $cat->name ); ?> <span class="ccs-count"><?php echo esc_html( number_format_i18n( $cat->count ) ); ?></span></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>
		<?php endif; ?>

		<?php
		$tags = get_terms( array( 'taxonomy' => 'product_tag', 'hide_empty' => true ) );
		if ( ! is_wp_error( $tags ) && $tags ) :
			?>
			<nav class="ccs-filter" aria-labelledby="ccs-filter-tags">
				<h2 class="ccs-filter__title" id="ccs-filter-tags"><?php esc_html_e( 'File format', 'crumb-co' ); ?></h2>
				<ul class="ccs-filter__chips">
					<?php foreach ( $tags as $tag ) : ?>
						<li><a class="ccs-chip<?php echo is_tax( 'product_tag', $tag->term_id ) ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $tag ) ); ?>"<?php echo is_tax( 'product_tag', $tag->term_id ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $tag->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>
		<?php endif; ?>

		<form method="get" class="ccs-filter ccs-filter--price" action="<?php echo esc_url( $base_url ); ?>">
			<fieldset>
				<legend class="ccs-filter__title"><?php esc_html_e( 'Price', 'crumb-co' ); ?></legend>
				<div class="ccs-filter__row">
					<label><span><?php esc_html_e( 'Min', 'crumb-co' ); ?></span>
						<input type="number" inputmode="decimal" min="0" step="1" name="min_price" value="<?php echo isset( $_GET['min_price'] ) ? esc_attr( wc_clean( wp_unslash( $_GET['min_price'] ) ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification ?>" /></label>
					<label><span><?php esc_html_e( 'Max', 'crumb-co' ); ?></span>
						<input type="number" inputmode="decimal" min="0" step="1" name="max_price" value="<?php echo isset( $_GET['max_price'] ) ? esc_attr( wc_clean( wp_unslash( $_GET['max_price'] ) ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification ?>" /></label>
				</div>
				<?php if ( isset( $_GET['orderby'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification ?>
					<input type="hidden" name="orderby" value="<?php echo esc_attr( wc_clean( wp_unslash( $_GET['orderby'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification ?>" />
				<?php endif; ?>
				<div class="ccs-filter__row">
					<button type="submit" class="wp-element-button"><?php esc_html_e( 'Apply', 'crumb-co' ); ?></button>
					<a class="ccs-filter__clear" href="<?php echo esc_url( $base_url ); ?>"><?php esc_html_e( 'Clear filters', 'crumb-co' ); ?></a>
				</div>
			</fieldset>
		</form>

		<div class="ccs-filter ccs-help-box">
			<h2 class="ccs-filter__title"><?php esc_html_e( 'Questions before you buy?', 'crumb-co' ); ?></h2>
			<p><?php esc_html_e( 'Every product is a digital download. See how downloads work, or ask us anything.', 'crumb-co' ); ?></p>
			<p><a href="<?php echo esc_url( crumb_co_page_url( 'faq' ) ); ?>"><?php esc_html_e( 'Read the FAQ', 'crumb-co' ); ?></a> &middot; <a href="<?php echo esc_url( crumb_co_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact support', 'crumb-co' ); ?></a></p>
		</div>

		</div>
	</div>
	<?php
	return ob_get_clean();
}
