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

<!--[if lt IE 9]>
    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Votre navigateur n'est pas compatible !</h4>
                </div>
                <div class="modal-body">
                    <p class="chromeframe">Votre navigateur n'est pas <strong>à jour</strong>.</p>
                    <p>
                        Veuillez <a href="http://browsehappy.com/">le mettre à jour</a> ou en <a href="http://browsehappy.com/">télécharger un nouveau</a>.
                    </p>
                    <p>
                        Vous pouvez aussi utiliser <a href="http://www.google.com/chromeframe/?redirect=true">Google Chrome Frame</a> afin d'améliorer votre expérience.
                    </p>
                    <p><br></p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<![endif]-->


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
