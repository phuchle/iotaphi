<script type="text/javascript">

(function($){

	$('#<?php echo $id;?>').easyResponsiveTabs({
		type: '<?php echo $type; ?>', //Types: default, vertical, accordion           
   		width: 'auto', //auto or any custom width
   		tabidentify: '<?php echo $id;?>',
    	fit: true,   // 100% fits in a container
	});
	
})(jQuery);


</script>