<?php
/**
 * Title: About page
 * Slug: crumb-co/page-about
 * Categories: crumb-co-pages
 * Post Types: page
 * Block Types: core/post-content
 * Description: About the studio, with placeholders for your own story.
 */
echo crumb_co_p( __( 'Crumb & Co. Studio makes practical digital tools for people who bake from home and sell what they make — cakes, cookies, breads and everything in between.', 'crumb-co' ), 'ccs-lead' );
echo crumb_co_h( __( 'Why we started', 'crumb-co' ) );
echo crumb_co_note( __( '[Placeholder — tell your own story here: who you are, how you came to baking, and why you decided to make these tools. Keep it true and personal.]', 'crumb-co' ) );
echo crumb_co_h( __( 'What we make', 'crumb-co' ) );
echo crumb_co_p( __( 'We keep the range small on purpose. Each product does one job well: tracking orders, adding up costs, getting ready to launch, or planning what to post. No giant bundles you will never open.', 'crumb-co' ) );
echo crumb_co_h( __( 'What we believe', 'crumb-co' ) );
echo crumb_co_list( array(
	__( '<strong>Practical over pretty.</strong> Every template is built around a real task, then made to look good.', 'crumb-co' ),
	__( '<strong>Yours to edit.</strong> Files open in common software, and you can change anything to fit your bakery.', 'crumb-co' ),
	__( '<strong>Honest promises.</strong> Our tools help you get organised. They do not guarantee sales, prices or profit — your skill and your customers do the rest.', 'crumb-co' ),
	__( '<strong>Small and focused.</strong> We add new tools slowly, based on what home bakers actually ask for.', 'crumb-co' ),
) );
echo crumb_co_h( __( 'Say hello', 'crumb-co' ) );
echo crumb_co_p( sprintf( /* translators: %s: contact page URL */ __( 'Have an idea for a tool, or a question about a product? <a href="%s">Get in touch</a> — we read every message.', 'crumb-co' ), esc_url( crumb_co_page_url( 'contact' ) ) ) );
