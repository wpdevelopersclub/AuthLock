<?php namespace AuthLock;

/**
 * Page Options Metabox - Runtime Configuration file.
 *
 * @package     AuthLock
 * @since       1.1.0
 * @author      WPDevelopersClub, hellofromTonya, Alain Schlesser, Gary Jones
 * @link        https://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 */

return array(
	'meta_name'     => 'wpdevsclub_page_options',
	'meta_defaults' => array(
		'_page_access' => 'public',
	),
	'sanitize'      => array(
		'_page_access' => 'strip_tags',
	),
	'metabox_view'  => AUTHLOCK_PLUGIN_DIR . 'src/views/admin/metabox-page-options.php',
);
