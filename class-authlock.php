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

use WPDevsClub_Core\Config\I_Config;
use WPDevsClub_Core\I_Core;

class AuthLock {

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
	 * @var I_Config
	 */
	protected $config;

	/**
	 * Instance of Core
	 *
	 * @var I_Core
	 */
	protected $core;

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
	 * @param I_Config $config Runtime configuration parameters
	 * @param I_Core $core Instance of Core
	 * @return self
	 */
	public function __construct( I_Config $config, I_Core $core ) {
		$this->config   = $config;
		$this->core     = $core;

		$this->init_parameters();
		$this->init_events();
	}

	/**
	 * Initialize the initial parameters by loading each into the Container.
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_parameters() {
		array_walk( $this->config->initial_parameters, function( $value, $unique_id ) {
			$this->core[ $unique_id ] = $value;
		} );
	}

	/**
	 * Initialize events
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_events() {
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
		$service_providers = array(
			is_admin() ? 'be_service_providers' : 'fe_service_providers',
			'both_service_providers'
		);

		array_walk( $service_providers, function( $service_provider ) {
			if ( 'fe_service_providers' == $service_provider ) {
				ob_start();
			}
			$this->core->register_service_providers( $this->config->$service_provider );
		} );
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