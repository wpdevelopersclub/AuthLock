<?php namespace AuthLock\Restrict;

/**
 * Login - Access Restriction Manager
 *
 * @package     AuthLock\Restrict
 * @since       1.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @license     GPL-2.0+
 * @link        http://wpdevelopersclub.com/wordpress-plugins/authlock/
 * @copyright   2015 WP Developers Club
 */

class Login {

	/**
	 * Handles the methods upon instantiation
	 *
	 * @return  self
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize the object by hooking into the needed actions and/or filters
	 *
	 * @since  1.0.0
	 *
	 * @return null
	 */
	protected function init_hooks() {

		add_filter( 'login_errors',     array( $this, 'login_errors' ) );

		// Redirect to portal page after logging in
		add_filter( 'login_redirect',   array( $this, 'redirect_to_portal_after_login' ), 10, 3 );
	}

	/**
	 * Prevents brute-force hacking into our site by eliminating the
	 * error messages on the wp-login.php page.
	 *
	 * @since 1.0.0
	 *
	 * @param string    $error
	 * @return string Returns the new error message
	 */
	public function login_errors( $error ) {

		$new_error_message = __( 'The credentials provided are incorrect.', 'lunarwp' );
		$error             = str_replace( 'Invalid username.', $new_error_message, $error );
		$error             = preg_replace( '{The password you entered for the username <strong>.*</strong> is incorrect\.}', $new_error_message, $error );

		return $error;
	}

	/**
	 * Redirect to the portal page after logging into the network
	 *
	 * @since  1.0.0
	 *
	 * @param string $redirect_to The redirect destination URL.
	 * @param string $requested_redirect_to The requested redirect destination URL passed as a parameter.
	 * @param WP_User|WP_Error $user WP_User object if login was successful, WP_Error object otherwise.
	 *
	 * @return string  Returns the redirect portal url
	 */
	public function redirect_to_portal_after_login( $redirect_to, $requested_redirect_to, $user ) {

		// Bail out if there was an error
		if ( is_wp_error( $user ) ) {
			return $redirect_to;
		}

		// Bail out on logging out
		if ( true === $_REQUEST['loggedout'] ) {
			return $redirect_to;
		}

		return esc_url( DOMAIN_CURRENT_SITE . '/member-dashboard' );
	}

	/**
	 * Record login datetime in user meta, stored in _wpdevsclub_user_last_login
	 *
	 * @since  1.0.0
	 *
	 * @param string $redirect_to The redirect destination URL.
	 * @param string $requested_redirect_to The requested redirect destination URL passed as a parameter.
	 * @param WP_User|WP_Error $user WP_User object if login was successful, WP_Error object otherwise.
	 *
	 * @return string                                   Returns unaltered $redirect_to
	 */
	public function record_login_datetime( $redirect_to, $requested_redirect_to, $user ) {
		if ( ! is_wp_error( $user ) && is_object( $user ) && isset( $user->ID ) ) {
			update_user_meta( $user->ID, '_wpdevsclub_user_last_login', current_time( 'mysql' ) );
		}
	}
}