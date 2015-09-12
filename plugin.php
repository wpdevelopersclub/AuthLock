<?php namespace AuthLock;

/**
 * AuthLock
 *
 * @package         AuthLock
 * @author          WPDevelopersClub and hellofromTonya
 * @license         GPL-2.0+
 * @link            https://wpdevelopersclub.com
 * @copyright       2015 WP Developers Club
 *
 * @wordpress-plugin
 * Plugin Name:     AuthLock
 * Plugin URI:      https://wpdevelopersclub.com
 * Description:     Access security for your posts, pages, resources, media, and more + 3-auth for login
 * Version:         1.1.1
 * Author:          WP Developers Club and Tonya
 * Author URI:      https://wpdevelopersclub.com
 * Text Domain:     authlock
 * Requires WP:     3.3
 * Requires PHP:    5.3
 */

/*
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

use WPDevsClub_Core\I_Core;
use WPDevsClub_Core\Config\Factory;

// Oh no you don't. Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheating&#8217; uh?' );
}

require_once( __DIR__ . '/assets/vendor/autoload.php' );

if ( ! defined( 'AUTHLOCK_PLUGIN_DIR' ) ) {
	define( 'AUTHLOCK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'AUTHLOCK_PLUGIN_URL' ) ) {
	$plugin_url = plugin_dir_url( __FILE__ );
	if ( is_ssl() ) {
		$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
	}
	define( 'AUTHLOCK_PLUGIN_URL', $plugin_url );
}

add_action( 'wpdc_is_loaded', __NAMESPACE__ . '\\launch', 9 );
/**
 * Launch the plugin, if the user is an admin
 *
 * @since 1.1.0
 *
 * @param I_Core $core
 * @return null
 */
function launch( I_Core $core ) {
	if ( version_compare( $GLOBALS['wp_version'], AuthLock::MIN_WP_VERSION, '>' ) ) {
		new AuthLock( Factory::create( AUTHLOCK_PLUGIN_DIR . 'config/authlock.php' ), $core );
	}
}