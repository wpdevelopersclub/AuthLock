<?php

// Not much of a view as there is no HTML. But shortcut
// way to kick out the content.

if ( is_user_logged_in() ) {

	$content = wp_kses_post( do_shortcode( $content ) );

	echo $atts['wpautop'] ? wpautop( $content ) : $content;

} else {
	esc_html_e( $atts['alternate_message'] );
}