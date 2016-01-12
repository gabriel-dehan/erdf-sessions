<?php

/**
 * Load Theme Support on Init
 */
if(!( function_exists('ebor_framework_add_editor_styles') )){
	function ebor_framework_add_editor_styles() {
		/**
		 * Add WP Editor Styling
		 */
	    add_editor_style( 'admin/editor-style.css' );
	    
	    /**
	     * Set Content Width
	     */
	    if ( ! isset( $content_width ) ) $content_width = 1180;
	}
	add_action( 'init', 'ebor_framework_add_editor_styles', 10 );
}

/**
 * Load Theme Support after_theme_setup
 */
if(!( function_exists('ebor_framework_add_theme_support') )){
	function ebor_framework_add_theme_support() {
		/**
		 * Add post thumbnail (featured image) support
		 */
		add_theme_support( 'post-thumbnails' );
		
		/**
		 * Image Sizes used in the theme
		 */
		add_image_size( 'team-small', 172, 172, true);
		add_image_size( 'blog-grid', 600, 400, true);
		add_image_size( 'admin-list-thumb', 60, 60, true );
		
		/**
		 * Add Custom Background Support and Set Default
		 */
		add_theme_support( 'custom-background', array( 'default-color' => 'f7f7f7' ) );
		
		/**
		 * Add feed link support
		 */
		add_theme_support( 'automatic-feed-links' );
		
		/**
		 * Add html5 support
		 */
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
		
		/**
		 * Load Translation Files
		 */
		load_theme_textdomain('meetup', EBOR_THEME_DIRECTORY . 'languages');
		
		/**
		 * Woocommerce support
		 */
		add_theme_support( 'woocommerce' );
	}
	add_action('after_setup_theme', 'ebor_framework_add_theme_support', 10 );
}