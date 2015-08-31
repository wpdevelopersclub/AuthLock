<?php namespace AuthLock;

return array(
	'shortcode'                 => 'login_to_view',
	'view'                      => AUTHLOCK_PLUGIN_DIR . 'src/views/shortcodes/login-to-view.php',
	'defaults'                  => array(
		'class'                 => '',
		'wpautop'               => 1,
		'alternate_message'     => __( 'For members-only', 'authlock' ),
	),
);