<?php
	
if (!defined('ABSPATH')) exit; // Exit if accessed directly	
	
?>

<form onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected slides?', $this -> plugin_name); ?>')) { return false; }" action="<?php echo $this -> url; ?>&amp;method=mass" method="post">
	
	<?php wp_nonce_field($this -> sections -> slides . '-bulkaction'); ?>
	
	<div class="tablenav">
		<div class="alignleft actions">
			<?php if (!empty($_GET['page']) && $_GET['page'] == $this -> sections -> galleries) : ?>
				<a href="?page=<?php echo $this -> sections -> slides; ?>&amp;method=order&amp;gallery_id=<?php echo $gallery -> id; ?>" class="button"><i class="fa fa-sort"></i> <?php _e('Order Slides', $this -> plugin_name); ?></a>
			<?php else : ?>
				<a href="<?php echo $this -> url; ?>&amp;method=order" class="button"><i class="fa fa-sort"></i> <?php _e('Order Slides', $this -> plugin_name); ?></a>
			<?php endif; ?>
		</div>
		<div class="alignleft actions">
			<select name="action" class="action" onchange="change_action(this.value);">
				<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
				<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
				<optgroup label="<?php _e('Galleries', $this -> plugin_name); ?>">
					<option value="addgalleries"><?php _e('Add Galleries...', $this -> plugin_name); ?></option>
					<option value="setgalleries"><?php _e('Set Galleries...', $this -> plugin_name); ?></option>
					<option value="remgalleries"><?php _e('Remove All Galleries', $this -> plugin_name); ?></option>
				</optgroup>
			</select>
			<input type="submit" class="button" value="<?php _e('Apply', $this -> plugin_name); ?>" name="execute" />
		</div>
		<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
	</div>
	
	<div id="action_galleries_div" style="display:none;">
		<?php if ($galleries = $this -> Gallery() -> select()) : ?>
			<div><label style="font-weight:bold"><input onclick="jqCheckAll(this, false, 'galleries');" type="checkbox" name="checkboxall" value="1" /> <?php _e('Select all', $this -> plugin_name); ?></label></div>
			<?php foreach ($galleries as $gallery_id => $gallery_name) : ?>
				<div><label><input type="checkbox" name="galleries[]" value="<?php echo $gallery_id; ?>" /> <?php _e($gallery_name); ?></label></div>
			<?php endforeach; ?>
		<?php else : ?>
			<p class="slideshow_error"><?php _e('No galleries are available', $this -> plugin_name); ?></p>
		<?php endif; ?>
	</div>
	
	<script type="text/javascript">
	function change_action(action) {
		switch (action) {
			case 'addgalleries'				:
			case 'setgalleries'				:
				jQuery('#action_galleries_div').show();
				break;
			default 						:
				jQuery('#action_galleries_div').hide();
				break;
		}
	}
	</script>
	
	<?php
	
	$orderby = (empty($_GET['orderby'])) ? 'modified' : esc_html($_GET['orderby']);
	$order = (empty($_GET['order'])) ? 'desc' : strtolower(esc_html($_GET['order']));
	$otherorder = ($order == "desc") ? 'asc' : 'desc';
	$colspan = 8;
	
	?>

	<table class="widefat">
		<thead>
			<tr>
				<td class="check-column"><input type="checkbox" name="checkboxall" id="checkboxall" value="checkboxall" /></td>
				<th class="column-id <?php echo ($orderby == "id") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=id&order=' . (($orderby == "id") ? $otherorder : "asc")); ?>">
						<span><?php _e('ID', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="column-image <?php echo ($orderby == "image") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=image&order=' . (($orderby == "image") ? $otherorder : "asc")); ?>">
						<span><?php _e('Image', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
						<span><?php _e('Title', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th><?php _e('Galleries', $this -> plugin_name); ?></th>
                <th class="column-uselink <?php echo ($orderby == "uselink") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=uselink&order=' . (($orderby == "uselink") ? $otherorder : "asc")); ?>">
						<span><?php _e('Link', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="column-modified <?php echo ($orderby == "modified") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=modified&order=' . (($orderby == "modified") ? $otherorder : "asc")); ?>">
						<span><?php _e('Date', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="column-order <?php echo ($orderby == "order") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=order&order=' . (($orderby == "order") ? $otherorder : "asc")); ?>">
						<span><?php _e('Order', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td class="check-column"><input type="checkbox" name="checkboxall" id="checkboxall" value="checkboxall" /></td>
				<th class="column-id <?php echo ($orderby == "id") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=id&order=' . (($orderby == "id") ? $otherorder : "asc")); ?>">
						<span><?php _e('ID', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="column-image <?php echo ($orderby == "image") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=image&order=' . (($orderby == "image") ? $otherorder : "asc")); ?>">
						<span><?php _e('Image', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
						<span><?php _e('Title', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th><?php _e('Galleries', $this -> plugin_name); ?></th>
                <th class="column-uselink <?php echo ($orderby == "uselink") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=uselink&order=' . (($orderby == "uselink") ? $otherorder : "asc")); ?>">
						<span><?php _e('Link', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="column-modified <?php echo ($orderby == "modified") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=modified&order=' . (($orderby == "modified") ? $otherorder : "asc")); ?>">
						<span><?php _e('Date', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="column-order <?php echo ($orderby == "order") ? 'sorted ' . $order : 'sortable desc'; ?>">
					<a href="<?php echo $this -> Html -> retainquery('orderby=order&order=' . (($orderby == "order") ? $otherorder : "asc")); ?>">
						<span><?php _e('Order', $this -> plugin_name); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($slides)) : ?>
				<?php foreach ($slides as $slide) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th class="check-column"><input type="checkbox" name="Slide[checklist][]" value="<?php echo $slide -> id; ?>" id="checklist<?php echo $slide -> id; ?>" /></th>
						<td><label for="checklist<?php echo $slide -> id; ?>"><?php echo $slide -> id; ?></label></td>
						<td style="width:75px;">
							<?php $image = $slide -> image; ?>
							<a href="<?php echo $slide -> image_path; ?>" title="<?php echo __($slide -> title); ?>" class="colorbox" rel="slides"><img class="img-rounded" src="<?php echo $this -> Html -> otf_image_src($slide, 50, 50, 100); ?>" alt="<?php echo $this -> Html -> sanitize(__($slide -> title)); ?>" /></a>
						</td>
						<td>
	                    	<a class="row-title" href="<?php echo $this -> url; ?>&amp;method=save&amp;id=<?php echo $slide -> id; ?>" title=""><?php echo __($slide -> title); ?></a>
	                        <div class="row-actions">
	                        	<span class="edit"><?php echo $this -> Html -> link(__('Edit', $this -> plugin_name), "?page=" . $this -> sections -> slides . "&amp;method=save&amp;id=" . $slide -> id); ?> |</span>
	                            <span class="delete"><?php echo $this -> Html -> link(__('Delete', $this -> plugin_name), "?page=" . $this -> sections -> slides . "&amp;method=delete&amp;id=" . $slide -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you want to permanently remove this slide?', $this -> plugin_name) . "')) { return false; }")); ?></span>
	                        </div>
	                    </td>
	                    <td>
	                    	<?php if (!empty($slide -> gallery)) : ?>
	                    		<?php $g = 1; ?>
	                    		<?php foreach ($slide -> gallery as $gallery) : ?>
	                    			<a href="?page=<?php echo $this -> sections -> galleries; ?>&amp;method=view&amp;id=<?php echo $gallery -> id; ?>" title="<?php echo esc_attr(__($gallery -> title)); ?>"><?php echo __($gallery -> title); ?></a>
	                    			<?php if ($g < count($slide -> gallery)) : ?>, <?php endif; ?>
	                    			<?php $g++; ?>
	                    		<?php endforeach; ?>
	                    	<?php else : ?>
	                    		<?php _e('None', $this -> plugin_name); ?>
	                    	<?php endif; ?>
						</td>
	                    <td>
	                    	<?php if (!empty($slide -> uselink) && $slide -> uselink == "Y") : ?>
	                        	<span class="slideshow_success"><i class="fa fa-check"></i></span>
	                        	<small>(<a href="<?php echo __($slide -> link); ?>" title="" target="_blank"><?php _e('Open', $this -> plugin_name); ?></a>)</small>
	                        <?php else : ?>
	                        	<span class="slideshow_error"><i class="fa fa-times"></i></span>
	                        <?php endif; ?>
	                    </td>
						<td><abbr title="<?php echo $slide -> modified; ?>"><?php echo date(get_option('date_format'), strtotime($slide -> modified)); ?></abbr></td>
						<td><?php echo ((int) $slide -> order + 1); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="no-items">
					<td class="colspanchange" colspan="<?php echo $colspan; ?>">
						<?php echo sprintf(__('No slides available, %s or %s', $this -> plugin_name), '<a href="' . admin_url('admin.php?page=' . $this -> sections -> slides . '&method=save') . '">' . __('add one', $this -> plugin_name) . '</a>', '<a href="' . admin_url('admin.php?page=' . $this -> sections -> slides . '&method=save-multiple') . '">' . __('add multiple', $this -> plugin_name) . '</a>'); ?>
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	
	<div class="tablenav">
		<div class="alignleft">
			<?php if (empty($_GET['showall'])) : ?>
				<select class="widefat" style="width:auto;" name="perpage" onchange="change_perpage(this.value);">
					<option value=""><?php _e('- Per Page -', $this -> plugin_name); ?></option>
					<?php $p = 5; ?>
					<?php while ($p < 100) : ?>
						<option <?php echo (!empty($_COOKIE[$this -> pre . 'slidesperpage']) && $_COOKIE[$this -> pre . 'slidesperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('per page', $this -> plugin_name); ?></option>
						<?php $p += 5; ?>
					<?php endwhile; ?>
					<?php if (isset($_COOKIE[$this -> pre . 'slidesperpage'])) : ?>
						<option selected="selected" value="<?php echo $_COOKIE[$this -> pre . 'slidesperpage']; ?>"><?php echo $_COOKIE[$this -> pre . 'slidesperpage']; ?></option>
					<?php endif; ?>
				</select>
			<?php endif; ?>
			
			<script type="text/javascript">
			function change_perpage(perpage) {				
				if (perpage != "") {
					document.cookie = "<?php echo $this -> pre; ?>slidesperpage=" + perpage + "; expires=<?php echo $this -> Html -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> UTC; path=/";
					window.location = "<?php echo preg_replace("/\&?" . $this -> pre . "page\=(.*)?/si", "", $_SERVER['REQUEST_URI']); ?>";
				}
			}
			</script>
		</div>
		<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
	</div>
</form>