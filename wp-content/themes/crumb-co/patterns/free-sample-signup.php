<?php
/**
 * Title: Email signup + free sample
 * Slug: crumb-co/free-sample-signup
 * Categories: crumb-co, call-to-action
 * Keywords: newsletter, signup, free, sample, lead magnet
 * Viewport width: 1400
 * Description: Free one-page order tracker offered in exchange for an email signup (requires the Crumb & Co. Toolkit plugin for the form).
 */
?>
<?php echo crumb_co_section_open( 'ccs-signup', 'section', 'free-sample' ); // phpcs:ignore ?>
<!-- wp:group {"align":"wide","className":"ccs-signup__card","backgroundColor":"sage-light","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide ccs-signup__card has-sage-light-background-color has-background"><!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"ccs-signup__img"} -->
<figure class="wp-block-image size-full ccs-signup__img"><img src="<?php echo esc_url( crumb_co_image( 'free-sample.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Preview of the free one-page printable order tracker', 'crumb-co' ); ?>"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%"><!-- wp:paragraph {"className":"ccs-eyebrow"} -->
<p class="ccs-eyebrow"><?php esc_html_e( 'Free printable', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Try the one-page order tracker', 'crumb-co' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'A simple printable sheet for a week of orders: customer, item, pickup time, price, deposit and status. Join our email list and the download link appears right away.', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[crumb_signup]
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
<?php echo crumb_co_section_close(); // phpcs:ignore ?>
