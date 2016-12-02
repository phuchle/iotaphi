<?php
	
if (!defined('ABSPATH')) exit; // Exit if accessed directly	
	
?>

<div class="wrap <?php echo $this -> pre; ?> slideshow">	
	<h1><?php _e('Manage Galleries', $this -> plugin_name); ?> <?php echo $this -> Html -> link(__('Add New', $this -> plugin_name), $this -> url . '&amp;method=save', array('class' => "add-new-h2")); ?></h1>

	<?php if (!empty($galleries)) : ?>	
		<form id="posts-filter" action="<?php echo $this -> url; ?>" method="post">
			<ul class="subsubsub">
				<li><?php echo $paginate -> allcount; ?> <?php _e('galleries', $this -> plugin_name); ?></li>
			</ul>
		</form>
	<?php endif; ?>
	
	<form onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected galleries?', $this -> plugin_name); ?>')) { return false; }" action="<?php echo $this -> url; ?>&amp;method=mass" method="post">
		
		<?php wp_nonce_field($this -> sections -> galleries . '-bulkaction'); ?>
		
		<div class="tablenav">
			<div class="alignleft actions">				
				<select name="action" class="action">
					<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
				</select>
				<input type="submit" class="button" value="<?php _e('Apply', $this -> plugin_name); ?>" name="execute" />
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
		</div>
		
		<?php
		
		$orderby = (empty($_GET['orderby'])) ? 'modified' : esc_html($_GET['orderby']);
		$order = (empty($_GET['order'])) ? 'desc' : strtolower(esc_html($_GET['order']));
		$otherorder = ($order == "desc") ? 'asc' : 'desc';
		$colspan = 6;
		
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
					<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $this -> Html -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
							<span><?php _e('Title', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Slides', $this -> plugin_name); ?></th>
					<th><?php _e('Shortcode', $this -> plugin_name); ?></th>
					<th class="column-modified <?php echo ($orderby == "modified") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $this -> Html -> retainquery('orderby=modified&order=' . (($orderby == "modified") ? $otherorder : "asc")); ?>">
							<span><?php _e('Date', $this -> plugin_name); ?></span>
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
					<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $this -> Html -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
							<span><?php _e('Title', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Slides', $this -> plugin_name); ?></th>
					<th><?php _e('Shortcode', $this -> plugin_name); ?></th>
					<th class="column-modified <?php echo ($orderby == "modified") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $this -> Html -> retainquery('orderby=modified&order=' . (($orderby == "modified") ? $otherorder : "asc")); ?>">
							<span><?php _e('Date', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
				</tr>
			</tfoot>
			<tbody>
				<?php if (!empty($galleries)) : ?>
					<?php foreach ($galleries as $gallery) : ?>
						<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
							<th class="check-column"><input type="checkbox" name="Gallery[checklist][]" value="<?php echo $gallery -> id; ?>" id="checklist<?php echo $gallery -> id; ?>" /></th>
							<td><?php echo $gallery -> id; ?></td>
							<td>
	                        	<a class="row-title" href="<?php echo $this -> url; ?>&amp;method=save&amp;id=<?php echo $gallery -> id; ?>" title=""><?php echo __($gallery -> title); ?></a>
	                            <div class="row-actions">
	                            	<span class="view"><?php echo $this -> Html -> link(__('View', $this -> plugin_name), "?page=" . $this -> sections -> galleries . "&amp;method=view&amp;id=" . $gallery -> id); ?> |</span>
	                            	<span class="edit"><?php echo $this -> Html -> link(__('Edit', $this -> plugin_name), "?page=" . $this -> sections -> galleries . "&amp;method=save&amp;id=" . $gallery -> id); ?> |</span>
	                            	<span class="edit"><?php echo $this -> Html -> link(__('Hardcode', $this -> plugin_name), '?page=' . $this -> sections -> galleries . "&amp;method=hardcode&amp;id=" . $gallery -> id); ?> |</span>
	                            	<span class="edit"><?php echo $this -> Html -> link(__('Order Slides', $this -> plugin_name), '?page=' . $this -> sections -> slides . '&amp;method=order&amp;gallery_id=' . $gallery -> id); ?> |</span>
	                                <span class="delete"><?php echo $this -> Html -> link(__('Delete', $this -> plugin_name), "?page=" . $this -> sections -> galleries . "&amp;method=delete&amp;id=" . $gallery -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you want to permanently remove this slide?', $this -> plugin_name) . "')) { return false; }")); ?></span>
	                            </div>
	                        </td>
	                        <td>
	                        	<a href="?page=<?php echo $this -> sections -> galleries; ?>&amp;method=view&amp;id=<?php echo $gallery -> id; ?>"><?php echo $gallery -> slidescount; ?></a>
	                        </td>
	                        <td>
	                        	<code>[tribulant_slideshow gallery_id="<?php echo $gallery -> id; ?>"]</code>
	                        </td>
							<td><abbr title="<?php echo $gallery -> modified; ?>"><?php echo date(get_option('date_format'), strtotime($gallery -> modified)); ?></abbr></td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr class="no-items">
						<td class="colspanchange" colspan="<?php echo $colspan; ?>">
							<?php echo sprintf(__('No galleries available, %s', $this -> plugin_name), '<a href="' . admin_url('admin.php?page=' . $this -> sections -> galleries . '&method=save') . '">' . __('add one', $this -> plugin_name) . '</a>'); ?>
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
							<option <?php echo (!empty($_COOKIE[$this -> pre . 'galleriesperpage']) && $_COOKIE[$this -> pre . 'galleriesperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('per page', $this -> plugin_name); ?></option>
							<?php $p += 5; ?>
						<?php endwhile; ?>
						<?php if (isset($_COOKIE[$this -> pre . 'galleriesperpage'])) : ?>
							<option selected="selected" value="<?php echo $_COOKIE[$this -> pre . 'galleriesperpage']; ?>"><?php echo $_COOKIE[$this -> pre . 'galleriesperpage']; ?></option>
						<?php endif; ?>
					</select>
				<?php endif; ?>
				
				<script type="text/javascript">
				function change_perpage(perpage) {				
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>galleriesperpage=" + perpage + "; expires=<?php echo $this -> Html -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> UTC; path=/";
						window.location = "<?php echo preg_replace("/\&?" . $this -> pre . "page\=(.*)?/si", "", $_SERVER['REQUEST_URI']); ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
		</div>
	</form>
</div>