<?php namespace AuthLock\Restrict;

/**
 * Restrict Menu
 *
 * @package     AuthLock\Restrict
 * @since       1.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @license     GPL-2.0+
 * @link        http://wpdevelopersclub.com/wordpress-plugins/authlock/
 * @copyright   2015 WP Developers Club
 */

class Menu {

	/**
	 * Handles the methods upon instantiation
	 *
	 * @return  self
	 */
	public function __construct() {
		$this->init_hooks();
	}

	protected function init_hooks() {

		// add custom menu fields to menu
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_nav_item' ) );

		// save menu custom fields
		add_action( 'wp_update_nav_menu_item', array( $this, 'update_nav_item' ), 10, 3 );

		// edit menu walker
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'nav_walker' ), 10, 2 );

		//
		add_filter( 'walker_nav_menu_start_el', array( $this, 'check_access_level_for_menu_item' ), 10, 4 );

	}

	/**
	 * Add the new custom field "Access Level" to the $menu_item (will be used in the Walker)
	 *
	 * @since  1.0.0
	 *
	 * @param stdObj $menu_item Menu item
	 * @return stdObj           Returns the amended menu item
	 */
	public function add_nav_item( $menu_item ) {
		$access_level               = get_post_meta( $menu_item->ID, '_authlock_menu_access_level', true );
		$menu_item->access_level    = $access_level ? $access_level : 'public';

		return $menu_item;
	}

	/**
	 * Verify the menu item's access level against the current user
	 *
	 * @since  1.0.0
	 *
	 * The menu item's starting output only includes $args->before, the opening <a>,
	 * the menu item's title, the closing </a>, and $args->after. Currently, there is
	 * no filter for modifying the opening and closing <li> for a menu item.
	 *
	 * @since 1.0.0
	 *
	 * @see wp_nav_menu()
	 *
	 * @param string $item_output The menu item's starting HTML output.
	 * @param object $item        Menu item data object.
	 * @param int    $depth       Depth of menu item. Used for padding.
	 * @param array  $args        An array of wp_nav_menu() arguments.
	 * @return string
	 */
	public function check_access_level_for_menu_item( $item_output, $item, $depth, $args ) {
		$access_level = isset( $item->access_level ) ? $item->access_level : 'public';

		if ( 'public' == $access_level ) {
			return $item_output;
		}

		if ( 'member' == $access_level ) {
			return is_user_logged_in() ? $item_output : '';
		}

		if ( 'not_logged_in' == $access_level ) {
			return ! is_user_logged_in() ? $item_output : '';
		}

		return $item_output;
	}

	/**
	 * Save the custom field
	 *
	 * @since  1.0.0
	 *
	 * @param  integer $menu_id         Menu's ID
	 * @param  integer $menu_item_db_id Menu item's ID
	 * @param  array $menu_item_data    Menu item's data
	 * @return void
	 */
	public function update_nav_item( $menu_id, $menu_item_db_id, $menu_item_data ) {
		// Bail out if this menu does not have the access level field
		if ( ! is_array( $_REQUEST['menu-item-access-level'] ) ) {
			return;
		}

		$access_level = strip_tags( $_REQUEST['menu-item-access-level'][$menu_item_db_id] );
		update_post_meta( $menu_item_db_id, '_authlock_menu_access_level', $access_level );
	}

	/**
	 * Define the new Walker callback
	 *
	 * @since  1.0.0
	 *
	 * @param  string $walker   Name of the current Walker
	 * @param  integer $menu_id Menu's ID
	 * @return string           New Walker_Limited_Access_Nav
	 */
	public function nav_walker( $walker, $menu_id ) {
		return '\AuthLock\Restrict\Restrict_Menu_Walker';
	}

}