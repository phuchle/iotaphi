<?php
	
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GallerySlide extends GalleryDbHelper {

	var $table;
	var $model = 'Slide';
	var $controller = "slides";
	
	var $data = array();
	var $errors = array();
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'description'		=>	"TEXT NOT NULL",
		'showinfo'			=>	"VARCHAR(50) NOT NULL DEFAULT 'both'",
		'iopacity'			=>	"INT(11) NOT NULL DEFAULT '70'",
		'image'				=>	"TEXT NOT NULL",
		'type'				=>	"ENUM('media','file','url') NOT NULL DEFAULT 'file'",
		'image_url'			=>	"TEXT NOT NULL",
		'attachment_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'uselink'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'linktarget'		=>	"ENUM('self','blank') NOT NULL DEFAULT 'self'",
		'link'				=>	"VARCHAR(200) NOT NULL DEFAULT ''",
		'order'				=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`), INDEX(`type`)",
	);
	
	var $indexes = array('type');

	function GallerySlide($data = array()) {
		global $wpdb;
		$this -> plugin_name = basename(dirname(dirname(__FILE__)));
		$this -> table = $wpdb -> prefix . strtolower($this -> pre) . "_" . $this -> controller;
		
		if (is_admin()) { $this -> check_table($this -> model); }
	
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = (stripslashes_deep($dval));
				
				switch ($dkey) {
					case 'id'					:
						$this -> galleries = array();
						$this -> gallery = array();
						
						$galleryslidesquery = "SELECT * FROM `" . $wpdb -> prefix . strtolower($this -> pre) . "_galleriesslides` WHERE `slide_id` = '" . $dval . "'";
						
						$query_hash = md5($galleryslidesquery);
						if ($oc_galleryslides = wp_cache_get($query_hash, 'slideshowgallery')) {
							$galleryslides = $oc_galleryslides;
						} else {
							$galleryslides = $wpdb -> get_results($galleryslidesquery);
							wp_cache_set($query_hash, $galleryslides, 'slideshowgallery', 0);
						}
						
						if (!empty($galleryslides)) {
							foreach ($galleryslides as $galleryslide) {
								$this -> galleries[] = $galleryslide -> gallery_id;
								$this -> gallery[$galleryslide -> gallery_id] = $wpdb -> get_row("SELECT * FROM `" . $wpdb -> prefix . strtolower($this -> pre) . "_galleries` WHERE `id` = '" . $galleryslide -> gallery_id . "'");
							}
						}
						break;
				}
			}
			
			$this -> image_path = $this -> Html -> image_path($data);
		}
		
		return true;
	}
	
	function defaults() {
		$defaults = array(
			'galleries'			=>	false,
			'order'				=>	0,
			'created'			=>	$this -> Html -> gen_date(),
			'modified'			=>	$this -> Html -> gen_date(),
		);
		
		return $defaults;
	}
	
	function validate($data = null) {
		$this -> errors = array();
	
		if (!empty($data)) {
			$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
			$data = stripslashes_deep($data);			
			extract($data, EXTR_SKIP);
			
			if (empty($title)) { $this -> errors['title'] = __('Please fill in a title', $this -> plugin_name); }
			if (empty($showinfo)) { $this -> data -> showinfo = "both"; }
			
			if (empty($type)) { $this -> errors['type'] = __('Please select an image type', $this -> plugin_name); }
			elseif ($type == "media") {
				if (!empty($media_file) && !empty($attachment_id)) {
					$imagename = basename($media_file);
					$attachment_metadata = wp_get_attachment_metadata($attachment_id);
					$this -> data -> image = $attachment_metadata['file'];
					$this -> data -> image_path = $media_file;
					$this -> data -> image_url = $media_file;
				} else {
					$this -> errors['media_file'] = __('Choose an image', $this -> plugin_name);
				}
			} elseif ($type == "file") {
				if (!empty($image_oldfile) && empty($_FILES['image_file']['name'])) {
					$imagename = $image_oldfile;
					$imagepath = $this -> Html -> uploads_path() . DS . $this -> plugin_name . DS;
					$imagefull = $imagepath . $imagename;
					
					$this -> data -> image = $imagename;
					$this -> Html -> image_path($this -> data);					
				} else {								
					if ($_FILES['image_file']['error'] <= 0) {
						$imagename = $_FILES['image_file']['name'];
						$image_name = $this -> Html -> strip_ext($imagename, "name");
						$image_ext = $this -> Html -> strip_ext($imagename, "ext");
						$imagename = $this -> Html -> sanitize($image_name) . '.' . $image_ext;
						
						$imagepath = $this -> Html -> uploads_path() . DS . $this -> plugin_name . DS;
						$imagefull = $imagepath . $imagename;
						
						$issafe = false;
						$mimes = get_allowed_mime_types();						
						foreach ($mimes as $type => $mime) {
							if (strpos($type, $image_ext) !== false) {
								$issafe = true;
							}
						}
						
						if (empty($issafe) || $issafe == false) {
							$this -> errors['image_file'] = __('This file type is not allowed for security reasons', $this -> plugin_name);
						} else {							
							$uploadedfile = $_FILES['image_file'];
							$upload_overrides = array('test_form' => false);
							$movefile = wp_handle_upload($uploadedfile, $upload_overrides);
							
							if (empty($movefile['error'])) {
								$file = _wp_relative_upload_path($movefile['file']);
								$this -> data -> image = $file;
							} else {
								$this -> errors['image_file'] = $movefile['error'];
							}
						}
					} else {					
						switch ($_FILES['image_file']['error']) {
							case UPLOAD_ERR_INI_SIZE		:
							case UPLOAD_ERR_FORM_SIZE 		:
								$this -> errors['image_file'] = __('The image file is too large', $this -> plugin_name);
								break;
							case UPLOAD_ERR_PARTIAL 		:
								$this -> errors['image_file'] = __('The image was partially uploaded, please try again', $this -> plugin_name);
								break;
							case UPLOAD_ERR_NO_FILE 		:
								$this -> errors['image_file'] = __('No image was chosen for uploading, please choose an image', $this -> plugin_name);
								break;
							case UPLOAD_ERR_NO_TMP_DIR 		:
								$this -> errors['image_file'] = __('No TMP directory has been specified for PHP to use, please ask your hosting provider', $this -> plugin_name);
								break;
							case UPLOAD_ERR_CANT_WRITE 		:
								$this -> errors['image_file'] = __('Image cannot be written to disc, please ask your hosting provider', $this -> plugin_name);
								break;
						}
					}
				}
			} elseif ($type == "url") {
				if (empty($image_url)) { $this -> errors['image_url'] = __('Please specify an image', $this -> plugin_name); }
				else {
					if ($image = wp_remote_fopen(str_replace(" ", "%20", $image_url))) {
						$filename = basename($image_url);
						$file_name = $this -> Html -> strip_ext($filename, "name");
						$file_ext = $this -> Html -> strip_ext($filename, "ext");
						$filename = $file_name . '.' . $file_ext;
						$filepath = $this -> Html -> uploads_path() . DS . $this -> plugin_name . DS;
						$filefull = $filepath . $filename;
						
						$issafe = false;
						$mimes = get_allowed_mime_types();												
						foreach ($mimes as $type => $mime) {
							if (strpos($type, $file_ext) !== false) {
								$issafe = true;
							}
						}
						
						$this -> data -> image = $filename;
						
						if (empty($issafe) || $issafe == false) {
							$this -> errors['image_url'] = __('This file type is not allowed for security reasons', $this -> plugin_name);
						} else {							
							if (true || !file_exists($filefull)) {								
								$fh = fopen($filefull, "w");
								fwrite($fh, $image);
								fclose($fh);
							}	
						}
					}
				}
			}
		} else {
			$this -> errors[] = __('No data was posted', $this -> plugin_name);
		}
		
		return apply_filters('slideshow_slide_validation', $this -> errors, $data);
	}
}

include_once(dirname(__FILE__) . DS . 'slideshow.php');

?>