<?php 

/**
 * Build theme metaboxes
 * Uses the cmb metaboxes class found in the ebor framework plugin
 * More details here: https://github.com/WebDevStudios/Custom-Metaboxes-and-Fields-for-WordPress
 * 
 * @since 1.0.0
 * @author tommusrhodus
 */
if(!( function_exists('ebor_custom_metaboxes') )){
	function ebor_custom_metaboxes( $meta_boxes ) {
		$prefix = '_ebor_';
		$social_options = ebor_get_social_icons();

		/**
		 * Social Icons for Team Members
		 */
		$meta_boxes[] = array(
			'id' => 'team_social_metabox',
			'title' => __('Social Icons: Click To Add More', 'meetup'),
			'object_types' => array('team'), // post type
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			'fields' => array(
				array(
					'name' => __('Job Title', 'meetup'),
					'desc' => '(Optional) Enter a Job Title for this Team Member',
					'id'   => $prefix . 'the_job_title',
					'type' => 'text',
				),
				array(
				    'id'          => $prefix . 'team_social_icons',
				    'type'        => 'group',
				    'options'     => array(
				        'add_button'    => __( 'Add Another Icon', 'meetup' ),
				        'remove_button' => __( 'Remove Icon', 'meetup' ),
				        'sortable'      => true
				    ),
				    'fields' => array(
						array(
							'name' => 'Social Icon',
							'desc' => 'What icon would you like for this team members first social profile?',
							'id' => $prefix . 'social_icon',
							'type' => 'select',
							'options' => $social_options
						),
						array(
							'name' => __('URL for Social Icon', 'meetup'),
							'desc' => __("Enter the URL for Social Icon 1 e.g www.google.com", 'meetup'),
							'id'   => $prefix . 'social_icon_url',
							'type' => 'text_url',
						),
				    ),
				),
			)
		);
		
		/**
		 * Social Icons for Users
		 */
		$meta_boxes[] = array(
			'id' => 'social_metabox',
			'title' => __('Social Icons: Click To Add More', 'meetup'),
			'object_types' => array('user'), // post type
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			'fields' => array(
				array(
				    'id'          => $prefix . 'user_social_icons',
				    'type'        => 'group',
				    'options'     => array(
				        'add_button'    => __( 'Add Another Icon', 'meetup' ),
				        'remove_button' => __( 'Remove Icon', 'meetup' ),
				        'sortable'      => true
				    ),
				    'fields' => array(
						array(
							'name' => 'Social Icon',
							'desc' => 'What icon would you like for this team members first social profile?',
							'id' => $prefix . 'social_icon',
							'type' => 'select',
							'options' => $social_options
						),
						array(
							'name' => __('URL for Social Icon', 'meetup'),
							'desc' => __("Enter the URL for Social Icon 1 e.g www.google.com", 'meetup'),
							'id'   => $prefix . 'social_icon_url',
							'type' => 'text',
						),
				    ),
				),
			)
		);
		
		/**
		 * Quote Format Metaboxes
		 */
		$meta_boxes[] = array(
			'id' => 'post_format_metabox_quote',
			'title' => __('Quote Details', 'meetup'),
			'object_types' => array('post'), // post type
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			'fields' => array(
				array(
					'name' => __('Quote Author', 'meetup'),
					'desc' => __("Enter an author for the quote.", 'meetup'),
					'id'   => $prefix . 'quote_author',
					'type' => 'text',
				),
				array(
					'name' => __('Quote Date', 'meetup'),
					'desc' => __("Enter a date for the quote.", 'meetup'),
					'id'   => $prefix . 'quote_date',
					'type' => 'text',
				),
			)
		);
		
		/**
		 * Video Format Metaboxes
		 */
		$meta_boxes[] = array(
			'id' => 'post_format_metabox_video',
			'title' => __('Videos & oEmbeds', 'meetup'),
			'object_types' => array('post'), // post type
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			'fields' => array(
				array(
				    'id'          => $prefix . 'videos',
				    'type'        => 'group',
				    'options'     => array(
				        'add_button'    => __( 'Add Another oEmbed', 'meetup' ),
				        'remove_button' => __( 'Remove oEmbed', 'meetup' ),
				        'sortable'      => true
				    ),
				    'fields' => array(
						array(
							'name' => 'oEmbed',
							'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
							'id'   => $prefix . 'the_oembed',
							'type' => 'oembed',
						),
				    ),
				),
			)
		);
		
		$meta_boxes[] = array(
			'id' => 'clients_metabox',
			'title' => __('Client URL', 'meetup'),
			'object_types' => array('client'), // post type
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			'fields' => array(
				array(
					'name' => __('URL for this client (optional)', 'meetup'),
					'desc' => __("Enter a URL for this client, if left blank, client logo will open into a lightbox.", 'meetup'),
					'id'   => $prefix . 'client_url',
					'type' => 'text',
				),
			),
		);
		
		return $meta_boxes;
	}
	add_filter( 'cmb2_meta_boxes', 'ebor_custom_metaboxes' );
}