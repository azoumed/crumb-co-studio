<?php
/**
 * Title: Privacy Policy page
 * Slug: crumb-co/page-privacy-policy
 * Categories: crumb-co-pages
 * Post Types: page
 * Block Types: core/post-content
 * Description: Editable privacy policy template with placeholders.
 */
echo crumb_co_note( __( 'Template notice: this privacy policy is a starting point, not legal advice. Complete every [placeholder], list the services you actually use, and have it reviewed for the privacy laws that apply to you. WordPress also offers a privacy policy guide under Settings → Privacy.', 'crumb-co' ) );
echo crumb_co_p( __( 'Last updated: [date]', 'crumb-co' ) );
echo crumb_co_h( __( 'Who we are', 'crumb-co' ) );
echo crumb_co_p( __( 'This website is run by [Business name], [business address or country]. Contact: [support email].', 'crumb-co' ) );
echo crumb_co_h( __( 'What we collect', 'crumb-co' ) );
echo crumb_co_list( array(
	__( '<strong>Orders:</strong> your name, email address, billing details needed by the payment provider, and what you bought.', 'crumb-co' ),
	__( '<strong>Account:</strong> if you create an account, your login details and order history.', 'crumb-co' ),
	__( '<strong>Email list:</strong> if you sign up for the free sample or newsletter, your email address and the date you joined.', 'crumb-co' ),
	__( '<strong>Contact form:</strong> the name, email address and message you send us.', 'crumb-co' ),
	__( '<strong>Technical data:</strong> cookies needed for the cart, checkout and login to work. [Add any analytics tools you use.]', 'crumb-co' ),
) );
echo crumb_co_h( __( 'How we use it', 'crumb-co' ) );
echo crumb_co_p( __( 'To process your order and deliver your downloads, provide support, send emails you asked for, and keep the website secure. [Add any other purposes.]', 'crumb-co' ) );
echo crumb_co_h( __( 'Payments', 'crumb-co' ) );
echo crumb_co_p( __( 'Payments are handled by [payment provider]. We do not store your full card details on this website. See [payment provider]’s privacy policy for how they handle your data.', 'crumb-co' ) );
echo crumb_co_h( __( 'Who we share it with', 'crumb-co' ) );
echo crumb_co_p( __( '[Placeholder — list service providers such as your hosting company, payment provider and email marketing service.] We do not sell your personal data.', 'crumb-co' ) );
echo crumb_co_h( __( 'How long we keep it', 'crumb-co' ) );
echo crumb_co_p( __( '[Placeholder — e.g. order records for the period required for tax purposes; email list data until you unsubscribe.]', 'crumb-co' ) );
echo crumb_co_h( __( 'Your choices and rights', 'crumb-co' ) );
echo crumb_co_p( __( 'You can unsubscribe from emails at any time and ask us to access, correct or delete your personal data, subject to legal record-keeping requirements. Contact [support email].', 'crumb-co' ) );
