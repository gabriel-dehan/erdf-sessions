<?php
	get_header();
	the_post();

	$job = get_post_meta( $post->ID, '_ebor_the_job_title', true );
	$icons = get_post_meta( $post->ID, '_ebor_team_social_icons', true );
?>

<section <?php post_class(); ?>>
	<div class="container">
		<div class="row">

			<div class="col-sm-4">
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
				</div>
			</div>

			<div class="col-sm-8">
				<div class="article-body">
					<?php
						the_title('<h1>','</h1><p><strong>'. $job .'</strong></p>');
						the_content();
						wp_link_pages();
					?>
          <a class='text-link' href="<?php echo home_url(); ?>">Retour à l'accueil</a>
				</div><!--end of article snippet-->
			</div>

		</div>
	</div>
</section>

<?php
	get_footer();
