<?php
/**
 * Shop settings screen (business details and editable site-wide text).
 *
 * @package CrumbCoToolkit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Field definitions.
 *
 * @return array
 */
function ccs_settings_fields() {
	return array(
		'business_name'     => array( 'label' => __( 'Business name', 'crumb-co-toolkit' ), 'type' => 'text', 'translate' => false, 'help' => __( 'Shown in the footer copyright line. Leave empty to use "Crumb & Co. Studio".', 'crumb-co-toolkit' ) ),
		'support_email'     => array( 'label' => __( 'Support email', 'crumb-co-toolkit' ), 'type' => 'email', 'translate' => false, 'help' => __( 'Shown on the Contact page and used in download notices. Defaults to the site admin email.', 'crumb-co-toolkit' ) ),
		'contact_recipient' => array( 'label' => __( 'Contact form recipient', 'crumb-co-toolkit' ), 'type' => 'email', 'translate' => false, 'help' => __( 'Where contact form messages are sent. Defaults to the support email.', 'crumb-co-toolkit' ) ),
		'announcement'      => array( 'label' => __( 'Announcement bar text', 'crumb-co-toolkit' ), 'type' => 'text', 'translate' => true, 'help' => __( 'Leave empty to use the built-in translated text.', 'crumb-co-toolkit' ) ),
		'footer_blurb'      => array( 'label' => __( 'Footer description', 'crumb-co-toolkit' ), 'type' => 'textarea', 'translate' => true, 'help' => __( 'Leave empty to use the built-in translated text.', 'crumb-co-toolkit' ) ),
		'free_sample_url'   => array( 'label' => __( 'Free sample file URL', 'crumb-co-toolkit' ), 'type' => 'url', 'translate' => false, 'help' => __( 'Link shown after someone joins the email list. Leave empty to use the included one-page order tracker PDF.', 'crumb-co-toolkit' ) ),
		'simplify_checkout' => array( 'label' => __( 'Simplify classic checkout', 'crumb-co-toolkit' ), 'type' => 'checkbox', 'translate' => false, 'help' => __( 'Hide street address fields when the cart only contains digital products (classic checkout only; for the Checkout block, toggle fields in the block settings).', 'crumb-co-toolkit' ) ),
		// --- Search & sharing (Google Search Central recommendations) ---
		'share_image_url'     => array( 'section' => __( 'Search & sharing', 'crumb-co-toolkit' ), 'label' => __( 'Default share image URL', 'crumb-co-toolkit' ), 'type' => 'url', 'translate' => false, 'help' => __( 'Image used when a page without its own image is shared (1200 × 630 px). Leave empty to use the included Crumb & Co. image.', 'crumb-co-toolkit' ) ),
		'social_profiles'     => array( 'label' => __( 'Social profile URLs', 'crumb-co-toolkit' ), 'type' => 'urls', 'translate' => false, 'help' => __( 'One URL per line (Instagram, Pinterest…). Added to your Organization structured data so Google can connect your profiles to the shop.', 'crumb-co-toolkit' ) ),
		'google_verification' => array( 'label' => __( 'Google Search Console verification code', 'crumb-co-toolkit' ), 'type' => 'verification', 'translate' => false, 'help' => __( 'Paste the code (or the whole meta tag) from Search Console → Add property → HTML tag. Not needed if you verify with Site Kit or DNS.', 'crumb-co-toolkit' ) ),
		'bing_verification'   => array( 'label' => __( 'Bing Webmaster Tools verification code', 'crumb-co-toolkit' ), 'type' => 'verification', 'translate' => false, 'help' => __( 'Optional. Paste the msvalidate.01 code or meta tag.', 'crumb-co-toolkit' ) ),
		'return_policy'       => array( 'label' => __( 'Return policy (structured data)', 'crumb-co-toolkit' ), 'type' => 'select', 'translate' => false, 'options' => array( '' => __( 'Not set — do not output', 'crumb-co-toolkit' ), 'MerchantReturnNotPermitted' => __( 'No returns/refunds', 'crumb-co-toolkit' ), 'MerchantReturnFiniteReturnWindow' => __( 'Refunds within a number of days', 'crumb-co-toolkit' ) ), 'help' => __( 'Must match your Digital Download & Refund Policy page. Google shows return information in shopping results.', 'crumb-co-toolkit' ) ),
		'return_days'         => array( 'label' => __( 'Refund window (days)', 'crumb-co-toolkit' ), 'type' => 'number', 'translate' => false, 'help' => __( 'Only used with "Refunds within a number of days".', 'crumb-co-toolkit' ) ),
		'return_countries'    => array( 'label' => __( 'Countries the policy applies to', 'crumb-co-toolkit' ), 'type' => 'text', 'translate' => false, 'help' => __( 'Two-letter country codes separated by commas, e.g. FR, BE, ES, MA. Required by Google for return policy markup.', 'crumb-co-toolkit' ) ),
	);
}

add_action( 'admin_init', function () {
	register_setting( 'ccs_settings', 'ccs_settings', array(
		'type'              => 'array',
		'sanitize_callback' => function ( $input ) {
			$out = array();
			foreach ( ccs_settings_fields() as $key => $field ) {
				$val = isset( $input[ $key ] ) ? wp_unslash( $input[ $key ] ) : '';
				switch ( $field['type'] ) {
					case 'urls':
						$lines       = array_filter( array_map( 'esc_url_raw', array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $val ) ) ) );
						$out[ $key ] = implode( "\n", $lines );
						break;
					case 'verification':
						$val = (string) $val;
						if ( preg_match( '/content=["\']([^"\']+)["\']/', $val, $m ) ) {
							$val = $m[1];
						}
						$out[ $key ] = preg_replace( '/[^A-Za-z0-9_\-]/', '', $val );
						break;
					case 'select':
						$out[ $key ] = array_key_exists( $val, $field['options'] ) ? $val : '';
						break;
					case 'number':
						$out[ $key ] = '' === trim( (string) $val ) ? '' : (string) absint( $val );
						break;
					case 'email':
						$out[ $key ] = sanitize_email( $val );
						break;
					case 'url':
						$out[ $key ] = esc_url_raw( $val );
						break;
					case 'textarea':
						$out[ $key ] = sanitize_textarea_field( $val );
						break;
					case 'checkbox':
						$out[ $key ] = $val ? '1' : '0';
						break;
					default:
						$out[ $key ] = sanitize_text_field( $val );
				}
			}
			return $out;
		},
	) );
} );

/**
 * Register editable text with Polylang (Languages → Translations).
 */
add_action( 'init', function () {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}
	foreach ( ccs_settings_fields() as $key => $field ) {
		if ( $field['translate'] && '' !== ccs_option( $key ) ) {
			pll_register_string( 'ccs_' . $key, ccs_option( $key ), 'Crumb & Co.', 'textarea' === $field['type'] );
		}
	}
} );

/**
 * Feed the theme's editable strings.
 */
add_filter( 'crumb_co_text', function ( $value, $key ) {
	if ( in_array( $key, array( 'announcement', 'footer_blurb', 'business_name' ), true ) ) {
		$opt = 'business_name' === $key ? ccs_option( $key ) : ccs_option_t( $key );
		return '' !== $opt ? $opt : $value;
	}
	return $value;
}, 10, 2 );

/**
 * Render the settings page.
 */
function ccs_render_settings_page() {
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Crumb & Co. shop settings', 'crumb-co-toolkit' ); ?></h1>
		<p><?php esc_html_e( 'Business details and site-wide text. Page content, products and prices are edited in Pages and Products as usual.', 'crumb-co-toolkit' ); ?></p>
		<?php if ( function_exists( 'pll_register_string' ) ) : ?>
			<p><em><?php esc_html_e( 'Polylang is active: after saving, translate the text fields under Languages → Translations (group "Crumb & Co.").', 'crumb-co-toolkit' ); ?></em></p>
		<?php endif; ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'ccs_settings' ); ?>
			<table class="form-table" role="presentation">
				<?php foreach ( ccs_settings_fields() as $key => $field ) : ?>
					<?php if ( ! empty( $field['section'] ) ) : ?>
						<tr><th colspan="2"><h2 style="margin:1em 0 0"><?php echo esc_html( $field['section'] ); ?></h2></th></tr>
					<?php endif; ?>
					<tr>
						<th scope="row"><label for="ccs-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
						<td>
							<?php
							$name  = 'ccs_settings[' . $key . ']';
							$value = ccs_option( $key );
							if ( 'select' === $field['type'] ) {
								printf( '<select id="ccs-%1$s" name="%2$s">', esc_attr( $key ), esc_attr( $name ) );
								foreach ( $field['options'] as $opt => $label ) {
									printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $opt ), selected( $value, $opt, false ), esc_html( $label ) );
								}
								echo '</select>';
							} elseif ( 'textarea' === $field['type'] || 'urls' === $field['type'] ) {
								printf( '<textarea class="large-text" rows="3" id="ccs-%1$s" name="%2$s">%3$s</textarea>', esc_attr( $key ), esc_attr( $name ), esc_textarea( $value ) );
							} elseif ( 'checkbox' === $field['type'] ) {
								printf( '<input type="checkbox" id="ccs-%1$s" name="%2$s" value="1" %3$s />', esc_attr( $key ), esc_attr( $name ), checked( '1', $value, false ) );
							} else {
								$type = in_array( $field['type'], array( 'email', 'url', 'number' ), true ) ? $field['type'] : 'text';
								printf( '<input type="%4$s" class="regular-text" id="ccs-%1$s" name="%2$s" value="%3$s" />', esc_attr( $key ), esc_attr( $name ), esc_attr( $value ), esc_attr( $type ) );
							}
							?>
							<p class="description"><?php echo esc_html( $field['help'] ); ?></p>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			<?php submit_button(); ?>
		</form>
		<hr />
		<h2><?php esc_html_e( 'Payments', 'crumb-co-toolkit' ); ?></h2>
		<p><?php esc_html_e( 'Payment providers are not configured by this plugin. Enable and connect one (for example WooPayments, Stripe or PayPal) in WooCommerce → Settings → Payments, then update the payment placeholders on the FAQ, Privacy Policy and Terms pages.', 'crumb-co-toolkit' ); ?></p>
		<p><a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout' ) ); ?>"><?php esc_html_e( 'Open payment settings', 'crumb-co-toolkit' ); ?></a></p>
	</div>
	<?php
}
