<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * WP_Head_Footer_Sanitize
 *
 * @package     WP_Head_Footer\Includes
 * @author      Francesco Taurino <dev.francescotaurino@gmail.com>
 * @copyright   Copyright (c) 2017, Francesco Taurino
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 */
if( !class_exists('WP_Head_Footer_Sanitize') ) :

	
	class WP_Head_Footer_Sanitize implements iWP_Head_Footer  {


		/**
		 * Sanitize Priority
		 * 
		 * Used to specify the order in which the functions associated 
		 * with a particular action are executed. 
		 * Lower numbers correspond with earlier execution, and functions 
		 * with the same priority are executed in the order in which they were added to the action.
		 * 
		 * @param  integer $val. Possible values are: 1, 10, PHP_INT_MAX. Default 10
		 * @param  string  $context
		 * 
		 * @return integer $val
		 */
		public static function sanitize_priority( $val = 10, $context = '' ) {
			return in_array( $val, array(1, 10, PHP_INT_MAX ) ) ? $val : 10;
		}


		/**
		 * Sanitize Replace
		 * 
		 * @param  integer $val
		 * @param  string  $context
		 * 
		 * @return integer 1 or 0
		 */
		public static function sanitize_replace( $val = 0, $context = '' ) {
			return filter_var($val, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
		}

		
		/**
		 * Content
		 * 
		 * Obviously, no sanitization or validation being done here
		 * 
		 * @param  string  $val
		 * @param  string  $context
		 * 
		 * @return string  $val
		 */
		public static function sanitize_content( $val = '', $context = '' ) {
			
			if( $context == 'db'){
			
				return trim($val);
			
			} elseif( $context == ''){
				
				return implode( PHP_EOL, array_map( 'trim', explode( PHP_EOL, $val ) ) );
			
			}

		}


	}


endif;