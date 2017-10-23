<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * WP_Head_Footer_Form
 *
 * @package     WP_Head_Footer\Includes
 * @author      Francesco Taurino <dev.francescotaurino@gmail.com>
 * @copyright   Copyright (c) 2017, Francesco Taurino
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 */
if( !class_exists('WP_Head_Footer_Form') ) :


	class WP_Head_Footer_Form implements iWP_Head_Footer  {

		
		/**
		 * Option name
		 * @var string
		 */
		protected static $option_name = '';
		

		/**
		 * sitewide
		 * @var bool
		 */
		protected static $sitewide = false;


		public function __construct( $key = '' ) {

			if( $key =='site' ){
				self::$option_name = self::OPTION_NAME;
				self::$sitewide = true;
			}elseif( $key =='post' ){
				self::$option_name = self::META_KEY;
			}else{
				return;
			}
		}


		/**
		 * Input Name
		 * 
		 * @param  string  $key
		 * @param  boolean $sitewide [description]
		 * @return string
		 */
		public static function input_name( $key = null ) { 
			return self::$option_name.'['.$key.']';
		}


		/**
		 * Input ID
		 * 
		 * @param  string  $key
		 * @return string
		 */
		public static function input_id( $key = null ) { 
			return self::$option_name.'-'.$key;
		}


		/**
		 * Input Field
		 * 
		 * @param  array  $args
		 * @return void
		 */
		public static function field( $args ) {

			$post_id = isset( $args['post_id'] ) ? $args['post_id'] : 0 ;
			$type = isset( $args['input_type'] ) ? $args['input_type'] : false ;
			
			if( isset( $args['post_id'] ) ){
				unset($args['post_id']);
			}

			if( $type == 'select'){
				
				self::select(
					array( 
					'id' => self::input_id($args['input_name'] ),
					'name' => self::input_name($args['input_name'] ), 
					'list' => WP_Head_Footer_options::get_default_options($args['input_name'])['select'], 
					'value' => WP_Head_Footer_options::get_options( $post_id, $args['input_name'], self::$sitewide), 
					'label' => WP_Head_Footer_options::get_default_options($args['input_name'])['label'], 
					)
				);

			} elseif( $type == 'text') {

				self::textarea(
					array( 
					'id' => self::input_id($args['input_name'] ),
					'name' => self::input_name($args['input_name'] ), 
					'value' => WP_Head_Footer_options::get_options( $post_id, $args['input_name'], self::$sitewide ), 
					'label' => WP_Head_Footer_options::get_default_options($args['input_name'])['label'], 
					'label_top' => true,
					)
				);

			}

		}


		/**
		 * Nonce
		 * 
		 * @return string
		 */
		public static function nonce() {
	    echo '<input type="hidden" id="' . esc_attr( self::input_id( 'nonce' ) ) . '" name="' . esc_attr( self::input_name( 'nonce' ) ) .'" value="' . wp_create_nonce( plugin_basename( self::FILE ) ) . '" />';
		}


		/**
		 * Fields
		 * 
		 * @param  object  $post_object
		 * @param  string $section
		 * @return void
		 */
		final public static function fields( $post_object, $section = '' ) {

			$options = wp_filter_object_list(
				WP_Head_Footer_options::get_default_options(), 
				!empty($section) ? array( 'section' => $section ) : array(),
				'and', 
				null
			);

			foreach ( (array) $options as $key => $args ) {
				if( self::$sitewide && strpos($key, 'replace') !== false ) continue;

				if( !self::$sitewide ){
					$args['post_id'] = isset($post_object->ID) ? $post_object->ID : 0;
				}

				?> 
				<table class="form-table"> 
				<tr>
				<?php
				echo '
				<th scope="row">
				<label for="' . esc_attr( self::input_id($key,self::$sitewide) ) . '">
				' . esc_html($args['label']) . '
				</label>
				</th>';
				echo '<td>';
				echo '<fieldset>';
				echo self::field( $args );
				if( isset($args['description']) && !empty($args['description']) ){
					echo '<p class="description">'.esc_html($args['description']).'</p>';
				}
				echo '</fieldset>';
				echo '</td>';
				?> 
				</tr>
				</table> <?php
			
			}


		}


		/**
		 * Create Textarea field
		 * 
		 * @param  array  $args
		 * @return void
		 */
		public static function textarea( $args = array() ) {
			if( !isset( $args['id'] ) || empty( $args['id'] ) ) return;
			$val = isset( $args['value'] ) ? $args['value'] : '';
 			echo '<textarea ';
 			echo 'id="'.esc_attr( isset( $args['id'] ) ? $args['id'] : '' ).'" ';
 			echo 'name="'.esc_attr( isset( $args['name'] ) ? $args['name'] : $args['id'] ).'" ';
 			echo 'class="'.esc_attr(isset( $args['class'] ) ? $args['class'] : 'textarea').'" ';
 			echo 'style="width:100%; min-height:200px" ';
 			echo '>';
 			echo esc_textarea($val);
 			echo '</textarea>';
		}


		/**
		 * Create select field
		 * 
		 * @param  array  $args
		 * @return void
		 */
		public static function select( $args = array() ) {
			if( !isset( $args['id'] ) || empty( $args['id'] ) ) return;
			if( !isset( $args['list'] ) ) return;
			$val = isset( $args['value'] ) ? $args['value'] : '';
 			echo '<select ';
 			echo 'id="'.esc_attr( isset( $args['id'] ) ? $args['id'] : '' ).'" ';
 			echo 'name="'.esc_attr( isset( $args['name'] ) ? $args['name'] : $args['id'] ).'" ';
 			echo 'class="'.esc_attr( isset( $args['class'] ) ? $args['class'] : 'select-option').'" ';
 			echo '>';
 			foreach ( !empty( $args['list'] ) ? $args['list'] : array() as $v => $l ) :
					$s = ( $v == $val ) ? ' selected="selected" ' : ' ';
					echo '<option'.$s.'value="'.esc_attr($v).'">'.esc_html($l).'</option>';
			endforeach;
 			echo '</select>';
		}


	}

endif;