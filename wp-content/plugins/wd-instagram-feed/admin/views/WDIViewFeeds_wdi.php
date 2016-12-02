<?php

class WDIViewFeeds_wdi {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $model;
  
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct($model) {
    $this->model = $model;
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function display() {
    /*My Edit*/
    global $wdi_options;
    $rows_data = $this->model->get_rows_data();
    $page_nav = $this->model->page_nav();
    $search_value = ((isset($_POST['search_value'])) ? esc_html(stripslashes($_POST['search_value'])) : '');
    $search_select_value = ((isset($_POST['search_select_value'])) ? (int) $_POST['search_select_value'] : 0);
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html(stripslashes($_POST['asc_or_desc'])) : 'asc');
    $order_by = (isset($_POST['order_by']) ? esc_html(stripslashes($_POST['order_by'])) : 'id');
    $order_class = 'manage-column column-title sorted ' . $asc_or_desc;
    $ids_string = '';
    ?>
    <!-- Banner Start -->
    <div style="clear: both; float: left; width: 100%;">
          <div style="float: left; font-size: 14px; font-weight: bold;">
            <?php _e('This Section Allows You to Add/Edit Feeds','wdi') ?>
            <a style="color: #15699F; text-decoration: none;" target="_blank" href="https://web-dorado.com/wordpress-instagram-feed-wd/creating-feeds.html"><?php _e('Read More in User Manual',"wdi"); ?></a>
          </div>
          <div style="float: right; text-align: right;margin-top:10px">
            <a style="text-decoration: none;" target="_blank" href="https://web-dorado.com/files/fromInstagramFeedWD.php">
              <img width="215" border="0" alt="web-dorado.com" src="<?php echo WDI_URL . '/images/wd_logo.png'; ?>" />
            </a>
          </div>
    </div>
    <!-- Banner END -->
    <form class="wrap" id="sliders_form" method="post" action="admin.php?page=wdi_feeds" style="float: left; width: 99%;">
      <?php wp_nonce_field('nonce_wd', 'nonce_wd'); ?>
      <input type="hidden" id="wdi_access_token" name="access_token" value="<?php echo isset($wdi_options['wdi_access_token'])?$wdi_options['wdi_access_token']:'';?>">
      <span class="slider-icon"></span>
      <h2>
        <?php _e('Feeds', "wdi"); ?>
        <a href="" class="add-new-h2" onclick="wdi_spider_set_input_value('task', 'add');
              if(document.getElementById('wdi_access_token').value!=''){
                    wdi_spider_form_submit(event, 'sliders_form');
              }"><?php _e('Add new', "wdi"); ?></a>
      </h2>
      <div class="buttons_div">
        <span class="button-secondary non_selectable" onclick="wdi_spider_check_all_items()">
          <input type="checkbox" id="check_all_items" name="check_all_items" onclick="wdi_spider_check_all_items_checkbox()" style="margin: 0; vertical-align: middle;" />
          <span style="vertical-align: middle;"><?php _e('Select All', "wdi"); ?></span>
        </span>
        <input class="button-secondary" type="submit" onclick="wdi_spider_set_input_value('task', 'publish_all')" value="<?php esc_attr_e('Publish', "wdi"); ?>" />
        <input class="button-secondary" type="submit" onclick="wdi_spider_set_input_value('task', 'unpublish_all')" value="<?php esc_attr_e('Unpublish', "wdi"); ?>" />
        <input class="button-secondary" type="submit" onclick="wdi_spider_set_input_value('task', 'duplicate_all')" value="<?php esc_attr_e('Duplicate', "wdi"); ?>" />
        
        <input class="button-secondary" type="submit" onclick="if (confirm('<?php esc_attr_e('Do you want to delete selected items?', "wdi"); ?>')) {
                                                       wdi_spider_set_input_value('task', 'delete_all');
                                                     } else {
                                                       return false;
                                                     }" value="<?php esc_attr_e('Delete', "wdi"); ?>" />
      </div>
      <div class="tablenav top">
        <?php
        WDILibrary::search(__('Name',"wdi"), $search_value, 'sliders_form');
        WDILibrary::html_page_nav($page_nav['total'], $page_nav['limit'], 'sliders_form');
        ?>
      </div>
      <table class="wp-list-table widefat fixed pages">
        <thead>
          <th class="manage-column column-cb check-column table_small_col"><input id="check_all" type="checkbox" onclick="wdi_spider_check_all(this)" style="margin:0;" /></th>
          <th class="table_small_col <?php if ($order_by == 'id') {echo $order_class;} ?>">
            <a onclick="wdi_spider_set_input_value('task', '');
                        wdi_spider_set_input_value('order_by', 'id');
                        wdi_spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'id') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        wdi_spider_form_submit(event, 'sliders_form')" href="">
              <span>ID</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_big_col"><?php _e("Feed","wdi")?></th>
          <th class="<?php if ($order_by == 'feed_name') {echo $order_class;} ?>">
            <a onclick="wdi_spider_set_input_value('task', '');
                        wdi_spider_set_input_value('order_by', 'feed_name');
                        wdi_spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'feed_name') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        wdi_spider_form_submit(event, 'sliders_form')" href="">
              <span><?php _e('Name', "wdi"); ?></span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_big_col"><?php _e('Shortcode', "wdi"); ?></th>
          <th class="table_large_col"><?php _e('PHP function', "wdi"); ?></th>
          <th class="table_big_col <?php if ($order_by == 'published') {echo $order_class;} ?>">
            <a onclick="wdi_spider_set_input_value('task', '');
                        wdi_spider_set_input_value('order_by', 'published');
                        wdi_spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'published') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        wdi_spider_form_submit(event, 'sliders_form')" href="">
              <span><?php _e('Published', "wdi"); ?></span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_big_col"><?php _e('Edit', "wdi"); ?></th>
          <th class="table_big_col"><?php _e('Delete', "wdi"); ?></th>
        </thead>
        <tbody id="tbody_arr">
          <?php
          if ($rows_data) {
            foreach ($rows_data as $row_data) {
              $alternate = (!isset($alternate) || $alternate == 'class="alternate"') ? '' : 'class="alternate"';
              $published_image = (($row_data->published) ? 'publish' : 'unpublish');
              $published = (($row_data->published) ? 'unpublish' : 'publish');
              $prev_img_url = $this->model->get_slider_prev_img($row_data->id);
              ?>
              <tr id="tr_<?php echo $row_data->id; ?>" <?php echo $alternate; ?>>
                <td class="table_small_col check-column"><input id="check_<?php echo $row_data->id; ?>" name="check_<?php echo $row_data->id; ?>" onclick="wdi_spider_check_all(this)" type="checkbox" /></td>
                <td class="table_small_col"><?php echo $row_data->id; ?></td>
                <td class="table_big_col">
                  <img title="<?php echo $row_data->feed_name; ?>" style="border: 1px solid #CCCCCC; max-width: 70px; max-height: 50px;" src="<?php echo $prev_img_url . '?date=' . date('Y-m-y H:i:s'); ?>">
                </td>
                <td>
                  <a onclick="wdi_spider_set_input_value('task', 'edit');
                                wdi_spider_set_input_value('page_number', '1');
                                wdi_spider_set_input_value('search_value', '');
                                wdi_spider_set_input_value('search_or_not', '');
                                wdi_spider_set_input_value('asc_or_desc', 'asc');
                                wdi_spider_set_input_value('order_by', 'order');
                                wdi_spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                wdi_spider_form_submit(event, 'sliders_form')" href="" title="Edit"><?php echo $row_data->feed_name; ?>
                  </a>
                </td>
                <td class="table_big_col" style="padding-left: 0; padding-right: 0;">
                  <input type="text" value='[wdi_feed id="<?php echo $row_data->id; ?>"]' onclick="wdi_spider_select_value(this)" size="11" readonly="readonly" style="padding-left: 1px; padding-right: 1px;" />
                </td>
                <td class="table_large_col" style="padding-left: 0; padding-right: 0;">
                  <input type="text" value="&#60;?php echo wdi_feed(array('id'=>'<?php echo $row_data->id; ?>')); ?&#62;" onclick="wdi_spider_select_value(this)" size="23" readonly="readonly" style="padding-left: 1px; padding-right: 1px;" />
                </td>
                <td class="table_big_col"><a onclick="wdi_spider_set_input_value('task', '<?php echo $published; ?>');wdi_spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');wdi_spider_form_submit(event, 'sliders_form')" href=""><img src="<?php echo WDI_URL . '/images/' . $published_image . '.png'; ?>"></img></a></td>
                <td class="table_big_col"><a onclick="wdi_spider_set_input_value('task', 'edit');
                                                      wdi_spider_set_input_value('page_number', '1');
                                                      wdi_spider_set_input_value('search_value', '');
                                                      wdi_spider_set_input_value('search_or_not', '');
                                                      wdi_spider_set_input_value('asc_or_desc', 'asc');
                                                      wdi_spider_set_input_value('order_by', 'order');
                                                      wdi_spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                                      wdi_spider_form_submit(event, 'sliders_form')" href="">Edit</a></td>
                <td class="table_big_col"><a onclick="if (confirm('<?php esc_attr_e('Do you want to delete selected items?', "wdi"); ?>')){
                                                           wdi_spider_set_input_value('task', 'delete');
                                                           wdi_spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                                           wdi_spider_form_submit(event, 'sliders_form');
                                                       }" href="">Delete</a></td>
              </tr>
              <?php
              $ids_string .= $row_data->id . ',';
            }
          }
          ?>
        </tbody>
      </table>
      <input id="task" name="task" type="hidden" value="" />
      <input id="current_id" name="current_id" type="hidden" value="" />
      <input id="ids_string" name="ids_string" type="hidden" value="<?php echo $ids_string; ?>" />
      <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="asc" />
      <input id="order_by" name="order_by" type="hidden" value="<?php echo $order_by; ?>" />
    </form>
    <?php
  }
  public function edit($type){
  if($type===0){
    $this->generateForm();
    ?>
    <script>jQuery(document).ready(function(){
      wdi_controller.switchFeedTabs('feed_settings');
    });</script>
    <?php
  }else{
    global $wdi_new_feed;
    $wdi_new_feed = true;
    $current_id = $type;
    $feed_row= $this->model->get_feed_row($current_id);
    $view_id = $feed_row->feed_type;
    $this->generateForm($current_id);
    $tab = isset($_POST['wdi_refresh_tab']) ? $_POST['wdi_refresh_tab'] : 'feed_settings';
    ?>
    <script>jQuery(document).ready(function(){
      wdi_controller.switchFeedTabs("<?php echo $tab;?>","<?php echo $view_id;?>");
    });</script>
    <?php
    
  }
    
 
  }



public function getFormElements($current_id=''){
    require_once(WDI_DIR. '/admin/models/WDIModelThemes_wdi.php');
    $themes = WDIModelThemes_wdi::get_themes();
    $elements = array(
      'feed_name' => array('name'=>'feed_name','title'=>__('Feed Name',"wdi"),'type'=>'input','tooltip'=>__('The name of your feed which can be displayed in feed\'s header section',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'theme_id' => array('switched'=>'off','label'=>array('place'=>'after','class'=>'wdi_pro_only','text'=>__("Changing Theme is Available Only in PRO version","wdi"),'br'=>'true'),'name' =>'theme_id', 'title'=>__('Theme',"wdi"),'valid_options'=>$themes,'type'=>'select','tooltip'=>__('The theme of your feed, you can create themes in themes menu',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'feed_users' => array('name'=>'feed_users','title'=>__('Feed Usernames and Hashtags',"wdi"),'type'=>'input','input_type'=>'hidden','tooltip'=>__('Enter usernames or hashtags to your feed, hashtags must start with #, username\'s shouldn\'t start with @',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'thumb_user' => array('name' =>'thumb_user', 'title'=>__('Featured Image',"wdi"),'valid_options'=>array(),'type'=>'select','tooltip'=>__('Select Featured Image For Header Section',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'feed_display_view' => array('name'=>'feed_display_view','title'=>__('Feed Display Type',"wdi"),'type'=>'radio','valid_options'=>array('pagination'=>__('Pagination',"wdi"),'load_more_btn'=>__('Load More Button',"wdi"),'infinite_scroll'=>__('Infinite Scroll',"wdi")),'disabled_options'=>array('infinite_scroll'=>__('This Feature is Available in PRO version'),'br'=>'true'),'break'=>'true','hide_ids'=>array('pagination'=>'number_of_photos,load_more_number,resort_after_load_more','load_more_btn'=>'pagination_per_page_number,pagination_preload_number','infinite_scroll'=>'pagination_per_page_number,pagination_preload_number'),'tooltip'=>__('How to load and display new images',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style'))),
      'sort_images_by' => array('name' =>'sort_images_by', 'title'=>__('Sort Images By',"wdi"),'valid_options'=>array('date'=>__('Date',"wdi"),'likes'=>__('Likes',"wdi"),'comments'=>__('Comments',"wdi"),'random'=>__('Random',"wdi")),'type'=>'select','tooltip'=>__('How to sort images',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'display_order' => array('name' =>'display_order', 'title'=>__('Order By',"wdi"),'valid_options'=>array('asc'=>'Ascending','desc'=>'Descending '),'type'=>'select','tooltip'=>__('Sorting order either Ascending or Descending',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'follow_on_instagram_btn' => array('name'=>'follow_on_instagram_btn','title'=>__('Follow on Instagram Button',"wdi"),'type'=>'checkbox','tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'display_header' => array('name'=>'display_header','title'=>__('Display Header',"wdi"),'type'=>'checkbox','tooltip'=>__('Displays feed\'s header, header includes feed name and feed users',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'number_of_photos' => array('name'=>'number_of_photos','title'=>__('Number of Photos to Display',"wdi"),'type'=>'input','input_type'=>'number','tooltip'=>__('Number of images to load when page loads first time',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style'))),
      'load_more_number' => array('name'=>'load_more_number','title'=>__('Number of Photos to Load',"wdi"),'type'=>'input','input_type'=>'number','tooltip'=>__('Number of images to load when clicking load more button or triggering infinite scroll',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style'))),
      'pagination_per_page_number'=>array('name'=>'pagination_per_page_number','title'=>__('Number of Images Per Page',"wdi"),'type'=>'input','input_type'=>'number','tooltip'=>__('Number Of Images To Show On Each Pagination Page',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style'))),
      'pagination_preload_number'=>array('name'=>'pagination_preload_number','title'=>__('Number of Pages To Preload',"wdi"),'type'=>'input','input_type'=>'number','tooltip'=>__('This Will Preload Images For Pagination',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style'))),
      'image_browser_preload_number'=>array('name'=>'image_browser_preload_number','title'=>__('Number of Images To Preload',"wdi"),'type'=>'input','input_type'=>'number','tooltip'=>__('This Will Preload Images For Pagination',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'image_browser'))),
      'image_browser_load_number'=>array('name'=>'image_browser_load_number','title'=>__('Number of Images To Load Each Time',"wdi"),'type'=>'input','input_type'=>'number','tooltip'=>__('Number Of Photos To Load on Each Load',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'image_browser'))),
      'number_of_columns' => array('name'=>'number_of_columns','title'=>__('Number of Columns',"wdi"),'type'=>'select','valid_options'=>array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8'),'tooltip'=>__('Feed item\'s column count',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry'))),
      'resort_after_load_more' => array('name'=>'resort_after_load_more','title'=>__('Sort Again Whole Feed After Loading New Images',"wdi"),'type'=>'checkbox','tooltip'=>__('Sort both newly loaded and existing images alltogether',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style'))),
      'show_likes' => array('switched'=>'off','name'=>'show_likes','title'=>__('Show Likes',"wdi"),'type'=>'checkbox','label'=>array('place'=>'after','class'=>'wdi_pro_only','text'=>__("This Feature is Available Only in PRO version","wdi"),'br'=>'true'),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'show_description' => array('switched'=>'off','name'=>'show_description','title'=>__('Show Description',"wdi"),'type'=>'checkbox','label'=>array('place'=>'after','class'=>'wdi_pro_only','text'=>__("This Feature is Available Only in PRO version","wdi"),'br'=>'true'),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'show_comments' => array('switched'=>'off','name'=>'show_comments','title'=>__('Show Comments',"wdi"),'type'=>'checkbox','label'=>array('place'=>'after','class'=>'wdi_pro_only','text'=>__("This Feature is Available Only in PRO version","wdi"),'br'=>'true'),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'show_username_on_thumb' => array('switched'=>'off','name'=>'show_username_on_thumb','title'=>__('Show Username On Image Thumb',"wdi"),'type'=>'checkbox','label'=>array('place'=>'after','class'=>'wdi_pro_only','text'=>__("This Feature is Available Only in PRO version","wdi"),'br'=>'true'),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry'))),
      'show_usernames' => array('name'=>'show_usernames','title'=>__('Show User Data',"wdi"),'type'=>'checkbox','tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'display_user_info' => array('name'=>'display_user_info','title'=>__('Display User Bio',"wdi"),'type'=>'checkbox','tooltip'=>__('User bio will be displayed if feed has only one user',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'display_user_post_follow_number' => array('name'=>'display_user_post_follow_number','title'=>__('Display User Posts and Followers count',"wdi"),'type'=>'checkbox','tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      'show_full_description' => array('name'=>'show_full_description','title'=>__('Show Full Description',"wdi"),'type'=>'checkbox','tooltip'=>__('Discription will be shown no matter how long it is',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'masonry'))),
      'disable_mobile_layout' => array('name'=>'disable_mobile_layout','title'=>__('Disable Mobile Layout',"wdi"),'type'=>'checkbox','tooltip'=>__('Column number stays the same in all screens',"wdi"),'attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry'))),
      'feed_item_onclick' => array('name'=>'feed_item_onclick','title'=>__('Image Onclick',"wdi"),'type'=>'radio','valid_options'=>array('lightbox'=>__('Open Lightbox',"wdi"),'instagram'=>__('Redirect To Instagram',"wdi"),'none'=>__('Do Nothing',"wdi")),'break'=>'true','tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'feed_settings'),array('name'=>'section','value'=>'thumbnails,masonry,blog_style,image_browser'))),
      //lightbox settings
      'popup_fullscreen' => array('name'=>'popup_fullscreen','title'=>__('Full width lightbox',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_width' => array('name'=>'popup_width','title'=>__('Lightbox Width',"wdi"),'type'=>'input','input_type'=>'number','label'=>array('text'=>'px','place'=>'after'),'tooltip'=>'','attr'=>array(array('name'=>'class','value'=>'small_input'),array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_height' => array('name'=>'popup_height','title'=>__('Lightbox Height',"wdi"),'type'=>'input','input_type'=>'number','label'=>array('text'=>'px','place'=>'after'),'tooltip'=>'','attr'=>array(array('name'=>'class','value'=>'small_input'),array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_type' => array('name' =>'popup_type', 'title'=>__('Lightbox Effect',"wdi"),'valid_options'=>array('none'=>'None','fade'=>'Fade','cubeH'=>'Cube Horizontal','cubeV'=>'Cube Vertical','sliceH'=>'Slice Horizontal','sliceV'=>'Slice Vertical','slideH'=>'Slide Horizontal','slideV'=>'Slide Vertical','scaleOut'=>'Scale Out','scaleIn'=>'Scale In','blockScale'=>'Block Scale','kaleidoscope'=>'Kaleidoscope','fan'=>'Fan','blindH'=>'Blind Horizontal','blindV'=>'Blinde Vertical','random'=>'Random'),'disabled_options'=>array('cubeH','cubeV','sliceH','sliceV','slideH','slideV','scaleOut','scaleIn','blockScale','kaleidoscope','fan','blindH','blindV','random'),'type'=>'select','tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_autoplay' => array('name'=>'popup_autoplay','title'=>__('Lightbox autoplay',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'hide_ids'=>array('0'=>'popup_interval'),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_interval' => array('name'=>'popup_interval','title'=>__('Time Interval',"wdi"),'type'=>'input','input_type'=>'number','label'=>array('text'=>'sec','place'=>'after'),'tooltip'=>'','attr'=>array(array('name'=>'class','value'=>'small_input'),array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_filmstrip' => array('disabled_options'=>array('1'=>'','0'=>''),'label'=>array('place'=>'after','class'=>'wdi_pro_only','text'=>__("This Feature is Available Only in PRO version","wdi"),'br'=>'true'),'name'=>'popup_enable_filmstrip','title'=>__('Enable filmstrip in lightbox',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'hide_ids'=>array('0'=>'popup_filmstrip_height'),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_filmstrip_height' => array('switched'=>'off','disabled'=>array('text'=>__("This Feature is Available Only in PRO version","wdi")),'name'=>'popup_filmstrip_height','title'=>__('Filmstrip size',"wdi"),'type'=>'input','input_type'=>'number','label'=>array('text'=>'px','place'=>'after'),'tooltip'=>'','attr'=>array(array('name'=>'class','value'=>'small_input'),array('name'=>'tab','value'=>'lightbox_settings'))),
      'autohide_lightbox_navigation' => array('name'=>'autohide_lightbox_navigation','title'=>__('Show Next / Previous Buttons',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('On Hover',"wdi"),'0'=>__('Always',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_info_always_show' => array('disabled_options'=>array('1'=>'','0'=>''),'name'=>'popup_info_always_show','title'=>__('Display info by default',"wdi"),'type'=>'radio','label'=>array('place'=>'after','class'=>'wdi_pro_only','text'=>__("This Feature is Available Only in PRO version","wdi"),'br'=>'true'),'valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_info_full_width' => array('disabled_options'=>array('1'=>'','0'=>''),'name'=>'popup_info_full_width','title'=>__('Full width info',"wdi"),'type'=>'radio','label'=>array('place'=>'after','class'=>'wdi_pro_only','text'=>__("This Feature is Available Only in PRO version","wdi"),'br'=>'true'),'valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'enable_loop' => array('name'=>'enable_loop','title'=>__('Enable Loop',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_image_right_click' => array('name'=>'popup_image_right_click','title'=>__('Enable Right Click Protection',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_ctrl_btn' => array('name'=>'popup_enable_ctrl_btn','title'=>__('Enable control buttons',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'hide_ids'=>array('0'=>'popup_enable_info,popup_enable_fullscreen,popup_enable_info,popup_enable_comment,popup_enable_download,popup_enable_share_buttons,popup_enable_fullsize_image'),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_info' => array('disabled_options'=>array('1'=>'','0'=>''),'name'=>'popup_enable_info','title'=>__('Enable info',"wdi"),'type'=>'radio','label'=>array('place'=>'after','class'=>'wdi_pro_only','text'=>__("This Feature is Available Only in PRO version","wdi"),'br'=>'true'),'valid_options'=>array('1'=>'Yes','0'=>'No'),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_fullscreen' => array('name'=>'popup_enable_fullscreen','title'=>__('Enable fullscreen',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_comment' => array('switched'=>'off','disabled_options'=>array('1'=>'','0'=>''),'label'=>array('place'=>'after','class'=>'wdi_pro_only','text'=>__("This Feature is Available Only in PRO version","wdi"),'br'=>'true'),'name'=>'popup_enable_comment','title'=>__('Enable comments',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_fullsize_image' => array('name'=>'popup_enable_fullsize_image','title'=>__('Link To Instagram Button',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_download' => array('name'=>'popup_enable_download','title'=>__('Enable Download Button',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_share_buttons' => array('disabled_options'=>array('1'=>'','0'=>''),'label'=>array('place'=>'after','class'=>'wdi_pro_only','text'=>__("This Feature is Available Only in PRO version","wdi"),'br'=>'true'),'name'=>'popup_enable_share_buttons','title'=>__('Enable Share Buttons',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_facebook' => array('status'=>'disabled','name'=>'popup_enable_facebook','title'=>__('Enable Facebook button',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_twitter' => array('status'=>'disabled','name'=>'popup_enable_twitter','title'=>__('Enable Twitter button',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_google' => array('status'=>'disabled','name'=>'popup_enable_google','title'=>__('Enable Google+ button',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_pinterest' => array('status'=>'disabled','name'=>'popup_enable_pinterest','title'=>__('Enable Pinterest button',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'popup_enable_tumblr' => array('status'=>'disabled','name'=>'popup_enable_tumblr','title'=>__('Enable Tumblr button',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),
      'show_image_counts' => array('status'=>'disabled','name'=>'show_image_counts','title'=>__('Show Images Count',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'lightbox_settings'))),

      //filters
      'conditional_filter_enable' => array('name'=>'conditional_filter_enable','title'=>__('Enable Conditional Filters',"wdi"),'type'=>'radio','valid_options'=>array('1'=>__('Yes',"wdi"),'0'=>__('No',"wdi")),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'conditional_filters'))),
      'conditional_filter_type' => array('name'=>'conditional_filter_type','title'=>__('Filter Logic',"wdi"),'type'=>'select','label'=>array('text'=>'','place'=>'after'),'valid_options'=>array('AND'=>'AND','OR'=>'OR','NOR'=>'NOR'),'tooltip'=>'','attr'=>array(array('name'=>'tab','value'=>'conditional_filters'))),
      );
    $return = array('elements'=>$elements,'current_id'=>$current_id);
    return $return;
}


public function genarateFeedViews(){
    ?>
      <div class="wdi_border_wrapper">


      <div class="display_type" tab="feed_settings" style="margin:5px;float:left;">
        <div style="text-align:center;padding:2px;" ><input type="radio" id="thumbnails" name="feed_type" value="thumbnails"><label for="thumbnails">Thumbnails</label></div>
        <label for="thumbnails"><img src="<?php echo plugins_url('../../images/feed_views/thumbnails.png',__FILE__);?>"></label>
      </div>

      <div class="display_type wdi_tooltip" wdi-tooltip="<?php _e('Available In Pro Version') ?>" tab="feed_settings" style="margin:5px;float:left;">
        <div style="text-align:center;padding:2px;" ><input type="radio" disabled id="masonry" name="feed_type" value="masonry"><label for="masonry" class="wdi_pro_only">Masonry</label></div>
        <label for="masonry" class="wdi_pro_only_op"><img src="<?php echo plugins_url('../../images/feed_views/masonry.png',__FILE__);?>"></label>
      </div>

      <div class="display_type wdi_tooltip" wdi-tooltip="<?php _e('Available In Pro Version') ?>" tab="feed_settings" style="margin:5px;float:left;">
        <div style="text-align:center;padding:2px;" ><input disabled type="radio" id="blog_style" name="feed_type" value="blog_style"><label for="blog_style" class="wdi_pro_only">Blog Style</label></div>
        <label for="blog_style" class="wdi_pro_only_op"><img src="<?php echo plugins_url('../../images/feed_views/blog_style.png',__FILE__);?>"></label>
      </div>

      <div class="display_type" tab="feed_settings" style="margin:5px;float:left;">
        <div style="text-align:center;padding:2px;" ><input type="radio" id="image_browser" name="feed_type" value="image_browser"><label for="image_browser">Image Browser</label></div>
        <label for="image_browser"><img src="<?php echo plugins_url('../../images/feed_views/image_browser.png',__FILE__);?>"></label>
      </div>

      <br class="clear">
    <?php
}
public function generateTabs(){
  ?>
    <div id="wdi_feed_tabs">
      <div class="wdi_feed_tabs" id="wdi_feed_settings" onclick="wdi_controller.switchFeedTabs('feed_settings');"><?php _e('Feed Settings',"wdi")?></div>
      <div class="wdi_feed_tabs" id="wdi_lightbox_settings" onclick="wdi_controller.switchFeedTabs('lightbox_settings');"><?php _e('Lightbox Settings',"wdi")?></div>
      <div class="wdi_feed_tabs" id="wdi_conditional_filters" onclick="wdi_controller.switchFeedTabs('conditional_filters');"><?php _e('Conditional Filters',"wdi")?></div>
      <br class="clear">
    </div>
  <?php
}
public function generateForm($current_id = ''){
  $formInfo = $this->getFormElements($current_id);
  $elements=$formInfo['elements'];
  
  global  $wdi_options;
  //for edit
  $edit = false;
  if($current_id != ''){
      $feed_row = WDILibrary::objectToarray($this->model->get_feed_row($current_id));
      $edit = true; 
  }
  else{
    $feed_row = '';
  }
  ?>
    <!-- Banner Start -->
    <div style="clear: both; float: left; width: 100%;">
          <div style="float: left; font-size: 14px; font-weight: bold;">
            <?php _e('Here You Can Change Feed Parameters','wdi') ?>
            <a style="color: #15699F; text-decoration: none;" target="_blank" href="https://web-dorado.com/wordpress-instagram-feed-wd/creating-feeds.html"><?php _e('Read More in User Manual',"wdi"); ?></a>
          </div>
          <div style="float: right; text-align: right;margin-top:10px">
            <a style="text-decoration: none;" target="_blank" href="https://web-dorado.com/files/fromInstagramFeedWD.php">
              <img width="215" border="0" alt="web-dorado.com" src="<?php echo WDI_URL . '/images/wd_logo.png'; ?>" />
            </a>
          </div>
    </div>
    <!-- Banner END -->
    <div class="wrap">
    <h2><?php if($edit==true && isset($feed_row['feed_name'])){
      echo __('Edit feed',"wdi").' <b style="font-size:23px;color:rgb(255, 97, 0);">' .$feed_row['feed_name'].'</b>';
      }
      else{
        _e('Add new Feed', "wdi");
      }?>
    

    </h2>
    <?php $this->generateTabs();?>
    <?php $this->genarateFeedViews();?>
    <form method="post" action="admin.php?page=wdi_feeds" id='wdi_save_feed'>
      <?php wp_nonce_field('nonce_wd', 'nonce_wd'); ?>
      <input type="hidden" id="wdi_feed_type" name='<?php echo WDI_FSN.'[feed_type]'?>'>
      <input type="hidden" id="task" name='task'>
      <input type="hidden" id="wdi_feed_thumb" name="<?php echo WDI_FSN.'[feed_thumb]'?>">
      <input type="hidden" id="wdi_access_token" name="access_token" value="<?php echo $wdi_options['wdi_access_token'];?>">
      <input type="hidden" id="wdi_add_or_edit" name="add_or_edit" value="<?php echo $current_id;?>">
      <input type="hidden" id="wdi_thumb_user"  value="<?php echo isset($feed_row['thumb_user'])?$feed_row['thumb_user']:$wdi_options['wdi_user_name'];?>">
      <input type="hidden" id="wdi_default_user" value="<?php echo $wdi_options['wdi_user_name'];?>">
      <input type="hidden" id="wdi_default_user_id" value="<?php echo $wdi_options['wdi_user_id'];?>">
      <input type="hidden" name="<?php echo WDI_FSN.'[published]'?>" value="<?php echo isset($feed_row['published'])?$feed_row['published']: '1';?>">
      <input type="hidden" id="wdi_current_id" name="current_id" value=''>
      <input type="hidden" id="wdi_refresh_tab" name="wdi_refresh_tab">
      <table class="form-table">
        <tbody>
          <?php
          foreach ($elements as $element) {
             if( $element['name'] == 'conditional_filter_enable' ){ continue; } 
  
              if( $element['name'] == 'conditional_filter_type' ){
               ?>
               
               <div id="wdi-conditional-filters-ui" class="wdi_demo_img">
               <div class="wdi_pro_notice"> <?php _e("This is FREE version, Conditional filters are available only in PRO version","wdi"); ?> </div>
               <div class="wdi-pro-overlay"> <img src="<?php echo WDI_URL . '/demo_images/filters.png'; ?>" alt=""></div>
               </div><?php
              continue;
              }

            if(isset($element['status'])){
              if($element['status'] == 'disabled'){
                  continue;
              }
            }
            ?>

             
             

            <tr>
              <th scope="row"><a  href="#" <?php echo ($element['tooltip']!='' && isset($element['tooltip'])) ?  'class="wdi_tooltip" wdi-tooltip="'.$element['tooltip'].'"' :  'class="wdi_settings_link"'; ?> ><?php echo $element['title'];?></a></th>
                  <td>

                  <?php $this->buildField($element,$feed_row);?>
                      <!-- FEED USERS -->
                      <?php if($element['name']=='feed_users'):?>
                        <input type="text" id="wdi_add_user_ajax_input">
                        <div id="wdi_add_user_ajax" class="button"><?php _e('Add', "wdi"); ?></div>
                        <div id="wdi_feed_users">
                          <?php $this->display_feed_users($feed_row);?>
                        </div>
                      <?php endif; ?>
                      <!-- END FEED USERS -->
                      
                     

                  </td>
              </tr><?php

          }
          ?>
        </tbody>
      </table>
    <div id="wdi_save_feed_submit" class="button button-primary"><?php _e('Save', "wdi"); ?></div>
     
        <div id="wdi_save_feed_apply" class="button button-primary"><?php _e('Apply', "wdi"); ?></div>
        <div id="wdi_save_feed_reset" style="display:none" class="button button-secondary"><?php _e('Reset', "wdi"); ?></div>
        <div id="wdi_cancel_changes" class="button button-secondary"><?php _e('Cancel', "wdi"); ?></div>
    </form>
    </div> 
    </div>
  <?php
}
private function buildField($element,$feed_row=''){
  require_once(WDI_DIR.'/framework/WDI_form_builder.php');
  $element['defaults'] = $this->model->wdi_get_feed_defaults();
  $element['CONST'] = WDI_FSN;
  $builder = new WDI_form_builder();
  switch($element['type']){
    case 'input':{
      $builder->input($element,$feed_row);
      break;
    }
    case 'select':{
      $builder->select($element,$feed_row);
      break;
    }
    case 'radio':{
      $builder->radio($element,$feed_row);
      break;
    }
    case 'checkbox':{
      $builder->checkbox($element,$feed_row);
      break;
    }
  }
}


 public function display_feed_users($feed_row){
   global $wdi_options;

  $users = isset($feed_row['feed_users']) ? $feed_row['feed_users']: "";
   
  $users = json_decode($users);
  if($users === null){
    $users = array();
  }
  
 

  ?>
  <script>
    wdi_controller.instagram = new WDIInstagram();
    wdi_controller.feed_users = [];
    wdi_controller.instagram.addToken(<?php echo '"'.$wdi_options['wdi_access_token'].'"'; ?>);
    jQuery(document).ready(function(){
    wdi_controller.updateFeaturedImageSelect(<?php echo '"'.$wdi_options['wdi_user_name'].'"'; ?>,'add','selected');
    }); 
  <?php foreach ($users as $user) : ?>
    wdi_controller.makeInstagramUserRequest(<?php echo '"'.$user->username.'"'?>,true);
  <?php endforeach; ?>

  </script>
   <?php
 
 }


}





