<?php namespace AuthLock\Admin;

/**
 * Media
 *
 * @package     AuthLock\Admin
 * @since       1.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @license     GPL-2.0+
 * @link        http://wpdevelopersclub.com/wordpress-plugins/authlock/
 * @copyright   2015 WP Developers Club
 */

class Media {

	/**
	 * Restrict by user role
	 *
	 * @var booean
	 */
	protected $restrict_by_user_role = false;

	/***************************
	 * Instantiate & Initialize
	 **************************/

	/**
	 * Handles the methods upon instantiation
	 *
	 * @since 1.0.0
	 *
	 * @param boolean   $restrict_by_user_role     Set to true to restrict by user role;
	 *                                              else restricts by user ID
	 * @return  self
	 */
	public function __construct( $restrict_by_user_role = false ) {

		$this->restrict_by_user_role = $restrict_by_user_role;

		$this->init_events();
	}

	/**
	 * Initialize Events
	 *
	 * @since 1.0.1
	 *
	 * @return null
	 */
	protected function init_events() {
		add_action( 'admin_init', function() {

			if ( ! current_user_can( 'manage_options' ) ) {
				add_filter( 'posts_where', array( $this, 'build_media_library_where_sql' ) );
			}
		} );
	}

	/***************************
	 * Callbacks
	 **************************/

	/**
	 * Build the WHERE SQL for the Media Library based on user role
	 *
	 * @since 1.0.0
	 *
	 * @param string $where_sql
	 * @return string
	 */
	public function build_media_library_where_sql( $where_sql ) {
		if ( ! isset( $_POST['action'] ) || 'query-attachments' != $_POST['action'] ) {
			return $where_sql;
		}

		$user_ids = $this->restrict_by_user_role
			// Get all the user IDs for this current user's role
			? $this->get_user_ids_based_on_current_user_role()
			// Get current user id
			: array( get_current_user_id() );

		// Bail out if we do not have the IDs
		if ( false === $user_ids ) {
			return $where_sql;
		}

		$this->sanitize_user_ids( $user_ids );

		// Modify the WHERE SQL statement and return
		return sprintf( '%s AND post_author IN ( %s )',
			$where_sql,
			implode( ',', $user_ids )
		);
	}

	/***************************
	 * Helpers
	 **************************/

	/**
	 * Get all of the user IDs based on the current user's role
	 *
	 * @since 1.0.0
	 *
	 * @return array|bool
	 */
	protected function get_user_ids_based_on_current_user_role() {

		global $current_user;

		$user_ids = get_users( array(
			'role'      => $current_user->roles[0],
			'orderby'   => 'ID',
			'fields'    => 'ID',
		) );

		return is_array( $user_ids ) && ! empty( $user_ids ) ? $user_ids : false;
	}

	/**
	 * Sanitize the user IDs
	 *
	 * @since 1.0.0
	 *
	 * @param array     $user_ids   Passed by reference
	 */
	protected function sanitize_user_ids( array &$user_ids ) {

		global $wpdb;

		foreach ( $user_ids as $key => $id ) {
			$user_ids[ $key ] = $wpdb->prepare( '%d', $id );
		}
	}
}