<?php 
	get_header();
	the_post();
	
	$class = ( is_active_sidebar('primary') ) ? 'col-md-8 col-sm-12' : 'col-md-8 col-md-offset-2';
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
					<?php the_title('<h1 class="text-white">', '</h1><p class="text-white">'. get_the_time(get_option('date_format')) .'</p>'); ?>
				</div>
			</div><!--end of row-->
		</div><!--end of container-->
		
	</section>
	
<?php endif; ?>

<section <?php post_class(); ?>>
	<div class="container">
		<div class="row">
		
			<div class="<?php echo esc_attr($class); ?>">
				<div class="article-body">
					<?php
						if(!( $thumbnail ))
							the_title('<p>'. get_the_time(get_option('date_format')) .'</p><h1>','</h1>');
							
						the_content();
						wp_link_pages();
						the_tags('<div class="meta">' . __('Tags: ','meetup'),', ','</div>');
					?>
				</div><!--end of article snippet-->
			</div>
			
			<?php get_sidebar(); ?>
			
		</div>
	</div>
</section>

<?php 
	if( comments_open() )
		comments_template();
		
	get_footer();