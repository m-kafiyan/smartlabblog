<?php
function main_meta_box_text_advertisements() {
	add_meta_box('picor-ads-meta', 'text advertisements', 'add_ads_meta_box', 'textads', 'normal', 'high');
	function add_ads_meta_box() {
		global $post;
		$textads_link = get_post_meta($post->ID, 'textads-link', true);
		$textads_des  = get_post_meta($post->ID, 'textads-des', true);
		echo '
		<div class="textads-main">
			<label for="textads-link">' . __('Advertisement link adress (without http://):', 'text-advertisements') . '</label>
			<input type="text" dir="ltr" name="textads-link" value="' . $textads_link . '" />
			<label for="textads-link-des">' . __('Advertisement description :', 'text-advertisements') . '</label>
			<input type="text" name="textads-des" value="' . $textads_des . '" />
			
		</div>
		';
	}
}
add_action( 'add_meta_boxes', 'main_meta_box_text_advertisements' );
function save_textads_meta() {
	global $post;
	if( isset($_POST['post_type']) && ($_POST['post_type'] == "textads") ) {
		if( isset($_POST['textads-link']) && $_POST['textads-link'] != get_post_meta($post->ID, 'textads-link', true)) {
			  update_post_meta($post->ID, 'textads-link', $_POST['textads-link']);
		}
		if( isset($_POST['textads-des']) && $_POST['textads-des'] != get_post_meta($post->ID, 'textads-des', true)) {
			  update_post_meta($post->ID, 'textads-des', $_POST['textads-des']);
		}
    }
}
add_action('save_post', 'save_textads_meta');
?>