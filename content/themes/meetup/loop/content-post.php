<?php $sticky = ( is_sticky() ) ? __('Sticky: ','meetup') : ''; ?>

<div id="<?php the_ID(); ?>" <?php post_class('article-snippet'); ?>>
	<a href="<?php the_permalink(); ?>">
		<?php 
			the_title('<span class="uppercase">'. $sticky . get_the_time(get_option('date_format')) .'</span><h2>', '</h2>'); 
			the_post_thumbnail('large');
		?>
	</a>
	<?php the_excerpt(); ?>
	<a class="text-link" href="<?php the_permalink(); ?>"><?php echo get_option('blog_continue', 'Read More'); ?></a>
</div>