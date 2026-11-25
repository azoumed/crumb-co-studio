<?php
/**
 * Starter catalogue. Every string is translatable; the setup tool loads this file once per language.
 * After setup, edit everything in Products → (product) like any WooCommerce product.
 *
 * Prices are PLACEHOLDERS — set your own before launch.
 *
 * @package CrumbCoToolkit
 */

defined( 'ABSPATH' ) || exit;

return array(
	'categories' => array(
		'order-management' => array(
			'name'        => __( 'Order Management', 'crumb-co-toolkit' ),
			'description' => __( 'Keep customer orders, pickup dates and payments in one organised place.', 'crumb-co-toolkit' ),
			'image'       => 'order-tracker.jpg',
		),
		'pricing-costing'  => array(
			'name'        => __( 'Pricing & Costing', 'crumb-co-toolkit' ),
			'description' => __( 'See what each bake really costs you — ingredients, packaging and your time.', 'crumb-co-toolkit' ),
			'image'       => 'pricing-calculator.jpg',
		),
		'launch-setup'     => array(
			'name'        => __( 'Launch & Setup', 'crumb-co-toolkit' ),
			'description' => __( 'The documents and checklists you need to start taking orders with confidence.', 'crumb-co-toolkit' ),
			'image'       => 'launch-kit.jpg',
		),
		'marketing'        => array(
			'name'        => __( 'Marketing', 'crumb-co-toolkit' ),
			'description' => __( 'Plan what to post and when, around your products and the seasons.', 'crumb-co-toolkit' ),
			'image'       => 'content-planner.jpg',
		),
	),

	'tags'       => array(
		'spreadsheet' => __( 'Spreadsheet (XLSX)', 'crumb-co-toolkit' ),
		'document'    => __( 'Document (DOCX)', 'crumb-co-toolkit' ),
		'bundle'      => __( 'Bundle (ZIP)', 'crumb-co-toolkit' ),
	),

	'products'   => array(

		'order-tracker'      => array(
			'name'        => __( 'Home Bakery Order Tracker', 'crumb-co-toolkit' ),
			'slug'        => 'home-bakery-order-tracker',
			'price'       => '9.00',
			'menu_order'  => 1,
			'category'    => 'order-management',
			'tags'        => array( 'spreadsheet' ),
			'images'      => array( 'order-tracker.jpg', 'order-tracker-preview.jpg' ),
			'image_alt'   => __( 'Laptop showing the Home Bakery Order Tracker spreadsheet with order status labels', 'crumb-co-toolkit' ),
			'download'    => array( 'file' => 'home-bakery-order-tracker.xlsx', 'name' => __( 'Home Bakery Order Tracker (XLSX)', 'crumb-co-toolkit' ) ),
			'short'       => __( 'An editable spreadsheet for recording customer orders, pickup dates, payments and order status — all in one place.', 'crumb-co-toolkit' ),
			'description' => array(
				__( 'If your orders live in text messages, direct messages and sticky notes, this tracker gives them one home. Each row is an order: who it is for, what they ordered, when they are collecting it, what they have paid and where it is up to.', 'crumb-co-toolkit' ),
				__( 'Drop-down lists keep payment and order statuses consistent, the balance due calculates itself, and a summary tab counts orders by status and adds up what is still to collect.', 'crumb-co-toolkit' ),
			),
			'helps'       => array(
				__( 'See upcoming pickups in date order', 'crumb-co-toolkit' ),
				__( 'Know who has paid a deposit and what is still owed', 'crumb-co-toolkit' ),
				__( 'Keep allergy, flavour and design notes with each order', 'crumb-co-toolkit' ),
				__( 'Spot enquiries that still need a reply or confirmation', 'crumb-co-toolkit' ),
			),
			'for_who'     => __( 'Home bakers taking custom orders — cakes, cookies, cupcakes or bread — who want one reliable record instead of scattered messages.', 'crumb-co-toolkit' ),
			'task'        => __( 'Recording and following customer orders from enquiry to pickup', 'crumb-co-toolkit' ),
			'format'      => __( 'Spreadsheet · XLSX', 'crumb-co-toolkit' ),
			'software'    => __( 'Microsoft Excel, Google Sheets, LibreOffice Calc', 'crumb-co-toolkit' ),
			'files'       => array(
				__( 'home-bakery-order-tracker.xlsx — tabs: Start here, Orders, Lists, Summary', 'crumb-co-toolkit' ),
				__( '300 pre-formatted order rows with drop-down statuses and automatic balance due', 'crumb-co-toolkit' ),
				__( 'Three example rows (clearly marked) to delete when you are ready', 'crumb-co-toolkit' ),
			),
			'howto'       => array(
				__( 'Excel: open the downloaded .xlsx file. Google Sheets: upload it to Google Drive, then choose Open with → Google Sheets.', 'crumb-co-toolkit' ),
				__( 'Read the "Start here" tab, then delete the three grey example rows on the Orders tab.', 'crumb-co-toolkit' ),
				__( 'Edit the drop-down options on the Lists tab to match how you work.', 'crumb-co-toolkit' ),
				__( 'Set the money columns to your currency using Format → Number.', 'crumb-co-toolkit' ),
			),
			'faq'         => array(
				array( __( 'Can a helper use it too?', 'crumb-co-toolkit' ), __( 'Yes. Upload it to Google Sheets or store it in OneDrive and share it with the people who help you.', 'crumb-co-toolkit' ) ),
				array( __( 'How many orders does it hold?', 'crumb-co-toolkit' ), __( '300 rows are ready to use. You can copy the last row down to add more.', 'crumb-co-toolkit' ) ),
				array( __( 'Can I change the statuses?', 'crumb-co-toolkit' ), __( 'Yes. Edit the lists on the Lists tab and the drop-downs update.', 'crumb-co-toolkit' ) ),
				array( __( 'Does it send reminders to customers?', 'crumb-co-toolkit' ), __( 'No. It is a spreadsheet for your own records; it does not send messages or connect to other apps.', 'crumb-co-toolkit' ) ),
			),
		),

		'pricing-calculator' => array(
			'name'        => __( 'Cake Pricing Calculator', 'crumb-co-toolkit' ),
			'slug'        => 'cake-pricing-calculator',
			'price'       => '9.00',
			'menu_order'  => 2,
			'category'    => 'pricing-costing',
			'tags'        => array( 'spreadsheet' ),
			'images'      => array( 'pricing-calculator.jpg', 'pricing-calculator-preview.jpg' ),
			'image_alt'   => __( 'Tablet showing the Cake Pricing Calculator with ingredient, packaging and labour sections', 'crumb-co-toolkit' ),
			'download'    => array( 'file' => 'cake-pricing-calculator.xlsx', 'name' => __( 'Cake Pricing Calculator (XLSX)', 'crumb-co-toolkit' ) ),
			'short'       => __( 'A spreadsheet template that organises ingredient, packaging and labour costs for each bake, so you can see what it really costs you.', 'crumb-co-toolkit' ),
			'description' => array(
				__( 'Pricing is personal: it depends on your market, your skills and your goals. What every baker needs first is an accurate cost. This calculator helps you record what you pay for ingredients, work out the cost of the amounts a recipe uses, then add packaging, the time you spend and any overheads you track.', 'crumb-co-toolkit' ),
				__( 'You can test a markup percentage of your choice to see the arithmetic next to your total cost. The calculator does not recommend a price or promise a profit — it gives you clear numbers to make your own decision.', 'crumb-co-toolkit' ),
			),
			'helps'       => array(
				__( 'Keep an ingredient library with cost per gram, millilitre or item', 'crumb-co-toolkit' ),
				__( 'Cost a recipe line by line using drop-down ingredient names', 'crumb-co-toolkit' ),
				__( 'Include packaging and the time you spend, at an hourly rate you choose', 'crumb-co-toolkit' ),
				__( 'Duplicate the costing tab for every product you make', 'crumb-co-toolkit' ),
			),
			'for_who'     => __( 'Bakers who want to understand their costs before setting or reviewing prices — whether you are just starting or ingredient prices have changed.', 'crumb-co-toolkit' ),
			'task'        => __( 'Organising ingredient, packaging and labour costs per product', 'crumb-co-toolkit' ),
			'format'      => __( 'Spreadsheet · XLSX', 'crumb-co-toolkit' ),
			'software'    => __( 'Microsoft Excel, Google Sheets, LibreOffice Calc', 'crumb-co-toolkit' ),
			'files'       => array(
				__( 'cake-pricing-calculator.xlsx — tabs: Start here, Ingredient library, Cake costing', 'crumb-co-toolkit' ),
				__( 'Room for 100 ingredients and 20 recipe lines per product', 'crumb-co-toolkit' ),
				__( 'Example figures (clearly marked) to replace with your own', 'crumb-co-toolkit' ),
			),
			'howto'       => array(
				__( 'Open the .xlsx file in Excel, or upload it to Google Drive and open it with Google Sheets.', 'crumb-co-toolkit' ),
				__( 'Fill in the yellow cells on the Ingredient library tab with what you pay and the package size.', 'crumb-co-toolkit' ),
				__( 'On Cake costing, choose ingredients from the drop-down and enter the amounts your recipe uses.', 'crumb-co-toolkit' ),
				__( 'Add packaging, your minutes and your hourly rate. Right-click the tab to duplicate it for another product.', 'crumb-co-toolkit' ),
			),
			'faq'         => array(
				array( __( 'Will it tell me what to charge?', 'crumb-co-toolkit' ), __( 'No. It adds up your costs and shows the arithmetic for a markup you choose. The price you set is your decision.', 'crumb-co-toolkit' ) ),
				array( __( 'Can I use it for cookies or bread?', 'crumb-co-toolkit' ), __( 'Yes. Rename the tab and the product, and it works for any bake.', 'crumb-co-toolkit' ) ),
				array( __( 'Does it work with my currency?', 'crumb-co-toolkit' ), __( 'Yes. The numbers are plain values — set any currency format you like.', 'crumb-co-toolkit' ) ),
				array( __( 'What hourly rate should I use?', 'crumb-co-toolkit' ), __( 'That is up to you. The sheet simply uses the rate you enter so you can see how your time adds up.', 'crumb-co-toolkit' ) ),
			),
		),

		'launch-kit'         => array(
			'name'        => __( 'Bakery Launch Kit', 'crumb-co-toolkit' ),
			'slug'        => 'bakery-launch-kit',
			'price'       => '19.00',
			'menu_order'  => 3,
			'category'    => 'launch-setup',
			'tags'        => array( 'bundle', 'document', 'spreadsheet' ),
			'images'      => array( 'launch-kit.jpg', 'launch-kit-preview.jpg' ),
			'image_alt'   => __( 'Order form, customer questionnaire, menu and launch checklist templates laid out together', 'crumb-co-toolkit' ),
			'download'    => array( 'file' => 'bakery-launch-kit.zip', 'name' => __( 'Bakery Launch Kit (ZIP, 4 files)', 'crumb-co-toolkit' ) ),
			'short'       => __( 'A focused bundle of four editable files — order form, customer questionnaire, menu template and launch checklist — for bakers getting ready to take orders.', 'crumb-co-toolkit' ),
			'description' => array(
				__( 'Starting to sell from home comes with a pile of small documents. This kit covers the four you will use straight away: an order form to capture every detail, a questionnaire to send before you quote, a simple menu layout, and a checklist that walks through launch tasks in stages.', 'crumb-co-toolkit' ),
				__( 'Replace the [square brackets] with your own details, add your logo and colours, and you are ready to go.', 'crumb-co-toolkit' ),
			),
			'helps'       => array(
				__( 'Collect the same details for every order', 'crumb-co-toolkit' ),
				__( 'Ask the right questions before quoting a custom bake', 'crumb-co-toolkit' ),
				__( 'Present your products and ordering information clearly', 'crumb-co-toolkit' ),
				__( 'Work through launch tasks from planning to first orders', 'crumb-co-toolkit' ),
			),
			'for_who'     => __( 'New and soon-to-launch home bakers, or anyone tidying up how they take orders.', 'crumb-co-toolkit' ),
			'task'        => __( 'Preparing the documents and steps needed to start taking orders', 'crumb-co-toolkit' ),
			'format'      => __( 'Bundle · DOCX + XLSX (ZIP)', 'crumb-co-toolkit' ),
			'software'    => __( 'Word, Google Docs or LibreOffice Writer (.docx); Excel, Google Sheets or LibreOffice Calc (.xlsx)', 'crumb-co-toolkit' ),
			'files'       => array(
				__( '01-order-form.docx — customer, order, pickup and payment fields', 'crumb-co-toolkit' ),
				__( '02-customer-questionnaire.docx — 11 questions to ask before quoting', 'crumb-co-toolkit' ),
				__( '03-menu-template.docx — sections for cakes, cookies, small bakes and specials', 'crumb-co-toolkit' ),
				__( '04-launch-checklist.xlsx — 25 tasks in six stages with a progress count', 'crumb-co-toolkit' ),
				__( 'READ-ME-FIRST.txt — quick instructions', 'crumb-co-toolkit' ),
			),
			'howto'       => array(
				__( 'Download the ZIP file and unzip it: double-click on a Mac, or right-click → Extract All on Windows.', 'crumb-co-toolkit' ),
				__( 'Open the .docx files in Word, or upload them to Google Drive and open them with Google Docs.', 'crumb-co-toolkit' ),
				__( 'Replace everything in [square brackets] with your bakery details.', 'crumb-co-toolkit' ),
				__( 'Open the checklist in a spreadsheet app and mark tasks "Yes" as you complete them.', 'crumb-co-toolkit' ),
			),
			'faq'         => array(
				array( __( 'Does the checklist cover legal requirements?', 'crumb-co-toolkit' ), __( 'It reminds you to research the rules for selling food from home where you live, but it is not legal advice and does not list specific requirements.', 'crumb-co-toolkit' ) ),
				array( __( 'Can I add my logo and colours?', 'crumb-co-toolkit' ), __( 'Yes. All files are fully editable.', 'crumb-co-toolkit' ) ),
				array( __( 'Can I give the order form to customers?', 'crumb-co-toolkit' ), __( 'Yes. You can share blank or completed forms with your own customers. Please do not resell or share the template files themselves.', 'crumb-co-toolkit' ) ),
				array( __( 'Why is it a ZIP file?', 'crumb-co-toolkit' ), __( 'It keeps all four files together in one download. Unzipping is built into Windows and macOS.', 'crumb-co-toolkit' ) ),
			),
		),

		'content-planner'    => array(
			'name'        => __( 'Social Content Planner for Bakers', 'crumb-co-toolkit' ),
			'slug'        => 'social-content-planner-for-bakers',
			'price'       => '9.00',
			'menu_order'  => 4,
			'category'    => 'marketing',
			'tags'        => array( 'spreadsheet' ),
			'images'      => array( 'content-planner.jpg', 'content-planner-preview.jpg' ),
			'image_alt'   => __( 'Tablet showing a monthly social media calendar with colour-coded post themes', 'crumb-co-toolkit' ),
			'download'    => array( 'file' => 'social-content-planner-for-bakers.xlsx', 'name' => __( 'Social Content Planner for Bakers (XLSX)', 'crumb-co-toolkit' ) ),
			'short'       => __( 'An editable monthly planner with post prompts organised around your bakery products and seasonal promotions.', 'crumb-co-toolkit' ),
			'description' => array(
				__( 'When you are busy baking, posting is often the first thing to slip. This planner helps you sketch out a month in one sitting: choose a theme for each day you plan to post, pick the product to feature, borrow a prompt from the prompt bank and track each post from idea to posted.', 'crumb-co-toolkit' ),
				__( 'A seasonal ideas tab lists occasions you might plan around through the year, with a reminder to check the dates that apply where you live.', 'crumb-co-toolkit' ),
			),
			'helps'       => array(
				__( 'Plan a realistic number of posts for the month', 'crumb-co-toolkit' ),
				__( 'Feature each of your products in a balanced way', 'crumb-co-toolkit' ),
				__( 'Have prompts ready for days when ideas run dry', 'crumb-co-toolkit' ),
				__( 'Prepare seasonal pre-orders and promotions ahead of time', 'crumb-co-toolkit' ),
			),
			'for_who'     => __( 'Home bakers who promote their business on social media and want a simple monthly plan instead of daily guesswork.', 'crumb-co-toolkit' ),
			'task'        => __( 'Planning posts around products and seasonal promotions', 'crumb-co-toolkit' ),
			'format'      => __( 'Spreadsheet · XLSX', 'crumb-co-toolkit' ),
			'software'    => __( 'Microsoft Excel, Google Sheets, LibreOffice Calc', 'crumb-co-toolkit' ),
			'files'       => array(
				__( 'social-content-planner-for-bakers.xlsx — tabs: Start here, Monthly planner, Prompt bank, Seasonal ideas, Lists', 'crumb-co-toolkit' ),
				__( '22 post prompts across 8 themes, from product spotlights to order reminders', 'crumb-co-toolkit' ),
				__( 'A 12-month list of seasonal ideas to adapt to your region', 'crumb-co-toolkit' ),
			),
			'howto'       => array(
				__( 'Open the .xlsx file in Excel, or upload it to Google Drive and open it with Google Sheets.', 'crumb-co-toolkit' ),
				__( 'On Monthly planner, type the month and the dates you plan to post.', 'crumb-co-toolkit' ),
				__( 'Choose a theme and format from the drop-downs and borrow a prompt from the Prompt bank.', 'crumb-co-toolkit' ),
				__( 'Duplicate the Monthly planner tab at the start of each new month.', 'crumb-co-toolkit' ),
			),
			'faq'         => array(
				array( __( 'Does it post for me?', 'crumb-co-toolkit' ), __( 'No. It is a planning template. You publish posts yourself on whichever platform you use.', 'crumb-co-toolkit' ) ),
				array( __( 'Which platforms does it suit?', 'crumb-co-toolkit' ), __( 'Any. The themes and prompts work for photo, video and text posts.', 'crumb-co-toolkit' ) ),
				array( __( 'Will it grow my followers?', 'crumb-co-toolkit' ), __( 'We cannot promise any results. It helps you plan and post consistently, which is the part you control.', 'crumb-co-toolkit' ) ),
				array( __( 'Can I add my own prompts and themes?', 'crumb-co-toolkit' ), __( 'Yes. Add rows to the Prompt bank and edit the Lists tab to change the drop-downs.', 'crumb-co-toolkit' ) ),
			),
		),
	),

	'pages'      => array(
		// key => [ title, pattern slug (theme), slug per language, search description ].
		'home'           => array( __( 'Home', 'crumb-co-toolkit' ), 'home', array( 'en' => 'home', 'fr' => 'accueil', 'es' => 'inicio', 'ar' => 'ar-home' ) , __( 'Editable templates for home bakers: order tracker, cake pricing calculator, launch kit and social content planner. Instant download, nothing shipped.', 'crumb-co-toolkit' ) ),
		'about'          => array( __( 'About', 'crumb-co-toolkit' ), 'page-about', array( 'en' => 'about', 'fr' => 'a-propos', 'es' => 'sobre-nosotros', 'ar' => 'ar-about' ) , __( 'Crumb & Co. Studio makes practical, editable digital tools for home-based bakers: a small, focused range built around real bakery tasks.', 'crumb-co-toolkit' ) ),
		'faq'            => array( __( 'FAQ', 'crumb-co-toolkit' ), 'page-faq', array( 'en' => 'faq', 'fr' => 'questions-frequentes', 'es' => 'preguntas-frecuentes', 'ar' => 'ar-faq' ) , __( 'Answers about buying, downloading and editing our digital templates for home bakers: file formats, software, licence, refunds and support.', 'crumb-co-toolkit' ) ),
		'contact'        => array( __( 'Contact', 'crumb-co-toolkit' ), 'page-contact', array( 'en' => 'contact', 'fr' => 'contactez-nous', 'es' => 'contacto', 'ar' => 'ar-contact' ) , __( 'Questions about a product or a download? Contact Crumb & Co. Studio support. Include your order number and we will help.', 'crumb-co-toolkit' ) ),
		'refund-policy'  => array( __( 'Digital Download & Refund Policy', 'crumb-co-toolkit' ), 'page-refund-policy', array( 'en' => 'refund-policy', 'fr' => 'politique-de-remboursement', 'es' => 'politica-de-reembolso', 'ar' => 'ar-refund-policy' ) , __( 'How delivery works for our digital downloads, what to do if a file has a problem, and when refunds are possible.', 'crumb-co-toolkit' ) ),
		'privacy-policy' => array( __( 'Privacy Policy', 'crumb-co-toolkit' ), 'page-privacy-policy', array( 'en' => 'privacy-policy', 'fr' => 'politique-de-confidentialite', 'es' => 'politica-de-privacidad', 'ar' => 'ar-privacy-policy' ) , __( 'How Crumb & Co. Studio collects, uses and protects your personal data when you shop, join the email list or contact us.', 'crumb-co-toolkit' ) ),
		'terms'          => array( __( 'Terms & Conditions', 'crumb-co-toolkit' ), 'page-terms', array( 'en' => 'terms', 'fr' => 'conditions-generales', 'es' => 'terminos-y-condiciones', 'ar' => 'ar-terms' ) , __( 'Terms of sale and licence for the Crumb & Co. Studio digital templates for home bakers.', 'crumb-co-toolkit' ) ),
		'cart'           => array( __( 'Cart', 'crumb-co-toolkit' ), '', array( 'en' => 'cart', 'fr' => 'panier', 'es' => 'carrito', 'ar' => 'ar-cart' ) ),
		'checkout'       => array( __( 'Checkout', 'crumb-co-toolkit' ), '', array( 'en' => 'checkout', 'fr' => 'commande', 'es' => 'finalizar-compra', 'ar' => 'ar-checkout' ) ),
		'my-account'     => array( __( 'My Account', 'crumb-co-toolkit' ), '', array( 'en' => 'my-account', 'fr' => 'mon-compte', 'es' => 'mi-cuenta', 'ar' => 'ar-my-account' ) ),
	),

	'menus'      => array(
		'primary'     => array(
			'name'  => __( 'Main navigation', 'crumb-co-toolkit' ),
			'items' => array(
				array( 'shop', __( 'Shop', 'crumb-co-toolkit' ), array( 'cat:order-management', 'cat:pricing-costing', 'cat:launch-setup', 'cat:marketing' ) ),
				array( 'about', __( 'About', 'crumb-co-toolkit' ) ),
				array( 'faq', __( 'FAQ', 'crumb-co-toolkit' ) ),
				array( 'contact', __( 'Contact', 'crumb-co-toolkit' ) ),
			),
		),
		'footer_shop' => array(
			'name'  => __( 'Footer: Shop', 'crumb-co-toolkit' ),
			'items' => array(
				array( 'shop', __( 'All products', 'crumb-co-toolkit' ) ),
				array( 'cat:order-management', '' ),
				array( 'cat:pricing-costing', '' ),
				array( 'cat:launch-setup', '' ),
				array( 'cat:marketing', '' ),
				array( 'my-account', __( 'My account & downloads', 'crumb-co-toolkit' ) ),
			),
		),
		'footer_help' => array(
			'name'  => __( 'Footer: Help & policies', 'crumb-co-toolkit' ),
			'items' => array(
				array( 'about', __( 'About', 'crumb-co-toolkit' ) ),
				array( 'faq', __( 'FAQ', 'crumb-co-toolkit' ) ),
				array( 'contact', __( 'Contact', 'crumb-co-toolkit' ) ),
				array( 'refund-policy', __( 'Digital download & refund policy', 'crumb-co-toolkit' ) ),
				array( 'privacy-policy', __( 'Privacy policy', 'crumb-co-toolkit' ) ),
				array( 'terms', __( 'Terms & conditions', 'crumb-co-toolkit' ) ),
			),
		),
	),
);
