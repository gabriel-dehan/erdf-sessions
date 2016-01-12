<section>
	<div class="container">
	
		<div class="row speakers-row">	
			<?php 
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					
					/**
					 * Get blog posts by blog layout.
					 */
					get_template_part('loop/content', 'team-row');
				
				endwhile;	
				else : 
					
					/**
					 * Display no posts message if none are found.
					 */
					get_template_part('loop/content','none');
					
				endif;
			?>
		</div><!--end of row-->
		
		<?php 
			/**
			* Post pagination, use ebor_pagination() first and fall back to default
			*/
			echo function_exists('ebor_pagination') ? ebor_pagination() : posts_nav_link();
		?>
		
	</div>
</section>