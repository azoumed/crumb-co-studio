---
name: Crumb & Co. Studio
description: Editable order, pricing and marketing templates for home bakers, shown working on a cocoa worktop.
colors:
  cream: "#FBF6EE"
  warm-cream: "#F4EADB"
  white: "#FFFFFF"
  cocoa: "#3B2A20"
  soft-cocoa: "#6B5546"
  crumb-line: "#E6D9C6"
  raspberry: "#B8325A"
  deep-raspberry: "#932446"
  raspberry-cream: "#F6DCE3"
  sage: "#7E9C7C"
  deep-sage: "#4F6B4E"
  sage-cream: "#E3EBDD"
  butter: "#FFF1CC"
  butter-ink: "#7A5410"
typography:
  display:
    fontFamily: "Fraunces, Cairo, Georgia, 'Times New Roman', serif"
    fontSize: "clamp(2.1rem, 1.2rem + 3.6vw, 4.25rem)"
    fontWeight: 600
    lineHeight: 1.02
    letterSpacing: "-0.025em"
  headline:
    fontFamily: "Fraunces, Cairo, Georgia, 'Times New Roman', serif"
    fontSize: "2.75rem"
    fontWeight: 600
    lineHeight: 1.12
    letterSpacing: "-0.01em"
  title:
    fontFamily: "Fraunces, Cairo, Georgia, 'Times New Roman', serif"
    fontSize: "1.75rem"
    fontWeight: 600
    lineHeight: 1.12
    letterSpacing: "-0.01em"
  body:
    fontFamily: "Nunito, Cairo, 'Segoe UI', system-ui, -apple-system, sans-serif"
    fontSize: "1.0625rem"
    fontWeight: 400
    lineHeight: 1.65
  lead:
    fontFamily: "Nunito, Cairo, 'Segoe UI', system-ui, -apple-system, sans-serif"
    fontSize: "1.25rem"
    fontWeight: 400
    lineHeight: 1.55
  ui:
    fontFamily: "Nunito, Cairo, 'Segoe UI', system-ui, -apple-system, sans-serif"
    fontSize: "1rem"
    fontWeight: 800
    lineHeight: 1.2
  sheet:
    fontFamily: "Nunito, Cairo, 'Segoe UI', system-ui, -apple-system, sans-serif"
    fontSize: "0.92rem"
    fontWeight: 400
    lineHeight: 1.35
    fontFeature: "tnum"
  label:
    fontFamily: "Nunito, Cairo, 'Segoe UI', system-ui, -apple-system, sans-serif"
    fontSize: "0.8rem"
    fontWeight: 800
    lineHeight: 1.3
    letterSpacing: "0.12em"
  arabic:
    fontFamily: "Cairo, 'Segoe UI', Tahoma, sans-serif"
    fontWeight: 700
    lineHeight: 1.8
    letterSpacing: "0em"
rounded:
  small: "10px"
  sheet: "14px"
  medium: "18px"
  large: "28px"
  pill: "999px"
spacing:
  "20": "0.5rem"
  "30": "1rem"
  "40": "clamp(1.25rem, 2.5vw, 1.75rem)"
  "50": "clamp(1.75rem, 4vw, 3rem)"
  "60": "clamp(2.5rem, 6vw, 5rem)"
  "70": "clamp(3.5rem, 9vw, 7.5rem)"
  gutter: "clamp(1rem, 4vw, 2.5rem)"
components:
  button-primary:
    backgroundColor: "{colors.raspberry}"
    textColor: "{colors.white}"
    typography: "{typography.ui}"
    rounded: "{rounded.pill}"
    padding: "0.85em 1.6em"
  button-primary-hover:
    backgroundColor: "{colors.deep-raspberry}"
    textColor: "{colors.white}"
  button-outline:
    backgroundColor: "transparent"
    textColor: "{colors.cocoa}"
    rounded: "{rounded.pill}"
    padding: "calc(0.85em - 2px) 1.6em"
  button-outline-hover:
    backgroundColor: "{colors.cocoa}"
    textColor: "{colors.cream}"
  job-tab:
    backgroundColor: "transparent"
    textColor: "{colors.cream}"
    rounded: "{rounded.medium}"
    padding: "0.85rem 1.1rem"
    height: "4.25rem"
  job-tab-selected:
    backgroundColor: "{colors.raspberry}"
    textColor: "{colors.cream}"
  sheet:
    backgroundColor: "{colors.white}"
    textColor: "{colors.cocoa}"
    typography: "{typography.sheet}"
    rounded: "{rounded.sheet}"
  sheet-bar:
    backgroundColor: "{colors.warm-cream}"
    textColor: "{colors.cocoa}"
    padding: "0.6rem 0.9rem"
  sheet-head:
    backgroundColor: "{colors.cocoa}"
    textColor: "{colors.cream}"
    padding: "0.62rem 0.8rem"
  chip-status-sage:
    backgroundColor: "{colors.sage-cream}"
    textColor: "{colors.deep-sage}"
    rounded: "{rounded.pill}"
    padding: "0.12rem 0.55rem"
  chip-status-rasp:
    backgroundColor: "{colors.raspberry-cream}"
    textColor: "{colors.deep-raspberry}"
    rounded: "{rounded.pill}"
    padding: "0.12rem 0.55rem"
  chip-status-butter:
    backgroundColor: "{colors.butter}"
    textColor: "{colors.butter-ink}"
    rounded: "{rounded.pill}"
    padding: "0.12rem 0.55rem"
  chip-status-plain:
    backgroundColor: "{colors.warm-cream}"
    textColor: "{colors.cocoa}"
    rounded: "{rounded.pill}"
    padding: "0.12rem 0.55rem"
  filter-chip:
    backgroundColor: "{colors.cream}"
    textColor: "{colors.cocoa}"
    rounded: "{rounded.pill}"
    padding: "0.35rem 0.8rem"
  filter-chip-active:
    backgroundColor: "{colors.sage-cream}"
    textColor: "{colors.deep-sage}"
  product-card:
    backgroundColor: "{colors.white}"
    textColor: "{colors.cocoa}"
    rounded: "{rounded.medium}"
    padding: "0.75rem 0.75rem 1.25rem"
  input:
    backgroundColor: "{colors.white}"
    textColor: "{colors.cocoa}"
    rounded: "{rounded.small}"
    padding: "0.8rem 1rem"
    height: "48px"
  nav-link:
    textColor: "{colors.cocoa}"
    rounded: "{rounded.pill}"
    padding: "0.55rem 0.9rem"
  nav-link-active:
    backgroundColor: "{colors.warm-cream}"
  panel-filter:
    backgroundColor: "{colors.white}"
    rounded: "{rounded.medium}"
    padding: "1.1rem 1.2rem"
  notice-digital:
    backgroundColor: "{colors.sage-cream}"
    textColor: "{colors.cocoa}"
    rounded: "{rounded.medium}"
    padding: "1rem 1.2rem"
---

# Design System: Crumb & Co. Studio

## Overview

**Creative North Star: "The Cocoa Worktop"**

The shop is a baker's bench with the paperwork laid out on it. The deepest surface is cocoa, the color of a dark worktop, and the products sit on it as what they really are: white spreadsheet sheets with real column heads, a file-name bar, a tab strip and status chips. Everything else on the site is cream paper around that bench. The system proves the product by showing the product; the sheet is the hero image, not an illustration of one.

Density is moderate and calm. Cream pages carry generous section rhythm (spacing 60, up to 5rem), pill-shaped controls, and softly rounded cards with hairline crumb borders. The one dark field (cocoa) is reserved for the first viewport worktop and the footer, so a page reads as cream between two cocoa slabs. Raspberry is the single action color; sage and butter are status and reassurance tones taken from the shipped template files.

The system is fully bidirectional. Every component is written with logical properties (`margin-inline`, `padding-block`, `inset-inline-start`, `border-inline-end`, `text-align: start`), directional glyphs mirror under `.ccs-rtl`, and Arabic switches every role to Cairo with zero tracking. Sheet excerpts (column heads, file names, sample rows) stay in English in every locale, because the files buyers download are English; the surrounding page copy is translated.

**Key Characteristics:**
- Cocoa worktop for the first viewport and footer; cream everywhere else.
- The spreadsheet sheet is the signature component and the main proof.
- Raspberry means "act" (buttons, the chosen job tab, focus ring, mini-cart badge).
- Pills for controls, 18px corners for containers, 10px for fields.
- Soft, warm, cocoa-tinted shadows only; most surfaces are flat with a 1px crumb line.
- Logical properties everywhere; Arabic is a first-class version, not a mirror pass.

## Colors

A warm bakery palette: cream paper, cocoa ink, one raspberry action color, and three soft status tones (sage, raspberry cream, butter) borrowed from the template files.

### Primary
- **Raspberry** (#B8325A): the only action color. Primary buttons, add-to-cart, the selected job tab fill, links, focus outlines, the mini-cart badge, step numerals, FAQ and filter toggle marks.
- **Deep Raspberry** (#932446): hover state of every raspberry control; text color on raspberry-cream chips and the current filter row.
- **Raspberry Cream** (#F6DCE3): tint for "unpaid"-style status chips, the inline digital-only notice pill, selection highlight, current filter and account-nav rows, error alerts.

### Secondary
- **Sage** (#7E9C7C): borders of success alerts and the digital notice, the active sheet tab underline, file-icon corner fold.
- **Deep Sage** (#4F6B4E): text on sage-cream chips, formula cells in the sheet, step and dot markers in the digital band, active filter chip text.
- **Sage Cream** (#E3EBDD): "confirmed / paid" status chips, the digital notice and digital band backgrounds, the free tracker signup card, the check-mark discs in check lists.

### Tertiary
- **Butter** (#FFF1CC): "in progress / deposit" status chips, the sheet's "Example data" pill, and the input-cell marks inside the sheet. It appears only inside or beside a sheet.
- **Butter Ink** (#7A5410): text on butter.

### Neutral
- **Cocoa** (#3B2A20): body text, headings, the hero worktop and footer background, sheet column-head row, active product tab, current pagination page, outline button stroke.
- **Soft Cocoa** (#6B5546): secondary text: leads, captions, result counts, breadcrumbs, fact labels, consent text.
- **Cream** (#FBF6EE): page background; type color on cocoa.
- **Warm Cream** (#F4EADB): quieter surface: sheet file bar and tab strip, nav hover and current item, feedback section band, contact aside, plain chips, count pills.
- **White** (#FFFFFF): sheets, product cards, filter panels, inputs, FAQ items, product facts, tab panels.
- **Crumb Line** (#E6D9C6): every hairline: card and panel borders (1px), field borders (1.5px), sheet cell rules, header underline, separators.

On cocoa, secondary text is a mix rather than a token: `color-mix(in srgb, cream 74%, cocoa)` for leads and hints, and cream at 18 to 34% alpha for outlines and dividers.

### Named Rules
**The One Action Color Rule.** Raspberry is the only color a buyer clicks. Sage and butter never fill a button; they describe state.

**The Status Triad Rule.** Statuses use exactly the tones the shipped files use: sage cream for done or paid, butter for in progress or deposit, raspberry cream for unpaid or attention, warm cream for neutral. Do not add a fourth hue.

**The Two Slabs Rule.** Cocoa fills a full-bleed band only for the first-viewport worktop and the footer. Elsewhere cocoa is ink, a stroke, or a small fill (sheet head, active tab, badge).

## Typography

**Display Font:** Fraunces (with Cairo, Georgia, serif)
**Body Font:** Nunito (with Cairo, Segoe UI, system-ui)
**Arabic:** Cairo for every role

**Character:** Fraunces brings the warm, slightly soft serif of a bakery sign to questions and product names; Nunito is round and friendly but carries the sheet's tabular figures and the extra-bold controls. Cairo replaces both under `:lang(ar)` with letter-spacing reset to 0 and body line height raised to 1.8.

### Hierarchy
- **Display** (Fraunces 600, clamp(2.1rem, 1.2rem + 3.6vw, 4.25rem), 1.02, -0.025em): the hero question on the worktop only; 1.95rem on phones; Arabic at 1.3 line height and weight 700.
- **Headline** (Fraunces 600, 2.1 to 3.4rem fluid, 1.12, -0.01em): section h2 and product titles. Balanced wrapping on h1 to h3.
- **Title** (Fraunces 600, 1.45 to 2rem fluid, 1.12): h3, card and step titles, the worktop product name (1.5 to 2rem), loop product titles at 1.2rem.
- **Lead** (Nunito 400, 1.125 to 1.35rem, 1.55): intro paragraphs in soft cocoa, max 36 to 60ch.
- **Body** (Nunito 400, 1.0625rem, 1.65): running text; tab panel content capped at 72ch.
- **UI** (Nunito 800, 1rem, 1.2): buttons, job tab labels, FAQ summaries, prices (800 at 1.05 to 1.6rem).
- **Sheet** (Nunito 400, 0.92rem, 1.35, tabular numerals): all spreadsheet content; column heads 800 at 0.8rem.
- **Label** (Nunito 800, 0.8rem, 0.12 to 0.14em, uppercase): footer column headings and filter group titles only; Arabic drops the case and tracking and sets 0.95rem.

### Named Rules
**The Serif Asks, The Sans Works Rule.** Fraunces is for questions, headings and product names. Anything a baker reads as data (sheet, facts, prices, chips, controls) is Nunito.

**The Tabular Sheet Rule.** Sheet content always uses tabular numerals so example amounts line up the way they will in the real file.

## Layout

WordPress block layout with a 720px content size and a 1200px wide size; root gutters are `clamp(1rem, 4vw, 2.5rem)` and block gap 1.25rem. Sections breathe on spacing 60 (`clamp(2.5rem, 6vw, 5rem)`) top and bottom; two consecutive unbackgrounded sections drop the second one's top padding so rhythm does not double.

Breakpoints are content-driven: 380, 480, 599, 760, 782, 860 and 899/900px. The decisive one is 900px: above it the header shows inline nav, job tabs sit in one row of four, the worktop panel is sheet (1.6fr) beside the buy column (1fr) stretched to equal height, and the shop is a 270px sticky sidebar beside the grid. Below it the nav collapses into a toggle panel, tabs become 2x2, the panel stacks, and filters fold behind a full-width toggle. Below 600px the sheet hides its wide columns, tab strip and rows after the second so the sheet and the add-to-cart button both land in the first screen; product cards become compact rows (7rem preview beside the facts).

Product grids are auto-fill at `minmax(230px, 1fr)` with gap spacing 40; card and step grids use `repeat(auto-fit, minmax(min(15rem, 100%), 1fr))`. The single product page is a two-column grid (1.05fr gallery, sticky; 1fr summary) that stacks at 860px, with the summary ordered title, short description, facts, price, button, digital notice, meta.

All spacing, insets, borders and alignment are logical properties. Physical floats from WooCommerce are flipped explicitly under `.ccs-rtl`.

## Elevation & Depth

Mostly flat. Surfaces separate by tone (cream, warm cream, white) and a 1px crumb line; shadows are warm (cocoa-tinted), diffuse, with large negative spread so they sit low under the element. Shadows answer interaction on cards and buttons; the only resting shadows belong to things that float (submenu, mobile nav panel, the worktop sheet, signup preview image, the main add-to-cart).

### Shadow Vocabulary
- **Soft** (`box-shadow: 0 18px 40px -18px rgba(59, 42, 32, 0.28)`): hover on buttons and task cards; resting on the single-product add-to-cart.
- **Lift** (`box-shadow: 0 26px 60px -26px rgba(59, 42, 32, 0.38)`): hover on product cards, the desktop submenu, the signup preview image.
- **Sheet on worktop** (`box-shadow: 0 2px 0 rgba(0, 0, 0, 0.08), 0 28px 60px -30px rgba(0, 0, 0, 0.7)`): only for the white sheet on cocoa, a paper edge plus a deep drop so it reads as a page lying on the bench.
- **Cart on worktop** (`box-shadow: 0 12px 24px -12px rgba(0, 0, 0, 0.6)`): the raspberry add-to-cart inside the hero.
- **Focus ring** (`box-shadow: 0 0 0 3px #FBF6EE, 0 0 0 5px #B8325A`): text fields on focus, with the border turning raspberry.

### Named Rules
**The Flat Until Touched Rule.** Cream-page cards rest flat on a crumb line and gain Soft or Lift only on hover. Only floating layers and the worktop sheet carry a shadow at rest.

## Shapes

Rounded, never sharp, never blobby. Controls are full pills (999px): buttons, nav links, chips, language switcher, ordering select, product tabs, the inline digital notice, pagination. Containers use 18px (cards, product cards, filter panels, notices, facts, tab panels, submenu, gallery); fields, alerts, FAQ items and filter rows use 10px; the free-tracker signup card uses 28px. The worktop sheet uses its own 14px so it reads as a document rather than a card. Product images inside cards use 12px (container radius minus 6px).

Borders are 1px crumb line for containers and 1.5px for interactive outlines (fields, chips, job tabs, product tabs). Step blocks are marked by a 2px cocoa top rule instead of a box. File-list items carry a small 28x34px document shape with a sage folded corner.

## Components

### Buttons
Confident, round, extra-bold.
- **Shape:** full pill (999px).
- **Primary:** raspberry with white text, Nunito 800 at 1rem, padding 0.85em 1.6em. WooCommerce buttons are forced to the same treatment.
- **Hover / Focus:** deep raspberry, rises 1px with the Soft shadow (0.2s ease). Focus is a 2px outline, offset 3px: cocoa on cream pages, cream on the worktop.
- **Outline:** transparent with a 2px cocoa stroke; fills cocoa with cream text on hover.
- **Sizes:** compact (0.6em 1.1em, 0.9rem) in loop rows and filters; large (1em 2.2em, 1.1rem, Soft shadow at rest) for single-product add-to-cart.
- **Added state:** a check mark mask follows the label after add-to-cart.

### Job Tabs (signature)
The four jobs on the worktop, the page's main control.
- **Style:** cream text on cocoa, 1.5px outline at cream 34%, 18px corners, min height 4.25rem; label Nunito 800 1.02rem with a 0.85rem hint in muted cream.
- **States:** hover brightens the outline to full cream with an 8% cream wash; selected (`aria-selected="true"`) fills raspberry with a cream outline. Transitions 0.25s on `cubic-bezier(0.22, 1, 0.36, 1)`.
- **Layout:** one row of four from 900px, 2x2 below; hints hidden under 600px.

### Spreadsheet Sheet (signature)
The product, shown as itself.
- **Structure:** warm-cream file bar (bold file name, butter "Example data" pill), cocoa header row with cream 800 column heads, white cells ruled in crumb line (inline-end and block-end only), cream footer row, warm-cream tab strip whose active tab is white with a 3px sage underline.
- **Cells:** butter bars for input cells, italic deep-sage formulas, status chips for status columns.
- **Motion:** on job change, rows enter top to bottom (0.42s, 55ms stagger, slight rise and clip reveal); disabled under reduced motion.
- **Content:** column heads, file names and sample rows are taken from the shipped English files and stay English in every locale; sample names are prefixed "Example:".

### Chips
- **Status chips:** pill, 0.12rem 0.55rem, Nunito 800 0.78rem, no border; sage, raspberry, butter or plain per the Status Triad Rule.
- **Filter chips:** pill with 1.5px crumb outline on cream; hover and active switch to deep-sage outline on sage cream with deep-sage text.
- **Count pills:** warm cream, soft cocoa, 0.8rem.

### Cards / Containers
- **Product card:** white, 1px crumb line, 18px corners, 0.75rem padding with a square 12px-radius image on warm cream; hover adds Lift and darkens the border toward cocoa. On phones it becomes a row; on the home index it becomes a horizontal two-up list with the button at the end.
- **Task card:** cream, crumb line, 18px, padding spacing 40, link with arrow pinned to the bottom.
- **Feedback card:** white, 18px; the placeholder variant is a 2px dashed crumb outline with an uppercase warm-cream badge and italic Fraunces text in soft cocoa.
- **Facts list:** white panel, 18px, rows of 8.5rem label (800, soft cocoa) beside value; stacks under 480px.

### Inputs / Fields
- **Style:** white, 1.5px crumb border, 10px radius, 0.8rem 1rem padding, min height 48px (44px in the price filter).
- **Focus:** border turns raspberry, outline removed, two-ring box-shadow (cream 3px, raspberry 5px).
- **Consent checkbox:** 1.1rem, raspberry accent.
- **Alerts:** 10px, sage cream with sage border for success, raspberry cream with raspberry border for error.

### Navigation
- **Header:** sticky, cream at 92% with a 10px blur and saturate, 1px crumb underline. Site title Fraunces 700 1.35rem.
- **Links:** cocoa Nunito 700 pills (0.55rem 0.9rem); hover and current get warm cream.
- **Tool buttons:** 44x44 round search, account and cart; raspberry badge on the cart count.
- **Mobile (under 900px):** outlined pill toggle with three bars that cross to an X; full-width cream panel below the header with a cocoa-tinted drop shadow and 0.8rem 1rem rows.
- **Language switcher:** small pills; the current language is a cream pill on cocoa.
- **Footer:** cocoa slab, cream links, uppercase tracked column labels at 70% opacity, a cream 18% hairline above the legal row.

### Notices
- **Digital notice:** sage-cream panel, 18px, sage 40% border, a 36px white disc holding a deep-sage SVG icon, bold first line.
- **Inline digital-only pill:** raspberry cream, full pill, centered text.
- **Digital band:** full-width sage cream with small deep-sage dot markers before each h3.

## Do's and Don'ts

### Do:
- **Do** show the template itself as proof: a white sheet with real column heads, file bar and tab strip, labelled "Example data".
- **Do** keep raspberry (#B8325A) for actions only, with deep raspberry (#932446) on hover.
- **Do** use the four status tones (sage cream, butter, raspberry cream, warm cream) exactly as the shipped files use them.
- **Do** write every inset, margin, border and alignment with logical properties, and mirror directional icons under `.ccs-rtl`.
- **Do** switch every role to Cairo under `:lang(ar)` with letter-spacing 0, body line height 1.8 and headings at 700.
- **Do** keep sheet excerpts in English in every locale while translating the surrounding copy.
- **Do** keep touch targets at 44px or more (header tools, nav toggle, filter fields, ordering select).
- **Do** use warm cocoa-tinted shadows (rgba(59, 42, 32, ...)) with negative spread, and only on hover or floating layers.

### Don't:
- **Don't** fill a full-bleed band with cocoa outside the hero worktop and the footer.
- **Don't** use sage or butter as a button or link color.
- **Don't** set sheet data, prices or controls in Fraunces.
- **Don't** invent reviews, counts or guarantees to fill a component; use the dashed placeholder card instead.
- **Don't** use physical properties (`margin-left`, `left`, `text-align: left`) in new components.
- **Don't** use neutral grey or black shadows on cream pages; black-based shadows belong only to objects lying on the cocoa worktop.
