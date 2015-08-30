<?php

$user_is_logged_in = is_user_logged_in();

if ( (bool) $atts['hide_until_logged_in'] && ! $user_is_logged_in ) {
	return '';
}

$icon       = $atts['icon'] ? sprintf('<i class="fa fa-%s"></i>', esc_attr( $atts['icon'] ) ) : '';
$class      = $atts['class'] ? ' ' . esc_attr( $atts['class'] ) : '';
$url        = $atts['href'];

if ( $atts['add_user_id_to_url'] && $atts['url_param'] && $user_is_logged_in ) {
	$url = $url . '?memberID=' . get_current_user_id();
}

if ( false === strpos( $url, 'http' ) ) {
	$url = site_url( $url );
}

if ( empty( $atts['min_access_level'] ) || 'public' == $atts['min_access_level'] || $user_is_logged_in ): ?>

	<a href="<?php echo esc_url( $url ); ?>" class="button security<?php echo $class; ?>"<?php echo (bool) $atts['open_new_tab'] ? ' target="_blank"' : ''; ?>>
		<?php echo $icon; ?><?php echo esc_html( $content ); ?>
	</a>

<?php else: ?>

	<a class="button security grayedout <?php echo $class; ?>">
		<?php echo $icon; ?><?php esc_html_e( $content ); ?>
	</a>

<?php endif; ?>