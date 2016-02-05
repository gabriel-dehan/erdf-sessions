</div><!-- end main container -->

<div class="footer-container">
	<footer class="short footer">
		<div class="container">

			<?php
				if( is_active_sidebar('footer1') )
					get_template_part('inc/content','widgets');
			?>

			<div class="row">

				<div class="col-sm-3">
					<span class="text-white"><?php echo htmlspecialchars_decode(get_option('subfooter_text','Mentions légales © ERDF 2015')); ?></span>
				</div>

				<div class="col-sm-9 text-right">
					<?php
						/**
						 * Subfooter nav menu, allows top level items only
						 */
						if ( has_nav_menu( 'footer' ) ) {
						    wp_nav_menu(
							    array(
							        'theme_location'    => 'footer',
							        'depth'             => 1,
							        'container'         => false,
							        'container_class'   => false,
							        'menu_class'        => 'menu'
							    )
						    );
						}
					?>
				</div>

			</div><!--end of row-->

		</div><!--end of container-->
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
