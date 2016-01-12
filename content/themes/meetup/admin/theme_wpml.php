<?php 

if(!( function_exists('ebor_language_selector_flags') ) && function_exists('icl_get_languages') ){
	function ebor_language_selector_flags(){
	    $languages = icl_get_languages('skip_missing=0&orderby=code');
	    if(!( empty($languages) )){
	        foreach($languages as $l){
	            echo '<a href="'.$l['url'].'" class="language"><img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" /></a>';
	        }
	    }
	}
}

if(!( function_exists('ebor_wpml_cleaner') )){
	function ebor_wpml_cleaner($items,$args) {
	      
	    if($args->theme_location == 'primary'){
	          
	        if (function_exists('icl_get_languages')) {
	            $items = str_replace('sub-menu', 'subnav', $items);
	            $items = str_replace('menu-item-language', 'menu-item-language has-dropdown', $items);
	        }
	  
	        return $items;
	    }
	    else
	        return $items;
	}
}
add_filter( 'wp_nav_menu_items', 'ebor_wpml_cleaner', 20,2 );