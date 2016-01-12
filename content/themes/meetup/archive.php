<?php 
	get_header(); 
	
	$background = get_option('blog_header_background');

	$term = get_queried_object();
	$title = $term->name;
	$sub = __('Items in: ', 'meetup');
	$items = __(' items', 'meetup');
	
	if( $background )
		ebor_page_header($sub . $title, $term->count . $items, $background);
	
	get_template_part('loop/loop','blog');
	
	get_footer();