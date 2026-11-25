<?php
/**
 * Title: Hero: what is taking your time?
 * Slug: crumb-co/hero
 * Categories: crumb-co, banner
 * Keywords: hero, header, intro, task picker
 * Viewport width: 1400
 * Description: Asks which job takes most of the visitor's week and answers with the template that handles it: a preview with example data, its format, price and add-to-cart button.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"ccs-hero","backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull ccs-hero has-base-color has-contrast-background-color has-text-color has-background"><!-- wp:group {"align":"wide","className":"ccs-hero__head","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide ccs-hero__head"><!-- wp:heading {"level":1,"className":"ccs-hero__title"} -->
<h1 class="wp-block-heading ccs-hero__title"><?php esc_html_e( 'What is taking most of your time this week?', 'crumb-co' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"ccs-hero__lead"} -->
<p class="ccs-hero__lead"><?php esc_html_e( 'Pick the job. You will see the template that handles it, with example data, before you buy. Every tool is an editable file you download straight away.', 'crumb-co' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"ccs-hero__picker","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide ccs-hero__picker"><!-- wp:shortcode -->
[crumb_task_picker]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
