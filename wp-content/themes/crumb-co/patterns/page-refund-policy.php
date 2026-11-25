<?php
/**
 * Title: Digital Download & Refund Policy page
 * Slug: crumb-co/page-refund-policy
 * Categories: crumb-co-pages
 * Post Types: page
 * Block Types: core/post-content
 * Description: Editable policy template for digital products with placeholders.
 */
echo crumb_co_note( __( 'Template notice: this policy is a starting point, not legal advice. Fill in every [placeholder] and check it against the consumer laws that apply to you and your customers before publishing.', 'crumb-co' ) );
echo crumb_co_p( __( 'Last updated: [date]', 'crumb-co' ) );
echo crumb_co_h( __( 'What you are buying', 'crumb-co' ) );
echo crumb_co_p( __( 'All products sold by [Business name] are digital files (such as spreadsheets, documents and PDFs). No physical products are printed or shipped.', 'crumb-co' ) );
echo crumb_co_h( __( 'Delivery', 'crumb-co' ) );
echo crumb_co_p( __( 'After your payment is confirmed, download links are shown on the order confirmation page, sent to the email address you provide, and kept in My Account → Downloads if you created an account.', 'crumb-co' ) );
echo crumb_co_p( __( 'Download limits: [Placeholder — e.g. unlimited downloads / X downloads, available for X days].', 'crumb-co' ) );
echo crumb_co_h( __( 'Before you buy', 'crumb-co' ) );
echo crumb_co_p( __( 'Each product page lists the included files and compatible software. Please check these details, or ask us, before purchasing.', 'crumb-co' ) );
echo crumb_co_h( __( 'Problems with a file', 'crumb-co' ) );
echo crumb_co_p( __( 'If a file is faulty, will not open in the listed software, or does not match its description, contact us within [X days] of purchase with your order number. We will first try to fix the problem or send a replacement file.', 'crumb-co' ) );
echo crumb_co_h( __( 'Refunds', 'crumb-co' ) );
echo crumb_co_p( __( '[Placeholder — describe your refund policy for digital products, for example when a refund is offered, when it is not, and how long it takes. Make sure it respects any statutory rights your customers have.]', 'crumb-co' ) );
echo crumb_co_h( __( 'Duplicate purchases', 'crumb-co' ) );
echo crumb_co_p( __( 'If you accidentally buy the same product twice, contact us within [X days] and we will [Placeholder — e.g. refund the duplicate order].', 'crumb-co' ) );
echo crumb_co_h( __( 'How to contact us', 'crumb-co' ) );
echo crumb_co_p( sprintf( /* translators: %s: contact page URL */ __( 'Use our <a href="%s">contact page</a> or email [support email]. Please include your order number.', 'crumb-co' ), esc_url( crumb_co_page_url( 'contact' ) ) ) );
