<?php namespace AuthLock\Restrict;

/**
 * Page - Handles Access Restrictions for a Webpage
 *
 * @package     AuthLock\Restrict
 * @since       1.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @license     GPL-2.0+
 * @link        http://wpdevelopersclub.com/wordpress-plugins/authlock/
 * @copyright   2015 WP Developers Club
 */

class Page {

	/***************************
	 * Instantiate & Initialize
	 **************************/

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
		add_action( 'wp_head', array( $this, 'check_viewer_has_minimum_access' ) );
	}

	/***************************
	 * Callbacks
	 **************************/

	/**
	 * Check the page's security against the viewer's access role
	 *
	 * Pulls the page's security option (from meta)
	 * If the viewer does not have rights, he/she is redirected to home_url()
	 *
	 * @since  1.0.0
	 *
	 * @return null
	 */
	public function check_viewer_has_minimum_access() {
		if ( $this->is_ok_to_redirect() ) {
			ob_start();

			$this->redirect_to_portal();

			$this->redirect_to_home();
		}
	}

	/***************************
	 * Helpers
	 **************************/

	/**
	 * Checks if it's Ok to redirect
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	protected function is_ok_to_redirect() {
		if ( is_admin() || is_home() || is_front_page() ) {
			return false;
		}

		global $post;

		if ( ! is_object( $post ) ) {
			return false;
		}

		$page_access = wpdevsclub_get_access_level( $post->ID );
		if ( empty( $page_access ) || 'public' == $page_access || is_user_logged_in() ) {
			return false;
		}

		return true;
	}

	/**
	 * Redirect back to the member's dashboard
	 *
	 * @since 1.1.0
	 *
	 * @return null
	 */
	protected function redirect_to_portal() {
		if ( is_page( 'member-dashboard' ) ) {
			wp_redirect( esc_url( DOMAIN_CURRENT_SITE . '/wp-login.php' ) );
			exit;
		}
	}

	/**
	 * Redirect back to the home page
	 *
	 * @since 1.1.0
	 *
	 * @return null
	 */
	protected function redirect_to_home() {
		wp_redirect( esc_url( DOMAIN_CURRENT_SITE ) );
		exit;
	}

}