<?php namespace AuthLock;

return array(
	'shortcode'                 => 'loginout_button',
	'view'                      => AUTHLOCK_PLUGIN_DIR . 'src/views/shortcodes/loginlogout.php',
	'defaults'                  => array(
		'class'                 => '',
		'open_new_tab'          => 0,
		'login_icon'            => 'sign-in',
		'logout_icon'           => 'sign-out',
		'href'                  => '',
		'login'                 => __( 'Sign in', 'authlock' ),
		'logout'                => __( 'Sign out', 'authlock' ),
	),
);