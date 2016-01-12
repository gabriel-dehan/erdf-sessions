<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title('| ', true, 'right'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php 
	get_template_part('inc/content','preloader');
	
	$light = get_option('light_logo', EBOR_THEME_DIRECTORY . 'style/img/logo.png');
	$dark = get_option('dark_logo', EBOR_THEME_DIRECTORY  . 'style/img/logo-dark.png');
	$title = get_bloginfo('title');
?>

<div class="nav-container">
				
	<nav class="overlay-nav">
	
		<div class="container">
			<div class="row">
			
				<div class="col-md-2">
					<a href="<?php echo esc_url(home_url('/')); ?>">
						<?php
							if( $light )
								echo '<img class="logo logo-light" alt="'. esc_attr($title) .'" src="'. $light .'">';
							
							if( $dark )
								echo '<img class="logo logo-dark" alt="'. esc_attr($title) .'" src="'. $dark .'">';
						?>
					</a>
				</div>
		
				<div class="col-md-10 text-right">
					<?php
						if ( has_nav_menu( 'primary' ) ){
						    wp_nav_menu( 
						    	array(
							        'theme_location'    => 'primary',
							        'depth'             => 3,
							        'container'         => false,
							        'container_class'   => false,
							        'menu_class'        => 'menu',
							        'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
							        'walker'            => new ebor_framework_medium_rare_bootstrap_navwalker()
						        )
						    );  
						} else {
							echo '<ul class="menu"><li><a href="'. admin_url('nav-menus.php') .'">Set up a navigation menu now</a></li></ul>';
						}
					?>
					<div class="sidebar-menu-toggle"><i class="icon icon_menu"></i></div>
					<div class="mobile-menu-toggle"><i class="icon icon_menu"></i></div>
				</div>
				
			</div><!--end of row-->
		</div><!--end of container-->

		<div class="bottom-border"></div>

		<?php get_sidebar('header'); ?>

	</nav>
	
</div>

<div class="main-container">
	<a href="#" id="top" class="in-page-link"></a>