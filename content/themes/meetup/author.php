<?php 
	get_header(); 
	
	$background = get_option('blog_header_background');

	$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
	$title = $author->display_name;;
	$sub = __('Items by: ', 'meetup');
	$items = __(' items', 'meetup');
	$count = count_user_posts( $author->ID );
	
	if( $background )
		ebor_page_header($sub . $title, $count . $items, $background);
	
	get_template_part('loop/loop','blog');
	
	get_footer();