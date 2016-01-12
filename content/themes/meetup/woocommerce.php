<?php 
	get_header();
?>

	<section>
		<div class="container">
			<div class="row">
			
				<div class="col-sm-12">
					<div class="article-body">
						<?php
							woocommerce_content();
						?>
					</div><!--end of article snippet-->
				</div>
				
			</div>
		</div>
	</section>

<?php 
	get_footer();