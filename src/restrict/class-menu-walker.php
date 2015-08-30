<?php namespace AuthLock\Restrict;

/**
 * Restrict Menu Walker
 *
 * @package     AuthLock\Restrict
 * @since       1.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @license     GPL-2.0+
 * @link        http://wpdevelopersclub.com/wordpress-plugins/authlock/
 * @copyright   2015 WP Developers Club
 */

use WPDevsClub_Core\Config\Factory;
use Walker_Nav_Menu_Edit;

class Restrict_Menu_Walker extends Walker_Nav_Menu_Edit {

	protected $insert_position;

	/**
	 * Instance of the Config parameters
	 *
	 * @var I_Config
	 */
	protected $config;

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker_Nav_Menu::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * As there is no hook, this is a direct copy of the start_el() method
	 * with the new custom field added into it.
	 *
	 * Start the element output.
	 *
	 * @see Walker_Nav_Menu_Edit::start_el()
	 *
	 * @since 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if ( empty( $this->config ) ) {
			$this->init_config();
		}

		parent::start_el( $output, $item, $depth, $args, $id );
		$this->render( $output, $item, $depth, $args, $id );
	}

	/**
	 * Initialize the configuration parameters
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_config() {
		$this->config = Factory::create( AUTHLOCK_PLUGIN_DIR . 'config/admin/menu-walker.php' );
	}

	/**
	 * Render the menu HTML
	 *
	 * @since 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	protected function render( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$item_id = esc_attr( $item->ID );

		$start_pos = $this->insert_position + 3000;
		$this->insert_position = strpos( $output, '</p>', strpos( $output, 'field-move', $start_pos ) );

		ob_start();
		include( $this->config->view );
		$field = ob_get_clean();

		$output = substr_replace( $output, $field, $this->insert_position, 4 );
	}
}