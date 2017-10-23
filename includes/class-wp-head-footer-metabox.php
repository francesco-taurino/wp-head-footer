<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * WP_Head_Footer_Metabox
 *
 * @package     WP_Head_Footer\Includes
 * @author      Francesco Taurino <dev.francescotaurino@gmail.com>
 * @copyright   Copyright (c) 2017, Francesco Taurino
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 */
if( !class_exists('WP_Head_Footer_Metabox') ) : 


	class WP_Head_Footer_Metabox implements iWP_Head_Footer  {		
		

		/**
		 * init
		 * 
		 * @access private
		 * 
		 * @return void
		 */
		public static function init( ) {

			self::register_meta();
			
		}
		

		/**
		 * Register meta
		 * 
		 * @access private
		 * 
		 * @return void
		 */
		private static function register_meta() {

			register_meta( 
				'post', 
				self::META_KEY, 
				array(
					'sanitize_callback' => array( 'WP_Head_Footer_Options', 'sanitize_options' ),
					'auth_callback'     => array( 'WP_Head_Footer_Utils', 'is_user_authorized' ),
				)
			);
			
		}


		/**
		 * Adds a meta box
		 * @access private
		 * 
		 * @return void
		 */
		public static function add_meta_boxes( $post_type, $post ) {
			
			if( ! post_type_supports( $post_type, self::PLUGIN_SLUG ) ){
				return;
			}

			add_meta_box(
				self::PLUGIN_SLUG.'-'.$post_type,
				self::PLUGIN_TITLE,
				array( __CLASS__ , 'template_metabox' ),
				$post_type,
				'advanced',
				'default'
			);

		}


		/**
		 * Metabox template
		 * @access private
		 * 
		 * @return void
		 */
		public static function template_metabox( $post=null, $array=array() ) {		
			$WP_Head_Footer_Form = new WP_Head_Footer_Form( 'post' );
			include_once( plugin_dir_path( self::FILE ) . 'templates/wp-head-footer-templates-metabox.php' );
			
		}


		/**
		 * Save
		 * 
		 * @param  integer $post_id
		 * @param  object  $post_object
		 * @param  boolean $update
		 * @access private
		 * 
		 * @return void
		 */
		public static function save_post( $post_id = 0, $post_object = null, $update = false  ){

			$k = self::META_KEY;

			if ( !isset( $_POST[ $k ] ) || empty( $_POST[ $k ] ) ) {
		
				return false;
		
			}

			if ( !is_array( $_POST[ $k ] ) ) {
			
				return false;
			
			}

			if ( !isset( $_POST[ $k ]['nonce'] ) || empty( $_POST[ $k ]['nonce'] ) ) {
				
				return false;
			
			}

			if ( !wp_verify_nonce( $_POST[ $k ]['nonce'], plugin_basename( self::FILE ) ) ) {
					
				return false;
			
			}
				 
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			
				return false;
			
			}

			if( wp_is_post_revision( $post_id ) ) {
			
				return false;
			
			}
			
			if ( !( isset( $post_object->post_type ) && !empty( $post_object->post_type ) ) ) {
				
				return false;

			}

			if( ! post_type_supports( $post_object->post_type, self::PLUGIN_SLUG ) ){
				
				return false;

			}

			if ( 'page' == $post_object->post_type ) {
		
				if ( !current_user_can( 'edit_page', $post_id) )
					return false;
		
			} else {
		
				if (!current_user_can('edit_post', $post_id))
					return false;

			}

			/**
			 * Save
			 * 
			 * NOTE: $_POST has already been slashed by wp_magic_quotes 
			 * in wp-settings so do nothing before saving
			 * @see wp_magic_quotes() in WP 4.8.2 -> wp-settings.php;
			 *
			 * WP_Head_Footer_Options::sanitize_options will be called by update_post_meta 
			 * as it is used as sanitize_callback in register_meta
			 */		
		 	update_post_meta( $post_id, self::META_KEY, $_POST[ $k ] );

		}


}

endif;