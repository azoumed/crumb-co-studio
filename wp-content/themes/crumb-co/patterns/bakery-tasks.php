<?php
/**
 * Title: Made for real bakery tasks
 * Slug: crumb-co/bakery-tasks
 * Categories: crumb-co, featured
 * Keywords: features, problems, tasks
 * Viewport width: 1400
 * Description: Four cards explaining the everyday jobs the tools help organise, each linking to a product category.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"ccs-section ccs-tasks","backgroundColor":"white","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull ccs-section ccs-tasks has-white-background-color has-background"><!-- wp:group {"className":"ccs-section__intro","layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group ccs-section__intro"><!-- wp:paragraph {"align":"center","className":"ccs-eyebrow"} -->
<p class="has-text-align-center ccs-eyebrow"><?php esc_html_e( 'Why these tools exist', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Made for real bakery tasks', 'crumb-co' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"ccs-lead"} -->
<p class="has-text-align-center ccs-lead"><?php esc_html_e( 'Running a bakery from home means juggling orders, costs and customers between batches. Each tool tackles one of those jobs.', 'crumb-co' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"ccs-grid-4","layout":{"type":"grid","minimumColumnWidth":"15rem"}} -->
<div class="wp-block-group alignwide ccs-grid-4">
<!-- wp:group {"className":"ccs-card","layout":{"type":"default"}} -->
<div class="wp-block-group ccs-card"><!-- wp:image {"width":"56px","sizeSlug":"full","linkDestination":"none","className":"ccs-card__icon"} -->
<figure class="wp-block-image size-full is-resized ccs-card__icon"><img src="<?php echo esc_url( crumb_co_image( 'icon-orders.svg' ) ); ?>" alt="" style="width:56px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Keeping orders straight', 'crumb-co' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Track who ordered what, when it\'s due, what\'s been paid and what\'s still to bake — in one sheet instead of scattered messages.', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"ccs-link-arrow"} -->
<p class="ccs-link-arrow"><a href="<?php echo esc_url( crumb_co_page_url( 'cat:order-management' ) ); ?>"><?php esc_html_e( 'Order tools', 'crumb-co' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"ccs-card","layout":{"type":"default"}} -->
<div class="wp-block-group ccs-card"><!-- wp:image {"width":"56px","sizeSlug":"full","linkDestination":"none","className":"ccs-card__icon"} -->
<figure class="wp-block-image size-full is-resized ccs-card__icon"><img src="<?php echo esc_url( crumb_co_image( 'icon-pricing.svg' ) ); ?>" alt="" style="width:56px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Knowing what a bake costs', 'crumb-co' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Add up ingredients, packaging and your time so you can see your real costs before you set a price.', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"ccs-link-arrow"} -->
<p class="ccs-link-arrow"><a href="<?php echo esc_url( crumb_co_page_url( 'cat:pricing-costing' ) ); ?>"><?php esc_html_e( 'Pricing tools', 'crumb-co' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"ccs-card","layout":{"type":"default"}} -->
<div class="wp-block-group ccs-card"><!-- wp:image {"width":"56px","sizeSlug":"full","linkDestination":"none","className":"ccs-card__icon"} -->
<figure class="wp-block-image size-full is-resized ccs-card__icon"><img src="<?php echo esc_url( crumb_co_image( 'icon-launch.svg' ) ); ?>" alt="" style="width:56px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Getting ready to take orders', 'crumb-co' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'An order form, customer questionnaire, menu and launch checklist so you don\'t start from a blank page.', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"ccs-link-arrow"} -->
<p class="ccs-link-arrow"><a href="<?php echo esc_url( crumb_co_page_url( 'cat:launch-setup' ) ); ?>"><?php esc_html_e( 'Launch tools', 'crumb-co' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"ccs-card","layout":{"type":"default"}} -->
<div class="wp-block-group ccs-card"><!-- wp:image {"width":"56px","sizeSlug":"full","linkDestination":"none","className":"ccs-card__icon"} -->
<figure class="wp-block-image size-full is-resized ccs-card__icon"><img src="<?php echo esc_url( crumb_co_image( 'icon-planner.svg' ) ); ?>" alt="" style="width:56px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Knowing what to post', 'crumb-co' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Plan a month of posts around your products and the seasons, with prompts for the days ideas run dry.', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"ccs-link-arrow"} -->
<p class="ccs-link-arrow"><a href="<?php echo esc_url( crumb_co_page_url( 'cat:marketing' ) ); ?>"><?php esc_html_e( 'Marketing tools', 'crumb-co' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

</div>
<!-- /wp:group --></section>
<!-- /wp:group -->
