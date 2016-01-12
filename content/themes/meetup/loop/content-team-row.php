<?php
	global $post;
	$job = get_post_meta( $post->ID, '_ebor_the_job_title', true );
	$icons = get_post_meta( $post->ID, '_ebor_team_social_icons', true );
?>

<div class="col-md-3 col-sm-6 speaker-column">
	<div class="speaker">
	
		<div class="image-holder">

			<?php the_post_thumbnail('full', array('class' => 'background-image')); ?>
			
			<div class="hover-state text-center preserve3d">
				<div class="social-links vertical-align">
					<?php 
						foreach( $icons as $key => $icon ){
							if(!( isset( $icon['_ebor_social_icon_url'] ) ))
								continue;
								
							echo '<a href="'. esc_url($icon['_ebor_social_icon_url']) .'" target="_blank"><i class="icon '. esc_attr($icon['_ebor_social_icon']) .'"></i></a>';
						}
					?>
				</div>
			</div>
			
		</div>

		<?php the_title('<span class="speaker-name">', '</span><span>'. $job .'</span>'); ?>

	</div>
</div><!--end of individual speaker with bio-->