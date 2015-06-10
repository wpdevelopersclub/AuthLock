<?php

return array(
	'page_options'          => array(
		'meta_name'         => 'wpdevsclub_page_options',
		'meta_defaults'     => array(
			'_page_access'  => 'public',
		),
		'sanitize'          => array(
			'_page_access'  => 'strip_tags',
		),
		'metabox_view'      => AUTHLOCK_PLUGIN_DIR . 'lib/views/admin/metabox-page-options.php',
	),
);