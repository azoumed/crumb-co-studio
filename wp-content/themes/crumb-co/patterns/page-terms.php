<?php
/**
 * Title: Terms & Conditions page
 * Slug: crumb-co/page-terms
 * Categories: crumb-co-pages
 * Post Types: page
 * Block Types: core/post-content
 * Description: Editable terms of sale for digital products with placeholders.
 */
echo crumb_co_note( __( 'Template notice: these terms are a starting point, not legal advice. Complete every [placeholder] and have them reviewed for your country before publishing.', 'crumb-co' ) );
echo crumb_co_p( __( 'Last updated: [date]', 'crumb-co' ) );
echo crumb_co_h( __( 'About these terms', 'crumb-co' ) );
echo crumb_co_p( __( 'These terms apply to purchases from [Business name] through this website. By placing an order you agree to them.', 'crumb-co' ) );
echo crumb_co_h( __( 'Digital products', 'crumb-co' ) );
echo crumb_co_p( __( 'All products are digital downloads. No physical items are shipped. Delivery and refunds are described in our Digital Download & Refund Policy.', 'crumb-co' ) );
echo crumb_co_h( __( 'Your licence', 'crumb-co' ) );
echo crumb_co_list( array(
	__( 'You may use and edit the files for your own bakery business.', 'crumb-co' ),
	__( 'You may print copies for your own use and give completed forms to your customers.', 'crumb-co' ),
	__( 'You may not resell, share, give away or upload the template files, or claim them as your own design.', 'crumb-co' ),
	__( '[Placeholder — add any other licence terms, e.g. use by staff or multiple locations.]', 'crumb-co' ),
) );
echo crumb_co_h( __( 'Prices and payment', 'crumb-co' ) );
echo crumb_co_p( __( 'Prices are shown at checkout in [currency] and include or exclude taxes as shown. Payment is processed securely by [payment provider].', 'crumb-co' ) );
echo crumb_co_h( __( 'What our tools do — and do not do', 'crumb-co' ) );
echo crumb_co_p( __( 'Our templates are organisation aids. They do not provide financial, legal, tax or food-safety advice, and we cannot promise any particular sales, prices or profit. You are responsible for checking the figures you enter and for following the rules that apply to your business.', 'crumb-co' ) );
echo crumb_co_h( __( 'Liability', 'crumb-co' ) );
echo crumb_co_p( __( '[Placeholder — limitation of liability wording appropriate for your country.]', 'crumb-co' ) );
echo crumb_co_h( __( 'Governing law', 'crumb-co' ) );
echo crumb_co_p( __( '[Placeholder — the country or state whose laws apply.]', 'crumb-co' ) );
echo crumb_co_h( __( 'Changes and contact', 'crumb-co' ) );
echo crumb_co_p( __( 'We may update these terms. The version shown when you placed your order applies to that order. Questions? Contact [support email].', 'crumb-co' ) );
