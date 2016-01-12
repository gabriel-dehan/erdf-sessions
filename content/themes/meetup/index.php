<?php 
	get_header(); 
	
	$background = get_option('blog_header_background');
	$title = get_option('blog_title','Our Blog');
	$sub = get_option('blog_subtitle', 'News & Views');
	
	if( $background )
		ebor_page_header($title, $sub, $background);
	
	get_template_part('loop/loop','blog');
	
	get_footer();