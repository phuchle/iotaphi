<?php

class WDIFeaturedPlugins
{
  private $plugins = array(
    "form-maker" => array(
      'title' => 'Form Maker',
      'text' => 'Wordpress form builder plugin',
      'content' => 'Form Maker is a modern and advanced tool for creating WordPress forms easily and fast.',
      'href' => 'https://web-dorado.com/products/wordpress-form.html'
    ),
    "photo-gallery" => array(
      'title' => 'Photo Gallery',
      'text' => 'WordPress Photo Gallery plugin',
      'content' => 'Photo Gallery is a fully responsive WordPress Gallery plugin with advanced functionality.',
      'href' => 'https://web-dorado.com/products/wordpress-photo-gallery-plugin.html'
    ),
    "wd-google-analytics" => array(
      'title' => 'Wd Google Analytics',
      'text' => 'WordPress Google Analytics Plugin',
      'content' => 'WD Google Analytics is a user-friendly all in one plugin, which allows to manage and monitor your website analytics from WordPress dashboard.',
      'href' => 'https://web-dorado.com/products/wordpress-google-analytics-plugin.html'
    ),
    "ecommerce-wd" => array(
      'title' => 'Ecommerce',
      'text' => 'WordPress Ecommerce Plugin',
      'content' => 'Ecommerce WD is a highly-functional, user friendly WordPress Ecommerce plugin, which is perfect for developing online stores for any level of complexity.',
      'href' => 'https://web-dorado.com/products/wordpress-ecommerce.html'
    ),
    "google-maps" => array(
      'title' => 'Google Map',
      'text' => 'WordPress Google Maps Plugin',
      'content' => 'Google Maps WD is an intuitive tool for creating Google maps with advanced markers, custom layers and overlays for your website.',
      'href' => 'https://web-dorado.com/products/wordpress-google-maps-plugin.html'
    ),
    "facebook-wd" => array(
      'title' => 'Facebook Feed WD',
      'text' => 'WordPress facebook feed plugin',
      'content' => 'Facebook Feed WD is a completely customizable, responsive solution to help you display your Facebook feed on your WordPress website.',
      'href' => 'https://web-dorado.com/products/wordpress-facebook-feed-plugin.html'
    ),

    "slider_wd" => array(
      'title' => 'Slider WD',
      'text' => 'WordPress slider plugin',
      'content' => 'Create responsive, highly configurable sliders with various effects for your WordPress site.',
      'href' => 'https://web-dorado.com/products/wordpress-slider-plugin.html'
    ),
    "events-wd" => array(
      'title' => 'Event Calendar WD',
      'text' => 'WordPress calendar plugin',
      'content' => 'Organize and publish your events in an easy and elegant way using Event Calendar WD.',
      'href' => 'https://web-dorado.com/products/wordpress-event-calendar-wd.html'
    ),

    "contact_form_bulder" => array(
      'title' => 'Contact Form Builder',
      'text' => 'WordPress contact form builder plugin',
      'content' => 'Contact Form Builder is the best tool for quickly arranging a contact form for your clients and visitors.',
      'href' => 'https://web-dorado.com/products/wordpress-contact-form-builder.html'
    ),
    "contact-maker" => array(
      'title' => 'Contact Form Maker',
      'text' => 'WordPress contact form maker plugin',
      'content' => 'WordPress Contact Form Maker is an advanced and easy-to-use tool for creating forms.',
      'href' => 'https://web-dorado.com/products/wordpress-contact-form-maker-plugin.html'
    ),
    "spider-calendar" => array(
      'title' => 'Spider Calendar',
      'text' => 'WordPress event calendar plugin',
      'content' => 'Spider Event Calendar is a highly configurable product which allows you to have multiple organized events.',
      'href' => 'https://web-dorado.com/products/wordpress-calendar.html'
    ),
    "faq_wd" => array(
      'title' => 'FAQ WD',
      'text' => 'WordPress FAQ plugin',
      'content' => 'Organize and publish your FAQs in an easy and elegant way using FAQ WD.',
      'href' => 'https://web-dorado.com/products/wordpress-faq-wd.html'
    ),
    "instagram_feed" => array(
      'title' => 'Instagram Feed WD',
      'text' => 'WordPress Instagram Feed plugin',
      'content' => 'WD Instagram Feed is a user-friendly tool for displaying user or hashtag-based feeds on your website.',
      'href' => 'https://web-dorado.com/products/wordpress-instagram-feed-wd.html'
    ),
    "post-slider" => array(
      'title' => 'Post Slider',
      'text' => 'WordPress Post Slider plugin',
      'content' => 'Post Slider WD is designed to show off the selected posts of your website in a slider.',
      'href' => 'https://web-dorado.com/products/wordpress-post-slider-plugin.html'
    ),
    "catalog" => array(
      'title' => 'Spider Catalog',
      'text' => 'WordPress product catalog plugin',
      'content' => 'Spider Catalog for WordPress is a convenient tool for organizing the products represented on your website into catalogs.',
      'href' => 'https://web-dorado.com/products/wordpress-catalog.html'
    ),
    "player" => array(
      'title' => 'Video Player',
      'text' => 'WordPress Video player plugin',
      'content' => 'Spider Video Player for WordPress is a Flash & HTML5 video player plugin that allows you to easily add videos to your website with the possibility.',
      'href' => 'https://web-dorado.com/products/wordpress-player.html'
    ),
    "contacts" => array(
      'title' => 'Spider Contacts',
      'text' => 'Wordpress staff list plugin',
      'content' => 'Spider Contacts helps you to display information about the group of people more intelligible, effective and convenient.',
      'href' => 'https://web-dorado.com/products/wordpress-contacts-plugin.html'
    ),
    "facebook" => array(
      'title' => 'Spider Facebook',
      'text' => 'WordPress Facebook plugin',
      'content' => 'Spider Facebook is a WordPress integration tool for Facebook.It includes all the available Facebook social plugins and widgets.',
      'href' => 'https://web-dorado.com/products/wordpress-facebook.html'
    ),
    "twitter-widget" => array(
      'title' => 'Widget Twitter',
      'text' => 'WordPress Widget Twitter plugin',
      'content' => 'The Widget Twitter plugin lets you to fully integrate your WordPress site with your Twitter account.',
      'href' => 'https://web-dorado.com/products/wordpress-twitter-integration-plugin.html'
    ),
    "faq" => array(
      'title' => 'Spider FAQ',
      'text' => 'WordPress FAQ Plugin',
      'content' => 'The Spider FAQ WordPress plugin is for creating an FAQ (Frequently Asked Questions) section for your website.',
      'href' => 'https://web-dorado.com/products/wordpress-faq-plugin.html'
    ),
    "zoom" => array(
      'title' => 'Zoom',
      'text' => 'WordPress text zoom plugin',
      'content' => 'Zoom enables site users to resize the predefined areas of the web site.',
      'href' => 'https://web-dorado.com/products/wordpress-zoom.html'
    ),
    "flash-calendar" => array(
      'title' => 'Flash Calendar',
      'text' => 'WordPress flash calendar plugin',
      'content' => 'Spider Flash Calendar is a highly configurable Flash calendar plugin which allows you to have multiple organized events.',
      'href' => 'https://web-dorado.com/products/wordpress-events-calendar.html'
    ),
    "folder_menu" => array(
      'title' => 'Folder Menu',
      'text' => 'WordPress folder menu plugin',
      'content' => 'Folder Menu Vertical is a WordPress Flash menu module for your website, designed to meet your needs and preferences.',
      'href' => 'https://web-dorado.com/products/wordpress-menu-vertical.html'
    ),
    "random_post" => array(
      'title' => 'Random post',
      'text' => 'WordPress random post plugin',
      'content' => 'Spider Random Post is a small but very smart solution for your WordPress web site.',
      'href' => 'https://web-dorado.com/products/wordpress-random-post.html'
    ),

  );

  public function display($current_plugin = "instagram_feed")
  {
    $this->print_css();
    ?>
    <div id="main_featured_plugins_page">
    <h3>Featured Plugins</h3>
    <div class="featured_header">
      <a target="_blank"
         href="https://web-dorado.com/wordpress-plugins.html?source=<?php echo $current_plugin; ?>">
        <h1>GET <?php echo $this->plugins[$current_plugin]["title"]; ?> +23 PLUGINS</h1>
        <h1 class="get_plugins">FOR $100 ONLY <span>- SAVE 70%</span></h1>
        <div class="try-now">
          <span>TRY NOW</span>
        </div>
      </a>
    </div>
    <ul id="featured-plugins-list">
      <?php
      foreach ($this->plugins as $key => $plugins) {
        if ($current_plugin != $key) {
          ?>
          <li class="<?php echo $key; ?>">
            <div class="product"></div>
            <div class="title">
              <strong class="heading"><?php echo $plugins['title']; ?></strong>
            </div>
            <div class="description">
              <p><?php echo $plugins['content']; ?></p>
            </div>
            <a target="_blank" href="<?php echo $plugins['href']; ?>?source=<?php echo $current_plugin; ?>"
               class="download">Download Plugin &#9658;</a>
          </li>
          <?php
        }
      }
      ?>
    </ul>
    </div><?php
  }

  public function print_css()
  {
    ?>
    <style>
    @import url(http://fonts.googleapis.com/css?family=Oswald);

    #main_featured_plugins_page {
      font-family: Oswald;
      width: 90%;
      margin: 15px auto 0px auto;
    }

    #main_featured_plugins_page h3 {
      border-bottom: 2px solid #CECECE;
      color: rgb(111, 111, 111);
      font-family: Segoe UI;
      font-size: 18px;
      margin: 0px auto 15px auto;
      padding: 20px 0;
    }

    #main_featured_plugins_page #featured-plugins-list {
      position: relative;
      margin: 0px auto;
      height: auto;
      display: table;
      list-style: none;
      text-align: center;
      width: 100%;
    }

    #main_featured_plugins_page #featured-plugins-list li {
      display: inline-table;
      width: 200px;
      margin: 20px 10px 0px 10px;
      background: #FFFFFF;
      border-right: 3px solid #E5E5E5;
      height: 335px;
      border-bottom: 3px solid #E5E5E5;
      position: relative;
    }

    #main_featured_plugins_page #featured-plugins-list li .product {
      position: relative;
      height: 113px;
      background-color: transparent !important;
      background-position-x: 50% !important;
      margin: 7px;
      border-radius: 3px;
      background-size: 115px !important;
    }

    #main_featured_plugins_page #featured-plugins-list li .title {
      width: 90%;
      text-align: center;
      margin: 0 auto;
    }

    #main_featured_plugins_page #featured-plugins-list li.form-maker .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/form.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.catalog .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/catalog.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.contact-maker .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/contact.maker.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.contacts .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/contacts.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.ecommerce-wd .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/ecommerce.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.facebook .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/facebook.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.facebook-wd .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/facebook-feed.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.faq .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/faq.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.flash-calendar .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/flash.calendar.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.player .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/player.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.spider-calendar .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/spider.calendar.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.contact_form_bulder .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/contact.builder.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.random_post .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/random.post.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.slider_wd .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/slider.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.folder_menu .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/folder.menu.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.zoom .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/zoom.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.fm-import .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/fm-import.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.photo-gallery .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/photo-gallery.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.twitter-widget .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/twittertools.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.events-wd .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/events-wd.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.faq_wd .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/faq_wd.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.instagram_feed .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/instagram_feed.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.wd-google-analytics .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/wd-google-analytics.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.post-slider .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/post-slider.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li.google-maps .product {
      background: url("<?php echo WDI_URL; ?>/featured/images/google-maps.png") center center no-repeat;
    }

    #main_featured_plugins_page #featured-plugins-list li .title .heading {
      display: block;
      position: relative;
      font-size: 17px;
      color: #767676;
      margin: 13px 0px 13px 0px;
      text-transform: uppercase;
    }

    #main_featured_plugins_page #featured-plugins-list li .title p {
      font-size: 14px;
      color: #444;
      margin-left: 20px;
    }

    #main_featured_plugins_page #featured-plugins-list li .description {
      height: 127px;
      width: 90%;
      margin: 0 auto;
    }

    #main_featured_plugins_page #featured-plugins-list li .description p {
      text-align: center;
      width: 100%;
      color: #9A9A9A;
      font-family: Segoe UI Light;
    }

    #featured-plugins-list li a.download {
      display: block;
      border-top: 1px solid #CACACA;
      outline: none;
      width: 90%;
      margin: 0 auto;
      font-size: 14px;
      line-height: 40px;
      text-decoration: none;
      font-weight: bolder;
      text-align: center;
      color: #134D68;
      position: absolute;
      text-transform: uppercase;
      bottom: 0;
      left: 10px;
      font-family: Segoe UI Black;
      text-shadow: 1px 0;
    }

    #featured-plugins-list li a.download:hover {
      color: #F47629;
    }

    .featured_header {
      background: #11465F;
      border-right: 3px solid #E5E5E5;
      border-bottom: 3px solid #E5E5E5;
      position: relative;
      padding: 20px 0;
    }

    .featured_header .old_price {
      color: rgba(180, 180, 180, 0.3);
      text-decoration: line-through;
      font-family: Oswald;
    }

    .featured_header h1.get_plugins {
      color: #FFFFFF;
      height: 85px;
      margin: 0;
      background-size: 85% 100%;
      background-position: center;
      line-height: 60px;
    }

    .featured_header .try-now {
      text-align: center;
    }

    .featured_header .try-now span {
      display: inline-block;
      padding: 7px 16px;
      background: #F47629;
      border-radius: 10px;
      color: #ffffff;
      font-size: 23px;
    }

    .featured_header h1 {
      font-size: 50px;
      text-align: center;
      color: #FFFFFF;
      letter-spacing: 3px;
      text-transform: uppercase;
    }

    .featured_header a {
      text-decoration: none;
    }

    .featured_header a:hover {
      text-decoration: none;
    }

    @media screen and (max-width: 1105px) {
      .featured_header h1 {
        font-size: 37px;
        line-height: 0;
      }
    }

    @media screen and (max-width: 835px) {
      .get_plugins span {
        display: none;
      }
    }

    @media screen and (max-width: 700px) {
      .featured_header h1 {
        line-height: 40px;
      }
    }

    @media screen and (max-width: 435px) {
      .featured_header h1 {
        font-size: 20px;
        line-height: 25px;
      }
    } </style><?php
  }
}




