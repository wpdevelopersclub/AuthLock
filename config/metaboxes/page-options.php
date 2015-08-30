<?php

return array(
	'meta_name'         => 'wpdevsclub_page_options',
	'meta_defaults'     => array(
		'_page_access'  => 'public',
	),
	'sanitize'          => array(
		'_page_access'  => 'strip_tags',
	),
	'metabox_view'      => AUTHLOCK_PLUGIN_DIR . 'src/views/admin/metabox-page-options.php',
);