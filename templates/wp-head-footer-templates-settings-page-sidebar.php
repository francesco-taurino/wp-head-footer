<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * Plugin Information
 * 
 * @package     WP_Head_Footer\Templates
 * @author      Francesco Taurino <dev.francescotaurino@gmail.com>
 * @copyright   Copyright (c) 2017, Francesco Taurino
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 * @Last Modified time: 2017-10-21 21:36:23
 */
?>
<style type="text/css">.ft-plugin-info a{ text-decoration:none; }</style>

<div class="postbox ft-plugin-info">
	
	<h3 class="hndle">
		<span>
			Plugin
		</span>
	</h3>
	
	<div class="inside">

		<ul>
			
			<li class="version">
				<span class="dashicons dashicons-admin-plugins"></span> 
				<?php echo esc_html_x( 'Name', 'Name of the plugin', 'wp-head-footer' ); ?> 
				<?php echo ( get_plugin_data( self::FILE )['Title'] ); ?>
			</li>	

			<li class="version">
				<span class="dashicons dashicons-admin-generic"></span> 
				<?php echo esc_html_x( 'Version', 'Plugin version', 'wp-head-footer' ); ?> 
				<?php list( $__Major, $__Minor, $__Patch ) = explode('.', get_plugin_data( self::FILE )['Version'] ); ?>
				<span title="Major version" style="color:red"><code><?php echo esc_html( $__Major ); ?></code></span>.
				<span title="Minor version" style="color:orange"><code><?php echo esc_html( $__Minor ); ?></code></span>.
				<span title="Patch version" style="color:green"><code><?php echo esc_html( $__Patch ); ?></code></span>
			</li>	

			<li>
				<span class="dashicons dashicons-admin-users"></span>
				<?php echo esc_html_x('Created by', 'Author\'s name', 'wp-head-footer' ); ?> 
				<a href="<?php echo esc_attr( get_plugin_data( self::FILE )['AuthorURI'] ); ?>" target="_blank" title="<?php echo esc_attr( get_plugin_data( self::FILE )['AuthorURI'] ); ?>">
					<?php echo esc_html( get_plugin_data( self::FILE )['AuthorName'] ); ?> 
				</a>

				<a title="<?php echo esc_attr( get_plugin_data( self::FILE )['AuthorName'] ); ?> - WordPress" style="color:green; padding-left: 10px;" href="https://www.francescotaurino.com/wordpress/" target="_blank">
					<span style="font-size:16px!important;" class="dashicons dashicons-rss"></span>
				</a>
			</li>
		
			<li>
				<span class="dashicons dashicons-media-text"></span> 
				<a target="_blank" href="https://plugins.svn.wordpress.org/<?php echo self::PLUGIN_SLUG; ?>/trunk/CHANGELOG.md">
					<?php echo esc_html_x( 'Changelog', 'Changelog of the plugin', 'wp-head-footer' ); ?>
				</a>
			</li>

			<li>
				<span class="dashicons dashicons-star-filled"></span> 
				<a href="https://wordpress.org/support/plugin/<?php echo self::PLUGIN_SLUG; ?>/reviews/#new-post" target="_blank">
					<?php echo esc_html_x( 'Vote', 'Vote the plugin', 'wp-head-footer' ); ?>
				</a>
			</li>

			<li title="<?php echo esc_attr__( 'If you find this plugin useful, please consider making a donation', 'wp-head-footer' ); ?>">
				<span style="color: red" class="dashicons dashicons-heart"></span> 
				<a href="https://www.paypal.me/<?php echo str_replace(' ', '', 'f r a n c e s c o t a u r i n o' ) ?>" target="_blank">
					<?php echo esc_html_x( 'Donate', 'Making a donation', 'wp-head-footer' ); ?>
				</a>
			</li>

		</ul>

	</div>

</div>
<!-- /.postbox -->