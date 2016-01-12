<?php 

/**
 * The Shortcode
 */
function ebor_twitter_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' => ''
			), $atts 
		) 
	);
	
	$output = '<div class="row">
		<div class="col-md-12">
			<div class="twitter-feed">
				<i class="icon social_twitter text-white"></i>
				<div class="tweets-feed" data-widget-id="'. esc_attr($title) .'">=</div>
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			</div>
		</div>
	</div>';
	
	return $output;
}
add_shortcode( 'meetup_twitter', 'ebor_twitter_shortcode' );

/**
 * The VC Functions
 */
function ebor_twitter_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'meetup-vc-block',
			"name" => __("Twitter Feed", 'meetup'),
			"base" => "meetup_twitter",
			"category" => __('Meetup - WP Theme', 'meetup'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __("Twitter Widget ID", 'meetup'),
					"param_name" => "title",
					"value" => '',
					"description" => "Twitter Widget ID <code>e.g: 492085717044981760</code><br /><br />
					<strong>Note!</strong> You need to generate this ID from your account, do this by going to the 'Settings' page of your Twitter account and clicking 'Widgets'. Click 'Create New' and then 'Create Widget'. One done, go back to the 'Widgets' page and click 'Edit' on your newly created widget. From here you need to copy the widget id out of the url bar. The widget id is the long numerical string after /widgets/ and before /edit."
				),
				array(
					"type" => "textarea_html",
					"heading" => __("Content Under Feed", 'meetup'),
					"param_name" => "content",
					"value" => '',
					"description" => '',
					'holder' => 'div'
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'ebor_twitter_shortcode_vc' );