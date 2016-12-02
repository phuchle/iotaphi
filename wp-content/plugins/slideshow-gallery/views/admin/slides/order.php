<?php
	
if (!defined('ABSPATH')) exit; // Exit if accessed directly	
	
?>

<div class="wrap">
	<h1><?php _e('Order Slides', $this -> plugin_name); ?><?php echo (!empty($gallery)) ? ': ' . __($gallery -> title) : ''; ?></h1>
	
	<div style="float:none;" class="subsubsub">
		<a href="<?php echo $this -> url; ?>"><?php _e('&larr; Manage All Slides', $this -> plugin_name); ?></a>
	</div>
	
	<p class="howto"><?php echo sprintf(__('This page lets you order all slides shown with %s.', $this -> plugin_name), '<code>[tribulant_slideshow]</code>'); ?><br/>
	<?php echo __('To order slides per gallery, go to Slideshow > Manage Galleries and order for that specific gallery.', $this -> plugin_name); ?></p>
	
	<?php if (!empty($slides)) : ?>
		<div id="slidemessage" class="updated fade" style="display:none; width:31%;"><!-- message will go here --></div>
		<div class="gallery_slides_list">
			<span class="gallery_slides_convert_list"><a href="#" id="gallery_convert_list"><i class="fa fa-reorder fa-fw"></i></a></span>
			<span class="gallery_slides_convert_grid"><a href="#" id="gallery_convert_grid"><i class="fa fa-th-large fa-fw"></i></a></span>
			<br class="clear" />
			<ul id="slidelist">
				<?php foreach ($slides as $slide) : ?>
					<li class="gallerylineitem" id="item_<?php echo $slide -> id; ?>">
						<span class="gallery_slide_image" style="display:none;"><img src="<?php echo $this -> Html -> otf_image_src($slide, 89, 89, 100); ?>" alt="<?php echo $this -> Html -> sanitize(__($slide -> title)); ?>" /></span>
						<span class="gallery_slide_title"><?php echo __($slide -> title); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<script type="text/javascript">
		var request_slides = false;
		jQuery(document).ready(function() {				
			jQuery('#gallery_convert_list').click(function() {
				jQuery('.gallery_slides_grid').removeClass('gallery_slides_grid').addClass('gallery_slides_list');
				
				return false;
			});
			
			jQuery('#gallery_convert_grid').click(function() {
				jQuery('.gallery_slides_list').removeClass('gallery_slides_list').addClass('gallery_slides_grid');
				
				return false;
			});
			
			jQuery("ul#slidelist").sortable({
				placeholder: "gallery-placeholder",
				revert: 100,
				distance: 5,
				start: function(request) {
					if (request_slides) { request_slides.abort(); }
					jQuery("#slidemessage").slideUp();
				},
				stop: function(request) {					
					jQuery.post(slideshowajax + '?action=slideshow_slides_order<?php echo (!empty($gallery)) ? '&gallery_id=' . $gallery -> id : ''; ?>', jQuery('#slidelist').sortable('serialize'), function(response) {
						jQuery('#slidemessage').html('<p>' + response + '</p>').fadeIn();
					});
				}
			});
		});
		</script>
	<?php else : ?>
		<p class="slideshow_error"><?php _e('No slides found', $this -> plugin_name); ?></p>
	<?php endif; ?>
</div>