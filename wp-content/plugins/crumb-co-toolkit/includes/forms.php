<?php
/**
 * Forms: [crumb_signup] email list + free sample, [crumb_contact] contact form, [crumb_support_email].
 *
 * Subscribers are stored privately in WordPress (Crumb & Co. → Subscribers) and can be exported as CSV.
 * To send newsletters, connect an email service: hook into `crumb_co_new_subscriber` or import the CSV.
 *
 * @package CrumbCoToolkit
 */

defined( 'ABSPATH' ) || exit;

/* ---------- Subscribers storage ---------- */

add_action( 'init', function () {
	register_post_type( 'ccs_subscriber', array(
		'labels'          => array(
			'name'          => __( 'Subscribers', 'crumb-co-toolkit' ),
			'singular_name' => __( 'Subscriber', 'crumb-co-toolkit' ),
			'menu_name'     => __( 'Subscribers', 'crumb-co-toolkit' ),
		),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => 'ccs-setup',
		'supports'        => array( 'title' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
} );

add_filter( 'manage_ccs_subscriber_posts_columns', function ( $cols ) {
	return array(
		'cb'         => $cols['cb'],
		'title'      => __( 'Email', 'crumb-co-toolkit' ),
		'ccs_lang'   => __( 'Language', 'crumb-co-toolkit' ),
		'ccs_source' => __( 'Source', 'crumb-co-toolkit' ),
		'date'       => __( 'Joined', 'crumb-co-toolkit' ),
	);
} );
add_action( 'manage_ccs_subscriber_posts_custom_column', function ( $col, $post_id ) {
	if ( 'ccs_lang' === $col ) {
		echo esc_html( get_post_meta( $post_id, '_ccs_lang', true ) );
	} elseif ( 'ccs_source' === $col ) {
		echo esc_html( get_post_meta( $post_id, '_ccs_source', true ) );
	}
}, 10, 2 );

// CSV export button on the Subscribers screen.
add_action( 'manage_posts_extra_tablenav', function ( $which ) {
	if ( 'top' === $which && 'ccs_subscriber' === get_current_screen()->post_type ) {
		$url = wp_nonce_url( admin_url( 'admin-post.php?action=ccs_export_subscribers' ), 'ccs_export' );
		echo '<div class="alignleft actions"><a class="button" href="' . esc_url( $url ) . '">' . esc_html__( 'Export CSV', 'crumb-co-toolkit' ) . '</a></div>';
	}
} );
add_action( 'admin_post_ccs_export_subscribers', function () {
	if ( ! current_user_can( 'manage_woocommerce' ) || ! check_admin_referer( 'ccs_export' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'crumb-co-toolkit' ) );
	}
	$posts = get_posts( array( 'post_type' => 'ccs_subscriber', 'post_status' => 'private', 'numberposts' => -1 ) );
	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=subscribers-' . gmdate( 'Y-m-d' ) . '.csv' );
	$out = fopen( 'php://output', 'w' );
	fputcsv( $out, array( 'email', 'language', 'source', 'consent_text', 'joined_utc' ) );
	foreach ( $posts as $p ) {
		fputcsv( $out, array( $p->post_title, get_post_meta( $p->ID, '_ccs_lang', true ), get_post_meta( $p->ID, '_ccs_source', true ), get_post_meta( $p->ID, '_ccs_consent', true ), $p->post_date_gmt ) );
	}
	fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	exit;
} );

// Personal data exporter / eraser (Tools → Export/Erase Personal Data).
add_filter( 'wp_privacy_personal_data_exporters', function ( $exporters ) {
	$exporters['crumb-co-subscribers'] = array(
		'exporter_friendly_name' => __( 'Crumb & Co. email list', 'crumb-co-toolkit' ),
		'callback'               => function ( $email ) {
			$data = array();
			foreach ( get_posts( array( 'post_type' => 'ccs_subscriber', 'post_status' => 'private', 'title' => $email, 'numberposts' => 1 ) ) as $p ) {
				$data[] = array(
					'group_id'    => 'ccs-subscribers',
					'group_label' => __( 'Email list', 'crumb-co-toolkit' ),
					'item_id'     => 'ccs-sub-' . $p->ID,
					'data'        => array(
						array( 'name' => __( 'Email', 'crumb-co-toolkit' ), 'value' => $p->post_title ),
						array( 'name' => __( 'Joined', 'crumb-co-toolkit' ), 'value' => $p->post_date ),
					),
				);
			}
			return array( 'data' => $data, 'done' => true );
		},
	);
	return $exporters;
} );
add_filter( 'wp_privacy_personal_data_erasers', function ( $erasers ) {
	$erasers['crumb-co-subscribers'] = array(
		'eraser_friendly_name' => __( 'Crumb & Co. email list', 'crumb-co-toolkit' ),
		'callback'             => function ( $email ) {
			$removed = false;
			foreach ( get_posts( array( 'post_type' => 'ccs_subscriber', 'post_status' => 'private', 'title' => $email, 'numberposts' => -1 ) ) as $p ) {
				$removed = (bool) wp_delete_post( $p->ID, true ) || $removed;
			}
			return array( 'items_removed' => $removed, 'items_retained' => false, 'messages' => array(), 'done' => true );
		},
	);
	return $erasers;
} );

/* ---------- Shared helpers ---------- */

/**
 * Simple per-visitor rate limit (hashed IP, no raw IP stored).
 *
 * @param string $action Action key.
 * @param int    $max    Max attempts per hour.
 * @return bool True if allowed.
 */
function ccs_rate_ok( $action, $max = 5 ) {
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key = 'ccs_rl_' . $action . '_' . substr( hash_hmac( 'sha256', $ip, wp_salt() ), 0, 20 );
	$n   = (int) get_transient( $key );
	if ( $n >= $max ) {
		return false;
	}
	set_transient( $key, $n + 1, HOUR_IN_SECONDS );
	return true;
}

/**
 * Redirect back to the form with a status flag.
 *
 * @param string $param  Query arg.
 * @param string $status Status.
 * @param string $anchor Anchor.
 */
function ccs_back( $param, $status, $anchor ) {
	$ref = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$ref = remove_query_arg( array( 'ccs_signup', 'ccs_contact' ), $ref );
	wp_safe_redirect( add_query_arg( $param, $status, $ref ) . '#' . $anchor );
	exit;
}

/**
 * Free sample URL.
 *
 * @return string
 */
function ccs_free_sample_url() {
	$url = ccs_option( 'free_sample_url' );
	return $url ? $url : CCS_URL . 'assets/downloads/free-one-page-order-tracker.pdf';
}

/* ---------- [crumb_signup] ---------- */

add_shortcode( 'crumb_signup', function () {
	$status = isset( $_GET['ccs_signup'] ) ? sanitize_key( $_GET['ccs_signup'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	ob_start();
	echo '<div class="ccs-signup-form" id="ccs-signup">';
	if ( 'ok' === $status ) {
		echo '<div class="ccs-alert ccs-alert--success" role="status">' . esc_html__( 'Thank you for joining! Your free one-page order tracker is ready.', 'crumb-co-toolkit' )
			. '<br /><a class="wp-element-button" href="' . esc_url( ccs_free_sample_url() ) . '" download>' . esc_html__( 'Download the free tracker (PDF)', 'crumb-co-toolkit' ) . '</a></div>';
	} elseif ( $status ) {
		$messages = array(
			'invalid' => __( 'Please enter a valid email address and tick the consent box.', 'crumb-co-toolkit' ),
			'limit'   => __( 'Too many attempts. Please try again later.', 'crumb-co-toolkit' ),
			'error'   => __( 'Something went wrong. Please try again.', 'crumb-co-toolkit' ),
		);
		$msg = isset( $messages[ $status ] ) ? $messages[ $status ] : $messages['error'];
		echo '<div class="ccs-alert ccs-alert--error" role="alert">' . esc_html( $msg ) . '</div>';
	}
	if ( 'ok' !== $status ) :
		?>
		<form class="ccs-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="ccs_signup" />
			<input type="hidden" name="ccs_lang" value="<?php echo esc_attr( ccs_current_lang() ); ?>" />
			<?php wp_nonce_field( 'ccs_signup', 'ccs_nonce' ); ?>
			<div class="ccs-form__hp" aria-hidden="true"><label for="ccs-website"><?php esc_html_e( 'Leave this field empty', 'crumb-co-toolkit' ); ?></label><input type="text" id="ccs-website" name="ccs_website" tabindex="-1" autocomplete="off" /></div>
			<label for="ccs-signup-email" class="screen-reader-text"><?php esc_html_e( 'Email address', 'crumb-co-toolkit' ); ?></label>
			<div class="ccs-form__row">
				<input type="email" id="ccs-signup-email" name="ccs_email" required autocomplete="email" placeholder="<?php esc_attr_e( 'Your email address', 'crumb-co-toolkit' ); ?>" />
				<button type="submit" class="wp-element-button"><?php esc_html_e( 'Send me the free tracker', 'crumb-co-toolkit' ); ?></button>
			</div>
			<div class="ccs-form__consent">
				<input type="checkbox" id="ccs-signup-consent" name="ccs_consent" value="1" required />
				<label for="ccs-signup-consent"><?php echo esc_html( ccs_consent_text() ); ?></label>
			</div>
			<p class="ccs-small"><?php
				printf(
					/* translators: %s: privacy policy URL */
					wp_kses_post( __( 'Unsubscribe any time. Read our <a href="%s">privacy policy</a>.', 'crumb-co-toolkit' ) ),
					esc_url( function_exists( 'crumb_co_page_url' ) ? crumb_co_page_url( 'privacy-policy' ) : get_privacy_policy_url() )
				);
			?></p>
		</form>
		<?php
	endif;
	echo '</div>';
	return ob_get_clean();
} );

/**
 * Consent wording (also saved with each subscriber).
 *
 * @return string
 */
function ccs_consent_text() {
	return __( 'Yes, email me the free tracker and occasional updates about new tools from Crumb & Co. Studio.', 'crumb-co-toolkit' );
}

add_action( 'admin_post_nopriv_ccs_signup', 'ccs_handle_signup' );
add_action( 'admin_post_ccs_signup', 'ccs_handle_signup' );

/**
 * Handle signup.
 */
function ccs_handle_signup() {
	if ( ! isset( $_POST['ccs_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ccs_nonce'] ) ), 'ccs_signup' ) ) {
		ccs_back( 'ccs_signup', 'error', 'ccs-signup' );
	}
	if ( ! empty( $_POST['ccs_website'] ) ) { // Honeypot: pretend success.
		ccs_back( 'ccs_signup', 'ok', 'ccs-signup' );
	}
	if ( ! ccs_rate_ok( 'signup', 5 ) ) {
		ccs_back( 'ccs_signup', 'limit', 'ccs-signup' );
	}
	$email = isset( $_POST['ccs_email'] ) ? sanitize_email( wp_unslash( $_POST['ccs_email'] ) ) : '';
	if ( ! is_email( $email ) || empty( $_POST['ccs_consent'] ) ) {
		ccs_back( 'ccs_signup', 'invalid', 'ccs-signup' );
	}
	$lang     = isset( $_POST['ccs_lang'] ) ? sanitize_key( wp_unslash( $_POST['ccs_lang'] ) ) : 'en';
	$existing = get_posts( array( 'post_type' => 'ccs_subscriber', 'post_status' => 'private', 'title' => $email, 'numberposts' => 1, 'fields' => 'ids' ) );
	if ( ! $existing ) {
		$id = wp_insert_post( array( 'post_type' => 'ccs_subscriber', 'post_status' => 'private', 'post_title' => $email ), true );
		if ( is_wp_error( $id ) ) {
			ccs_back( 'ccs_signup', 'error', 'ccs-signup' );
		}
		update_post_meta( $id, '_ccs_lang', $lang );
		update_post_meta( $id, '_ccs_source', 'free-sample' );
		update_post_meta( $id, '_ccs_consent', ccs_consent_text() );
		/**
		 * Fires when someone joins the list. Use it to send the address to your email service.
		 *
		 * @param string $email Email.
		 * @param string $lang  Language slug.
		 */
		do_action( 'crumb_co_new_subscriber', $email, $lang );
	}
	ccs_back( 'ccs_signup', 'ok', 'ccs-signup' );
}

/* ---------- [crumb_contact] ---------- */

add_shortcode( 'crumb_contact', function () {
	$status = isset( $_GET['ccs_contact'] ) ? sanitize_key( $_GET['ccs_contact'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	ob_start();
	echo '<div class="ccs-contact-form" id="ccs-contact">';
	if ( 'sent' === $status ) {
		echo '<div class="ccs-alert ccs-alert--success" role="status">' . esc_html__( 'Thanks — your message has been sent. We will reply by email.', 'crumb-co-toolkit' ) . '</div>';
	} elseif ( $status ) {
		$messages = array(
			'invalid' => __( 'Please fill in your name, a valid email address and a message.', 'crumb-co-toolkit' ),
			'limit'   => __( 'Too many messages. Please try again later or email us directly.', 'crumb-co-toolkit' ),
			'error'   => __( 'Your message could not be sent. Please email us directly.', 'crumb-co-toolkit' ),
		);
		echo '<div class="ccs-alert ccs-alert--error" role="alert">' . esc_html( isset( $messages[ $status ] ) ? $messages[ $status ] : $messages['error'] ) . '</div>';
	}
	?>
	<form class="ccs-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="ccs_contact" />
		<?php wp_nonce_field( 'ccs_contact', 'ccs_nonce' ); ?>
		<div class="ccs-form__hp" aria-hidden="true"><label for="ccs-company"><?php esc_html_e( 'Leave this field empty', 'crumb-co-toolkit' ); ?></label><input type="text" id="ccs-company" name="ccs_company" tabindex="-1" autocomplete="off" /></div>
		<div class="ccs-field"><label for="ccs-name"><?php esc_html_e( 'Your name', 'crumb-co-toolkit' ); ?></label><input type="text" id="ccs-name" name="ccs_name" required autocomplete="name" /></div>
		<div class="ccs-field"><label for="ccs-email"><?php esc_html_e( 'Email address', 'crumb-co-toolkit' ); ?></label><input type="email" id="ccs-email" name="ccs_email" required autocomplete="email" /></div>
		<div class="ccs-field"><label for="ccs-order"><?php esc_html_e( 'Order number (optional)', 'crumb-co-toolkit' ); ?></label><input type="text" id="ccs-order" name="ccs_order" /></div>
		<div class="ccs-field"><label for="ccs-message"><?php esc_html_e( 'Message', 'crumb-co-toolkit' ); ?></label><textarea id="ccs-message" name="ccs_message" rows="6" required></textarea></div>
		<p class="ccs-small"><?php esc_html_e( 'We only use these details to reply to you.', 'crumb-co-toolkit' ); ?></p>
		<div><button type="submit" class="wp-element-button"><?php esc_html_e( 'Send message', 'crumb-co-toolkit' ); ?></button></div>
	</form>
	<?php
	echo '</div>';
	return ob_get_clean();
} );

add_action( 'admin_post_nopriv_ccs_contact', 'ccs_handle_contact' );
add_action( 'admin_post_ccs_contact', 'ccs_handle_contact' );

/**
 * Handle contact form.
 */
function ccs_handle_contact() {
	if ( ! isset( $_POST['ccs_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ccs_nonce'] ) ), 'ccs_contact' ) ) {
		ccs_back( 'ccs_contact', 'error', 'ccs-contact' );
	}
	if ( ! empty( $_POST['ccs_company'] ) ) {
		ccs_back( 'ccs_contact', 'sent', 'ccs-contact' );
	}
	if ( ! ccs_rate_ok( 'contact', 5 ) ) {
		ccs_back( 'ccs_contact', 'limit', 'ccs-contact' );
	}
	$name    = isset( $_POST['ccs_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ccs_name'] ) ) : '';
	$email   = isset( $_POST['ccs_email'] ) ? sanitize_email( wp_unslash( $_POST['ccs_email'] ) ) : '';
	$order   = isset( $_POST['ccs_order'] ) ? sanitize_text_field( wp_unslash( $_POST['ccs_order'] ) ) : '';
	$message = isset( $_POST['ccs_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ccs_message'] ) ) : '';
	if ( '' === $name || ! is_email( $email ) || '' === $message ) {
		ccs_back( 'ccs_contact', 'invalid', 'ccs-contact' );
	}
	$to = ccs_option( 'contact_recipient' );
	$to = is_email( $to ) ? $to : ccs_support_email();
	/* translators: %s: sender name */
	$subject = sprintf( __( '[Contact] Message from %s', 'crumb-co-toolkit' ), $name );
	$body    = sprintf( "%s: %s\n%s: %s\n%s: %s\n\n%s", __( 'Name', 'crumb-co-toolkit' ), $name, __( 'Email', 'crumb-co-toolkit' ), $email, __( 'Order', 'crumb-co-toolkit' ), $order ? $order : '-', $message );
	$sent    = wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );
	ccs_back( 'ccs_contact', $sent ? 'sent' : 'error', 'ccs-contact' );
}

/* ---------- [crumb_support_email] ---------- */

add_shortcode( 'crumb_support_email', function () {
	$email = ccs_support_email();
	return '<a href="mailto:' . esc_attr( antispambot( $email ) ) . '">' . esc_html( antispambot( $email ) ) . '</a>';
} );
