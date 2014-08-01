<?php
$labels = array(
	'name' => 	__('Text advertisemets', 'text-advertisements'),
	'singular_name' => __('Text advertisemet', 'text-advertisements'),
	'add_new' => __('Add new advertisement', 'text-advertisements'),
	'add_new_item' => __('Add new text advertisements', 'text-advertisements'),
	'edit_item' => __('Edit advertisement', 'text-advertisements'),
	'new_item' => __('Add new text advertisement', 'text-advertisements'),
	'view_item' => __('View advertisement', 'text-advertisements'),
	'search_items' => __('Search in text advertisements', 'text-advertisements'),
	'not_found' => __('There is no text advertisement', 'text-advertisements'),
	'not_found_in_trash' => __('There is no text advertisement in trash', 'text-advertisements'),
	'parent_item_colon' => __('text advertisement', 'text-advertisements'),
	'menu_name' => __('text advertisements', 'text-advertisements'),
);
$arguments = array(
	'labels' => $labels,
	'label' => __('text advertisements', 'text-advertisements'),
	'description' => __('text advertisements', 'text-advertisements'),
	'supports' => array( 'title', 'custom-fields' ),
	'show_ui' => true,
	'show_in_menu' => true,
	'menu_position' => 80,
	'menu_icon' => plugins_url('images/icon.png', dirname(__FILE__) ),
);
register_post_type( 'textads', $arguments );
?>