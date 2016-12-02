<?php
	
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GalleryPlugin extends GalleryCheckinit {

	var $version = '1.6.4';
	var $plugin_name;
	var $plugin_base;
	var $pre = 'Gallery';
	
	var $menus = array();
	var $sections = array(
		'welcome'			=>	'slideshow-slides',
		'submitserial'		=>	'slideshow-submitserial',
		'about'				=>	'slideshow-gallery-about',
		'slides'			=>	'slideshow-slides',
		'galleries'			=>	'slideshow-galleries',
		'settings'			=>	'slideshow-settings',
	);
	
	var $helpers = array('Db', 'Html', 'Form', 'Metabox');
	var $models = array('Slide', 'Gallery', 'GallerySlides');
	var $debugging = false;		//set to "true" to turn on debugging
	var $debug_level = 2;		//set to 2 for PHP and DB errors or 1 for just DB errors
	
	function __call($method = null, $args = null) {
		$class = $this -> pre . $method;
						
		if (!class_exists($class)) {
			$file = $this -> plugin_base() . DS . 'models' . DS . strtolower($method) . '.php';
			if (file_exists($file)) {
				include($file);
			}
		}
		
		if (empty($this -> {$method}) || !is_object($this -> {$method})) {							
			if (class_exists($class)) {	
				$this -> {$method} = new $class($args);				
				return $this -> {$method};
			}
		} else {				
			return $this -> {$method};
		}
	}

	function register_plugin($name, $base) {
		$this -> plugin_name = $name;
		$this -> plugin_base = rtrim(dirname($base), DS);
		$this -> plugin_file = plugin_basename($base);
		$this -> sections = apply_filters('slideshow_sections', (object) $this -> sections);
		$this -> initialize_classes();
		//$this -> initialize_options();
		
		global $wpdb;
		$debugging = get_option('tridebugging');
		$this -> debugging = (empty($debugging)) ? $this -> debugging : true;
		
		if ($this -> debugging == true) {
			$wpdb -> show_errors();
			
			if ($this -> debug_level == 2) {
				error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
				@ini_set('display_errors', 1);
			}
		} else {
			$wpdb -> hide_errors();
			error_reporting(0);
			@ini_set('display_errors', 0);
		}
		
		return true;
	}
	
	function after_plugin_row($plugin_name = null) {		
        $key = $this -> get_option('serialkey');
        $update = $this -> vendor('update');
        $version_info = $update -> get_version_info();
        $hidemessage_upgradetopro = $this -> get_option('hidemessage_upgradetopro');
        
        if (empty($hidemessage_upgradetopro)) {
	        if (!$this -> ci_serial_valid() && !empty($version_info) && $version_info['is_valid_key'] == "0") {
		        echo '<tr id="slideshow-plugin-update-tr" class="plugin-update-tr">';
		        echo '<td colspan="3" class="plugin-update">';
		        echo '<div class="update-message">';
	
				echo sprintf(__('You are running Slideshow Gallery LITE. Take your slideshows to the next level with %s. Already purchased? %s.', $this -> plugin_name), '<a href="' . admin_url('admin.php?page=' . $this -> sections -> lite_upgrade) . '">Slideshow Gallery PRO</a>', '<a href="http://tribulant.com/docs/wordpress-slideshow-gallery/1758" target="_blank">' . __('See instructions to install PRO', $this -> plugin_name) . '</a>');
				echo ' <a class="button button-primary button-small" href="' . admin_url('admin.php?page=' . $this -> sections -> lite_upgrade) . '"><i class="fa fa-check"></i> ' . __('Upgrade to PRO', $this -> plugin_name) . '</a>';
				echo ' <a class="button button-secondary button-small" href="' . admin_url('admin.php?page=' . $this -> sections -> welcome . '&slideshow_method=hidemessage&message=upgradetopro') . '"><i class="fa fa-times"></i> ' . __('Hide this message', $this -> plugin_name) . '</a>';	        
	
		        echo '</div>';
		        echo '</td>';
		        echo '</tr>';
		        
		        ?>
		        
		        <script type="text/javascript">
			    jQuery(document).ready(function() {
				    var row = jQuery('#slideshow-plugin-update-tr').closest('tr').prev();
				    jQuery(row).addClass('update');
			    });
			    </script>
		        
		        <?php
	        }
	       }
    }
    
	/**
	 * This function outputs the changelog on the 'Plugins' page when the "View Details" link is clicked.
	 */
    function display_changelog() {	    	
    	if (!empty($_GET['plugin']) && $_GET['plugin'] == $this -> plugin_name) {			
	    	$update = $this -> vendor('update');
	    	if ($changelog = $update -> get_changelog()) {				
				$this -> render('changelog', array('changelog' => $changelog), true, 'admin');
	    	}
	    	
	    	exit();
    	}
    }
	
	function has_update($cache = true) {
		$update = $this -> vendor('update');
        $version_info = $update -> get_version_info($cache);
        return version_compare($this -> version, $version_info["version"], '<');
    }
	
	function check_update($option, $cache = true) {
		if ($update = $this -> vendor('update')) {
	        $version_info = $update -> get_version_info($cache);
	
	        if (!$version_info) { return $option; }
	        $plugin_path = $this -> plugin_file;
	        
	        if(empty($option -> response[$plugin_path])) {
				$option -> response[$plugin_path] = new stdClass();
	        }
	
	        //Empty response means that the key is invalid. Do not queue for upgrade
	        if(empty($version_info['is_valid_key']) || version_compare($this -> version, $version_info["version"], '>=')){
	            unset($option -> response[$plugin_path]);
	        } else {
	            $option -> response[$plugin_path] -> url = "http://tribulant.com";
	            $option -> response[$plugin_path] -> slug = $this -> plugin_name;
	            $option -> response[$plugin_path] -> package = $version_info['url'];
	            $option -> response[$plugin_path] -> new_version = $version_info["version"];
	            $option -> response[$plugin_path] -> id = "0";
	        }
        }

        return $option;
    }
    
    function ajax_serialkey() {
		define('DOING_AJAX', true);
		define('SHORTINIT', true);
		$errors = array();
		$success = false;
		
		if (!empty($_GET['delete'])) {
			$this -> delete_option('serialkey');
			$errors[] = __('Serial key has been deleted.', $this -> plugin_name);
		} else {
			if (!empty($_POST)) {
				if (empty($_REQUEST['serialkey'])) { $errors[] = __('Please fill in a serial key.', $this -> plugin_name); }
				else { 
					$this -> update_option('serialkey', $_REQUEST['serialkey']);	//update the DB option
					
					if (!$this -> ci_serial_valid()) { $errors[] = __('Serial key is invalid, please try again.', $this -> plugin_name); }
					else {
						delete_transient($this -> pre . 'update_info');
						$success = true; 
					}
				}
			}
		}
		
		delete_transient('slideshow_update_info');
		
		if (empty($_POST)) { ?><div id="slideshow_submitserial"><?php }
		$this -> render('submitserial', array('errors' => $errors, 'success' => $success), true, 'admin');
		if (empty($_POST)) { ?></div><?php }
		
		exit();
		die();
	}
	
	function ajax_slides_order() {	
		if (!empty($_REQUEST['item'])) {
			foreach ($_REQUEST['item'] as $order => $slide_id) {
				if (empty($_REQUEST['gallery_id'])) {
					$this -> Slide() -> save_field('order', ($order + 1), array('id' => $slide_id));
				} else {
					$this -> GallerySlides() -> save_field('order', ($order + 1), array('slide_id' => $slide_id, 'gallery_id' => $_REQUEST['gallery_id']));
				}
			}
			
			echo '<i class="fa fa-check"></i> ' . __('Slides have been ordered', $this -> plugin_name);
		}
		
		exit();
		die();
	}
	
	function ajax_tinymce() {
		$this -> render('tinymce-dialog', false, true, 'admin');
		
		exit();
		die();
	}
	
	function init_class($name = null, $params = array()) {
		if (!empty($name)) {
			$name = $this -> pre . $name;
				
			if (class_exists($name)) {
				if ($class = new $name($params)) {							
					return $class;
				}
			}
		}
		
		$this -> init_class('Country');
		
		return false;
	}
	
	function initialize_classes() {	
		if (!empty($this -> helpers)) {
			foreach ($this -> helpers as $helper) {
				$hfile = dirname(__FILE__) . DS . 'helpers' . DS . strtolower($helper) . '.php';
				
				if (file_exists($hfile)) {
					require_once($hfile);
					
					if (empty($this -> {$helper}) || !is_object($this -> {$helper})) {
						$classname = $this -> pre . $helper . 'Helper';
						
						if (class_exists($classname)) {
							$this -> {$helper} = new $classname;
						}
					}
				} 
			}
		}
		
		include_once(dirname(__FILE__) . DS . 'models' . DS . 'slideshow.php');
	}
	
	function updating_plugin() {
		if (!is_admin()) return;
		
		global $wpdb;
	
		if (!$this -> get_option('version')) {
			$this -> add_option('version', $this -> version);
			$this -> initialize_options();
			return;
		}

		$cur_version = $this -> get_option('version');
		$version = $this -> version;

		if (version_compare($this -> version, $cur_version) === 1) {			
			if (version_compare($cur_version, "1.4.8") < 0) {
				$this -> initialize_options();
				
				$query = "ALTER TABLE `" . $this -> Slide() -> table . "` CHANGE `image` `image` TEXT NOT NULL;";
				$wpdb -> query($query);
				
				$version = "1.4.8";
			}
			
			if (version_compare($cur_version, "1.5.3") < 0) {
				$this -> initialize_options();
				
				$query = "ALTER TABLE `" . $this -> Slide() -> table . "` CHANGE `type` `type` ENUM('media','file','url') NOT NULL DEFAULT 'media'";
				$wpdb -> query($query);
				
				
				$version = "1.5.3";
			}
			
			if (version_compare($cur_version, "1.6.4") < 0) {
				$this -> initialize_options();
				
				$version = "1.6.4";
			}
		
			//the current version is older.
			//lets update the database
			$this -> update_option('version', $version);
		}	
	}
	
	function initialize_options() {
		if (!is_admin()) { return; }
		
		$this -> init_roles();
	
		$styles = array(
			'layout'			=>	"responsive",
			'width'				=>	"450",
			'height'			=>	"250",
			'resheight'			=>	"50",
			'resheighttype' 	=>  "%",
			'border'			=>	"1px solid #CCCCCC",
			'background'		=>	"#000000",
			'infobackground'	=>	"#000000",
			'infocolor'			=>	"#FFFFFF",
			'resizeimages'		=>	"Y",
		);
		
		//$this -> add_option('existing', 1);	
		$this -> add_option('resizeimagescrop', "Y");
		$this -> update_option('imagespath', $this -> Html -> uploads_url() . '/' . $this -> plugin_name . '/');
		$this -> add_option('styles', $styles);
		$this -> add_option('effect', "fade");
		$this -> add_option('easing', "swing");
		$this -> add_option('slide_direction', "lr");
		$this -> add_option('fadespeed', 20);
		$this -> add_option('shownav', "Y");
		$this -> add_option('navopacity', 25);
		$this -> add_option('navhover', 75);
		$this -> add_option('information', "Y");
		$this -> add_option('infoposition', "bottom");
		$this -> add_option('infospeed', 10);
		$this -> add_option('infohideonmobile', 1);
		$this -> add_option('thumbnails', "N");
		$this -> add_option('thumbwidth', "100");
		$this -> add_option('thumbheight', "75");
		$this -> add_option('thumbposition', "bottom");
		$this -> add_option('thumbopacity', 70);
		$this -> add_option('thumbscrollspeed', 5);
		$this -> add_option('thumbspacing', 5);
		$this -> add_option('thumbactive', "#FFFFFF");
		$this -> add_option('thumbhideonmobile', 1);
		$this -> add_option('autoslide', "Y");
		$this -> add_option('autospeed', 10);
		$this -> add_option('alwaysauto', "true");
		$this -> add_option('imagesthickbox', "N");
		$this -> add_option('jsoutput', "perslideshow");
		
		$ratereview_scheduled = $this -> get_option('ratereview_scheduled');
		if (empty($ratereview_scheduled)) {
			wp_schedule_single_event(strtotime("+7 days"), 'slideshow_ratereviewhook', array(7));
			wp_schedule_single_event(strtotime("+14 days"), 'slideshow_ratereviewhook', array(14));
			wp_schedule_single_event(strtotime("+30 days"), 'slideshow_ratereviewhook', array(30));
			wp_schedule_single_event(strtotime("+60 days"), 'slideshow_ratereviewhook', array(60));
			wp_schedule_single_event(strtotime("+180 days"), 'slideshow_ratereviewhook', array(180));
			wp_schedule_single_event(strtotime("+360 days"), 'slideshow_ratereviewhook', array(360));
			$this -> update_option('ratereview_scheduled', true);
		}
		
		return;
	}
	
	function ratereview_hook($days = 7) {
		$this -> update_option('showmessage_ratereview', $days);
	} 
	
	function check_roles() {
		global $wp_roles;
		$permissions = $this -> get_option('permissions');
		
		if ($role = get_role('administrator')) {					
			if (!empty($this -> sections)) {			
				foreach ($this -> sections as $section_key => $section_menu) {								
					if (empty($role -> capabilities['slideshow_' . $section_key])) {
						$role -> add_cap('slideshow_' . $section_key);
						$permissions['administrator'][] = $section_key;
					}
				}
				
				$this -> update_option('permissions', $permissions);
			}
		}
		
		return false;		
	}
	
	function init_roles($sections = null) {
		global $wp_roles;
		$sections = $this -> sections;
	
		/* Get the administrator role. */
		$role = get_role('administrator');

		/* If the administrator role exists, add required capabilities for the plugin. */
		if (!empty($role)) {
			if (!empty($sections)) {			
				foreach ($sections as $section_key => $section_menu) {
					$role -> add_cap('slideshow_' . $section_key);
				}
			}
		} else if (empty($role) && !is_multisite()) {
			$newrolecapabilities = array();
			$newrolecapabilities[] = 'read';
		
			if (!empty($sections)) {
				foreach ($sections as $section_key => $section_menu) {
					$newrolecapabilities[] = 'slideshow_' . $section_key;
				}
			}

			add_role(
				'slideshow',
				_e('Slideshow Manager', $this -> plugin_name),
				$newrolecapabilities
			);
		}
		
		if (!empty($sections)) {
			$permissions = array();
		
			foreach ($sections as $section_key => $section_menu) {
				$wp_roles -> add_cap('administrator', 'slideshow_' . $section_key);
				$permissions['administrator'][] = $section_key;
			}
			
			$this -> update_option('permissions', $permissions);
		}
	}
	
	function render_msg($message = null, $dismissable = null, $escape = true) {
		if (!empty($escape)) $message = esc_html($message);
		$this -> render('msg-top', array('message' => $message, 'dismissable' => $dismissable), true, 'admin');
	}
	
	function render_err($message = null, $dismissable = null, $escape = true) {
		if (!empty($escape)) $message = esc_html($message);
		$this -> render('err-top', array('message' => $message, 'dismissable' => $dismissable), true, 'admin');
	}
	
	function redirect($location = null, $msgtype = null, $message = null, $action = null) {
		$url = $location;
		
		if ($msgtype == "message") {
			$url .= '&' . $this -> pre . 'updated=true';
		} elseif ($msgtype == "error") {
			$url .= '&' . $this -> pre . 'error=true';
		}
		
		if (!empty($message)) {
			$url .= '&' . $this -> pre . 'message=' . urlencode($message);
		}
		
		if (!empty($action)) {
			$url = wp_nonce_url($url, $action);
		}
		
		?>
		
		<script type="text/javascript">
		window.location = '<?php echo (empty($url)) ? get_option('home') : $url; ?>';
		</script>
		
		<?php
	}
	
	function paginate($model = null, $fields = '*', $sub = null, $conditions = null, $searchterm = null, $per_page = 10, $order = array('modified', "DESC")) {
		global $wpdb;
	
		if (!empty($model)) {
			global $paginate;
			$paginate = $this -> vendor('Paginate');
			$paginate -> table = $this -> {$model}() -> table;
			$paginate -> sub = (empty($sub)) ? $this -> sections -> {$this -> {$model}() -> controller} : $sub;
			$paginate -> fields = (empty($fields)) ? '*' : $fields;
			$paginate -> where = (empty($conditions)) ? false : $conditions;
			$paginate -> searchterm = (empty($searchterm)) ? false : $searchterm;
			$paginate -> per_page = $per_page;
			$paginate -> order = $order;
			
			$page = (empty($_GET[$this -> pre . 'page'])) ? 1 : $_GET[$this -> pre . 'page'];
			$data = $paginate -> start_paging(esc_html($page));
			
			if (!empty($data)) {
				$newdata = array();
			
				foreach ($data as $record) {
					$newdata[] = $this -> init_class($model, $record);
				}
				
				$data = array();
				$data[$model] = $newdata;
				$data['Paginate'] = $paginate;
			}
			
			return $data;
		}
		
		return false;
	}
	
	function vendor($name = null, $folder = null) {
		if (!empty($name)) {
			$filename = 'class.' . strtolower($name) . '.php';
			$filepath = rtrim(dirname(__FILE__), DS) . DS . 'vendors' . DS . $folder . '';
			$filefull = $filepath . $filename;
		
			if (file_exists($filefull)) {
				require_once($filefull);
				$class = 'Gallery' . $name;
				
				if (${$name} = new $class) {
					return ${$name};
				}
			}
		}
	
		return false;
	}
	
	function check_uploaddir() {
		$uploaddir = $this -> Html -> uploads_path() . DS . $this -> plugin_name . DS;
		$cachedir = $uploaddir . 'cache' . DS;
		
		if (!file_exists($uploaddir)) {
			if (@mkdir($uploaddir, 0777)) {
				@chmod($uploaddir, 0777);
				return true;
			} else {
				$message = sprintf(__('Uploads folder named "%s" cannot be created inside "%s"', $this -> plugin_name), $this -> plugin_name, "wp-content/uploads/");
				$this -> render_msg($message);
			}
		}
		
		if (!file_exists($cachedir)) {
			if (@mkdir($cachedir, 0777)) {
				@chmod($cachedir, 0777);
			} else {
				$message = sprintf(__('Slideshow cache folder "%s" for resizing images cannot be created inside "%s"', $this -> plugin_name), 'cache', 'wp-content/uploads/' . $this -> plugin_name . '/');
				$this -> render_msg($message);
			}
		}
		
		return false;
	}
	
	function add_action($action, $function = null, $priority = 10, $params = 1) {
		if (add_action($action, array($this, (empty($function)) ? $action : $function), $priority, $params)) {
			return true;
		}
		
		return false;
	}
	
	function add_filter($filter, $function = null, $priority = 10, $params = 1) {
		if (add_filter($filter, array($this, (empty($function)) ? $filter : $function), $priority, $params)) {
			return true;
		}
		
		return false;
	}
	
	function ci_print_styles() {
		wp_enqueue_style('slideshow', $this -> render_url('css/admin.css'), null, $this -> version, "all");
		wp_enqueue_style('colorbox', $this -> render_url('css/colorbox.css'), false, $this -> version, "all");
	}
	
	function ci_print_scripts() {
		wp_enqueue_script('slideshow', $this -> render_url('js/admin.js'), array('jquery'), '1.0', true);	
		wp_enqueue_script('colorbox', $this -> render_url('js/colorbox.js'), array('jquery'), false, true);
	}
	
	function print_scripts() {
		$this -> enqueue_scripts();
	}
	
	function enqueue_scripts() {	
		wp_enqueue_script('jquery');
		
		if (is_admin()) {
			$page = (!empty($_GET['page'])) ? esc_html($_GET['page']) : false;
			$method = (!empty($_GET['method'])) ? esc_html($_GET['method']) : false;
			
			if (!empty($page) && in_array($page, (array) $this -> sections)) {
				wp_enqueue_script('iris', admin_url('js/iris.min.js'), array('jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch'), false, 1);
			    wp_enqueue_script('wp-color-picker', admin_url('js/color-picker.min.js'), array( 'iris' ), false, 1);
			
				wp_enqueue_script('jquery-ui-tabs');
				wp_enqueue_script('jquery-ui-tooltip');
				wp_enqueue_script('jquery-ui-slider');
						
				if ($page == 'slideshow-settings') {
					wp_enqueue_script('common');
					wp_enqueue_script('wp-lists');
					wp_enqueue_script('postbox');
					wp_enqueue_script('plugin-install');
					wp_enqueue_script('settings-editor', $this -> render_url('js/settings-editor.js', "admin"), array('jquery'), '1.0');
				}
				
				if ($page == "slideshow-slides" && $method == "order") {
					wp_enqueue_script('jquery-ui-sortable');
				}
				
				if ($page == $this -> sections -> slides && ($method == "save" || $method == "save-multiple")) {
					wp_enqueue_media();
				}
				
				add_thickbox();
				wp_deregister_script('select2');
			}
			
			wp_enqueue_script('colorbox', $this -> render_url('js/colorbox.js', "admin"), array('jquery'), '1.6.3');
			wp_enqueue_script('select2', $this -> render_url('js/select2.js', "admin"), array('jquery'), '4.0.0');
			wp_enqueue_script($this -> plugin_name . 'admin', $this -> render_url('js/admin.js', "admin"), null, '1.0');
		} else {
			wp_enqueue_script($this -> plugin_name, $this -> render_url('js/gallery.js', "default"), null, '1.0');
			wp_enqueue_script('colorbox', $this -> render_url('js/colorbox.js', "default"), array('jquery'), '1.6.3');
			wp_enqueue_script('jquery-ui-effects', $this -> render_url('js/jquery-ui.js', "default"));
		}
		
		return true;
	}
	
	function get_css_url($attr = null, $layout = null) {
		$file = (empty($layout) || $layout == "specific") ? 'css' : 'css-responsive';
		$css_url = $this -> render_url($file . '.php', 'default') . '?';
		
		$default_attr = $this -> get_option('styles');
		$styles = wp_parse_args($attr, $default_attr);
		
		if (!empty($styles)) {	
			$s = 1;
			
			foreach ($styles as $skey => $sval) {			
				$css_url .= $skey . '=' . urlencode($sval);
				if ($s < count($styles)) { $css_url .= '&amp;'; }
				$s++;
			}
		}
		
		return $css_url;
	}
	
	function print_styles() {
		$this -> enqueue_styles();
	}
	
	function enqueue_styles() {
		if (is_admin()) {
			wp_enqueue_style($this -> plugin_name, $this -> render_url('css/admin.css', "admin"), null, "1.0", "all");
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_style('jquery-ui', $this -> render_url('css/jquery-ui.css', "admin"), null, "1.0", "all");
			wp_enqueue_style('colorbox', $this -> render_url('css/colorbox.css', "admin"), null, "1.3.19", "all");
			wp_enqueue_style('select2', $this -> render_url('css/select2.css', "admin"), false, '4.0.0', "all");
			wp_enqueue_style('fontawesome', $this -> render_url('css/fontawesome.css', "admin"), false, '4.4.0', "all");
		} else {
			wp_enqueue_style('colorbox', $this -> render_url('css/colorbox.css', "default"), null, "1.3.19", "all");
			wp_enqueue_style('fontawesome', $this -> render_url('css/fontawesome.css', "default"), false, '4.4.0', "all");
		}
	
		return true;
	}
	
	function plugin_base() {
		return rtrim(dirname(__FILE__), '/');
	}
	
	function url() {
		return site_url() . '/' . substr(preg_replace("/\\" . DS . "/si", "/", $this -> plugin_base()), strlen(ABSPATH));
	}
	
	function add_option($name = '', $value = '') {
		if (add_option($this -> pre . $name, $value)) {
			return true;
		}
		
		return false;
	}
	
	function update_option($name = null, $value = null) {	
		if (update_option($this -> pre . $name, $value)) {
			return true;
		}
		
		return false;
	}
	
	function get_option($name = null) {	
		if (!empty($name)) {
			if ($value = get_option($this -> pre . $name)) {
				return $value;
			}
		}
		
		return false;
	}
	
	function delete_option($name = null) {
		if (delete_option($this -> pre . $name)) {
			return true;
		}
		
		return false;
	}
	
	function debug($var = array()) {
		$debugging = get_option('tridebugging');
		$this -> debugging = (empty($debugging)) ? $this -> debugging : true;
	
		if ($this -> debugging) {
			echo '<pre>' . print_r($var, true) . '</pre>';
			return true;
		}
		
		return false;
	}
	
	function check_tables() {
		global $wpdb;
		
		if (!empty($this -> models)) {
			foreach ($this -> models as $model) {
				$this -> check_table($model);
			}
			
			$query = "ALTER TABLE `" . $this -> Slide() -> table . "` CHANGE `type` `type` ENUM('media','file','url') NOT NULL DEFAULT 'media'";
			$wpdb -> query($query);
		}
		
		return;
	}
	
	function check_table($model = null) {
		global $wpdb;
		
		$this -> initialize_classes();
	
		if (!empty($model)) {			
			if (!empty($this -> fields) && is_array($this -> fields)) {			
				if (!$wpdb -> get_var("SHOW TABLES LIKE '" . $this -> table . "'")) {				
					$query = "CREATE TABLE `" . $this -> table . "` (";
					$c = 1;
					
					foreach ($this -> fields as $field => $attributes) {
						if ($field != "key") {
							$query .= "`" . $field . "` " . $attributes . "";
						} else {
							$query .= "" . $attributes . "";
						}
						
						if ($c < count($this -> fields)) {
							$query .= ",";
						}
						
						$c++;
					}
					
					$query .= ") ENGINE=MyISAM AUTO_INCREMENT=1 CHARSET=UTF8;";
					
					if (!empty($query)) {
						$this -> table_query[] = $query;
					}
				} else {
					$field_array = $this -> get_fields($this -> table);
					
					foreach ($this -> fields as $field => $attributes) {					
						if ($field != "key") {
							$this -> add_field($this -> table, $field, $attributes);
						}
					}
					
					if (!empty($this -> indexes)) {
						foreach ($this -> indexes as $index) {
							$query = "SHOW INDEX FROM `" . $this -> table . "` WHERE `Key_name` = '" . $index . "'";
							if (!$wpdb -> get_row($query)) {
								$query = "ALTER TABLE `" . $this -> table . "` ADD INDEX(`" . $index . "`);";
								$wpdb -> query($query);	
							}
						}
					}
				}
				
				if (!empty($this -> table_query)) {				
					require_once(ABSPATH . 'wp-admin' . DS . 'upgrade-functions.php');
					dbDelta($this -> table_query, true);
				}
			}
		}
		
		return false;
	}
	
	function get_fields($table = null) {	
		global $wpdb;
	
		if (!empty($table)) {
			$fullname = $table;			
			$field_array = array();
			if ($fields = $wpdb -> get_results("SHOW COLUMNS FROM " . $fullname)) {
				foreach ($fields as $field) {
					$field_array[] = $field -> Field;
				}
				
				return $field_array;
			}
		}
		
		return false;
	}
	
	function delete_field($table = null, $field = null) {
		global $wpdb;
		
		if (!empty($table)) {
			if (!empty($field)) {
				$query = "ALTER TABLE `" . $wpdb -> prefix . "" . $table . "` DROP `" . $field . "`";
				
				if ($wpdb -> query($query)) {
					return false;
				}
			}
		}
		
		return false;
	}
	
	function change_field($table = null, $field = null, $newfield = null, $attributes = "TEXT NOT NULL") {
		global $wpdb;
		
		if (!empty($table)) {		
			if (!empty($field)) {			
				if (!empty($newfield)) {
					$field_array = $this -> get_fields($table);
					
					if (!in_array($field, $field_array)) {
						if ($this -> add_field($table, $newfield)) {
							return true;
						}
					} else {
						$query = "ALTER TABLE `" . $table . "` CHANGE `" . $field . "` `" . $newfield . "` " . $attributes . ";";
						
						if ($wpdb -> query($query)) {
							return true;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	function add_field($table = null, $field = null, $attributes = "TEXT NOT NULL") {
		global $wpdb;
	
		if (!empty($table)) {
			if (!empty($field)) {
				$field_array = $this -> get_fields($table);
				
				if (!empty($field_array)) {				
					if (!in_array($field, $field_array)) {					
						$query = "ALTER TABLE `" . $table . "` ADD `" . $field . "` " . $attributes . ";";
						
						if ($wpdb -> query($query)) {
							return true;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	function language_useordefault($content) {				
		$text = $content;
		
		if (!empty($text)) {
			$current_language = $this -> language_current();
			$language = (empty($current_language)) ? $this -> language_default() : $current_language;
			$text = $this -> language_use($language, $content, false);
		}
		
		return $text;
	}
	
	function language_use($lang = null, $text = null, $show_available = false) {
	
		if (!$this -> language_isenabled($lang)) { 
			return $text;
		}
		
		if (is_array($text) || is_object($text)) {				
			// handle arrays recursively
			if (is_array($text)) {
				foreach($text as $key => $t) {
					$text[$key] = $this -> language_use($lang, $text[$key], $show_available);
				}
			} elseif (is_object($text)) {
				foreach($text as $key => $t) {
					$text -> {$key} = $this -> language_use($lang, $text -> {$key}, $show_available);
				}
			}
			
			return $text;
		}
		
		if(is_object($text) && get_class($text) == '__PHP_Incomplete_Class') {
			foreach(get_object_vars($text) as $key => $t) {
				$text->$key = $this -> language_use($lang,$text -> $key,$show_available);
			}
			return $text;
		}
		
		// prevent filtering weird data types and save some resources
		if(!is_string($text) || $text == '') {
			return $text;
		}
		
		// get content
		$content = $this -> language_split($text);
		
		if (!is_array($content)) {
			return $content;
		}
		
		// find available languages
		$available_languages = array();
		foreach($content as $language => $lang_text) {
			$lang_text = trim($lang_text);
			if(!empty($lang_text)) $available_languages[] = $language;
		}
		
		// if no languages available show full text
		if(sizeof($available_languages)==0) return $text;
		// if content is available show the content in the requested language
		if(!empty($content[$lang])) {
			return $content[$lang];
		}
		// content not available in requested language (bad!!) what now?
		if(!$show_available){
			// check if content is available in default language, if not return first language found. (prevent empty result)
			if($lang != $this -> language_default()) {
				//if (!is_admin()) {
					$str = $this -> language_use($this -> language_default(), $text, $show_available);
				//}
				
				if ($q_config['show_displayed_language_prefix'])
					$str = "(". $this -> language_name($this -> language_default()) .") " . $str;
				return $str;
			}
			foreach($content as $language => $lang_text) {
				$lang_text = trim($lang_text);
				if (!empty($lang_text)) {
					$str = $lang_text;
					if ($q_config['show_displayed_language_prefix'])
						$str = "(". $this -> language_name($language) .") " . $str;
					return $str;
				}
			}
		}
		// display selection for available languages
		$available_languages = array_unique($available_languages);
		$language_list = "";
		if(preg_match('/%LANG:([^:]*):([^%]*)%/',$q_config['not_available'][$lang],$match)) {
			$normal_seperator = $match[1];
			$end_seperator = $match[2];
			// build available languages string backward
			$i = 0;
			foreach($available_languages as $language) {
				if($i==1) $language_list  = $end_seperator.$language_list;
				if($i>1) $language_list  = $normal_seperator.$language_list;
				$language_list = "<a href=\"". $this -> language_converturl('', $language)."\">". $this -> language_name($language) ."</a>".$language_list;
				$i++;
			}
		}
		return "<p>".preg_replace('/%LANG:([^:]*):([^%]*)%/', $language_list, $q_config['not_available'][$lang])."</p>";
	}
	
	function language_converturl($url = null, $language = null) {
		global $slideshow_languageplugin;
	
		if (!empty($url) && !empty($language)) {
			switch ($slideshow_languageplugin) {
				case 'qtranslate'				:
					$url = qtrans_convertURL($url, $language);
					break;
				case 'qtranslate-x'				:
					$url = qtranxf_convertURL($url, $language);
					break;
				case 'wpml'						:
					if (function_exists('icl_get_languages')) {
						$languages = icl_get_languages();
						$language = $this -> language_current();
						
						if (!empty($languages[$language]['url'])) {
							//$url = $languages[$language]['url'];
						}
					}
					break;
			}
		}
		
		return $url;
	}
	
	function language_default() {		
		global $slideshow_languageplugin, $slideshow_languagedefault;
		$default = false;
		
		if (!empty($slideshow_languagedefault)) {
			return $slideshow_languagedefault;
		}
		
		switch ($slideshow_languageplugin) {
			case 'qtranslate'				:
			case 'qtranslate-x'				:
				global $q_config;
				$default = $q_config['default_language'];
				break;
			case 'wpml'						:
				global $sitepress;
				$default = $sitepress -> get_default_language();
				break;
		}
		
		$slideshow_languagedefault = $default;
		return $default;
	}
	
	function language_name($language = null) {
		$name = false;
	
		if (!empty($language)) {
			global $slideshow_languageplugin, ${'slideshow_languagename_' . $language};
			
			if (!empty(${'slideshow_languagename_' . $language})) {
				return ${'slideshow_languagename_' . $language};
			}
			
			switch ($slideshow_languageplugin) {
				case 'qtranslate'				:
				case 'qtranslate-x'				:
					global $q_config;
					$name = $q_config['language_name'][$language];
					break;
				case 'wpml'						:
					if (function_exists('icl_get_languages')) {
						$languages = icl_get_languages();
						if (!empty($languages[$language]['translated_name'])) {
							$name = $languages[$language]['translated_name'];
						}
					}
					break;
			}
		}
		
		${'slideshow_languagename_' . $language} = $name;
		return $name;
	}
	
	function language_do() {
		global $slideshow_languageplugin;
		
		if (!$this -> ci_serial_valid()) {
			return false;
		}
	
		if (empty($slideshow_languageplugin)) {			
			if ($this -> is_plugin_active('qtranslate')) {
				$slideshow_languageplugin = "qtranslate";
				return true;
			} elseif ($this -> is_plugin_active('qtranslate-x')) {
				$slideshow_languageplugin = 'qtranslate-x';
				return true;
			} elseif ($this -> is_plugin_active('wpml')) {
				if (!empty($_GET['lang']) && $_GET['lang'] == "all") {
					return false;
				}
			
				$slideshow_languageplugin = "wpml";
				return true;
			}
		} else {
			return true;
		}
		
		return false;
	}
	
	function language_current() {
		global $slideshow_languageplugin, $slideshow_languagecurrent;
		$current = false;
		
		if (!empty($slideshow_languagecurrent)) {
			return $slideshow_languagecurrent;
		}
		
		switch ($slideshow_languageplugin) {
			case 'qtranslate'			:
				if (function_exists('qtrans_getLanguage')) {
					$current = qtrans_getLanguage();
				}
				break;
			case 'qtranslate-x'			:
				if (function_exists('qtranxf_getLanguage')) {
					$current = qtranxf_getLanguage();
				}
				break;
			case 'wpml'					:
				$current = ICL_LANGUAGE_CODE;
				break;
		}
		
		$slideshow_languagecurrent = $current;
		return $current;
	}
	
	function language_flag($language = null) {
		global $slideshow_languageplugin, ${'slideshow_languageflag_' . $language};
		$flag = false;
		
		if (!empty(${'slideshow_languageflag_' . $language})) {
			return ${'slideshow_languageflag_' . $language};
		}
	
		switch ($slideshow_languageplugin) {
			case 'qtranslate'			:
			case 'qtranslate-x'			:
				global $q_config;
				$flag = '<img src="' . content_url() . '/' . $q_config['flag_location'] . '/' . $q_config['flag'][$language] . '" alt="' . $language . '" />';
				break;
			case 'wpml'					:
				if (function_exists('icl_get_languages')) {
					$languages = icl_get_languages();
					$flag = '<img src="' . $languages[$language]['country_flag_url'] . '" alt="' . $language . '" />';
				}
				break;
		}
		
		${'slideshow_languageflag_' . $language} = $flag;
		return $flag;
	}
	
	function language_isenabled($language = null) {
		$enabled = false;
	
		if (!empty($language)) {
			global $slideshow_languageplugin, ${'slideshow_languageenabled_' . $language};
			
			if (!empty(${'slideshow_languageenabled_' . $language})) {
				return ${'slideshow_languageenabled_' . $language};
			}
		
			switch ($slideshow_languageplugin) {
				case 'qtranslate'				:
					$enabled = qtrans_isEnabled($language);
					break;
				case 'qtranslate-x'				:
					$enabled = qtranxf_isEnabled($language);
					break;
				case 'wpml'						:
					if (function_exists('icl_get_languages')) {
						$languages = icl_get_languages();
						if (!empty($languages[$language])) {
							$enabled = true;
						}
					}
					break;
			}
		}
		
		${'slideshow_languageenabled_' . $language} = $enabled;
		return $enabled;
	}
	
	function language_join($texts = array(), $tagTypeMap = array(), $strip_tags = false) {
		if(!is_array($texts)) $texts = $this -> language_split($texts, false);
		$split_regex = "#<!--more-->#ism";
		$max = 0;
		$text = "";
		$languages = $this -> language_getlanguages();
		
		foreach ($languages as $language) {
			$tagTypeMap[$language] = true;
		}
		
		foreach($languages as $language) {
			if (!empty($texts[$language])) {
				$texts[$language] = preg_split($split_regex, $texts[$language]);
				if(sizeof($texts[$language]) > $max) $max = sizeof($texts[$language]);
			}
		}
		
		for ($i = 0; $i < $max; $i++) {
			if($i>=1) {
				$text .= '<!--more-->';
			}
			foreach($languages as $language) {
				if (isset($texts[$language][$i]) && $texts[$language][$i] !== '') {
					
					if ($strip_tags) {
						$texts[$language][$i] = strip_tags($texts[$language][$i]);
					}
					
					if (empty($tagTypeMap[$language])) {
						$text .= '<!--:'.$language.'-->'.$texts[$language][$i].'<!--:-->';
					} else {
						$text .= "[:{$language}]{$texts[$language][$i]}";
					}
				}
			}
		}
		
		return $text;
	}
	
	function language_split($text, $quicktags = true, array $languageMap = NULL) {
		$array = false;
		
		if (!empty($text)) {	
			//init vars
			$split_regex = "#(<!--[^-]*-->|\[:[a-z-]{2,10}\])#ism";
			$current_language = "";
			$result = array();
			
			$languages = $this -> language_getlanguages();
			foreach ($languages as $language) {
				$result[$language] = "";
			}
			
			// split text at all xml comments
			$blocks = preg_split($split_regex, $text, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
			
			foreach($blocks as $block) {
				# detect language tags
				if(preg_match("#^<!--:([a-z-]{2,10})-->$#ism", $block, $matches)) {
					if($this -> language_isenabled($matches[1])) {
						$current_language = $matches[1];
						$languageMap[$current_language] = false;
					} else {
						$current_language = "invalid";
					}						
					continue;
				// detect quicktags
				} elseif($quicktags && preg_match("#^\[:([a-z-]{2,10})\]$#ism", $block, $matches)) {						
					if($this -> language_isenabled($matches[1])) {
						$current_language = $matches[1];
						$languageMap[$current_language] = true;
					} else {
						$current_language = "invalid";
					}
					
					continue;
				} elseif(preg_match("#^<!--:-->$#ism", $block, $matches)) {
					$current_language = "";
					continue;
				} elseif(preg_match("#^<!--more-->$#ism", $block, $matches)) {
					foreach($languages as $language) {
						$result[$language] .= $block;
					}
					
					continue;
				}
				
				if($current_language == "") {
					foreach($languages as $language) {
						$result[$language] .= $block;
					}
				} elseif($current_language != "invalid") {
					$result[$current_language] .= $block;
				}
			}
			
			foreach($result as $lang => $lang_content) {
				$result[$lang] = str_replace('[:]', '', preg_replace("#(<!--more-->|<!--nextpage-->)+$#ism", "", $lang_content));
			}
			
			return $result;
		}
		
		return $array;
	}
	
	function language_getlanguages() {
		global $slideshow_languageplugin, $slideshow_languagelanguages;
		$languages = false;
		
		if (!empty($slideshow_languagelanguages)) {
			return $slideshow_languagelanguages;
		}
	
		switch ($slideshow_languageplugin) {
			case 'qtranslate'					:
				if (function_exists('qtrans_getSortedLanguages')) {
					$languages = qtrans_getSortedLanguages();
				}
				break;
			case 'qtranslate-x'					:
				if (function_exists('qtranxf_getSortedLanguages')) {
					$languages = qtranxf_getSortedLanguages();
				}
				break;
			case 'wpml'							:				
				if (function_exists('icl_get_languages')) {
					$icl_languages = icl_get_languages();
					$languages = array();
					foreach ($icl_languages as $lang => $icl_language) {
						$languages[] = $lang;
					}
				}
				break;
		}
		
		$slideshow_languagelanguages = $languages;
		return $languages;
	}
	
	function is_plugin_active($name = null, $orinactive = false) {
		if (!empty($name)) {		
			require_once ABSPATH . 'wp-admin' . DS . 'includes' . DS . 'admin.php';
			
			if (empty($path)) {
				switch ($name) {
					case 'qtranslate'							:
						$path = 'qtranslate' . DS . 'qtranslate.php';
						break;
					case 'qtranslate-x'							:
						$path = 'qtranslate-x' . DS . 'qtranslate.php';
						break;
					case 'wpml'									:
						$path = 'sitepress-multilingual-cms' . DS . 'sitepress.php';
						break;
					case 'captcha'								:
						$path = 'really-simple-captcha' . DS . 'really-simple-captcha.php';
						break;
					default						:
						$path = $name;
						break;
				}
			}
			
			$path2 = str_replace("\\", "/", $path);
			
			if (!empty($name) && $name == "qtranslate") {
				$path2 = 'mqtranslate' . DS . 'mqtranslate.php';
			}
			
			if (!empty($path)) {
				$plugins = get_plugins();
				
				if (!empty($plugins)) {
					if (array_key_exists($path, $plugins) || array_key_exists($path2, $plugins)) {
						/* Let's see if the plugin is installed and activated */
						if (is_plugin_active(plugin_basename($path)) ||
							is_plugin_active(plugin_basename($path2))) {
							return true;
						}
						
						/* Maybe the plugin is installed but just not activated? */
						if (!empty($orinactive) && $orinactive == true) {
							if (is_plugin_inactive(plugin_basename($path)) ||
								is_plugin_inactive(plugin_basename($path2))) {
								return true;	
							}
						}	
					}
				}
			}
		}
		
		return false;
	}
	
	function has_child_theme_folder() {
		$theme_path = get_stylesheet_directory();
		$full_path = $theme_path . DS . 'slideshow';
		
		if (file_exists($full_path)) {
			return true;
		}
		
		return false;
	}
	
	function render_url($file = null, $folder = 'admin', $extension = null) {	
		$this -> plugin_name = basename(dirname(__FILE__));
	
		if (!empty($file)) {		
			if (!empty($folder) && $folder != "admin") {
				$theme_folder = $this -> get_option('theme_folder');
				$folder = (!empty($theme_folder)) ? $theme_folder : $folder;
				$folderurl = plugins_url() . '/' . $this -> plugin_name . '/views/' . $folder . '/';
			
				$template_url = get_stylesheet_directory_uri();
				$theme_path = get_stylesheet_directory();
				$full_path = $theme_path . DS . 'slideshow' . DS . $file;
				
				if (!empty($theme_path) && file_exists($full_path)) {
					$folderurl = $template_url . '/slideshow/';
				}
			} else {
				$folderurl = plugins_url() . '/' . $this -> plugin_name . '/';
			}
			
			$url = $folderurl . $file;			
			return $url;
		}
		
		return false;
	}
	
	function render($file = null, $params = array(), $output = true, $folder = 'admin') {	
		
		if (!empty($file)) {
			$this -> plugin_name = basename(dirname(__FILE__));
			$this -> plugin_base = rtrim(dirname(__FILE__), DS);
			$this -> sections = apply_filters('slideshow_sections', (object) $this -> sections);
			
			$theme_serve = false;
			$filename = $file . '.php';
			$filepath = $this -> plugin_base() . DS . 'views' . DS . $folder . DS;
			
			if (!empty($folder) && $folder != "admin") {				
				$theme_path = get_stylesheet_directory();
				$full_path = $theme_path . DS . 'slideshow' . DS . $filename;
				
				if (!empty($theme_path) && file_exists($full_path)) {
					$folder = $theme_path . DS . 'slideshow';
					$theme_serve = true;
				}
			}
			
			if (empty($theme_serve)) {
				$filepath = $this -> plugin_base() . DS . 'views' . DS . $folder . DS;
			} else {
				$filepath = $folder . DS;
			}
			
			$filefull = $filepath . $filename;
		
			if (file_exists($filefull)) {
				if (!empty($params)) {
					foreach ($params as $pkey => $pval) {
						${$pkey} = $pval;
					}
				}
				
				$this -> initialize_classes();
			
				if ($output == false) {
					ob_start();
				}
				
				include($filefull);
				
				if ($output == false) {					
					$data = ob_get_clean();					
					return $data;
				} else {
					return true;
				}
			}
		}
		
		return false;
	}
}

?>