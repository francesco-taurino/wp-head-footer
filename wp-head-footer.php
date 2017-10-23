<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * Plugin Name:   WP Head Footer
 * Plugin URI:    https://www.francescotaurino.com/wordpress/wp-head-footer
 * Description:   WP Head Footer allows you to add code to the <head> and/or footer of an individual post (or any post type) and/or site-wide
 * Author:        Francesco Taurino
 * Author URI:    https://www.francescotaurino.com
 * Version:       1.0.4
 * Text Domain:   wp-head-footer
 * Domain Path: 	/languages
 * License: GPL v3
 *
 * @package     WP_Head_Footer
 * @author      Francesco Taurino <dev.francescotaurino@gmail.com>
 * @copyright   Copyright (c) 2017, Francesco Taurino
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 *
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/gpl-3.0.html.
 */


interface iWP_Head_Footer{

	const PLUGIN_SLUG = 'wp-head-footer';
	const PLUGIN_TITLE = 'WP Head Footer';
	const REQUIRED_CAPABILITY = 'manage_options'; // + unfiltered_html
	const FILE = __FILE__;
	const OPTION_NAME = 'wphf_site_settings';
	const META_KEY = 'wphf_post_settings';
}


require_once( plugin_dir_path( __FILE__ ).'includes/class-wp-head-footer.php' );