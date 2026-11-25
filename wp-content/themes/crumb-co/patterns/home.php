<?php
/**
 * Title: Homepage (full)
 * Slug: crumb-co/home
 * Categories: crumb-co-pages
 * Keywords: home, landing, front page
 * Post Types: page
 * Block Types: core/post-content
 * Viewport width: 1400
 * Description: Complete homepage: task picker hero, the full toolkit, how it works, free sample signup and feedback placeholders.
 */
foreach ( array( 'hero', 'featured-products', 'how-it-works', 'free-sample-signup', 'feedback-placeholder' ) as $crumb_co_part ) {
	include __DIR__ . '/' . $crumb_co_part . '.php';
	echo "\n\n";
}
