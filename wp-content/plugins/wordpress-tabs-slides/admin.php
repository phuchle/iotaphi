		<?php 
		if(!defined('WP_TABS_SLIDES_VERSION')) exit;
		?>
		<div class="wrap">
		<h2 class="title">Wordpress Tabs Slides</h2>
		<hr />
		<?php echo $output ;?>
		<form action="" method="post">

		<table class="widefat fixed">
			<tr>
				<th colspan="2">
					<h3><?php _e("General Settings");?></h3>
				</th>
			</tr>
		<tr valign="top">
		<th scope="row" width="150px"><?php _e("Slider Speed");?></th>
		<td><input type="text" name="speed" value="<?php echo $sliderpeed;?>" /><br /><small><?php _e("miliseconds");?></small></td>
		</tr>	
		<tr>
		<th scope="row"><?php _e("Use Optimized Loader");?></th>
		<td><input type="checkbox" name="optimized" value="on"<?php echo $optimized;?>/><br /></td>
		</tr>
		<tr>
		<th scope="row">
			<label for="frontdisable">
				<?php _e("Disable on Frontpage");?>
			</label>
		</th>
		<td>
			<input type="checkbox" name="frontdisable" value="on"<?php echo $frontdisable;?>/>
		</td>
		</tr>
		<tr>
			<th scope="row"><?php _e("Disable on Posts/Pages");?></th>
			<td>
			<input type="checkbox" name="postdisable" value="on"<?php echo $postdisable;?>/>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e("Style");?></th>
			<td>
				<select name="style">
			<?php 
			foreach($styles as $style):

				if($style == $defaultstyle):
				?>
				<option value="<?php echo strtolower($style);?>" selected="selected"><?php echo $style;?></option>
					<?php
					else:
					?>	
				<option value="<?php echo strtolower($style);?>"><?php echo $style;?></option>
				<?php
				endif;
			endforeach;
			?>
				</select>
			</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Custom Stylesheet File");?></th>
		<td><input type="text" name="custom_style" value="<?php echo $customstyle;?>" style="width: 50%;" /></td>
		</tr>
			<tr>
			<th scope="row"><?php _e("Enable Bootstrap Tab");?></th>
			<td>
			<input type="checkbox" name="boottabs" value="on"<?php echo $boottabs;?>/>
			</td>
		</tr>
		</table>
		<p class="submit">
		<input class="button-primary" type="submit" name="submit" value="<?php _e("Save Changes");?>" />
		</p>
		</form>
		<hr />
		<a href="http://wts.dulabs.com/#usage" target="_blank"><?php _e("How to use");?></a>&nbsp;|&nbsp;
		<a href="http://wordpress.org/extend/plugins/wordpress-tabs-slides/changelog/"><?php _e("Changelog");?></a>&nbsp;|&nbsp;
		<a href="http://wts.dulabs.com" target="_blank"><?php _e("Plugin Home");?></a>&nbsp;|&nbsp;	
		</div>