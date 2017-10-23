<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * WP_Head_Footer_Options
 *
 * @package     WP_Head_Footer\Includes
 * @author      Francesco Taurino <dev.francescotaurino@gmail.com>
 * @copyright   Copyright (c) 2017, Francesco Taurino
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 */
if( !class_exists('WP_Head_Footer_Options') ) :

	
	class WP_Head_Footer_Options implements iWP_Head_Footer  {

		/**
		 * Sections
		 * 
		 * @param  string $key
		 * @return array
		 */
		public static function get_sections( $key = null ) {
			
			$defaults = array(
				
				'head' => array( 
					'name'=> 'head', 
					'title'=> 'Head', 
					'description' => 'Head section',
					'options' => wp_filter_object_list( 
													self::get_default_options(), 
													array('section' => 'head'), 
													'and' 
												)
				),

				'footer' => array( 
					'name'=> 'footer', 
					'title'=> 'Footer', 
					'description' => 'Footer section',
					'options' => wp_filter_object_list( 
													self::get_default_options(), 
													array('section' => 'footer'), 
													'and' 
												)
				),
			);

			if( $key !== null ){

				return isset( $defaults[$key] ) ? $defaults[$key] : null;

			}

			return $defaults;

		}


		/**
		 * Default options
		 * 
		 * @param  string $key
		 * @return array
		 */
		public static function get_default_options( $key = null ) {
			
			$defaults = array(
				
				'wp_head_priority' => array( 
					'type'=> 'string', 
					'input_name'=> 'wp_head_priority', 
					'input_type'=> 'select', 
					'input_value'=> 10, 
					'select'=> array( 
						10 => esc_html__( 'Default', 'wp-head-footer' ), 
						1 => esc_html__( 'Highest', 'wp-head-footer' ), 
						PHP_INT_MAX => esc_html__( 'Lowest', 'wp-head-footer' ) 
					), 
					'sanitize_callback' => 'sanitize_priority',
					'label' => esc_html__( 'Head code priority', 'wp-head-footer' ), 
					'description' => '',
					'section' => 'head'
				),

				'wp_head_replace' => array( 
					'type'=> 'integer', 
					'input_name'=> 'wp_head_replace', 
					'input_type'=> 'select', 
					'input_value'=> 0, 
					'select'=> array( 0 => esc_html__( 'No', 'wp-head-footer' ), 1 => esc_html__( 'Yes', 'wp-head-footer' ) ), 
					'sanitize_callback' => 'sanitize_replace',
					'label' => esc_html__( 'Replace site-wide head code', 'wp-head-footer' ), 
					'description' => '',
					'section' => 'head'
				),

				'wp_head' => array( 
					'type'=> 'string', 
					'input_name'=> 'wp_head', 
					'input_type'=> 'text', 
					'input_value'=> '', 
					'sanitize_callback' => 'sanitize_content',
					'label' => 'Head code', 
					'description' => '', 
					'section' => 'head'
				),

				'wp_footer_priority' => array( 
					'type'=> 'integer', 
					'input_name'=> 'wp_footer_priority', 
					'input_type'=> 'select', 
					'input_value'=> 10, 
					'select'=> array( 
						10 => esc_html__( 'Default', 'wp-head-footer' ), 
						1 => esc_html__( 'Highest', 'wp-head-footer' ), 
						PHP_INT_MAX => esc_html__( 'Lowest', 'wp-head-footer' ) 
					), 
					'sanitize_callback' => 'sanitize_priority',
					'label' => esc_html__( 'Footer code priority', 'wp-head-footer' ), 
					'description' => '',
					'section' => 'footer'
				),

				'wp_footer_replace' => array( 
					'type'=> 'integer', 
					'input_name'=> 'wp_footer_replace', 
					'input_type'=> 'select', 
					'input_value'=> 0, 
					'select'=> array( 0 => esc_html__( 'No', 'wp-head-footer' ), 1 => esc_html__( 'Yes', 'wp-head-footer' ) ), 
					'sanitize_callback' => 'sanitize_replace',
					'label' => esc_html__( 'Replace site-wide footer code', 'wp-head-footer' ), 
					'description' => '',
					'section' => 'footer'
				),

				'wp_footer' => array( 
					'type'=> 'string', 
					'input_name'=> 'wp_footer', 
					'input_type'=> 'text', 
					'input_value'=> '', 
					'sanitize_callback' => 'sanitize_content',
					'label' => 'Footer code', 
					'description' => '', 
					'section' => 'footer'
				),

			);

			if( $key !== null ){

				return isset( $defaults[$key] ) ? $defaults[$key] : null;

			}

			return $defaults;

		}


		/**
		 * Get Options
		 * 
		 * @param  integer $post_id  Post id
		 * @param  string  $key
		 * @param  boolean $sitewide
		 * @return array $options or null
		 */
		public static function get_options( $post_id = 0, $key = null, $sitewide = false ) {

			$options = array();
		
			$defaults = wp_filter_object_list( 
					self::get_default_options(), 
					array(), 
					'and', 
					'input_value'
			);

			if( $sitewide )	{
				
				$db_options = get_option( self::OPTION_NAME, $defaults );
			
			} else {
				
				$db_options = get_post_meta( $post_id, self::META_KEY, true );
			
			}

			foreach ( $defaults as $x => $default ) {

				$options[$x] = self::sanitize_option( $x, isset($db_options[$x]) ? $db_options[$x] : $default );
		
			}

			if( $key !== null ){

				return isset( $options[$key] ) ? $options[$key] : null;

			}

			return $options;

		}


		/**
		 * Get priority
		 * 
		 * Used to specify the order in which the functions associated 
		 * with a particular action are executed. 
		 * Lower numbers correspond with earlier execution, and functions 
		 * with the same priority are executed in the order in which they were added to the action.
		 * 
		 * @param  integer $post_id
		 * @param  string  $key [wp_head|wp_footer]
		 * @param  boolean $sitewide
		 * 
		 * @return integer $value. 0 or 10 or PHP_INT_MAX
		 */
		public static function get_priority( $post_id = 0, $key = '', $sitewide = false ) {
			
			$value = (int) self::get_options( $post_id, $key.'_priority', $sitewide );
			
			return ( $value == 1 ) ? 0 : $value;

		}


		/**
		 * Sanitize
		 *
		 * @param  string $key
		 * @param  mixed  $raw_value
		 * @param  string $context Allowed values are: db,''. Default empty.
		 * @see 	 WP_Head_Footer_Sanitize
		 * 
		 * @return mixed  $value
		 */
		public static function sanitize_option( $key = null, $raw_value = null, $context = '' ) {
			
			$dfs = self::get_default_options();
			
			$callback = isset( $dfs[$key]['sanitize_callback'] ) ? $dfs[$key]['sanitize_callback'] : null;
			
			$default = isset( $dfs[$key]['input_value'] ) ? $dfs[$key]['input_value'] : null;
			
			if( $callback && method_exists('WP_Head_Footer_Sanitize', $callback ) ){

				$value = WP_Head_Footer_Sanitize::$callback( $raw_value, $context );

			} else {

				$value = $default;

			}

			return $value;
			//return ( $context == 'db' ) ? apply_filters( 'content_save_pre', $value ) : $value;

		}

		/**
		 * Sanitize
		 * 
		 * @param string $key
		 * @param  mixed $val
		 * @return array
		 */
		public static function sanitize_options($data) {

			$sanitized = array();
			
			foreach ( self::get_default_options() as $key => $args ) :
					
					if ( isset( $data[ $key ] ) ) :
					
						$sanitized[$key] = self::sanitize_option( $key, $data[$key], 'db' );
					
					endif;

			endforeach;
			
			return $sanitized;

		}
		

	}

endif;