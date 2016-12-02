<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly	
	
?>

<?php if (!empty($paginate -> pagination)) : ?>
	<div class="tablenav-pages">
		<?php echo $paginate -> pagination; ?>
	</div>
<?php endif; ?>