<?php 
	get_header();
	the_post();
	
	$thumbnail = has_post_thumbnail();
	
	if( $thumbnail ) :
?>

	<section class="section-header overlay preserve3d">
		
		<div class="background-image-holder parallax-background">
			<?php the_post_thumbnail('full', array('class' => 'background-image')); ?>
		</div>
		
		<div class="container vertical-align">
			<div class="row">
				<div class="col-sm-7 col-sm-offset-">
					<?php the_title('<h1 class="text-white">', '</h1>'); ?>
				</div>
			</div><!--end of row-->
		</div><!--end of container-->
		
	</section>

<?php endif; ?>

	<section>
		<div class="container">
			<div class="article-body">
				<?php
					if(!( $thumbnail ))
						the_title('<h1>','</h1>');
						
					the_content();
					wp_link_pages();
				?>
			</div><!--end of article snippet-->
		</div>
	</section>

<?php 
	get_footer();