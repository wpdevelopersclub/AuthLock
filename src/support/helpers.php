<?php

if ( ! function_exists( 'wpdevsclub_get_access_level' ) ) {
	/**
	 * Get the access level
	 *
	 * @since 1.0.0
	 *
	 * @param integer       $post_id
	 * @return string       Returns the access level
	 */
	function wpdevsclub_get_access_level( $post_id = 0 ) {
		return wpdevsclub_get_meta( 'wpdevsclub_page_options', '_page_access', $post_id );
	}
}