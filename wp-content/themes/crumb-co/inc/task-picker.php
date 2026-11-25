<?php
/**
 * Home page task picker: "What is taking most of your time this week?"
 *
 * Four job tabs. Each answers with a faithful excerpt of the template that handles the job
 * (the same tabs, column heads and example rows as the shipped files), plus the live
 * WooCommerce product: name, format, software, price and an add-to-cart button.
 *
 * Without JavaScript every tab is a plain link to its product page and only the first
 * excerpt shows, so nothing shifts while the page loads.
 *
 * @package CrumbCo
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'crumb_task_picker', 'crumb_co_task_picker' );

/**
 * The four jobs, in reading order. Category keys match the Toolkit's starter catalogue.
 *
 * @return array
 */
function crumb_co_task_picker_jobs() {
	return array(
		'orders'  => array(
			'category' => 'order-management',
			'label'    => __( 'Keeping orders straight', 'crumb-co' ),
			'hint'     => __( 'Orders, pickups, deposits', 'crumb-co' ),
		),
		'costs'   => array(
			'category' => 'pricing-costing',
			'label'    => __( 'Knowing what a bake costs', 'crumb-co' ),
			'hint'     => __( 'Ingredients, packaging, your time', 'crumb-co' ),
		),
		'launch'  => array(
			'category' => 'launch-setup',
			'label'    => __( 'Getting ready to take orders', 'crumb-co' ),
			'hint'     => __( 'Order form, menu, checklist', 'crumb-co' ),
		),
		'posting' => array(
			'category' => 'marketing',
			'label'    => __( 'Knowing what to post', 'crumb-co' ),
			'hint'     => __( 'A month of posts, planned', 'crumb-co' ),
		),
	);
}

/**
 * First published product in a category, in the visitor's language when Polylang is active.
 *
 * @param string $cat_slug Category slug (default language).
 * @return WC_Product|null
 */
function crumb_co_task_picker_product( $cat_slug ) {
	if ( ! function_exists( 'wc_get_products' ) ) {
		return null;
	}
	// 'lang' => '' lets Polylang return the default-language term whatever the page language.
	$terms = get_terms( array( 'taxonomy' => 'product_cat', 'slug' => $cat_slug, 'hide_empty' => false, 'number' => 1, 'lang' => '' ) );
	if ( is_wp_error( $terms ) || ! $terms ) {
		return null;
	}
	$term_id = $terms[0]->term_id;
	if ( function_exists( 'pll_get_term' ) && function_exists( 'pll_current_language' ) && pll_current_language() ) {
		$translated = pll_get_term( $term_id, pll_current_language() );
		if ( $translated ) {
			$term_id = $translated;
		}
	}
	$ids = get_posts(
		array(
			'post_type'        => 'product',
			'post_status'      => 'publish',
			'numberposts'      => 1,
			'orderby'          => 'menu_order',
			'order'            => 'ASC',
			'fields'           => 'ids',
			'suppress_filters' => false,
			'tax_query'        => array( array( 'taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $term_id ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
		)
	);
	return $ids ? wc_get_product( $ids[0] ) : null;
}

/**
 * A status chip.
 *
 * @param string $text Label.
 * @param string $tone sage | rasp | butter | plain.
 * @return string
 */
function crumb_co_chip( $text, $tone ) {
	return '<span class="ccs-chip-s ccs-chip-s--' . esc_attr( $tone ) . '">' . esc_html( $text ) . '</span>';
}

/**
 * The sheet excerpt for one job.
 *
 * @param string $job Job key.
 * @return array { file, tabs, active, cols, rows, foot, narrow }
 */
function crumb_co_task_picker_sheet( $job ) {
	$ex   = 'Example';
	$auto = '<span class="ccs-sheet__fx" aria-label="' . esc_attr__( 'calculated by formula', 'crumb-co' ) . '">ƒx</span>';
	$in   = '<span class="ccs-sheet__input" aria-label="' . esc_attr__( 'you type this', 'crumb-co' ) . '"></span>';

	switch ( $job ) {
		case 'costs':
			return array(
				'file'   => 'cake-pricing-calculator.xlsx',
				'tabs'   => array( 'Start here', 'Ingredient library', 'Cake costing' ),
				'active' => 2,
				'cols'   => array( 'Ingredient', 'Amount used', 'Unit', 'Line cost' ),
				'narrow' => array( 0, 1, 3 ),
				'rows'   => array(
					array( esc_html( 'Flour (example)' ), $in, 'g', $auto ),
					array( esc_html( 'Sugar (example)' ), $in, 'g', $auto ),
					array( esc_html( 'Butter (example)' ), $in, 'g', $auto ),
					array( esc_html( 'Eggs (example)' ), $in, esc_html( 'each' ), $auto ),
				),
				'foot'   => array(
					array( esc_html( 'Packaging total' ), $auto ),
					array( esc_html( 'Labour total' ), $auto ),
					array( '<strong>' . esc_html( 'TOTAL COST' ) . '</strong>', $auto ),
				),
				'note'   => __( 'Yellow cells are yours to fill in. The sheet adds up your costs; it does not set your price.', 'crumb-co' ),
			);
		case 'launch':
			$done = crumb_co_chip( 'Yes', 'sage' );
			return array(
				'file'   => '04-launch-checklist.xlsx',
				'tabs'   => array( 'Launch checklist' ),
				'active' => 0,
				'cols'   => array( 'Stage', 'Task', 'Done?' ),
				'narrow' => array( 1, 2 ),
				'rows'   => array(
					array( esc_html( 'Foundations' ), esc_html( 'Research the local rules for selling food from home' ), $done ),
					array( esc_html( 'Products & pricing' ), esc_html( 'List your launch menu (keep it short)' ), $done ),
					array( esc_html( 'Products & pricing' ), esc_html( 'Write your allergen information honestly' ), '' ),
					array( esc_html( 'Ordering' ), esc_html( 'Set your lead time and booking limits' ), '' ),
					array( esc_html( 'Ordering' ), esc_html( 'Decide deposit, payment and cancellation terms' ), '' ),
				),
				'files'  => array( '01-order-form.docx', '02-customer-questionnaire.docx', '03-menu-template.docx', '04-launch-checklist.xlsx' ),
				'note'   => __( '25 tasks in six stages, plus the order form, questionnaire and menu as Word documents.', 'crumb-co' ),
			);
		case 'posting':
			return array(
				'file'   => 'social-content-planner-for-bakers.xlsx',
				'tabs'   => array( 'Monthly planner', 'Prompt bank', 'Seasonal ideas' ),
				'active' => 0,
				'cols'   => array( 'Post theme', 'Post idea / prompt', 'Format', 'Status' ),
				'narrow' => array( 1, 3 ),
				'rows'   => array(
					array( esc_html( 'Product spotlight' ), esc_html( 'Close-up of the crumb + what makes this recipe yours' ), esc_html( 'Photo' ), crumb_co_chip( 'Idea', 'plain' ) ),
					array( esc_html( 'Behind the scenes' ), esc_html( 'Your weekly baking rhythm: when you bake, decorate and pack.' ), esc_html( 'Carousel' ), crumb_co_chip( 'Drafted', 'butter' ) ),
					array( esc_html( 'How to order' ), esc_html( 'Explain your lead time and how far ahead to book.' ), esc_html( 'Story' ), crumb_co_chip( 'Scheduled', 'rasp' ) ),
					array( esc_html( 'Tips & care' ), esc_html( 'How to store and serve your bakes for best results.' ), esc_html( 'Short video' ), crumb_co_chip( 'Posted', 'sage' ) ),
				),
				'note'   => __( '22 prompts across 8 themes, and a month-by-month list of occasions to plan around.', 'crumb-co' ),
			);
		case 'orders':
		default:
			return array(
				'file'   => 'home-bakery-order-tracker.xlsx',
				'tabs'   => array( 'Start here', 'Orders', 'Lists', 'Summary' ),
				'active' => 1,
				'cols'   => array( 'Customer name', 'Item', 'Pickup or delivery', 'Payment status', 'Order status' ),
				'narrow' => array( 1, 3, 4 ),
				'rows'   => array(
					array( esc_html( $ex . ': Sam R.' ), esc_html( 'Celebration cake' ), esc_html( 'Pickup' ), crumb_co_chip( 'Deposit paid', 'butter' ), crumb_co_chip( 'Confirmed', 'sage' ) ),
					array( esc_html( $ex . ': Lee K.' ), esc_html( 'Cookie box' ), esc_html( 'Delivery' ), crumb_co_chip( 'Paid in full', 'sage' ), crumb_co_chip( 'In progress', 'butter' ) ),
					array( esc_html( $ex . ': Ana M.' ), esc_html( 'Cupcakes' ), esc_html( 'Pickup' ), crumb_co_chip( 'Unpaid', 'rasp' ), crumb_co_chip( 'Quoted', 'plain' ) ),
				),
				'note'   => __( '300 ready rows. The balance due works itself out, and the Summary tab counts orders by status.', 'crumb-co' ),
			);
	}
}

/**
 * Render the picker.
 *
 * @return string
 */
function crumb_co_task_picker() {
	$jobs  = crumb_co_task_picker_jobs();
	$uid   = 'ccs-tp';
	$first = true;

	wp_enqueue_script( 'crumb-co-task-picker', get_theme_file_uri( 'assets/js/task-picker.js' ), array(), wp_get_theme()->get( 'Version' ), array( 'strategy' => 'defer', 'in_footer' => true ) );

	ob_start();
	?>
	<div class="ccs-tp" data-ccs-task-picker>
		<div class="ccs-tp__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Choose a job', 'crumb-co' ); ?>">
			<?php
			foreach ( $jobs as $key => $job ) :
				$product = crumb_co_task_picker_product( $job['category'] );
				$href    = $product ? $product->get_permalink() : crumb_co_page_url( 'cat:' . $job['category'] );
				?>
				<a class="ccs-tp__tab" role="tab" id="<?php echo esc_attr( "$uid-tab-$key" ); ?>" href="<?php echo esc_url( $href ); ?>" aria-controls="<?php echo esc_attr( "$uid-panel-$key" ); ?>" aria-selected="<?php echo $first ? 'true' : 'false'; ?>" tabindex="<?php echo $first ? '0' : '-1'; ?>">
					<span class="ccs-tp__tab-label"><?php echo esc_html( $job['label'] ); ?></span>
					<span class="ccs-tp__tab-hint"><?php echo esc_html( $job['hint'] ); ?></span>
				</a>
				<?php
				$first = false;
			endforeach;
			?>
		</div>

		<?php
		$first = true;
		foreach ( $jobs as $key => $job ) :
			$product = crumb_co_task_picker_product( $job['category'] );
			$sheet   = crumb_co_task_picker_sheet( $key );
			$narrow  = isset( $sheet['narrow'] ) ? $sheet['narrow'] : array();
			?>
			<div class="ccs-tp__panel" role="tabpanel" id="<?php echo esc_attr( "$uid-panel-$key" ); ?>" aria-labelledby="<?php echo esc_attr( "$uid-tab-$key" ); ?>"<?php echo $first ? '' : ' hidden'; ?>>
				<figure class="ccs-sheet" lang="en" dir="ltr" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: file name */ __( 'Preview of %s with example data', 'crumb-co' ), $sheet['file'] ) ); ?>">
					<div class="ccs-sheet__bar">
						<span class="ccs-sheet__file"><?php echo esc_html( $sheet['file'] ); ?></span>
						<span class="ccs-sheet__sample"><?php esc_html_e( 'Example data', 'crumb-co' ); ?></span>
					</div>
					<div class="ccs-sheet__scroll">
						<table class="ccs-sheet__table">
							<thead><tr>
								<?php foreach ( $sheet['cols'] as $i => $col ) : ?>
									<th scope="col"<?php echo in_array( $i, $narrow, true ) ? '' : ' class="ccs-sheet__wide"'; ?>><?php echo esc_html( $col ); ?></th>
								<?php endforeach; ?>
							</tr></thead>
							<tbody>
								<?php foreach ( $sheet['rows'] as $r => $row ) : ?>
									<tr style="--r:<?php echo (int) $r; ?>">
										<?php foreach ( $row as $i => $cell ) : ?>
											<td<?php echo in_array( $i, $narrow, true ) ? '' : ' class="ccs-sheet__wide"'; ?>><?php echo wp_kses_post( $cell ); ?></td>
										<?php endforeach; ?>
									</tr>
								<?php endforeach; ?>
								<?php for ( $b = count( $sheet['rows'] ); $b < ( empty( $sheet['foot'] ) ? 7 : 5 ); $b++ ) : ?>
									<tr class="ccs-sheet__blank" aria-hidden="true"><?php echo str_repeat( '<td></td>', count( $sheet['cols'] ) ); // phpcs:ignore ?></tr>
								<?php endfor; ?>
							</tbody>
							<?php if ( ! empty( $sheet['foot'] ) ) : ?>
								<tfoot>
									<?php foreach ( $sheet['foot'] as $row ) : ?>
										<tr><th scope="row" colspan="<?php echo (int) ( count( $sheet['cols'] ) - 1 ); ?>"><?php echo wp_kses_post( $row[0] ); ?></th><td><?php echo wp_kses_post( $row[1] ); ?></td></tr>
									<?php endforeach; ?>
								</tfoot>
							<?php endif; ?>
						</table>
					</div>
					<div class="ccs-sheet__tabs" aria-hidden="true">
						<?php foreach ( $sheet['tabs'] as $i => $tab ) : ?>
							<span<?php echo $i === $sheet['active'] ? ' class="is-active"' : ''; ?>><?php echo esc_html( $tab ); ?></span>
						<?php endforeach; ?>
					</div>
				</figure>
				<?php if ( 0 !== strpos( determine_locale(), 'en' ) ) : ?>
					<p class="ccs-tp__lang"><?php esc_html_e( 'The template files are currently in English. Because every label is editable, you can translate headings and lists into your own language.', 'crumb-co' ); ?></p>
				<?php endif; ?>

				<div class="ccs-tp__buy">
					<?php if ( $product ) : ?>
						<h2 class="ccs-tp__name"><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h2>
						<p class="ccs-tp__note"><?php echo esc_html( $sheet['note'] ); ?></p>
						<?php if ( ! empty( $sheet['files'] ) ) : ?>
							<ul class="ccs-tp__files">
								<?php foreach ( $sheet['files'] as $file ) : ?>
									<li><?php echo esc_html( $file ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<dl class="ccs-tp__facts">
							<?php if ( $product->get_meta( '_ccs_format_label' ) ) : ?>
								<div><dt><?php esc_html_e( 'Format', 'crumb-co' ); ?></dt><dd><?php echo esc_html( $product->get_meta( '_ccs_format_label' ) ); ?></dd></div>
							<?php endif; ?>
							<?php if ( $product->get_meta( '_ccs_software' ) ) : ?>
								<div><dt><?php esc_html_e( 'Works with', 'crumb-co' ); ?></dt><dd><?php echo esc_html( $product->get_meta( '_ccs_software' ) ); ?></dd></div>
							<?php endif; ?>
						</dl>
						<div class="ccs-tp__action">
							<p class="ccs-tp__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
							<?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
								<a class="wp-element-button ccs-tp__cart add_to_cart_button ajax_add_to_cart" href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" data-quantity="1" rel="nofollow"><?php esc_html_e( 'Add to cart, instant download', 'crumb-co' ); ?></a>
							<?php endif; ?>
							<a class="ccs-tp__more" href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php esc_html_e( 'See everything inside', 'crumb-co' ); ?></a>
						</div>
					<?php else : ?>
						<p class="ccs-tp__note"><?php echo esc_html( $sheet['note'] ); ?></p>
						<a class="wp-element-button" href="<?php echo esc_url( crumb_co_page_url( 'shop' ) ); ?>"><?php esc_html_e( 'Explore the Toolkit', 'crumb-co' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
			<?php
			$first = false;
		endforeach;
		?>
	</div>
	<?php
	return ob_get_clean();
}
