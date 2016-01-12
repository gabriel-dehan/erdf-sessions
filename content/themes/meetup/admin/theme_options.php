<?php 

function ebor_theme_customize($wp_customize){
	$wp_customize->remove_section( 'colors' );
}
add_action('customize_register', 'ebor_theme_customize', 99999);

/**
 * Build theme options
 * Uses the Ebor_Options class found in the ebor-framework plugin
 * Panels are WP 4.0+!!!
 * 
 * @since 1.0.0
 * @author tommusrhodus
 */
if( class_exists('Ebor_Options') ){
	$ebor_options = new Ebor_Options;
	
	/**
	 * Variables
	 */
	$theme = wp_get_theme();
	$theme_name = $theme->get( 'Name' );
	$social_options = ebor_get_social_icons();
	$footer_default = 'Copyright 2014 TommusRhodus';
	$subtitle_default = 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta.';
	$team_layouts = array(
		'team-tiny' => 'Tiny (4 Columns)',	
		'team-small' => 'Small (3 Columns)',	
		'team-large' => 'Large (2 Columns)',	
	);
	$fonts_description = 'Fonts: ' . $theme_name . ' uses Google Fonts, <a href="https://www.google.com/fonts" target="_blank">all of which are viewable here</a>. Unlike some themes, ' . $theme_name . ' does not load all of these fonts into these options, in avoiding this ' . $theme_name . ' can work faster and more reliably.<br /><br />
	
	To customize the fonts on your website use the URL above and the inputs below accordingly. Full details of this process (and the default values) can be found in the theme documentation!';
	
	/**
	 * Panels
	 * 
	 * add_panel($name, $priority, $description)
	 * 
	 * @since 1.0.0
	 * @author tommusrhodus
	 */
	$ebor_options->add_panel( $theme_name . ': Demo Data', 5, '');
	$ebor_options->add_panel( $theme_name . ': Styling Settings', 205, 'All of the controls in this section directly relate to the styling page of ' . $theme_name);
	$ebor_options->add_panel( $theme_name . ': Header Settings', 215, 'All of the controls in this section directly relate to the header and logos of ' . $theme_name);
	$ebor_options->add_panel( $theme_name . ': Blog Settings', 225, 'All of the controls in this section directly relate to the control of blog items within ' . $theme_name);
	$ebor_options->add_panel( $theme_name . ': Team Settings', 235, 'All of the controls in this section directly relate to the control of team items within ' . $theme_name);
	$ebor_options->add_panel( $theme_name . ': Footer Settings', 290, 'All of the controls in this section directly relate to the control of the footer within ' . $theme_name);
	
	/**
	 * Sections
	 * 
	 * add_section($name, $title, $priority, $panel, $description)
	 * 
	 * @since 1.0.0
	 * @author tommusrhodus
	 */
	//Demo Data
	$ebor_options->add_section('demo_data_section', 'Import Demo Data', 10, $theme_name . ': Demo Data', '<strong>Please read this before importing demo data via this control:</strong><br /><br />The demo data this will install includes images from my demo site with <strong>heavy blurring applied</strong> this is due to licensing restrictions. Simply replace these images with your own.<br /><br />');
	
	//Styling Sections
	$ebor_options->add_section('fonts_section', 'Fonts', 5, $theme_name . ': Styling Settings', $fonts_description);
	$ebor_options->add_section('colours_section', 'Colours', 10, $theme_name . ': Styling Settings');
	$ebor_options->add_section('spacing_section', 'Spacing', 15, $theme_name . ': Styling Settings');
	$ebor_options->add_section('favicon_section', 'Favicons', 30, $theme_name . ': Styling Settings');
	$ebor_options->add_section('custom_css_section', 'Custom CSS', 40, $theme_name . ': Styling Settings');
	
	//Blog Sections
	$ebor_options->add_section('blog_settings', 'Blog Settings', 1, $theme_name . ': Blog Settings');
	$ebor_options->add_section('blog_text_section', 'Blog Texts', 5, $theme_name . ': Blog Settings');
	
	//Header Settings
	$ebor_options->add_section('header_layout_section', 'Header Layout', 5, $theme_name . ': Header Settings', 'This setting controls the theme header site-wide. If you need to you can override this setting on specific posts and pages from within that posts edit screen.');
	$ebor_options->add_section('logo_settings_section', 'Logo Settings', 10, $theme_name . ': Header Settings');
	$ebor_options->add_section('header_social_settings_section', 'Header Icons Settings', 40, $theme_name . ': Header Settings', 'These social icons are only shown in certain header layouts.');
	
	//Footer Settings
	$ebor_options->add_section('subfooter_settings_section', 'Sub-Footer Settings', 30, $theme_name . ': Footer Settings');
	
	//Team Settings
	$ebor_options->add_section('team_text_section', 'Team Texts', 5, $theme_name . ': Team Settings');
	$ebor_options->add_section('team_settings_section', 'Team Layout Settings', 10, $theme_name . ': Team Settings');
	
	/**
	 * Settings (The Actual Options)
	 * Repeated settings are stepped using a for() loop and counter
	 * 
	 * add_setting($type, $option, $title, $section, $default, $priority, $select_options)
	 * 
	 * @since 1.0.0
	 * @author tommusrhodus
	 */
	
	//Favicons
	$ebor_options->add_setting('image', 'custom_favicon', 'Custom Favicon Upload (Use .png)', 'favicon_section', '', 10);
	$ebor_options->add_setting('image', 'mobile_favicon', 'Mobile Favicon Upload (Use .png)', 'favicon_section', '', 15);
	$ebor_options->add_setting('image', '72_favicon', '72x72px Favicon Upload (Use .png)', 'favicon_section', '', 20);
	$ebor_options->add_setting('image', '114_favicon', '114x114px Favicon Upload (Use .png)', 'favicon_section', '', 25);
	$ebor_options->add_setting('image', '144_favicon', '144x144px Favicon Upload (Use .png)', 'favicon_section', '', 30);
	
	//Demo Data
	$ebor_options->add_setting('demo_import', 'demo_import', 'Import Demo Data', 'demo_data_section', '', 10);
	
	//Fonts
	$ebor_options->add_setting('input', 'body_font', 'Body Font', 'fonts_section', 'Open Sans', 10);
	$ebor_options->add_setting('textarea', 'body_font_url', 'Body Font URL Parameter', 'fonts_section', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700', 15);
	$ebor_options->add_setting('input', 'heading_font', 'Heading Font', 'fonts_section', 'Open Sans', 20);
	$ebor_options->add_setting('textarea', 'heading_font_url', 'Heading Font URL Parameter', 'fonts_section', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700', 25);
	
	//Colour Options
	$ebor_options->add_setting('color', 'color-primary', 'Primary Colour', 'colours_section', '#0072bc', 5);
	$ebor_options->add_setting('color', 'color-muted', 'Muted Background Colour', 'colours_section', '#f5f5f5', 20);
	$ebor_options->add_setting('color', 'color-text', 'Text Colour', 'colours_section', '#777777', 30);
	$ebor_options->add_setting('color', 'color-heading', 'Headings Colour', 'colours_section', '#333333', 35);
	
	//Styling Options
	$ebor_options->add_setting('range', 'theme_spacing', 'Standard Spacing (72 Default)', 'spacing_section', '72', 30, array('min' => '0', 'max' => '200', 'step' => '1'));
	$ebor_options->add_setting('textarea', 'custom_css', 'Custom CSS', 'custom_css_section', '', 30);
	
	//Blog Options
	$ebor_options->add_setting('image', 'blog_header_background', 'Blog Archives: Header Background', 'blog_settings', '', 10);
	$ebor_options->add_setting('input', 'blog_continue', '"Read More" Text', 'blog_text_section', 'Read More', 10);
	$ebor_options->add_setting('input', 'blog_title', 'Blog Archives: Title', 'blog_text_section', 'Our Journal', 20);
	$ebor_options->add_setting('input', 'blog_subtitle', 'Blog Archives: Subtitle', 'blog_text_section', 'News & Thoughts', 30);
	
	//Logo Options
	$ebor_options->add_setting('image', 'light_logo', 'Light Logo', 'logo_settings_section', EBOR_THEME_DIRECTORY . 'style/img/logo.png', 5);
	$ebor_options->add_setting('image', 'dark_logo', 'Dark Logo', 'logo_settings_section', EBOR_THEME_DIRECTORY . 'style/img/logo-dark.png', 10);
	
	//Header Icons
	for( $i = 1; $i < 4; $i++ ){
		$ebor_options->add_setting('select', 'header_social_icon_' . $i, 'Header Social Icon ' . $i, 'header_social_settings_section', 'none', 20 + $i + $i, $social_options);
		$ebor_options->add_setting('input', 'header_social_url_' . $i, 'Header Social URL ' . $i, 'header_social_settings_section', '', 21 + $i + $i);
	}
	
	//Footer Options
	$ebor_options->add_setting('textarea', 'subfooter_text', 'Copyright Message', 'subfooter_settings_section', $footer_default, 20);
	
	//Team Options
	$ebor_options->add_setting('select', 'team_layout', 'Team Layout', 'team_settings_section', 'team-large', 10, $team_layouts);
	$ebor_options->add_setting('input', 'team_title', 'Team Archives: Title', 'team_text_section', 'Our Team', 20);
	$ebor_options->add_setting('textarea', 'team_subtitle', 'Team Archives: Subtitle', 'team_text_section', $subtitle_default, 30);
	
	/**
	 * Instagram API Stuff
	 */
	$ebor_options->add_section('instagram_api_section', $theme_name . ': Instagram Settings', 340, false, '<code>IMPORTANT NOTE:</code> This is the Instagram block, it will grab your latest Instagram images. For this to work, the block requires you enter an access token in the correct field. Please grab your details from here: 
	<a href="https://instagram.com/oauth/authorize/?client_id=1f0ddba78ec74bfe829badaeaea02f15&redirect_uri=http://www.tommusrhodus.com&response_type=token" target="_blank">Get Access Token</a>');
	$ebor_options->add_setting('input', 'instagram_token', 'Instagram Access Token', 'instagram_api_section', '2158990778.1f0ddba.cdc1862ae5e64f828267d9ee11259e8c', 5);
}