<?php
/*	Plugin Name:	Konami Code Easter Egg
	Plugin URL:		http://www.sleeplessdevelopers.com
	Description:	Add the Konami Code Easter Egg to your Wordpress site!
	Author:			Sleepless Developers
	Version:		1.0.1
	Author URI:		http://www.sleeplessdevelopers.com
	License:		GPLv2
	Text Domain:	sd-konami-code
*/

//Translate Plugin Title
__('Konami Code Easter Egg', 'sd-konami-code');

//Translate Plugin Description
__('Add the Konami Code Easter Egg to your Wordpress site!', 'sd-konami-code');

if ( ! class_exists( 'sd_konami_code' ) ) :

class sd_konami_code {

	// Lets run some basics
	function __construct() {
	
		// Add support for translations
		load_plugin_textdomain( 'sd-konami-code', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		
		// Register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_option( 'sleeplessdev_konami_event', '0' ); //Event Selector
		delete_option( 'sleeplessdev_konami_e1select', '0' ); //Play A Sound: Select sound
		add_option( 'sleeplessdev_konami_e1url', '' ); //Play A Sound: Custom sound URL
		add_option( 'sleeplessdev_konami_e2url', home_url() ); //Redirect to URL: URL to redirect
		
		// Register settings page
		add_action('admin_menu', array ($this,'plugin_options_page') );
		
		// Register Javascript
		add_action('init', array( $this, 'load_javascript' ) );
		add_action('wp_footer', array( $this, 'load_javascript_footer' ) );
		
	}

	function register_settings() { // Register settings
		register_setting( 'sleeplessdev_konami_settings', 'sleeplessdev_konami_event');
		register_setting( 'sleeplessdev_konami_settings', 'sleeplessdev_konami_e1url');
		register_setting( 'sleeplessdev_konami_settings', 'sleeplessdev_konami_e2url');
	}
	
	function load_javascript() {
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'sleeplessdev_konami_js', plugin_dir_url('').dirname( plugin_basename( __FILE__ ) ) . '/js/konami.js', array(), false, false);
		wp_enqueue_script( 'sleeplessdev_konami_js' );
	}
	
	function load_javascript_footer() {
		?>
		<script>
			var konamicode = 0;
			jQuery(window).konami(function(){ runkonamicode(); });
			function runkonamicode(){
				console.log("<?php _e("A wild Konami Code appeared!","sd-konami-code"); ?>");
				console.log("<?php _e("It is very effective!","sd-konami-code"); ?>");
				<?php if (get_option('sleeplessdev_konami_event')=='1'): ?>
					var audio = new Audio('<?php echo get_option('sleeplessdev_konami_e1url'); ?>');
					audio.play();
				<?php elseif(get_option('sleeplessdev_konami_event')=='2'): ?>
					window.location.href="<?php echo get_option('sleeplessdev_konami_e2url'); ?>";
				<?php endif; ?>
			}
		</script>
		<?php
	}
	
	function plugin_options_page() { //Register settings page
		add_options_page(__('Konami Code Easter Egg', 'sd-konami-code'), __('Konami Code Easter Egg', 'sd-konami-code'), 'manage_options', 'sd-konami-code.php', array($this,'plugin_options_page_contents') );
	}
	
	function plugin_options_page_contents() { //Build settings page
		?>
		<div class="wrap">
			<h2><?php _e('Settings'); ?> - <?php _e('Konami Code Easter Egg','sd-konami-code'); ?></h2>
			<form method="post" action="options.php"> 
				<?php wp_enqueue_media(); ?>
				<?php settings_fields( 'sleeplessdev_konami_settings' ); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Event','sd-konami-code'); ?></th>
						<td><select id="sleeplessdev_konami_event" name="sleeplessdev_konami_event">
							<option value="0" <?php if (get_option('sleeplessdev_konami_event')=='0'){echo 'selected';} ?>><?php _e('Do nothing','sd-konami-code'); ?></option>
							<option value="1" <?php if (get_option('sleeplessdev_konami_event')=='1'){echo 'selected';} ?>><?php _e('Play a sound','sd-konami-code'); ?></option>
							<option value="2" <?php if (get_option('sleeplessdev_konami_event')=='2'){echo 'selected';} ?>><?php _e('Redirect to an URL','sd-konami-code'); ?></option>
						</select></td>
					</tr>
				</table>
				<div style="display:none;" class="eventsettings sleeplessdev_konami_event1">
					<h3><?php _e('Event Settings',"sd-konami-code"); ?></h3>
					<table class="form-table">
						<tr class="customSound">
							<th><?php _e("Set a custom sound",'sd-konami-code'); ?></th>
							<td>
								<input id="customSoundUrl" name="sleeplessdev_konami_e1url" type="text" value="<?php echo get_option('sleeplessdev_konami_e1url'); ?>" /> <a id="uploadCustomSound" href="#" class="button"><?php _e("...",'sd-konami-code'); ?></a>
								<br/><em><?php _e("Browse your Media Library for sound files, upload one or paste the URL in the upload box.",'sd-konami-code'); ?></em><br/>
								<em><?php _e("Note: Some old browsers can not play sound files and not all sound files can be played by all browsers. MP3 files are supported by all modern browsers.",'sd-konami-code'); ?></em>
							</td>
						</tr>
					</table>
				</div>
				<div style="display:none;" class="eventsettings sleeplessdev_konami_event2">
					<h3><?php _e('Event Settings',"sd-konami-code"); ?></h3>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e('URL to redirect','sd-konami-code'); ?></th>
							<td><input type="text" name="sleeplessdev_konami_e2url" value="<?php echo get_option('sleeplessdev_konami_e2url'); ?>" /></td>
						</tr>
					</table>
				</div>
				<?php submit_button(); ?>
			</form>
		</div>
		<script>
			konamiEventSelectedCheck();
			function konamiEventSelectedCheck(){
				var konamiEventSelected = jQuery( "#sleeplessdev_konami_event" ).val();
				if ( konamiEventSelected == 0) { jQuery( ".eventsettings" ).hide(); }
				else if ( konamiEventSelected == 1) { jQuery( ".eventsettings" ).hide(); jQuery( ".sleeplessdev_konami_event1" ).show(); }
				else if ( konamiEventSelected == 2) { jQuery( ".eventsettings" ).hide(); jQuery( ".sleeplessdev_konami_event2" ).show(); }
			}
			jQuery( "#sleeplessdev_konami_event" ).change( konamiEventSelectedCheck );
			
			jQuery( "#uploadCustomSound" ).click(function(e) {
				e.preventDefault();
				var custom_uploader = wp.media({
					title: "<?php _e("Select a sound or upload one","sd-konami-code"); ?>",
					button: { text: "<?php _e("Use this sound","sd-konami-code"); ?>" },
					multiple: false,
					library: { type:'audio' }
				})
				.on('select', function() {
					var attachment = custom_uploader.state().get('selection').first().toJSON();
					jQuery('#customSoundUrl').val(attachment.url);
				})
				.open();
			});
		</script>
		<?php
	}

}

new sd_konami_code;

endif;