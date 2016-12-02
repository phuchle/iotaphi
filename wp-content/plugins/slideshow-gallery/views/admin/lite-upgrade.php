<!-- LITE Upgrade -->

<?php

$plugin_link = "http://tribulant.com/plugins/view/13/wordpress-slideshow-gallery";

?>

<div class="wrap slideshow about-wrap">
	<h1>Upgrade to Slideshow Gallery PRO</h1>

	<div class="about-text">
		<?php echo sprintf('You are using the Slideshow Gallery LITE. Take your slideshows to the next level with %s. It gives you extra features to make your slideshows even better!', '<a href="' . $plugin_link . '" target="_blank">' . __('Slideshow Gallery PRO', $this -> plugin_name) . '</a>'); ?>
	</div>
	
	<div class="slideshow-badge">
		<div>
			<i class="fa fa-picture-o fa-fw" style="font-size: 72px !important; color: white;"></i>
		</div>
		<?php echo sprintf('Version %s', $this -> version); ?>
	</div>

	<div class="changelog slideshow-changelog">
		<div class="feature-section two-col">
			<div class="col">
				<h4>Extra Features in PRO</h4>
				<p><a href="<?php echo $plugin_link; ?>" target="_blank">Slideshow Gallery PRO</a> gives these extra features:</p>
				<ul>
					<li>13 different effects</li>
					<li>32 different easing effects</li>
					<li>Responsive (desktop/tablet/mobile) slideshows</li>
					<li>Mobile touch/swipe gestures support</li>
					<li>Information/description bar control</li>
					<li>Open/enlarge slideshow images in overlay</li>
					<li>Change featured posts/pages excerpt settings</li>
					<li>Multilingual with WPML and qTranslate-X</li>
					<li>Priority technical support</li>
					<li>And much more...</li>
				</ul>
			</div>
			<div class="col">
				<h4>Upgrade to PRO</h4>
				<p>Upgrading to Slideshow Gallery PRO is quick and easy by clicking the button below:</p>
				<p><a href="<?php echo $plugin_link; ?>" class="button button-primary button-hero" target="_blank"><i class="fa fa-mouse-pointer"></i> Buy PRO Now (only $19.99)</a></p>
				<p><?php _e('Once you have purchased a serial key, simply submit it to activate Slideshow Gallery PRO:', $this -> plugin_name); ?></p>
				<p><a class="button button-secondary button-large" href="<?php echo admin_url('admin.php?page=' . $this -> sections -> submitserial); ?>" onclick="jQuery.colorbox({href:ajaxurl + '?action=slideshow_serialkey'}); return false;"><i class="fa fa-key"></i> <?php _e('Submit Serial', $this -> plugin_name); ?></a></p>
			</div>
		</div>
	</div>
	
	<div class="changelog slideshow-changelog">
		<h3>About Tribulant Software</h3>
		<p><a href="http://tribulant.com" target="_blank"><img src="<?php echo $this -> url(); ?>/images/logo.png" alt="tribulant" /></a></p>
		<p>At Tribulant Software, we strive to provide the best WordPress plugins on the market.<br/>
		We are a full-time business developing, promoting and supporting WordPress plugins to the community.</p>
		<p>
			<a class="button button-primary button-large" target="_blank" href="http://tribulant.com">Visit Our Site</a>
		</p>
		
		<h3>Find Us On Social Networks</h3>
		<p>
			<!-- Facebook Like -->
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=229106274013";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			
			<div class="fb-like" data-href="https://www.facebook.com/tribulantsoftware" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
			
			<!-- Twitter Follow -->
			<a href="https://twitter.com/tribulant" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @tribulant</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			
			<!-- Google+ Follow -->
			<!-- Place this tag in your head or just before your close body tag. -->
			<script src="https://apis.google.com/js/platform.js" async defer></script>
			
			<!-- Place this tag where you want the widget to render. -->
			<div class="g-follow" data-annotation="none" data-height="20" data-href="//plus.google.com/u/0/116807944061700692613" data-rel="publisher"></div>
		</p>
	</div>
</div>