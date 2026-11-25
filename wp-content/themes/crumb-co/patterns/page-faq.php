<?php
/**
 * Title: FAQ page
 * Slug: crumb-co/page-faq
 * Categories: crumb-co-pages
 * Post Types: page
 * Block Types: core/post-content
 * Description: Frequently asked questions about digital downloads, editing, licensing and support.
 */
echo crumb_co_p( __( 'Quick answers about buying, downloading and editing our templates. Cannot find what you need? Contact us any time.', 'crumb-co' ), 'ccs-lead' );
echo crumb_co_h( __( 'Buying & downloading', 'crumb-co' ) );
echo crumb_co_details( __( 'Is anything shipped to me?', 'crumb-co' ), __( 'No. Every product is a digital download. Nothing physical is printed or posted, so there are no shipping costs or delivery times.', 'crumb-co' ) );
echo crumb_co_details( __( 'How do I get my files after paying?', 'crumb-co' ), sprintf( /* translators: %s: my account URL */ __( 'As soon as your payment is confirmed, download links appear on the order confirmation page. We also email them to you, and they stay available in <a href="%s">My Account → Downloads</a>.', 'crumb-co' ), esc_url( crumb_co_page_url( 'my-account' ) ) ) );
echo crumb_co_details( __( 'Do I need an account?', 'crumb-co' ), __( 'Creating an account at checkout is the easiest way to find your downloads again later. Your order email also contains your download links.', 'crumb-co' ) );
echo crumb_co_details( __( 'How many times can I download a file?', 'crumb-co' ), __( '[Placeholder — state your download limit and link expiry, for example "unlimited downloads for 12 months". Match this to the settings on each product.]', 'crumb-co' ) );
echo crumb_co_details( __( 'Which payment methods do you accept?', 'crumb-co' ), __( '[Placeholder — list the payment methods you enable in WooCommerce → Settings → Payments.]', 'crumb-co' ) );
echo crumb_co_h( __( 'Opening & editing', 'crumb-co' ) );
echo crumb_co_details( __( 'What software do I need?', 'crumb-co' ), __( 'Spreadsheets (.xlsx) open in Microsoft Excel, Google Sheets (free) and LibreOffice Calc (free). Documents (.docx) open in Microsoft Word, Google Docs and LibreOffice Writer. Printables (.pdf) open in any PDF reader. Each product page lists its exact files.', 'crumb-co' ) );
echo crumb_co_details( __( 'Can I use the files on my phone?', 'crumb-co' ), __( 'You can view and make small edits with the Google Sheets, Google Docs or Microsoft apps on a phone. For setting things up the first time, a computer or tablet is more comfortable.', 'crumb-co' ) );
echo crumb_co_details( __( 'Can I change the colours, wording and categories?', 'crumb-co' ), __( 'Yes. Everything is editable. Example rows are marked so you can delete them once you are ready.', 'crumb-co' ) );
echo crumb_co_details( __( 'What language are the files in?', 'crumb-co' ), __( 'The template files are currently in English. Because every label is editable, you can translate headings and lists into your own language.', 'crumb-co' ) );
echo crumb_co_details( __( 'Will the pricing calculator tell me what to charge?', 'crumb-co' ), __( 'No. It helps you add up your own costs and test the effect of a markup you choose. Your prices are your decision, based on your market and your goals.', 'crumb-co' ) );
echo crumb_co_h( __( 'Licence, refunds & help', 'crumb-co' ) );
echo crumb_co_details( __( 'Can I share or resell the templates?', 'crumb-co' ), sprintf( /* translators: %s: terms page URL */ __( 'You may use them for your own bakery business. Please do not share, resell or redistribute the files. See our <a href="%s">Terms</a> for details.', 'crumb-co' ), esc_url( crumb_co_page_url( 'terms' ) ) ) );
echo crumb_co_details( __( 'What if a file does not open or something is missing?', 'crumb-co' ), sprintf( /* translators: %s: contact page URL */ __( '<a href="%s">Contact us</a> with your order number and a short description of the problem. We will help you get it working or send a corrected file.', 'crumb-co' ), esc_url( crumb_co_page_url( 'contact' ) ) ) );
echo crumb_co_details( __( 'Can I get a refund?', 'crumb-co' ), sprintf( /* translators: %s: refund policy URL */ __( 'Please read our <a href="%s">Digital Download & Refund Policy</a> before you buy. It explains when refunds are possible for digital products.', 'crumb-co' ), esc_url( crumb_co_page_url( 'refund-policy' ) ) ) );
