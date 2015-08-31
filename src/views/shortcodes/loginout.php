<?php if ( is_user_logged_in() ) : ?>

<a href="<?php echo wp_logout_url(); ?>" class="button loginout last">
	<i class="fa fa-sign-out"></i> <?php __e( 'Sign Out', 'wpdc' ); ?>
</a>

<?php else: ?>

<a href="<?php echo site_url( 'wp-login.php' ); ?>" class="button loginout last">
	<i class="fa fa-sign-in"></i> <?php __e( 'Sign In', 'wpdc' ); ?>
</a>

<?php endif; ?>