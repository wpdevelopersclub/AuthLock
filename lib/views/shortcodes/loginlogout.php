<?php
$class = $atts['class'] ? ' ' . esc_attr( $atts['class'] ) : '';

if ( is_user_logged_in() ): ?>

<a href="<?php echo wp_logout_url( home_url() ); ?>" class="button security<?php echo $class; ?>">
	<?php echo $atts['logout_icon'] ? sprintf('<i class="fa fa-%s"></i>', esc_attr( $atts['logout_icon'] ) ) : ''; ?>
	<?php echo esc_html( $atts['logout'] ); ?>
</a>

<?php else: ?>

<a href="<?php echo wp_login_url( get_permalink() ); ?>" class="button security<?php echo $class; ?>">
	<?php echo $atts['login_icon'] ? sprintf('<i class="fa fa-%s"></i>', esc_attr( $atts['login_icon'] ) ) : ''; ?>
	<?php echo esc_html( $atts['login'] ); ?>
</a>

<?php endif; ?>