<?php
/**
 * Title: Hero — Spend less time organizing
 * Slug: crumb-co/hero
 * Categories: crumb-co, banner
 * Keywords: hero, header, intro
 * Viewport width: 1400
 * Description: Headline, supporting text, "Explore the Toolkit" button and bakery illustration.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"ccs-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull ccs-hero"><!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"ccs-hero__cols"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center ccs-hero__cols"><!-- wp:column {"verticalAlignment":"center","width":"54%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:54%"><!-- wp:paragraph {"className":"ccs-eyebrow"} -->
<p class="ccs-eyebrow"><?php esc_html_e( 'Templates & tools for home bakers', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"ccs-hero__title"} -->
<h1 class="wp-block-heading ccs-hero__title"><?php esc_html_e( 'Spend less time organizing. More time baking.', 'crumb-co' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"ccs-lead"} -->
<p class="ccs-lead"><?php esc_html_e( 'Crumb & Co. Studio makes practical, editable templates for home-based bakers: order trackers, cost calculators, launch documents and content planners. Download them, make them yours, and get back to the oven.', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"ccs-hero__actions"} -->
<div class="wp-block-buttons ccs-hero__actions"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( crumb_co_page_url( 'shop' ) ); ?>"><?php esc_html_e( 'Explore the Toolkit', 'crumb-co' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#free-sample"><?php esc_html_e( 'Get the free order tracker', 'crumb-co' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:list {"className":"ccs-checks"} -->
<ul class="wp-block-list ccs-checks"><!-- wp:list-item -->
<li><?php esc_html_e( 'Instant digital download', 'crumb-co' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Edit in Excel, Google Sheets, Word or Google Docs', 'crumb-co' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Nothing is shipped', 'crumb-co' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"46%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:46%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"ccs-hero__art"} -->
<figure class="wp-block-image size-full ccs-hero__art"><img src="<?php echo esc_url( crumb_co_image( 'hero-illustration.svg' ) ); ?>" alt="<?php esc_attr_e( 'Illustration of a layered cake next to a tablet showing an order list', 'crumb-co' ); ?>"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
