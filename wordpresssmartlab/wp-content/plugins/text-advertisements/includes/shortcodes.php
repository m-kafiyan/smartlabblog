<?php
function shortcodes_text_advertisements() {
	$tmp_query = $wp_query;
	wp_reset_postdata();
	wp_reset_query();
	$the_query = new WP_Query( 'post_type=textads' );
	$out .='';
	if ($the_query->have_posts()) {
		$out .= '';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$textads_link = get_post_meta(get_the_ID(), 'textads-link', true);
			$textads_des  = get_post_meta(get_the_ID(), 'textads-des', true);
			$out .= '
			<a href="http://' . $textads_link . '/" title="' . get_the_title() . '" class="ads grayads" target="_blank">
			<span class="ads-title" >' . get_the_title() . '</span>
			<span class="ads-description">' . $textads_des . '</span>
			<span class="ads-url">' . $textads_link . '</span>
			</a>
			';
		}
		$out .= '';
	} else {
		$out .= '
		<p>' . __('There is no text advertisement.', 'text-advertisements') . '
		</p>
		';
	}
	$out .= '';
	return $out;
	wp_reset_postdata();
	wp_reset_query();
	$wp_query = $tmp_query;
}

add_shortcode('Text-Advertisements', 'shortcodes_text_advertisements');

?>
