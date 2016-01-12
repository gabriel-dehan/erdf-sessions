<?php 
	$light = get_option('light_logo', EBOR_THEME_DIRECTORY . 'style/img/logo.png'); 
	$title = get_bloginfo('title');
?>

<div class="sidebar-menu">

	<?php
		if( $light )
			echo '<img class="logo logo-light" alt="'. esc_attr($title) .'" src="'. $light .'">';
	?>
	<div class="bottom-border"></div>
	
	<div class="sidebar-content">
	
		<div class="widget ebor-sidebar-menu">
			<?php
				if ( has_nav_menu( 'sidebar' ) ){
				    wp_nav_menu( 
				    	array(
					        'theme_location'    => 'sidebar',
					        'depth'             => 1,
					        'container'         => false,
					        'container_class'   => false,
					        'menu_class'        => 'menu'
				        )
				    );
					    
				}
			?>
		</div>
		
		<?php dynamic_sidebar('header'); ?>

		<div class="copy-text">
			<span><?php echo htmlspecialchars_decode(get_option('subfooter_text','Copyright 2015 TommusRhodus')); ?></span>
		</div>
		
	</div><!--end of sidebar content-->
	
</div><!--end of sidebar-->