=== WP Head Footer ===
Contributors: francescotaurino
Donate link: https://www.paypal.me/francescotaurino
Tags: header, footer, wp_head, wp_footer, head, post, scripts, html, css, js, simple, fast, secure
Requires at least: 4.7.0
Tested up to: 4.8.2
Requires PHP: 5.2.4
Stable tag: 1.0.4
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

WP Head Footer allows administrators to add code to the head and/or footer of an individual post (or any post type) and/or site-wide
 
== Description ==

WP Head Footer allows administrators to add code to the head and/or footer of an individual post (or any post type) and/or site-wide.  

= No need to edit your theme files! =

WP Head Footer allows you to add extra scripts to the header and footer, without touching your theme files

= Features of WP Head Footer =

* Quick to set up
* Simple interface 
* Insert header code and/or footer code of an individual post (or any post type) and/or site-wide.
* Set the output priority of the head and footer code
* Add <strong>Google Analytics</strong> code to any theme
* Insert <strong>Facebook pixel code</strong>
* Add <strong>custom CSS</strong> across themes
* Insert any code or script, including HTML and Javascript

= Notes about the Plugin =

In order to use this plugin, **you must have the `manage_options` and `unfiltered_html` capabilities** .

Setting the `DISALLOW_UNFILTERED_HTML` constant to `true` in the wp-config.php 
would effectively disable this plugin's admin because no user would have the capability.

**There is no input validation or any filtering.** This plugin puts exactly what you type in the meta box directly into the `html`. Be careful.

== Frequently Asked Questions ==
 
= Where is the settings? =
1. Menu > Settings > WP Head Footer, for the site-wide settings.
2. Edit post/page, WP Head Footer Meta box.

= How do I add support for custom post types? =
 
To add support for custom post types use add_post_type_support( 'my_post_type', 'wp-head-footer' ):

`
function my_WP_Head_Footer() {
    add_post_type_support( 'my_post_type', 'wp-head-footer' );
}
add_action( 'init', 'my_WP_Head_Footer' );
`

== Installation ==
 
1. Upload the `WP Head Footer` plugin to your WordPress site in the `/wp-content/plugins` folder or install via the WordPress admin.
1. Activate it from the WordPress plugin admin screen.

== Screenshots ==

1. Code will be included on every page of your website.
2. Code will output specifically to this page, post or custom post type. Optionally you can replace or remove the site-wide code
3. Head
4. Footer

== Changelog ==

View a list of all plugin changes in [CHANGELOG.md](https://plugins.svn.wordpress.org/wp-head-footer/trunk/CHANGELOG.md).
