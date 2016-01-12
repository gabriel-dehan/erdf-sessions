<?php 
	/**
	 * This page template is not directly accessible
	 * from wp-admin, there's a function in vc_init.php which will
	 * select this page template depending on the content of the $post.
	 * It's automatically used so that the page template selection step is not
	 * required by theme users.
	 */
	get_header();
	the_post();
?>

	<div class="ebor-page-wrapper">
		<?php the_content(); ?>
	</div>
	
<?php
	get_footer();