<?php namespace AuthLock;

/**
 * AuthLock Plugin Class
 *
 * This class is the controller for the plugin, directly traffic, creating the
 * admin menu, etc.
 *
 * @package     AuthLock
 * @since       1.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @license     GPL-2.0+
 * @link        http://wpdevelopersclub.com/wordpress-plugins/authlock/
 * @copyright   2015 WP Developers Club
 */

// Oh no you don't. Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheating&#8217; uh?' );
}

use AuthLock\Admin\Media;
use AuthLock\Admin\Metabox;
use AuthLock\Restrict\Login;
use AuthLock\Restrict\Menu;
use AuthLock\Restrict\Page;

class Plugin {

	/**
	 * The plugin's version
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * The plugin's minimum WordPress requirement
	 *
	 * @var string
	 */
	const MIN_WP_VERSION = '3.5';

	/**
	 * Configuration array
	 *
	 * @var array
	 */
	protected $config = array();

	/*************************
	 * Getters
	 ************************/

	public function version() {
		return self::VERSION;
	}

	public function min_wp_version() {
		return self::MIN_WP_VERSION;
	}

	/*************************
	 * Instantiate & Init
	 ************************/

	/**
	 * Instantiate the plugin
	 *
	 * @since 1.0.1
	 *
	 * @param array     $config     Configuration array
	 * @return self
	 */
	public function __construct( array $config ) {
		$this->config = $config;

		$this->init_hooks();
	}

	/**
	 * Initialize hooks
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_hooks() {
		add_action( 'init',     array( $this, 'init_object_factory' ), 1 );
	}

	/**
	 * Init the objects
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	function init_object_factory() {

		if ( is_admin() ) {
			$this->init_be();
		} else {
			$this->init_fe();
		}

		new Menu();
	}

	/**
	 * Init the back-end objects
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_be() {
		new Media;

		$metaboxes = wpdevsclub_load_config( 'metaboxes.php', AUTHLOCK_PLUGIN_DIR . 'config/' );
		foreach ( $metaboxes as $mb_config ) {
			new Metabox( $mb_config );
		}
	}

	/**
	 * Init the front-end objects
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_fe() {
		ob_start();

		new Login;
		new Page;

		$this->init_shortcodes( wpdevsclub_load_config( 'shortcodes.php', AUTHLOCK_PLUGIN_DIR . 'config/' ) );
	}

	/**
	 * Initialize Shortcodes
	 *
	 * @since 1.0.0
	 *
	 * @param array     $shortcodes     Configuration array
	 * @return null
	 */
	protected function init_shortcodes( array $shortcodes ) {

		foreach ( $shortcodes as $key => $config ) {

			if ( class_exists( $config['classname'] ) ) {
				$classname = $config['classname'];

				new $classname( $config );
			}
		}
	}

	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'authlock',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}
}