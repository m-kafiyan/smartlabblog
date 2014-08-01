<?php
/*
Plugin Name: Text Advertisements
Plugin URI: http://picor.ir/1703/text-advertisements-wordpress-plugin.html
Description: Easily put your text advertisements in your wordpress theme
Author: Arash Heidari
Author URI: http://picor.ir
Version: 1.3
License: GPL2
*/
load_plugin_textdomain('text-advertisements', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/');
function text_advertisements_style() {
	 wp_enqueue_style('css', plugin_dir_url(__FILE__) . 'style.css', true, '1.0');
}
add_action( 'wp_enqueue_scripts', 'text_advertisements_style' );
define ( 'PICOR_TEXTADS_URL', plugin_dir_url(__FILE__) );
add_action('init', 'add_ad_custom_posts' );
function add_ad_custom_posts() {
	include ('includes/posttype.php');
}
include ('includes/metaboxes.php');
function display_textads_list(){
	include ('includes/shortcodes.php');
}
add_action( 'init', 'display_textads_list');
add_filter('widget_text', 'do_shortcode');
?>