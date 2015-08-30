<?php namespace Authlock\Admin;

return array(
	'view'              => AUTHLOCK_PLUGIN_DIR . 'src/views/admin/menu.php',
	'label'             => __( 'Access Level', 'authlock' ),
	'menu_item'         => array(
		'public'        => __( 'Public', 'authlock' ),
		'member'        => __( 'Logged In', 'authlock' ),
		'not_logged_in' => __( 'Not Logged In', 'authlock' ),
	),
);