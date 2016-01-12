<?php get_header(); ?>

<section class="error-page fullscreen-element preserve-3d">
	<div class="container vertical-align">
		<div class="row">
		
			<div class="col-sm-8">
				<h1 class="text-white"><?php _e('404','meetup'); ?><br><?php _e('Not Found','meetup'); ?></h1>
				<p class="lead text-white"><?php _e('Oh dear, this is not the way to the Meetup...','meetup'); ?></p>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-white"><?php _e('Take Me Home','meetup'); ?></a>
			</div>
			
			<div class="col-sm-4 text-right">
				<i class="icon pe-7s-way"></i>
				<i class="icon pe-7s-compass"></i>
				<i class="icon pe-7s-attention"></i>
			</div>
			
		</div>
	</div>
</section>
			
<?php get_footer();	