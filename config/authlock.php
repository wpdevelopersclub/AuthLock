<?php namespace AuthLock;

/**
 * Core Defaults Configuration file.
 *
 * @package     AuthLock
 * @since       1.1.1
 * @author      WPDevelopersClub, hellofromTonya, Alain Schlesser, Gary Jones
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 */

use WPDevsClub_Core\Config\Arr_Config;
use WPDevsClub_Core\Shortcodes\Shortcode;
use AuthLock\Admin\Media;
use AuthLock\Admin\Metabox;
use AuthLock\Restrict\Login;
use AuthLock\Restrict\Menu;
use AuthLock\Restrict\Page;

return array(

	/*********************************************************
	 * Initial Core Parameters, which are loaded into the
	 * Container before anything else occurs.
	 *
	 * Format:
	 *    $unique_id => $value
	 ********************************************************/

	'initial_parameters'     => array(
		'authlock_plugin_dir' => AUTHLOCK_PLUGIN_DIR,
		'authlock_plugin_url' => AUTHLOCK_PLUGIN_URL,
		'authlock_config_dir' => AUTHLOCK_PLUGIN_DIR . 'config/',
	),
	/*********************************************************
	 * Back-End Service Providers -
	 * These service providers are loaded when 'admin_init' fires.
	 *
	 * Format:
	 *    $unique_id => array(
	 *      // When true, the instance is fetched out of the
	 *      // Container.
	 *      'autoload' => true|false,
	 *      // Closure that is loaded into the Container.
	 *      'concrete' => Closure,
	 ********************************************************/

	'be_service_providers'   => array(
		'authlock.media'                => array(
			'autoload' => true,
			'concrete' => function ( $container ) {
				return new Media;
			},
		),
		'authlock.metabox.page_options' => array(
			'autoload' => true,
			'concrete' => function ( $container ) {
				return new Metabox(
					new Arr_Config(
						$container['authlock_config_dir'] . 'metaboxes/page-options.php'
					)
				);
			},
		),
	),
	/*********************************************************
	 * Front-End Service Providers -
	 * These service providers are loaded when 'genesis_init'
	 * fires and not in back-end.
	 *
	 * Format:
	 *    $unique_id => array(
	 *      // When true, the instance is fetched out of the
	 *      // Container.
	 *      'autoload' => true|false,
	 *      // Closure that is loaded into the Container.
	 *      'concrete' => Closure,
	 ********************************************************/

	'fe_service_providers'   => array(
		'authlock.login'                => array(
			'autoload' => true,
			'concrete' => function ( $container ) {
				return new Login;
			},
		),
		'authlock.page'                 => array(
			'autoload' => true,
			'concrete' => function ( $container ) {
				return new Page;
			},
		),
		'shortcode.wpdevsclub_loginout' => array(
			'autoload' => true,
			'concrete' => function ( $container ) {
				return new Shortcode( new Arr_Config( $container['authlock_config_dir'] . 'shortcodes/loginout.php' ) );
			},
		),
		'shortcode.security_button'     => array(
			'autoload' => true,
			'concrete' => function ( $container ) {
				return new Shortcode( new Arr_Config( $container['authlock_config_dir'] . 'shortcodes/security-button.php' ) );
			},
		),
		'shortcode.loginout_button'     => array(
			'autoload' => true,
			'concrete' => function ( $container ) {
				return new Shortcode( new Arr_Config( $container['authlock_config_dir'] . 'shortcodes/loginout-button.php' ) );
			},
		),
		'shortcode.login_to_view'       => array(
			'autoload' => true,
			'concrete' => function ( $container ) {
				return new Shortcode( new Arr_Config( $container['authlock_config_dir'] . 'shortcodes/login-to-view.php' ) );
			},
		),
	),
	/*********************************************************
	 * Front-End Service Providers -
	 * These service providers are loaded when 'genesis_init' fires.
	 *
	 * Format:
	 *    $unique_id => array(
	 *      // When true, the instance is fetched out of the
	 *      // Container.
	 *      'autoload' => true|false|callback,
	 *      // Closure that is loaded into the Container.
	 *      'concrete' => Closure,
	 ********************************************************/

	'both_service_providers' => array(
		'authlock.menu' => array(
			'autoload' => true,
			'concrete' => function ( $container ) {
				return new Menu;
			},
		),
	),
);