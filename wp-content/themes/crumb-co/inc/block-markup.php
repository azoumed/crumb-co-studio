<?php
/**
 * Tiny helpers that print valid, editable core block markup from PHP patterns.
 * Using them keeps every visible string translatable with __().
 *
 * @package CrumbCo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Paragraph block. $html may contain inline markup (<strong>, <a>) and is passed through wp_kses_post().
 *
 * @param string $html  Paragraph HTML.
 * @param string $class Optional class.
 * @return string
 */
function crumb_co_p( $html, $class = '' ) {
	$attrs = $class ? ' ' . wp_json_encode( array( 'className' => $class ) ) : '';
	$cls   = $class ? ' class="' . esc_attr( $class ) . '"' : '';
	return "<!-- wp:paragraph{$attrs} -->\n<p{$cls}>" . wp_kses_post( $html ) . "</p>\n<!-- /wp:paragraph -->\n\n";
}

/**
 * Heading block.
 *
 * @param string $text  Heading text.
 * @param int    $level Heading level.
 * @return string
 */
function crumb_co_h( $text, $level = 2 ) {
	$level = (int) $level;
	$attrs = 2 === $level ? '' : ' {"level":' . $level . '}';
	return "<!-- wp:heading{$attrs} -->\n<h{$level} class=\"wp-block-heading\">" . esc_html( $text ) . "</h{$level}>\n<!-- /wp:heading -->\n\n";
}

/**
 * List block.
 *
 * @param string[] $items   Items (inline HTML allowed).
 * @param bool     $ordered Ordered list.
 * @return string
 */
function crumb_co_list( $items, $ordered = false ) {
	$tag   = $ordered ? 'ol' : 'ul';
	$attrs = $ordered ? ' {"ordered":true}' : '';
	$out   = "<!-- wp:list{$attrs} -->\n<{$tag} class=\"wp-block-list\">";
	$parts = array();
	foreach ( $items as $item ) {
		$parts[] = "<!-- wp:list-item -->\n<li>" . wp_kses_post( $item ) . "</li>\n<!-- /wp:list-item -->";
	}
	return $out . implode( "\n\n", $parts ) . "</{$tag}>\n<!-- /wp:list -->\n\n";
}

/**
 * Details (accordion) block for FAQs.
 *
 * @param string $question Summary text.
 * @param string $answer   Answer HTML.
 * @return string
 */
function crumb_co_details( $question, $answer ) {
	return "<!-- wp:details {\"className\":\"ccs-faq\"} -->\n<details class=\"wp-block-details ccs-faq\"><summary>" . esc_html( $question ) . "</summary>"
		. crumb_co_p( $answer ) . "</details>\n<!-- /wp:details -->\n\n";
}

/**
 * Opening/closing markup for a constrained section group.
 *
 * @param string $class Extra class names.
 * @param string $tag   Tag name.
 * @param string $anchor Optional id.
 * @return string
 */
function crumb_co_section_open( $class = '', $tag = 'section', $anchor = '' ) {
	$attrs = array( 'tagName' => $tag );
	if ( $anchor ) {
		$attrs['anchor'] = $anchor;
	}
	$attrs['align']     = 'full';
	$attrs['className'] = trim( 'ccs-section ' . $class );
	$attrs['layout']    = array( 'type' => 'constrained' );
	$id                 = $anchor ? ' id="' . esc_attr( $anchor ) . '"' : '';
	return '<!-- wp:group ' . wp_json_encode( $attrs ) . " -->\n<{$tag}{$id} class=\"wp-block-group alignfull " . esc_attr( $attrs['className'] ) . '">';
}

/**
 * Close a section opened with crumb_co_section_open().
 *
 * @param string $tag Tag name.
 * @return string
 */
function crumb_co_section_close( $tag = 'section' ) {
	return "</{$tag}>\n<!-- /wp:group -->\n\n";
}

/**
 * Highlighted placeholder note (editors should replace it).
 *
 * @param string $text Note text.
 * @return string
 */
function crumb_co_note( $text ) {
	return "<!-- wp:group {\"className\":\"ccs-placeholder-note\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group ccs-placeholder-note\">"
		. crumb_co_p( $text ) . "</div>\n<!-- /wp:group -->\n\n";
}
