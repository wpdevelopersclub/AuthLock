<?php namespace AuthLock;

return array(
	'shortcode'                 => 'security_button',
	'view'                      => AUTHLOCK_PLUGIN_DIR . 'src/views/shortcodes/security-button.php',
	'defaults'                  => array(
		'class'                 => '',
		'open_new_tab'          => 0,
		'icon'                  => '',
		'href'                  => '',
		'min_access_level'      => 'public',
		'hide_until_logged_in'  => 0,
		'add_user_id_to_url'    => 0,
		'url_param'             => 'userID',
	),
);