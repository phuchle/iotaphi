<?php header("Content-Type: text/css"); ?>

<?php $styles = array(); ?>
<?php foreach ($_GET as $skey => $sval) : ?>
	<?php $styles[$skey] = urldecode($sval); ?>
<?php endforeach; ?>

<?php

$unique = $styles['unique'];

?>

<?php if (!empty($styles['wrapperid'])) : ?>
	ul.slideshow<?php echo $unique; ?> { list-style:none !important; color:#fff; }
	ul.slideshow<?php echo $unique; ?> span { display:none; }
	#<?php echo $styles['wrapperid']; ?> { overflow:hidden; position:relative; width:<?php echo ($styles['width'] != "auto") ? ((int) $styles['width']) . 'px' : 'auto'; ?>; background:<?php echo $styles['background']; ?>; padding:0 0 0 0; border:<?php echo $styles['border']; ?>; margin:0; display:none; }
	#<?php echo $styles['wrapperid']; ?> * { margin:0; padding:0; }
	#<?php echo $styles['wrapperid']; ?> #fullsize<?php echo $unique; ?> { position:relative; z-index:1; overflow:hidden; width:<?php echo ($styles['width'] != "auto") ? ((int) $styles['width']) . 'px' : 'auto'; ?>; height:<?php echo ((int) $styles['height']); ?>px; clear:both; border: none; }
	#<?php echo $styles['wrapperid']; ?> #information<?php echo $unique; ?> { text-align:left; font-family:Verdana, Arial, Helvetica, sans-serif !important; position:absolute; bottom:0; width:<?php echo ($styles['width'] != "auto") ? ((int) $styles['width']) . 'px' : '100%'; ?>; height:0; background:<?php echo $styles['infobackground']; ?>; color:<?php echo $styles['infocolor']; ?>; overflow:hidden; z-index:300; opacity:.7; filter:alpha(opacity=70); }
	#<?php echo $styles['wrapperid']; ?> #information<?php echo $unique; ?> h3 { color:<?php echo $styles['infocolor']; ?>; padding:4px 8px 3px; margin:0 !important; font-size:16px; font-weight:bold; }
	#<?php echo $styles['wrapperid']; ?> #information<?php echo $unique; ?> a { color:<?php echo $styles['infocolor']; ?>; }
	#<?php echo $styles['wrapperid']; ?> #information<?php echo $unique; ?> p { color:<?php echo $styles['infocolor']; ?>; padding:0 8px 8px; margin:0 !important; font-size: 14px; font-weight:normal; }
	#<?php echo $styles['wrapperid']; ?> .infotop { margin-bottom:8px !important; top:0; }
	#<?php echo $styles['wrapperid']; ?> .infobottom { margin-top:8px !important; bottom:0; }
	<?php if (empty($styles['resizeimages']) || $styles['resizeimages'] == "Y") : ?>
		#<?php echo $styles['wrapperid']; ?> #image<?php echo $unique; ?> { width:<?php echo ($styles['width'] != "auto") ? ((int) $styles['width']) . 'px' : 'auto'; ?>; }
		#<?php echo $styles['wrapperid']; ?> #image<?php echo $unique; ?> img { border:none; border-radius:0; box-shadow:none; position:absolute; height:auto; max-width:100%; margin:0 auto; display:block; }
	<?php else : ?>
		#<?php echo $styles['wrapperid']; ?> #image<?php echo $unique; ?> { width:<?php echo ($styles['width'] != "auto") ? ((int) $styles['width']) . 'px' : 'auto'; ?>; }
		#<?php echo $styles['wrapperid']; ?> #image<?php echo $unique; ?> img { border:none; border-radius:0; box-shadow:none; position:absolute; left:0%; right:0%; max-height:100%; max-width:100%; margin:0 auto; display:block; }
	<?php endif; ?>
	#<?php echo $styles['wrapperid']; ?> .imgnav { position:absolute; width:25%; height:100%; cursor:pointer; z-index:250; }
	#<?php echo $styles['wrapperid']; ?> #imgprev<?php echo $unique; ?>:before { font-family:FontAwesome; content:"\f053"; font-size:30px; color:white; visibility:visible; left:0; text-align:left; width: auto; height:auto; line-height:160%; top:50%; margin:-30px 0 0 0; border-radius:0 10px 10px 0; background:black; padding:3px 10px 0 10px; position: absolute; display: inline-block; 	}
	#<?php echo $styles['wrapperid']; ?> #imgprev<?php echo $unique; ?> { display:none; -moz-user-select: none; -khtml-user-select: none; -webkit-user-select: none; -o-user-select: none; left:0; font-size:0px; }
	#<?php echo $styles['wrapperid']; ?> #imgnext<?php echo $unique; ?>:before { font-family:FontAwesome; content:"\f054"; font-size:30px; color:white; visibility:visible; right:0; text-align:right; width: auto; height:auto; line-height:160%; top:50%; margin:-30px 0 0 0; border-radius:10px 0 0 10px; background:black; padding:3px 10px 0 10px; position: absolute; display: inline-block; }
	#<?php echo $styles['wrapperid']; ?> #imgnext<?php echo $unique; ?> { display:none; -moz-user-select: none; -khtml-user-select: none; -webkit-user-select: none; -o-user-select: none; right:0; font-size:0px; }
	#<?php echo $styles['wrapperid']; ?> #imglink<?php echo $unique; ?> { position:absolute; zoom:1; background-color:#ffffff; height:100%; <?php if (!empty($styles['shownav']) && $styles['shownav'] == "true") : ?>width:50%; left:25%; right:20%;<?php else : ?>width:100%; left:0;<?php endif; ?> z-index:149; opacity:0; filter:alpha(opacity=0); }
	#<?php echo $styles['wrapperid']; ?> .linkhover:before { font-family:FontAwesome; content:"\f14c"; font-size:30px; text-align:center; height:auto; line-height:160%; width:auto; top:50%; left:auto; right:auto; margin:-30px 0 0 0; padding:0px 12px; display: inline-block; position: relative; background:black; color:white; border-radius:10px; }
	#<?php echo $styles['wrapperid']; ?> .linkhover { background:transparent !important; opacity:.4 !important; filter:alpha(opacity=40) !important; text-align:center; font-size:0px; }
	#<?php echo $styles['wrapperid']; ?> #thumbnails<?php echo $unique; ?> { background:<?php echo $styles['background']; ?>; }
	#<?php echo $styles['wrapperid']; ?> .thumbstop { margin-bottom:8px !important; }
	#<?php echo $styles['wrapperid']; ?> .thumbsbot { margin-top:8px !important; }
	#<?php echo $styles['wrapperid']; ?> #slideleft<?php echo $unique; ?>:before { font-family:FontAwesome; content: "\f104"; color:#999; position: absolute; height: auto; line-height:160%; width: auto; display: inline-block; top: 50%; font-size: 30px; margin: -30px 0 0 0; padding: 0 5px; }
	#<?php echo $styles['wrapperid']; ?> #slideleft<?php echo $unique; ?> { float:left; position:relative; width:20px; height:<?php echo ((int) $styles['thumbheight'] + 14); ?>px; background:#222; }
	#<?php echo $styles['wrapperid']; ?> #slideleft<?php echo $unique; ?>:hover { background-color:#333; }
	#<?php echo $styles['wrapperid']; ?> #slideright<?php echo $unique; ?>:before { font-family:FontAwesome; content: "\f105"; color:#999; position: absolute; height: auto; line-height:160%; width: auto; display: inline-block; top: 50%; font-size: 30px; margin: -30px 0 0 0; padding: 0 5px; }
	#<?php echo $styles['wrapperid']; ?> #slideright<?php echo $unique; ?> { float:right; position:relative; width:20px; height:<?php echo ((int) $styles['thumbheight'] + 14); ?>px; background:#222; }
	#<?php echo $styles['wrapperid']; ?> #slideright<?php echo $unique; ?>:hover { background-color:#333; }
	#<?php echo $styles['wrapperid']; ?> #slidearea<?php echo $unique; ?> { float:left; position:relative; background:<?php echo $styles['background']; ?>; width:<?php echo ($styles['width'] != "auto") ? ((int) $styles['width'] - 55) . 'px' : '90%'; ?>; margin:0 5px; height:<?php echo ((int) $styles['thumbheight'] + 14); ?>px; overflow:hidden; }
	#<?php echo $styles['wrapperid']; ?> #slider<?php echo $unique; ?> { position:absolute; width:<?php echo $styles['sliderwidth']; ?>px !important; left:0; height:<?php echo ((int) $styles['thumbheight'] + 14); ?>px; }
	#<?php echo $styles['wrapperid']; ?> #slider<?php echo $unique; ?> img { cursor:pointer; border:1px solid #666; padding:2px; float:left !important; }
	#<?php echo $styles['wrapperid']; ?> #spinner<?php echo $unique; ?> { position:relative; top:50%; left:45%; text-align:left; font-size:30px; }	
	#<?php echo $styles['wrapperid']; ?> #spinner<?php echo $unique; ?> img { border:none; }
	<?php if (!empty($styles['infohideonmobile'])) : ?> 
	@media (max-width:480px) { 	.slideshow-information { display: none !important; } }
	<?php endif; ?>
	<?php if (!empty($styles['thumbhideonmobile'])) : ?> 
	@media (max-width:480px) { 	.slideshow-thumbnails { display: none !important; } }
	<?php endif; ?>
<?php endif; ?>