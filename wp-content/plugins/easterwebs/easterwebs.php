<?php

/*
 * Plugin Name: EasterWebs
 * Plugin URI: http://wordpress.org/extend/plugins/easterwebs/
 * Description: Easily add an easter egg hunt to your site. Simple and fun.
 * Author: EasterWebs.com
 * Version: 1.6
 * Author URI: http://easterwebs.com
 * License: GPL2+
 */
 
 /*  Copyright 2013  Kai Chan  (email : hello@easterwebs.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
 
    define('EASTERWEBS_BASENAME', plugin_basename(__FILE__)) ;
    define('EASTERWEBS_PLUGIN_TITLE', 'EasterWebs');
    define('EASTERWEBS_SETTINGS_AUTH', 'administrator') ;

    class EasterWebs_Actions {
 
        public static function menu() {
            add_options_page( EASTERWEBS_PLUGIN_TITLE, EasterWebs_Output::__('EasterWebs Settings'), EASTERWEBS_SETTINGS_AUTH, 'easterwebs-config', "EasterWebs_Output::settingsPage") ;
		}   
		
		public static function actionLinks($links) {
			$link = '<a href="' . menu_page_url('easterwebs-config' , false) . '">' . EasterWebs_Output::__('Settings') .'</a>' ;
			array_unshift($links, $link) ;
			return $links ;
		}
		
		// Insert egg js code
		public static function insertCode() {
				
    		$options = array() ;
    		
    		if (EasterWebs_Settings::getVal('easterwebs_egg_id') !== false) {
    		
    			$options['egg_id'] = EasterWebs_Settings::getVal('easterwebs_egg_id') ;
    								
    			echo EasterWebs_Output::eggCode($options) ;
    		}
        }
    }
    
    class EasterWebs_Output {
		
		const _NAMESPACE = 'easterwebs';
		
		// wordpress alias output function
		public static function __($output) {
			return __($output, self::_NAMESPACE);
		}
		
		public static function _e($output) {
			_e($output, self::_NAMESPACE);
		}
		
		// settings page
		public static function settingsPage() {	
		
            if ( !current_user_can( 'manage_options' ) )  {
        		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        	}
        	
        	echo '<div class="wrap">';
        	
            	echo '<h2>'.EasterWebs_Output::__('EasterWebs Settings').'</h2>';
            	
            	echo '<p>';
                    echo EasterWebs_Output::__('To get started, create an egg at <a target="_blank" href="http://www.easterwebs.com/eggs/anegg">eastereggs.com</a>.') ;
                    echo '<br/>';
                    echo EasterWebs_Output::__('Once created, cut and paste the egg id into the following field and click on Save Changes.') ;
                echo '</p>';
                
                echo '<p>';
                    echo EasterWebs_Output::__('That\'s it, you\'re ready to go.') ;
    			echo '</p>';
			
                echo '<form method="post" action="options.php" id="google_form">';
                
                echo settings_fields( 'easterwebs-settings-group' );
                
                echo '  <table class="form-table">
                            <tr valign="top">
                                <th scope="row" style="text-align:right;">'.EasterWebs_Output::__("Egg ID").'</th>
                                <td>
                                    <input class="regular-text" type="text" name="easterwebs_egg_id" value="'.EasterWebs_Settings::getVal("easterwebs_egg_id").'">
                                </td>
                            </tr>
                        </table>

                        <p class="submit">
                            <input type="submit" class="button-primary" value="'.EasterWebs_Output::__("Save Changes").'" />
                        </p>';
                        
                echo '</form>';			     
        	
        	echo '</div>';
        }
		
		// Inject js code for egg
		public static function eggCode(array $options) {

            if ( !empty( $options['egg_id'] ) ) {
                // $ret  = '<script type="text/javascript" src="http://www.easterwebs.com/eggs/start?egg_id='.$options["egg_id"].'"></script>';
                $ret  = '<script type="text/javascript" src="http://easterwebs.local/eggs/start?egg_id='.$options["egg_id"].'"></script>';
            }
						
			return $ret ;			
		}
	}   
    
    class EasterWebs_Settings {
		
		// group name
		public static $settingsGroup = 'easterwebs-settings-group' ;
		
		// form parameters
		private static $settingsArray = array(
			'easterwebs_egg_id'
        ) ;
		
		
		public static function registerSettings() {
			foreach (self::$settingsArray as $value) {
				register_setting(self::$settingsGroup, $value) ;
			}
		}
		
		public static function getVal($option) {
			if (!in_array(strtolower($option), self::$settingsArray)) {
				return false ;
			} else {
				return get_option($option) ;
			}
		}
    }      
 
    // ## actions
    
    // settings menu and options page
    add_action( 'admin_menu', 'EasterWebs_Actions::menu' );
    
    // register parameters
    add_action( 'admin_init', 'EasterWebs_Settings::registerSettings' );
    
    // add egg js code to site pages
    add_action( 'wp_footer', 'EasterWebs_Actions::insertCode' ) ;
    
    // ## filters
    
    // settings link in plugin page 
    add_filter( "plugin_action_links_".EASTERWEBS_BASENAME, "EasterWebs_Actions::actionLinks" );

    
?>