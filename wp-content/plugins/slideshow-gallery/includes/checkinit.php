<?php
	
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('GalleryCheckinit')) {
	class GalleryCheckinit {
	
		function GalleryCheckinit() {
			return true;	
		}
		
		function ci_initialize() {							
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			
			if (!is_plugin_active(plugin_basename($this -> plugin_file))) {			
				return;
			}
			
			add_action('wp_ajax_slideshow_serialkey', array($this, 'ajax_serialkey'));
		
			if (true || !is_admin() || (is_admin() && $this -> ci_serial_valid())) {
				$this -> ci_initialization();
			} else {				
				$this -> add_action('admin_print_styles', 'ci_print_styles', 10, 1);
				$this -> add_action('admin_print_scripts', 'ci_print_scripts', 10, 1);
				$this -> add_action('admin_notices');
				$this -> add_action('init', 'init', 10, 1);
				$this -> add_action('admin_menu', 'admin_menu');
			}
			
			return false;
		}
		
		function ci_initialization() {	
			
			$this -> add_action('after_plugin_row_' . $this -> plugin_name . '/slideshow-gallery.php', 'after_plugin_row', 10, 2);
			
			if ($this -> ci_serial_valid()) {	
				$this -> add_action('install_plugins_pre_plugin-information', 'display_changelog', 10, 1);
				$this -> add_filter('transient_update_plugins', 'check_update', 10, 1);
		        $this -> add_filter('site_transient_update_plugins', 'check_update', 10, 1);
		    }							
			
			return true;
		}
		
		function ci_get_serial() {
			if ($serial = $this -> get_option('serialkey')) {
				return $serial;
			}
			
			return false;
		}
		
		function ci_serial_valid() {
			$host = $_SERVER['HTTP_HOST'];
			$result = false;
			
			$existing = $this -> get_option('existing');
			if (!empty($existing)) return true;
			
			if (preg_match("/^(www\.)(.*)/si", $host, $matches)) {
				$wwwhost = $host;
				$nonwwwhost = preg_replace("/^(www\.)?/si", "", $wwwhost);
			} else {
				$nonwwwhost = $host;
				$wwwhost = "www." . $host;
			}
			
			if ($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "localhost:" . $_SERVER['SERVER_PORT']) {
				$result = true;	
			} else {
				if ($serial = $this -> ci_get_serial()) {			
					if ($serial == strtoupper(md5($_SERVER['HTTP_HOST'] . "gallery" . "mymasesoetkoekiesisfokkenlekker"))) {
						$result = true;
					} elseif (strtoupper(md5($wwwhost . "gallery" . "mymasesoetkoekiesisfokkenlekker")) == $serial || 
								strtoupper(md5($nonwwwhost . "gallery" . "mymasesoetkoekiesisfokkenlekker")) == $serial) {
						$result = true;
					}
				}
			}
			
			$result = apply_filters($this -> pre . '_serialkey_validation', $result);
			return $result;
		}
	}
}

?>