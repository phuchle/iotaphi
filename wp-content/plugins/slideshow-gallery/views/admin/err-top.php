<?php
	
if (!defined('ABSPATH')) exit; // Exit if accessed directly	
	
?>

<?php if (!empty($message)) : ?>
	<div id="message" class="slideshow notice error">
		<p><i class="fa fa-times"></i> <?php echo $message; ?></p>
		<?php if (!empty($dismissable)) : ?>
			<a href="<?php echo $dismissable; ?>" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice.', $this -> plugin_name); ?></span></a>
		<?php endif; ?>
	</div>
<?php endif; ?>