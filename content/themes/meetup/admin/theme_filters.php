<?php 

/**
 * Here is all the custom colours for the theme.
 * $handle is a reference to the handle used with wp_enqueue_style()
 */
if(!( function_exists('ebor_less_vars') )){
	function ebor_less_vars( $vars, $handle = 'ebor-theme-styles' ) {
	    $vars['color-primary'] =       get_option('color-primary', '#0072bc');
	    $vars['color-heading'] =       get_option('color-heading', '#333333');
	    $vars['color-text'] =          get_option('color-text', '#777777');
	    $vars['standard-space'] =      get_option('theme_spacing', '72') . 'px';
	    $vars['custom-body-font'] =    get_option('body_font', 'Open Sans');
	    $vars['custom-heading-font'] = get_option('heading_font', 'Open Sans');
	    $vars['color-muted'] =         get_option('color-muted', '#f5f5f5');
	    
	    if( '' == $vars['custom-body-font'] )
	    	$vars['custom-body-font'] = 'sans-serif';
	    	
	    if( '' == $vars['custom-heading-font'] )
	    	$vars['custom-heading-font'] = 'sans-serif';
	    	
	    return $vars;
	}
	add_filter( 'less_vars', 'ebor_less_vars', 10, 2 );
}

if(!( function_exists('ebor_excerpt_more') )){
	function ebor_excerpt_more( $more ) {
		return '...';
	}
	add_filter('excerpt_more', 'ebor_excerpt_more');
}

if(!( function_exists('ebor_excerpt_length') )){
	function ebor_excerpt_length( $length ) {
		return 55;
	}
	add_filter( 'excerpt_length', 'ebor_excerpt_length', 999 );
}

/**
 * Filter the tag cloud appearance to match Tucson styling
 */
if(!( function_exists('ebor_tag_cloud') )){
	function ebor_tag_cloud($tag_string){
		$tag_string = preg_replace("/style='font-size:.+pt;'/", '', $tag_string);
		return $tag_string;
	}
	add_filter('wp_generate_tag_cloud', 'ebor_tag_cloud',10,3);
}

/**
 * Add body class so we know when we're using a page template from the page builder.
 */
if(!( function_exists('ebor_meetup_body_class') )){ 
	function ebor_meetup_body_class($c){
	    global $post;
	    if( isset($post->post_content) && has_shortcode( $post->post_content, 'vc_row' ) ) {
	        $c[] = 'visual-composer-active';
	    }
	    return $c;
	}
	add_filter( 'body_class', 'ebor_meetup_body_class' );
}

/**
 * Add Search Link to Menu
 */
if(!( function_exists('ebor_one_page_nav_rewrite') )){ 
	function ebor_one_page_nav_rewrite($items, $args) {
		global $post;
		
		if(!( isset($post) )){
			return $items;
		} elseif( has_shortcode($post->post_content, 'vc_row') ){
			return $items;
		} elseif( !( is_front_page() ) ){
			return str_replace('href="#', 'href="' . home_url() . '/#', $items);
		} else {
			return $items;
		}
	}
	add_filter( 'wp_nav_menu_items', 'ebor_one_page_nav_rewrite', 20,2 );
}

if(!( function_exists('ebor_remove_more_link_scroll') )){ 
	function ebor_remove_more_link_scroll( $link ) {
		$link = preg_replace( '|#more-[0-9]+|', '', $link );
		return $link;
	}
	add_filter( 'the_content_more_link', 'ebor_remove_more_link_scroll' );
}