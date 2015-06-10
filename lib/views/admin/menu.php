<p class="field-custom description description-wide">
	<label for="edit-menu-item-access-level-<?php echo $item_id; ?>">
		<?php esc_html_e( $this->config['label'] ); ?>
		<br />
		<select id="edit-menu-item-menu-before-%1$s" name="menu-item-access-level[<?php echo $item_id; ?>]"  class="widefat code edit-menu-item-access-level">
			<?php foreach( $this->config['menu_item'] as $value => $label ) : ?>
			<option value="<?php esc_attr_e( $value ); ?>"<?php selected( $value, $item->access_level ); ?>><?php esc_html_e( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</label>
</p>