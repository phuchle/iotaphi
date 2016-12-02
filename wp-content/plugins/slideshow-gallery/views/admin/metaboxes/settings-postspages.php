<!-- Posts/Pages Settings -->

<?php
	
$languages = $this -> language_getlanguages();

if ($this -> ci_serial_valid()) {
	$excerptsettings = $this -> get_option('excerptsettings');	
} else {
	$excerptsettings = false;
}
	
$excerpt_readmore = $this -> get_option('excerpt_readmore');
$excerpt_length = $this -> get_option('excerpt_length');
	
?>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="excerptsettings"><?php _e('Override Excerpt Settings', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo (!$this -> ci_serial_valid()) ? 'disabled="disabled"' : ''; ?> <?php echo (!empty($excerptsettings)) ? 'checked="checked"' : ''; ?> onclick="if (jQuery(this).is(':checked')) { jQuery('#excerptsettings_div').show(); } else { jQuery('#excerptsettings_div').hide(); }" type="checkbox" name="excerptsettings" value="1" id="excerptsettings" /> <?php _e('Yes, override the post/page excerpt settings', $this -> plugin_name); ?></label>
			</td>
		</tr>
	</tbody>
</table>

<div id="excerptsettings_div" style="display:<?php echo (!empty($excerptsettings)) ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="excerpt_readmore"><?php _e('Read More Text', $this -> plugin_name); ?></label></th>
				<td>
					<?php if ($this -> language_do()) : ?>
						<?php $readmores = $this -> language_split($excerpt_readmore); ?>
						<div id="readmore-tabs">
							<ul>
								<?php foreach ($languages as $language) : ?>
									<li><a href="#readmore-tabs-<?php echo $language; ?>"><?php echo $this -> language_flag($language); ?></a></li>
								<?php endforeach; ?>
							</ul>
							<?php foreach ($languages as $language) : ?>
								<div id="readmore-tabs-<?php echo $language; ?>">
									<input type="text" class="widefat" name="excerpt_readmore[<?php echo $language; ?>]" value="<?php echo esc_attr(stripslashes($readmores[$language])); ?>" id="excerpt_readmore_<?php echo $language; ?>" />
								</div>
							<?php endforeach; ?>
						</div>
						
						<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('#readmore-tabs').tabs();
						});
						</script>
					<?php else : ?>
						<input type="text" class="widefat" name="excerpt_readmore" value="<?php echo esc_attr(stripslashes(__($excerpt_readmore))); ?>" id="excerpt_readmore" />
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th><label for="excerpt_length"><?php _e('Excerpt Length', $this -> plugin_name); ?></label></th>
				<td>
					<input type="text" class="widefat" style="width:65px;" name="excerpt_length" value="<?php echo esc_attr(stripslashes($excerpt_length)); ?>" id="excerpt_length" />
				</td>
			</tr>
		</tbody>
	</table>
</div>