<?php
/**
 * Editable product details (who it is for, task, files, software, how-to steps, FAQ)
 * shown as facts in the product summary and as product tabs.
 *
 * @package CrumbCoToolkit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Field definitions.
 *
 * @return array
 */
function ccs_product_fields() {
	return array(
		'_ccs_for_who'      => array( 'label' => __( 'Who it is for', 'crumb-co-toolkit' ), 'type' => 'textarea', 'help' => __( 'One or two sentences.', 'crumb-co-toolkit' ) ),
		'_ccs_task'         => array( 'label' => __( 'Task it helps with', 'crumb-co-toolkit' ), 'type' => 'text', 'help' => __( 'Short phrase, e.g. "Recording customer orders".', 'crumb-co-toolkit' ) ),
		'_ccs_format_label' => array( 'label' => __( 'Format label', 'crumb-co-toolkit' ), 'type' => 'text', 'help' => __( 'Shown on product cards, e.g. "Spreadsheet · XLSX".', 'crumb-co-toolkit' ) ),
		'_ccs_software'     => array( 'label' => __( 'Compatible software', 'crumb-co-toolkit' ), 'type' => 'text', 'help' => __( 'e.g. "Microsoft Excel, Google Sheets, LibreOffice Calc".', 'crumb-co-toolkit' ) ),
		'_ccs_files'        => array( 'label' => __( 'Files included', 'crumb-co-toolkit' ), 'type' => 'textarea', 'help' => __( 'One file per line.', 'crumb-co-toolkit' ) ),
		'_ccs_howto'        => array( 'label' => __( 'Download & editing steps', 'crumb-co-toolkit' ), 'type' => 'textarea', 'help' => __( 'One step per line.', 'crumb-co-toolkit' ) ),
		'_ccs_faq'          => array( 'label' => __( 'Product FAQ', 'crumb-co-toolkit' ), 'type' => 'textarea', 'help' => __( 'Question on the first line, answer on the next line(s). Leave an empty line between questions.', 'crumb-co-toolkit' ) ),
	);
}

add_action( 'add_meta_boxes_product', function () {
	add_meta_box( 'ccs-product-details', __( 'Crumb & Co. product details', 'crumb-co-toolkit' ), 'ccs_render_product_box', 'product', 'normal', 'high' );
} );

/**
 * Meta box.
 *
 * @param WP_Post $post Post.
 */
function ccs_render_product_box( $post ) {
	wp_nonce_field( 'ccs_product_details', 'ccs_product_nonce' );
	echo '<p>' . esc_html__( 'These details appear in the product summary and in the "What’s included", "Download & editing" and "FAQ" tabs. The main description and short description are edited in the usual places.', 'crumb-co-toolkit' ) . '</p>';
	echo '<table class="form-table" role="presentation">';
	foreach ( ccs_product_fields() as $key => $field ) {
		$val = get_post_meta( $post->ID, $key, true );
		echo '<tr><th scope="row"><label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label></th><td>';
		if ( 'textarea' === $field['type'] ) {
			$rows = '_ccs_faq' === $key ? 10 : 4;
			echo '<textarea class="large-text" rows="' . (int) $rows . '" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '">' . esc_textarea( $val ) . '</textarea>';
		} else {
			echo '<input type="text" class="large-text" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
		}
		echo '<p class="description">' . esc_html( $field['help'] ) . '</p></td></tr>';
	}
	echo '</table>';
}

add_action( 'save_post_product', function ( $post_id ) {
	if ( ! isset( $_POST['ccs_product_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ccs_product_nonce'] ) ), 'ccs_product_details' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( ccs_product_fields() as $key => $field ) {
		if ( isset( $_POST[ $key ] ) ) {
			$raw = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			update_post_meta( $post_id, $key, 'textarea' === $field['type'] ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw ) );
		}
	}
} );

/**
 * Split a textarea into non-empty lines.
 *
 * @param string $text Text.
 * @return string[]
 */
function ccs_lines( $text ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $text ) ) ) );
}

/**
 * Parse the FAQ textarea into question/answer pairs.
 *
 * @param string $text Text.
 * @return array<int,array{q:string,a:string}>
 */
function ccs_parse_faq( $text ) {
	$out    = array();
	$blocks = preg_split( '/(\r\n|\r|\n)\s*(\r\n|\r|\n)/', trim( (string) $text ) );
	foreach ( $blocks as $block ) {
		$lines = ccs_lines( $block );
		if ( count( $lines ) >= 2 ) {
			$out[] = array( 'q' => array_shift( $lines ), 'a' => implode( ' ', $lines ) );
		}
	}
	return $out;
}

/**
 * Product tabs.
 */
add_filter( 'woocommerce_product_tabs', function ( $tabs ) {
	global $product;
	if ( ! $product ) {
		return $tabs;
	}
	if ( isset( $tabs['description'] ) ) {
		$tabs['description']['title'] = __( 'Overview', 'crumb-co-toolkit' );
	}
	unset( $tabs['additional_information'] );
	if ( $product->get_meta( '_ccs_files' ) || $product->get_meta( '_ccs_software' ) ) {
		$tabs['ccs_included'] = array( 'title' => __( 'What’s included', 'crumb-co-toolkit' ), 'priority' => 15, 'callback' => 'ccs_tab_included' );
	}
	$tabs['ccs_howto'] = array( 'title' => __( 'Download & editing', 'crumb-co-toolkit' ), 'priority' => 20, 'callback' => 'ccs_tab_howto' );
	if ( ccs_parse_faq( $product->get_meta( '_ccs_faq' ) ) ) {
		$tabs['ccs_faq'] = array( 'title' => __( 'FAQ', 'crumb-co-toolkit' ), 'priority' => 25, 'callback' => 'ccs_tab_faq' );
	}
	return $tabs;
}, 20 );

/**
 * "What's included" tab.
 */
function ccs_tab_included() {
	global $product;
	echo '<h2>' . esc_html__( 'What’s included', 'crumb-co-toolkit' ) . '</h2>';
	$files = ccs_lines( $product->get_meta( '_ccs_files' ) );
	if ( $files ) {
		echo '<ul class="ccs-files">';
		foreach ( $files as $file ) {
			echo '<li>' . esc_html( $file ) . '</li>';
		}
		echo '</ul>';
	}
	if ( $product->get_meta( '_ccs_software' ) ) {
		echo '<p><strong>' . esc_html__( 'Compatible software:', 'crumb-co-toolkit' ) . '</strong> ' . esc_html( $product->get_meta( '_ccs_software' ) ) . '</p>';
	}
	echo '<p class="ccs-small">' . esc_html__( 'Template files are written in English and every label can be edited, so you can translate them into your own language.', 'crumb-co-toolkit' ) . '</p>';
}

/**
 * "Download & editing" tab.
 */
function ccs_tab_howto() {
	global $product;
	echo '<h2>' . esc_html__( 'How to download', 'crumb-co-toolkit' ) . '</h2>';
	echo '<ol class="ccs-steps-list">';
	echo '<li>' . esc_html__( 'Add the product to your cart and check out securely.', 'crumb-co-toolkit' ) . '</li>';
	echo '<li>' . esc_html__( 'As soon as payment is confirmed, your download link appears on the order confirmation page.', 'crumb-co-toolkit' ) . '</li>';
	echo '<li>' . esc_html__( 'The same link is emailed to you and kept in My Account → Downloads.', 'crumb-co-toolkit' ) . '</li>';
	echo '</ol>';
	$steps = ccs_lines( $product->get_meta( '_ccs_howto' ) );
	if ( $steps ) {
		echo '<h2>' . esc_html__( 'How to edit', 'crumb-co-toolkit' ) . '</h2><ol class="ccs-steps-list">';
		foreach ( $steps as $step ) {
			echo '<li>' . esc_html( $step ) . '</li>';
		}
		echo '</ol>';
	}
	echo ccs_digital_notice( 'product' ); // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * FAQ tab.
 */
function ccs_tab_faq() {
	global $product;
	echo '<h2>' . esc_html__( 'Questions about this product', 'crumb-co-toolkit' ) . '</h2>';
	foreach ( ccs_parse_faq( $product->get_meta( '_ccs_faq' ) ) as $item ) {
		echo '<details class="wp-block-details ccs-faq"><summary>' . esc_html( $item['q'] ) . '</summary><p>' . esc_html( $item['a'] ) . '</p></details>';
	}
}
