<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * WP_Head_Footer_Settings
 *
 * @package     WP_Head_Footer\Includes
 * @author      Francesco Taurino <dev.francescotaurino@gmail.com>
 * @copyright   Copyright (c) 2017, Francesco Taurino
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 */
if( !class_exists('WP_Head_Footer_Settings') ) : 


	class WP_Head_Footer_Settings implements iWP_Head_Footer  {


		public static function admin_menu() {
			
			add_options_page(
				self::PLUGIN_TITLE,
				self::PLUGIN_TITLE,
				self::REQUIRED_CAPABILITY,
				self::PLUGIN_SLUG,
				array( __CLASS__, 'page' )
			);

		}


		public static function admin_init() {
			
			register_setting(
				self::OPTION_NAME.'_option_group',
				self::OPTION_NAME,
				array( 'WP_Head_Footer_Options', 'sanitize_options' )
			);


			foreach ( WP_Head_Footer_Options::get_sections() as $section => $section_args) {
				
				add_settings_section(
					self::OPTION_NAME.'_section_'. $section,
					$section_args['title'],
					null,
					self::PLUGIN_SLUG.'-admin-page'
				);

				foreach ( $section_args['options'] as $key => $value) {
						if( strpos( $value['input_name'], 'replace') !== false ) continue;
						
						add_settings_field(
							$key,
							$value['label'],
							array( __CLASS__, 'render_field' ),
							self::PLUGIN_SLUG.'-admin-page',
							self::OPTION_NAME.'_section_'. $section,
							$value
						);

				}
		
			}

		}
		
		public static function page() {
			include_once( plugin_dir_path( self::FILE ) . 'templates/wp-head-footer-templates-settings-page.php' );
		}


		public static function render_field( $args ) {
			$WP_Head_Footer_Form = new WP_Head_Footer_Form('site');
			$WP_Head_Footer_Form::field( $args, true );
		}


	}

endif;