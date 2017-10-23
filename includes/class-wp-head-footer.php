<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * WP_Head_Footer
 *
 * @package     WP_Head_Footer\Includes
 * @author      Francesco Taurino <dev.francescotaurino@gmail.com>
 * @copyright   Copyright (c) 2017, Francesco Taurino
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 */
if( !class_exists('WP_Head_Footer') ) :


	add_action('plugins_loaded', array( 'WP_Head_Footer', 'plugins_loaded'), 0 );


	class WP_Head_Footer implements iWP_Head_Footer  {

		
		private function __construct() {}


		public static function plugins_loaded() {
						
			self::includes();

			load_plugin_textdomain( 
				self::PLUGIN_SLUG, 
				false, 
				basename( dirname( self::FILE ) ) . '/languages' 
			); 
			
			self::add_post_type_support();

			// Metabox - Register Meta
			add_action( 'init', array( 'WP_Head_Footer_Metabox', 'init' ) );
			
			if( is_admin() && WP_Head_Footer_Utils::is_user_authorized() ) {
				
				// Metabox
				add_action( 'add_meta_boxes', array( 'WP_Head_Footer_Metabox', 'add_meta_boxes' ),10,2 );
				add_action( 'save_post', array(  'WP_Head_Footer_Metabox', 'save_post'), 10,3 );
			
				// Settings
				add_action( 'admin_menu', array( 'WP_Head_Footer_Settings', 'admin_menu' ) );
				add_action( 'admin_init', array( 'WP_Head_Footer_Settings', 'admin_init' ) );

			}

			// Frontend
			add_action( 'template_redirect', array( 'WP_Head_Footer_Frontend', 'template_redirect' ) );

		}


		private static function add_post_type_support() {
		
			add_post_type_support( 'post', self::PLUGIN_SLUG );
			
			add_post_type_support( 'page', self::PLUGIN_SLUG );	
		
		}


		private static function includes() {
			
			$array = array(
				'includes/class-wp-head-footer-*.php'
			);

			foreach ( $array as $key ) {
				
				foreach ( glob( plugin_dir_path( self::FILE ) . $key ) as $filename ){
					
					require_once ($filename);
				
				}
			
			}

		}


	}


endif;