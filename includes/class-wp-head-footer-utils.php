<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * WP_Head_Footer_Utils
 *
 * @package     WP_Head_Footer\Includes
 * @author      Francesco Taurino <dev.francescotaurino@gmail.com>
 * @copyright   Copyright (c) 2017, Francesco Taurino
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 */
if( !class_exists('WP_Head_Footer_Utils') ) :


	class WP_Head_Footer_Utils implements iWP_Head_Footer  {

	   
		/**
		 * Does the logged-in user have the required capability?
		 * 
		 * Note: Setting the DISALLOW_UNFILTERED_HTML constant to true in the wp-config.php 
		 * would effectively disable this plugin's admin because no user would have the capability.
		 * 
		 * @return bool
		 */
		public static function is_user_authorized() {
			
			if ( defined('DISALLOW_UNFILTERED_HTML') && DISALLOW_UNFILTERED_HTML ){
			  return false;
			}

			foreach ( self::get_required_capability() as $cap ) {
			  if( ! current_user_can( $cap ) ) {
				return false;
			  }
			}

			return true;
		}


		/**
		 * Get required capabilities to access settings page and metabox
		 *
		 * @since 1.0
		 * @see https://codex.wordpress.org/Roles_and_Capabilities
		 * @return array
		 */
		private static function get_required_capability() {
		  return array( self::REQUIRED_CAPABILITY, 'unfiltered_html' );
		}
	
	}

endif;  
