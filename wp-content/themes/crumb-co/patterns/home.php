<?php
/**
 * Title: Homepage (full)
 * Slug: crumb-co/home
 * Categories: crumb-co-pages
 * Keywords: home, landing, front page
 * Post Types: page
 * Block Types: core/post-content
 * Viewport width: 1400
 * Description: Complete homepage: hero, featured products, bakery tasks, how it works, feedback placeholders and free sample signup.
 */
foreach ( array( 'hero', 'featured-products', 'bakery-tasks', 'how-it-works', 'feedback-placeholder', 'free-sample-signup' ) as $crumb_co_part ) {
	include __DIR__ . '/' . $crumb_co_part . '.php';
	echo "\n\n";
}
