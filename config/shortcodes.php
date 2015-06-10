<?php

return array(

	'wpdevsclub_loginout'           => array(
		'classname'                 => 'WPDevsClub_Core\Shortcodes\Base',
		'shortcode'                 => 'wpdevsclub_loginout',
		'view'                      => AUTHLOCK_PLUGIN_DIR . 'lib/views/shortcodes/clearfix.php',
		'defaults'                  => array(
			'after'                 => '',
			'before'                => '',
			'class'                 => '',
		),
	),

	'security_button'               => array(
		'classname'                 => 'WPDevsClub_Core\Shortcodes\Base',
		'shortcode'                 => 'security_button',
		'view'                      => AUTHLOCK_PLUGIN_DIR . 'lib/views/shortcodes/security-button.php',
		'defaults'                  => array(
			'after'                 => '',
			'before'                => '',
			'class'                 => '',
			'open_new_tab'          => 0,
			'icon'                  => '',
			'href'                  => '',
			'min_access_level'      => 'public',
			'hide_until_logged_in'  => 0,
			'add_user_id_to_url'    => 0,
			'url_param'             => 'userID',
		),
	),

	'loginout_button'               => array(
		'classname'                 => 'WPDevsClub_Core\Shortcodes\Base',
		'shortcode'                 => 'loginout_button',
		'view'                      => AUTHLOCK_PLUGIN_DIR . 'lib/views/shortcodes/loginlogout.php',
		'defaults'                  => array(
			'after'                 => '',
			'before'                => '',
			'class'                 => '',
			'open_new_tab'          => 0,
			'login_icon'            => 'sign-in',
			'logout_icon'           => 'sign-out',
			'href'                  => '',
			'login'                 => __( 'Sign in', 'wpdevsclub' ),
			'logout'                => __( 'Sign out', 'wpdevsclub' ),
		),
	),

	'login_to_view'            => array(
		'classname'                 => 'WPDevsClub_Core\Shortcodes\Base',
		'shortcode'                 => 'login_to_view',
		'view'                      => AUTHLOCK_PLUGIN_DIR . 'lib/views/shortcodes/login-to-view.php',
		'defaults'                  => array(
			'after'                 => '',
			'before'                => '',
			'class'                 => '',
			'wpautop'               => 1,
		),
	),
);