<?php
/**
 * Title: Customer feedback (placeholders)
 * Slug: crumb-co/feedback-placeholder
 * Categories: crumb-co, testimonials
 * Keywords: testimonials, reviews, feedback
 * Viewport width: 1400
 * Description: Three clearly labelled placeholder cards. Replace with real feedback shared with permission, or remove.
 */
?>
<?php echo crumb_co_section_open( 'ccs-feedback has-surface-background-color has-background' ); // phpcs:ignore ?>
<!-- wp:group {"className":"ccs-section__intro","layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group ccs-section__intro"><!-- wp:paragraph {"align":"center","className":"ccs-eyebrow"} -->
<p class="has-text-align-center ccs-eyebrow"><?php esc_html_e( 'Customer feedback', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Words from bakers using the toolkit', 'crumb-co' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><?php esc_html_e( 'We are a new shop, so we have not collected feedback yet. These spaces are saved for real comments from customers, shared with their permission.', 'crumb-co' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"ccs-grid-3","layout":{"type":"grid","minimumColumnWidth":"16rem"}} -->
<div class="wp-block-group alignwide ccs-grid-3"><?php for ( $i = 1; $i <= 3; $i++ ) : ?><!-- wp:group {"className":"ccs-quote-card is-placeholder","layout":{"type":"default"}} -->
<div class="wp-block-group ccs-quote-card is-placeholder"><!-- wp:paragraph {"className":"ccs-badge"} -->
<p class="ccs-badge"><?php esc_html_e( 'Placeholder', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"ccs-quote-card__text"} -->
<p class="ccs-quote-card__text"><?php esc_html_e( '[Add a real customer comment here, in their own words, once they have agreed to share it.]', 'crumb-co' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"ccs-quote-card__who"} -->
<p class="ccs-quote-card__who"><?php esc_html_e( '[First name] · [Type of bakery] · [Product used]', 'crumb-co' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --><?php endfor; ?></div>
<!-- /wp:group -->
<?php echo crumb_co_section_close(); // phpcs:ignore ?>
