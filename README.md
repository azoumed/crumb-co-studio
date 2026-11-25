# Crumb & Co. Studio — WordPress + WooCommerce shop

A digital-product shop for home-based bakers. It's a WooCommerce **block theme** plus a companion plugin, with four starter products (real, editable template files) and content in **English, العربية (RTL), Français and Español**.

```
crumb-co-studio/
├── crumb-co-theme.zip               ← upload in Appearance → Themes → Add New
├── crumb-co-toolkit.zip             ← upload in Plugins → Add New
└── wp-content/
    ├── themes/crumb-co/             Block theme: design, templates, patterns, translations
    └── plugins/crumb-co-toolkit/    Shop features, starter content, download files
```

---

## 1. Install (about 15 minutes)

**Requirements:** WordPress 6.6+, PHP 7.4+, WooCommerce 9.0+, HTTPS (needed for secure checkout).
For the four languages you also need **Polylang**, the free plugin.

1. Install and activate **WooCommerce** and finish its setup wizard. You can skip the payment step for now.
2. Install and activate **Polylang**. Leave its wizard languages empty if you like, because step 5 can add them for you.
3. Go to **Appearance → Themes → Add New → Upload** and upload `crumb-co-theme.zip`, then activate it.
4. Go to **Plugins → Add New → Upload** and upload `crumb-co-toolkit.zip`, then activate it.
5. Go to **Crumb & Co. → Starter content**, keep the three boxes ticked, and click **Create starter content**. This:
   - adds the Polylang languages English, العربية, Français and Español, and downloads WordPress's language packs for them;
   - creates the product categories (Order Management, Pricing & Costing, Launch & Setup, Marketing) and the format tags;
   - creates the **4 digital products** in each language: virtual and downloadable, with protected files, mockup images, a "who it's for" field, the included files, compatible software, how-to steps and an FAQ;
   - creates the Home, About, FAQ, Contact, Digital Download & Refund Policy, Privacy Policy and Terms pages, plus translated Cart, Checkout and My Account pages;
   - creates the menus for each language and applies the digital-shop WooCommerce settings: forced (protected) downloads, access granted after payment, shipping disabled.

   You can run it again safely. It only creates what is missing and never overwrites pages you've edited.
6. In **Settings → Permalinks**, click **Save** once. This refreshes the language URLs such as `/fr/` and `/ar/`.

## 2. Before you launch — placeholder checklist

Nothing below has been invented for you. Every gap is a visible `[placeholder]`.

| What | Where |
|---|---|
| **Real prices.** The products start at 9 / 9 / 19 / 9 as placeholders. Each product shows a yellow admin notice until you change its price. | Products → edit → Product data → General (do this for every language version) |
| **Payment provider** (WooPayments, Stripe, PayPal…) | WooCommerce → Settings → Payments. Then place a test order. |
| Support email, contact-form recipient and business name | Crumb & Co. → Shop settings |
| Your story | About page |
| Download limits, payment methods and reply time | FAQ and Contact pages |
| Policy details (dates, days, currency, governing law…) | Refund, Privacy and Terms pages. **Have these reviewed by a qualified professional.** They are templates, not legal advice. |
| Logo, and social links (currently `#`) | Appearance → Editor → Patterns → Header / Footer |
| Customer feedback cards | Home page. They're labelled "Placeholder". Replace them with real quotes shared with permission, or delete the section. |

## 3. How digital delivery works

- All products are **virtual + downloadable**, so WooCommerce hides shipping. When payment succeeds, it **auto-completes** download-only orders.
- The customer gets their download links on the **order confirmation page**, in the **order email**, and in **My Account → Downloads**.
- The files are stored in `wp-content/uploads/woocommerce_uploads/crumb-co/` and served with the **Force downloads** method, so the real file URL is never exposed.
  - On **Apache**, the `.htaccess` file in that folder blocks direct access.
  - On **Nginx**, ask your host to add:
    ```
    location ~* /woocommerce_uploads/ { deny all; }
    ```
- "Digital download — nothing is shipped" notices appear on product cards, on product pages, in the cart and checkout (both the classic and block versions), on the thank-you page and in customer emails.
- Classic checkout hides street-address fields for digital-only carts. You can turn this off in Shop settings. For the **Checkout block**, open the Checkout page in the editor and switch off the optional fields (company, address line 2, phone) in the block settings.

## 4. Editing everything in WordPress

| To change… | Go to |
|---|---|
| Homepage text, images and sections | **Pages → Home** (each language has its own Home page). Sections are normal blocks, and more are under **+ → Patterns → Crumb & Co. sections**. |
| Product title, description, price, images and download file | **Products → edit**. The "Crumb & Co. product details" box holds *Who it's for*, *Task*, *Format*, *Software*, *Files included*, *Steps* and *FAQ* (one question per paragraph: the question on the first line, the answer below it). |
| Colours, fonts and spacing | **Appearance → Editor → Styles**. The palette is Cream, Cocoa, Raspberry, Sage and their tints. |
| Header and footer layout | **Appearance → Editor → Patterns → Template parts** |
| Menus (one per language) | **Appearance → Menus**, then pick the language next to each menu location |
| Announcement bar and footer text | **Crumb & Co. → Shop settings**. With Polylang, translate them in **Languages → Translations**. Leave them empty to keep the built-in four-language text. |
| Email-list subscribers | **Crumb & Co. → Subscribers** (with CSV export). To connect Mailchimp or another email service, import the CSV or hook into `crumb_co_new_subscriber`. |

**Adding a new product later:** go to Products → Add New. The Virtual and Downloadable boxes are ticked automatically. Upload the file under *Downloadable files*, pick a category, fill in the Crumb & Co. details box, and publish. If you use Polylang, add its translations with the **+** in the language columns. The shop, filters, search and related products update by themselves.

## 5. Languages

- **Theme and plugin text** (all buttons, notices and section copy) ship with full Arabic, French and Spanish translations in `languages/`, as `.po`, `.mo` and `.l10n.php` files. Edit them with Loco Translate or Poedit.
- **Arabic is right-to-left.** WordPress switches the direction automatically, the layout uses logical CSS properties so it mirrors correctly, and the Cairo font is loaded for Arabic text.
- **Pages and products** are ordinary content in each language, linked as translations by Polylang. The language switcher sits in the announcement bar and the footer.
- **Limits of free Polylang:** each product translation is a separate WooCommerce product, so a price change has to be made on each language version. For automatic price and stock syncing, plus translated WooCommerce emails per order language, use **Polylang for WooCommerce** or **WPML + WooCommerce Multilingual** (both paid). The theme works with either.
- The **template files themselves are in English**. The product pages say this, and every label inside them is editable.

## 6. Shop features

- Product category pages, header search (products only), and a sidebar with category links, file-format filter, price range filter and a help box. The sidebar becomes a "Search & filter" toggle on phones.
- Sorting comes from WooCommerce's dropdown. Related products, upsells (the Launch Kit) and cross-sells (in the cart) are all set up.
- Product page: a facts box (who it's for, what it helps with, format, works with), a prominent **"Add to cart — instant download"** button, the digital notice, and tabs for Overview, What's included, Download & editing, and FAQ.
- Email signup with the **free one-page order tracker** (PDF). It has a consent checkbox, spam honeypot and rate limit, and works with WordPress's personal-data export and erase tools.
- Contact form (nonce, honeypot, rate limit). It sends to your support email, with Reply-To set to the customer.

## 7. The starter files

These are real, working templates in `wp-content/plugins/crumb-co-toolkit/assets/downloads/`:

| File | Contents |
|---|---|
| `home-bakery-order-tracker.xlsx` | Start here / Orders (300 rows, drop-downs, automatic balance due, conditional colours) / Lists / Summary |
| `cake-pricing-calculator.xlsx` | Ingredient library (cost per unit) / Cake costing (ingredients, packaging, labour, overhead, a markup you choose to test). It doesn't recommend prices. |
| `bakery-launch-kit.zip` | Order form, customer questionnaire and menu (DOCX), plus a 25-task launch checklist (XLSX) and a read-me |
| `social-content-planner-for-bakers.xlsx` | Monthly planner / 22-prompt bank / 12-month seasonal ideas / Lists |
| `free-one-page-order-tracker.pdf` | The free printable for the email signup |

## 8. SEO and Google Search (following Google Search Central)

### Already built in

| Google recommendation | What the shop does |
|---|---|
| Unique, honest description per page | Translated search descriptions for every starter page and product (≤ 155 characters). They're stored where Yoast, Rank Math, The SEO Framework and SEOPress read them, so they carry over when you install one. |
| Structured data for shops | WooCommerce's Product markup, plus **brand** and your **return policy** (MerchantReturnPolicy) once you set it. The Organization markup includes your social profiles. |
| No duplicate or thin pages | `noindex, follow` on internal search, format-tag, author and date pages, and on sorted or filtered URLs. `robots.txt` keeps crawlers out of add-to-cart links and filter parameters (Google's faceted-navigation advice). WooCommerce already noindexes Cart, Checkout and My Account. |
| Clean XML sitemap | WordPress's sitemap (`/wp-sitemap.xml`) without author or tag sitemaps. An SEO plugin replaces it with its own. |
| Multilingual | One URL per language and `hreflang` (Polylang), correct `lang`/`dir`, and image alt text in the visitor's language. |
| Core Web Vitals | Theme images get width and height (no layout shift). The hero image loads first, everything else lazily. The heading font is preloaded and fonts are self-hosted. WordPress's emoji script is removed. |
| Sharing | Open Graph and X/Twitter cards, plus a 1200 × 630 share image (`share-default.jpg`). |
| Site name in results | WebSite and Organization markup. No sitelinks search box: Google retired it in 2024. |

**Without an SEO plugin**, the Toolkit prints the meta description, canonical, Open Graph and Organization/WebSite markup itself, and adds a **"Search description"** box to pages and products.
**With Yoast** (recommended), Rank Math, The SEO Framework, AIOSEO, SEOPress or Slim SEO, that fallback switches off automatically, so nothing is duplicated. The Toolkit still adds your return policy and social profiles to Yoast's Organization markup.

### Your launch checklist

1. **Crumb & Co. → Shop settings → Search & sharing**:
   - add your social profile URLs;
   - choose the return policy that matches your Refund Policy page (plus days and countries);
   - optionally, paste your Search Console and Bing verification codes.
2. **Crumb & Co. → Starter content → Create starter content** once more. On an existing site, this fills in the new search descriptions and translated image alt text without touching your edits.
3. Install **Yoast SEO**. In its first-time setup, choose **Organization**, add your name and logo, and confirm the sitemap.
4. Install **Performance Lab** (turn on *Modern Image Formats* for WebP/AVIF) and a cache plugin (**WP Super Cache**, or **LiteSpeed Cache** on LiteSpeed hosting).
5. Make sure the live site runs on **HTTPS**, then add it to **Google Search Console** and **Bing Webmaster Tools** and submit the sitemap (`/sitemap_index.xml` with Yoast, or `/wp-sitemap.xml` without).
6. Check the home page and a product page in each language with **PageSpeed Insights** (target: LCP ≤ 2.5 s, INP ≤ 200 ms, CLS ≤ 0.1) and with Google's **Rich Results Test**.
7. Optional: create a free **Google Merchant Center** account and link it to the shop, so the products can appear in the Shopping tab.
8. Write real, specific content: your story on About, real product photos if you have them, and real reviews only.

## 9. What was tested, and what to test on your server

**Tested while building:**
- All PHP passes `php -l`. The SEO helpers (description trimming, return-policy and social markup) and the image-size filter were unit-tested.
- Every page pattern was rendered in all 4 languages: 64 renders, and the HTML and block nesting are balanced.
- All 1,520 resulting blocks, plus the templates and template parts, were checked with WordPress's own block parser and validator (`@wordpress/blocks`). None were invalid or auto-corrected.
- All translation placeholders (`%s` and HTML tags) match the English source.
- The spreadsheet formulas were recalculated in LibreOffice and give correct results.
- Visual previews were checked at desktop and phone widths, in both LTR and Arabic RTL.

**Not tested:** the build environment couldn't download WordPress or WooCommerce, so this hasn't been run on a live install yet. Use a staging site first and check:

1. The starter-content run completes, and its log lists the pages and products.
2. Each language's Home page, shop, category page and product page look right.
3. A test order in each language, with your payment provider in test mode. Check the download link on the thank-you page, in the email and in My Account.
4. The signup and contact forms (your host must be able to send email; an SMTP plugin helps).
5. If the setup log mentions *approved download directories*, open WooCommerce → Settings → Products → Approved download directories and enable `…/uploads/woocommerce_uploads/crumb-co/`.

## Credits

Fonts: Fraunces, Nunito and Cairo, under the SIL Open Font License (the licences are in `assets/fonts/`). Illustrations and mockups were made for this project. Code is GPL-2.0-or-later.
