<p><label for="wpdevsclub_page_access"><b><?php _e( 'Select security access level for this page', 'wpdevsclub'); ?></b></label></p>
<p>
	<select name="wpdevsclub_page_options[_page_access]" id="wpdevsclub_page_access">
		<?php
		printf('<option value="public"%s>%s</option>', selected( 'public', $meta['_page_access'] ), __( 'Public', 'wpdevsclub' ) );
		printf('<option value="member"%s>%s</option>', selected( 'member', $meta['_page_access'] ), __( 'Members Only', 'wpdevsclub' ) );
		?>
	</select>
</p>