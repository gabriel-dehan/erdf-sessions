<?php
	global $ebor_css_class;
	
	if(!( isset($ebor_css_class) ))
		$ebor_css_class = 'col-md-4 col-sm-6';
?>

<div class="<?php echo esc_attr($ebor_css_class); ?> sponsor-column">
	<div class="sponsor text-center">
		<?php 
			global $post; 
			
			$url = get_post_meta( $post->ID, '_ebor_client_url', true );
		 
			if( $url )
				echo '<a href="'. esc_url($url) .'" target="_blank">';
				
			the_post_thumbnail('full'); 
			
			if( $url )
				echo '</a>';
		?>
	</div>
</div>