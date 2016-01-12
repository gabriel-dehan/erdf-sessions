<?php 
	get_header(); 
	
	$background = get_option('blog_header_background');
	
	$total_results = $wp_query->found_posts;
	$items = ( $total_results == '1' ) ? __(' item','meetup') : __(' items','meetup');
	$title = get_search_query();
	$sub = __('Found ','meetup') . $total_results . $items;
	
	if( $background )
		ebor_page_header($title, $sub, $background);
	
	get_template_part('loop/loop','blog');
	
	get_footer();