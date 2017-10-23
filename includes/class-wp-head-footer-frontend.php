<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * WP_Head_Footer_Frontend
 *
 * @package     WP_Head_Footer\Includes
 * @author      Francesco Taurino <dev.francescotaurino@gmail.com>
 * @copyright   Copyright (c) 2017, Francesco Taurino
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 */

if( !class_exists('WP_Head_Footer_Frontend') ) :


	class WP_Head_Footer_Frontend implements iWP_Head_Footer  {

		/**
		 * Template redirect
		 * This action hook executes just before WordPress determines which template page to load. 
		 * 
		 * @access private
		 * @return void
		 */
		public static function template_redirect() {
			
			if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {
				return;
			}

			$post_settings = WP_Head_Footer_Options::get_options( get_the_ID(), null );
		
			// Header (Site-Wide)
			if( empty( $post_settings['wp_head_replace'] ) ){

				add_action( 'wp_head', 
					array( __CLASS__, 'site_wp_head' ), 
					WP_Head_Footer_Options::get_priority( null, 'wp_head', true )
				);

			}
			
			// Footer (Site-Wide)
			if( empty( $post_settings['wp_footer_replace'] ) ){
				
				add_action( 'wp_footer', 
					array(__CLASS__, 'site_wp_footer'), 
					WP_Head_Footer_Options::get_priority( null, 'wp_footer', true )
				);			
			
			}

			if ( self::is_post() ) {
				
				// Header (Post)
				add_action( 'wp_head', 
					array(__CLASS__, 'post_wp_head'), 
					WP_Head_Footer_Options::get_priority( get_the_ID(), 'wp_head' )
				);
				
				// Footer (Post)
				add_action( 'wp_footer', 
					array(__CLASS__, 'post_wp_footer'), 
					WP_Head_Footer_Options::get_priority( get_the_ID(), 'wp_footer' )
				);			

			}

		}


		/**
		 * Output wp_head on site-wide
		 * 
		 * @access private
		 * @return void
		 */
		public static function site_wp_head() {
			self::html( 'wp_head', true );
		}
		

		/**
		 * Output wp_footer on site-wide
		 * 
		 * @access private
		 * @return void
		 */
		public static function site_wp_footer() {
			self::html( 'wp_footer', true );
		}


		/**
		 * Output wp_head on single page/post/cpt
		 * 
		 * @access private
		 * @return void
		 */
		public static function post_wp_head() {
			self::html( 'wp_head' );
		}


		/**
		 * Output wp_footer on single page/post/cpt
		 * 
		 * @access private
		 * @return void
		 */
		public static function post_wp_footer() {
			self::html('wp_footer');
		}


		/**
		 * Is Post
		 * 
		 * @return bool
		 */
		public static function is_post() {
			global $post;
			$x = ( ( is_front_page() || is_home() ) && get_option('show_on_front') == 'page' );
			$y = is_single() || is_page() || $x;
	 		$z = ( $y && ( isset( $post->post_type ) && isset( $post->ID ) && $post->ID > 0 ) );
			return ( $z && post_type_supports( $post->post_type, self::PLUGIN_SLUG ) );
		}


		/**
		 * Html
		 *
		 * @param  string $key
		 * @param  boolean $sitewide
		 * @return void
		 */
		private static function html( $key = '', $sitewide = false ) {
			
			$html = WP_Head_Footer_Options::get_options( get_the_ID(), $key, $sitewide );
			
			// H = Head 
			// F = Footer
			$where 	= 'wp_head' ? '[H]' : '[F]';

			// S = Site-wide
			// P = Page/Post/CPT			
			$type 	= $sitewide ? '[S]' : '[P]';
			
			if( WP_Head_Footer_Utils::is_user_authorized() ) {
				
				$debug 	= ' ' . $where . $type;

			} else {

				$debug 	= '';

			}

			if( empty($html) ) return ;
			echo PHP_EOL;
			echo PHP_EOL;
			echo "<!-- " . self::PLUGIN_TITLE . $debug . " -->";
			echo PHP_EOL . $html . PHP_EOL;
			echo "<!-- / " . self::PLUGIN_TITLE . $debug . " -->";
			echo PHP_EOL;
			echo PHP_EOL;
		}


	}

endif;