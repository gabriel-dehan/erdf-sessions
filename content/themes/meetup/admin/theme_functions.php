<?php 

/**
 * Add back to top button to footer menu
 */
if(!( function_exists('ebor_btt_button') )){
	function ebor_btt_button($items, $args) {
		if( 'footer' == $args->theme_location ){	   
			$items .= '<li><a class="inner-link back-to-top" href="#top">'. __('Back To Top','meetup') .'&nbsp;<i class="icon pe-7s-angle-up-circle"></i></a></li>';
		}
		return $items;
	}
	add_filter( 'wp_nav_menu_items', 'ebor_btt_button', 20,2 );
}

if(!( function_exists('ebor_nav_social') )){
	function ebor_nav_social($items, $args) {
		if( 'primary' == $args->theme_location ){
			$protocols = array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet', 'skype'); 	  
			for( $i = 1; $i < 4; $i++ ){
				if( get_option("header_social_url_$i") ) {
					$items .= '<li class="social-link">
						      <a href="' . esc_url(get_option("header_social_url_$i"), $protocols) . '" target="_blank">
							      <i class="icon ' . get_option("header_social_icon_$i") . '"></i>
						      </a>
						  </li>';
				}
			}  
		}
		return $items;
	}
	add_filter( 'wp_nav_menu_items', 'ebor_nav_social', 20,2 );
}

if(!( function_exists('ebor_get_team_layouts') )){
	function ebor_get_team_layouts(){
		return array(
			'grid' => 'Grid',
			'row' => 'Row'	
		);	
	}
}

if(!( function_exists('ebor_page_header') )){
	function ebor_page_header($title = false, $subtitle = false, $background = false){
	?>
		<section class="section-header overlay preserve3d">
			
			<?php if( $background ) : ?>
				<div class="background-image-holder parallax-background">
					<img class="background-image" alt="Background Image" src="<?php echo $background; ?>">
				</div>
			<?php endif; ?>
			
			<div class="container vertical-align">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-">
						<?php
							if( $title )
								echo '<h1 class="text-white">'. $title .'</h1>';
								
							if( $subtitle )
								echo '<p class="text-white">'. $subtitle .'</p>';
						?>
					</div>
				</div><!--end of row-->
			</div><!--end of container-->
			
		</section>
	<?php
	}
}

/**
 * Init theme options
 * Certain theme options need to be written to the database as soon as the theme is installed.
 * This is either for the enqueues in ebor-framework, or to override the default image sizes in WooCommerce.
 * Either way this function is only called when the theme is first activated, de-activating and re-activating the theme will result in these options returning to defaults.
 * 
 * @since 1.0.0
 * @author tommusrhodus
 */
if(!( function_exists('ebor_init_theme_options') )){
	/**
	 * Hook in on activation
	 */
	global $pagenow;
	
	/**
	 * Define image sizes
	 */
	function ebor_init_theme_options() {
	  	$catalog = array(
			'width' 	=> '440',	// px
			'height'	=> '295',	// px
			'crop'		=> 1 		// true
		);
	
		$single = array(
			'width' 	=> '600',	// px
			'height'	=> '600',	// px
			'crop'		=> 1 		// true
		);
	
		$thumbnail = array(
			'width' 	=> '113',	// px
			'height'	=> '113',	// px
			'crop'		=> 1 		// false
		);
	
		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
		
		//Ebor Framework
		$framework_args = array(
			'pivot_shortcodes'      => '1',
			'meetup_widgets'         => '1',
			'portfolio_post_type'   => '0',
			'team_post_type'        => '1',
			'client_post_type'      => '1',
			'testimonial_post_type' => '1',
			'faq_post_type'         => '1',
			'mega_menu'             => '0',
			'aq_resizer'            => '0',
			'page_builder'          => '0',
			'likes'                 => '0',
			'options'               => '1',
			'metaboxes'             => '1'
		);
		update_option('ebor_framework_options', $framework_args);
	}
	
	/**
	 * Only call this action when we first activate the theme.
	 */
	if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ){
		add_action( 'init', 'ebor_init_theme_options', 1 );
	}
}

/**
 * Register Menu Locations For The Theme
 * 
 * @since 1.0.0
 * @author tommusrhodus
 */
if(!( function_exists('ebor_register_nav_menus') )){
	function ebor_register_nav_menus() {
		register_nav_menus( 
			array(
				'primary' => __( 'Standard Navigation', 'meetup' ),
				'sidebar' => __( 'Sidebar Navigation', 'meetup' ),
				'footer' => __( 'Footer Navigation', 'meetup' )
			) 
		);
	}
	add_action( 'init', 'ebor_register_nav_menus' );
}

//REGISTER SIDEBARS
function ebor_register_sidebars() {

	register_sidebar( 
		array(
			'id' => 'primary',
			'name' => __( 'Blog Sidebar', 'meetup' ),
			'description' => __( 'Widgets to be displayed in the blog sidebar.', 'meetup' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		) 
	);
	
	register_sidebar( 
		array(
			'id' => 'header',
			'name' => __( 'Header Sidebar', 'meetup' ),
			'description' => __( 'Widgets to be displayed in the blog sidebar.', 'meetup' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		) 
	);
	
	register_sidebar( 
		array(
			'id' => 'page',
			'name' => __( 'Page Sidebar', 'meetup' ),
			'description' => __( 'Widgets to be displayed in the page sidebar.', 'meetup' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		) 
	);
	
	register_sidebar(
		array(
			'id' => 'footer1',
			'name' => __( 'Footer Column 1', 'meetup' ),
			'description' => __( 'If this is set, your footer will be 1 column', 'meetup' ),
			'before_widget' => '<div id="%1$s" class="sidebox widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title section-title">',
			'after_title' => '</h3>'
		)
	);
	
	register_sidebar(
		array(
			'id' => 'footer2',
			'name' => __( 'Footer Column 2', 'meetup' ),
			'description' => __( 'If this & column 1 are set, your footer will be 2 columns.', 'meetup' ),
			'before_widget' => '<div id="%1$s" class="sidebox widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title section-title">',
			'after_title' => '</h3>'
		)
	);
	
	
	register_sidebar(
		array(
			'id' => 'footer3',
			'name' => __( 'Footer Column 3', 'meetup' ),
			'description' => __( 'If this & column 1 & column 2 are set, your footer will be 3 columns.', 'meetup' ),
			'before_widget' => '<div id="%1$s" class="sidebox widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title section-title">',
			'after_title' => '</h3>'
		)
	);
	
	register_sidebar(
		array(
			'id' => 'footer4',
			'name' => __( 'Footer Column 4', 'meetup' ),
			'description' => __( 'If this & column 1 & column 2 & column 3 are set, your footer will be 4 columns.', 'meetup' ),
			'before_widget' => '<div id="%1$s" class="sidebox widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title section-title">',
			'after_title' => '</h3>'
		)
	);
	
}
add_action( 'widgets_init', 'ebor_register_sidebars' );
 
/**
 * Ebor Load Scripts
 * Properly Enqueues Scripts & Styles for the theme
 * @since version 1.0
 * @author TommusRhodus
 */ 
function ebor_load_scripts() {
	$protocol = is_ssl() ? 'https' : 'http';
	$heading_font = get_option('heading_font_url', $protocol . '://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700');
	$body_font = get_option('body_font_url', $protocol . '://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700');

	//Enqueue Fonts
	if( $body_font )
		wp_enqueue_style( 'ebor-body-font', $body_font );
		
	if( $heading_font )
		wp_enqueue_style( 'ebor-heading-font', $heading_font );

	//Enqueue Styles
	wp_enqueue_style( 'ebor-bootstrap', EBOR_THEME_DIRECTORY . 'style/css/bootstrap.min.css' );
	wp_enqueue_style( 'ebor-plugins', EBOR_THEME_DIRECTORY . 'style/css/plugins.css' );
	wp_enqueue_style( 'ebor-fonts', EBOR_THEME_DIRECTORY . 'style/css/fonts.css' );
	wp_enqueue_style( 'ebor-theme-styles', EBOR_THEME_DIRECTORY . 'style/css/theme.less' );
	wp_enqueue_style( 'ebor-style', get_stylesheet_uri() );

	//Enqueue Scripts
	wp_enqueue_script( 'ebor-bootstrap', EBOR_THEME_DIRECTORY . 'style/js/bootstrap.min.js', array('jquery'), false, true  );
	wp_enqueue_script( 'ebor-plugins', EBOR_THEME_DIRECTORY . 'style/js/plugins.js', array('jquery'), false, true  );
	wp_enqueue_script( 'ebor-scripts', EBOR_THEME_DIRECTORY . 'style/js/scripts.js', array('jquery'), false, true  );
	
	//Enqueue Comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	//Add custom CSS ability
	wp_add_inline_style( 'ebor-style', get_option('custom_css') );
	
	/**
	 * localize script
	 */
	$script_data = array( 
		'access_token' => get_option('instagram_token','2158990778.1f0ddba.cdc1862ae5e64f828267d9ee11259e8c')
	);
	wp_localize_script( 'ebor-scripts', 'wp_data', $script_data );
}
add_action('wp_enqueue_scripts', 'ebor_load_scripts', 200);

/**
 * Ebor Load Admin Scripts
 * Properly Enqueues Scripts & Styles for the theme
 * 
 * @since version 1.0
 * @author TommusRhodus
 */
function ebor_admin_load_scripts(){
	wp_enqueue_style( 'ebor-theme-admin-css', EBOR_THEME_DIRECTORY . 'admin/ebor-theme-admin.css' );
	wp_enqueue_style( 'ebor-theme-fonts', EBOR_THEME_DIRECTORY . 'style/css/fonts.css' );
	wp_enqueue_script( 'ebor-theme-admin-js', EBOR_THEME_DIRECTORY . 'admin/ebor-theme-admin.js', array('jquery'), false, true  );
}
add_action('admin_enqueue_scripts', 'ebor_admin_load_scripts', 200);

if(!( function_exists('ebor_meetup_load_conditional_scripts') )){
	function ebor_meetup_load_conditional_scripts(){
		echo '<!--[if gte IE 9]><link rel="stylesheet" type="text/css" href="'. EBOR_THEME_DIRECTORY .'style/css/ie9.css" /><![endif]-->';
	}
	add_action('wp_head','ebor_meetup_load_conditional_scripts',9999);	
}

/**
 * Register the required plugins for this theme.
 * 
 * @since 1.0.0
 * @author tommusrhodus
 */
if(!( function_exists('ebor_register_required_plugins') )){
	function ebor_register_required_plugins() {
		$plugins = array(
			array(
			    'name'      => 'Contact Form 7',
			    'slug'      => 'contact-form-7',
			    'required'  => false,
			    'version' 	=> '3.7.2'
			),
			array(
			    'name'      => 'Tickera WordPress Event Ticketing',
			    'slug'      => 'tickera-event-ticketing-system',
			    'required'  => false,
			    'version' 	=> '3.1.9.8'
			),
			array(
				'name'     				=> 'Ebor Framework',
				'slug'     				=> 'Ebor-Framework-master',
				'source'   				=> 'https://github.com/tommusrhodus/Ebor-Framework/archive/master.zip',
				'required' 				=> true,
				'external_url' 			=> 'https://github.com/tommusrhodus/Ebor-Framework/archive/master.zip',
				'version'               => '1.0.0'
			),
			array(
				'name'     				=> 'Visual Composer',
				'slug'     				=> 'js_composer',
				'source'   				=> 'http://www.madeinebor.com/plugin-downloads/js_composer.zip',
				'required' 				=> false,
				'external_url' 			=> 'http://www.madeinebor.com/plugin-downloads/js_composer.zip',
				'version'               => '4.7.4'
			)
		);
		$config = array(
			'is_automatic' => true,
		);
		tgmpa( $plugins, $config );
	}
	add_action( 'tgmpa_register', 'ebor_register_required_plugins' );
}

/**
 * Custom Comment Markup for meetup
 * 
 * @since 1.0.0
 * @author tommusrhodus
 */
if(!( function_exists('ebor_custom_comment') )){
	function ebor_custom_comment($comment, $args, $depth) { 
		$GLOBALS['comment'] = $comment; 
	?>
		
		<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<div class="blog-comment">
				
				<div class="user"><?php echo get_avatar( $comment->comment_author_email, 100 ); ?></div>

				<div class="info">
					<?php 
						printf('<span class="title">%s</span>', get_comment_author());
						echo '<span class="date">'. get_comment_date() .'</span>';
						comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); 
						echo wpautop( htmlspecialchars_decode( get_comment_text() ) );
						if ($comment->comment_approved == '0')
							echo '<p><em>'. __('Your comment is awaiting moderation.', 'meetup') .'</em></p>';
					?>
				</div>
			</div>
	
	<?php }
}

if(!( function_exists('ebor_pagination') )){
	function ebor_pagination($pages = '', $range = 2){
		$showitems = ($range * 2)+1;
		
		// Fix for pagination
		if( is_front_page() ) { 
			$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; 
		} else { 
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; 
		}
		
		if($pages == ''){
			global $wp_query;
			$pages = $wp_query->max_num_pages;
				if(!$pages) {
					$pages = 1;
				}
		}
		
		$output = '';
		
		if(1 != $pages){
			$output .= "<div class='text-center'><ul class='pagination ". get_option('pagination_size', 'pagination-sm') ."'>";
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) $output .= "<li><a href='".get_pagenum_link(1)."'><span aria-hidden='true'>&laquo;</span></a></li> ";
			
			for ($i=1; $i <= $pages; $i++){
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
					$output .= ($paged == $i)? "<li class='active'><a href='".get_pagenum_link($i)."'>".$i."</a></li> ":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li> ";
				}
			}
		
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) $output .= "<li><a href='".get_pagenum_link($pages)."'><span aria-hidden='true'>&raquo;</span></a></li> ";
			$output.= "</ul></div>";
		}
		
		return $output;
	}
}

/**
 * Add additional styling options to TinyMCE
 * 
 * @since 1.0.0
 * @author tommusrhodus
 */
if(!( function_exists('ebor_mce_buttons_2') )){
	function ebor_mce_buttons_2( $buttons ) {
	    array_unshift( $buttons, 'styleselect' );
	    return $buttons;
	}
	add_filter( 'mce_buttons_2', 'ebor_mce_buttons_2' );
}

/**
 * Add additional styling options to TinyMCE
 * 
 * @since 1.0.0
 * @author tommusrhodus
 */
if(!( function_exists('ebor_mce_before_init') )){
	function ebor_mce_before_init( $settings ) {
	    $style_formats = array(
	    	array(
	    		'title' => 'Uppercase',
	    		'selector' => 'p',
	    		'classes' => 'uppercase',
	    	),
	    	array(
	    		'title' => 'Subheading Paragraph',
	    		'selector' => 'p',
	    		'classes' => 'lead',
	    	),
	    	array(
	    		'title' => 'Ruled List',
	    		'selector' => 'ul',
	    		'classes' => 'ruled-list',
	    	),
	    );
	    $settings['style_formats'] = json_encode( $style_formats );
	    return $settings;
	}
	add_filter( 'tiny_mce_before_init', 'ebor_mce_before_init' );
}


/**
 * Medium rare nav walker.
 * 
 * This nav walker is for themes by tommusrhodus and medium rare.
 * 
 * @since 1.0.0
 * @author tommusrhodus
 */
if(!( class_exists('ebor_framework_medium_rare_bootstrap_navwalker') )){
	class ebor_framework_medium_rare_bootstrap_navwalker extends Walker_Nav_Menu {
	
		/**
		 * @see Walker::start_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int $depth Depth of page. Used for padding.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul role=\"menu\" class=\" nav-dropdown\">\n";
		}
	
		/**
		 * @see Walker::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param int $current_page Menu item ID.
		 * @param object $args
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
			/**
			 * Dividers, Headers or Disabled
			 * =============================
			 * Determine whether the item is a Divider, Header, Disabled or regular
			 * menu item. To prevent errors we use the strcasecmp() function to so a
			 * comparison that is not case sensitive. The strcasecmp() function returns
			 * a 0 if the strings are equal.
			 */
			if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
				$output .= $indent . '<li role="presentation" class="divider">';
			} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
				$output .= $indent . '<li role="presentation" class="divider">';
			} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
				$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
			} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
				$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
			} else {
	
				$class_names = $value = '';
	
				$classes = empty( $item->classes ) ? array() : (array) $item->classes;
				$classes[] = 'menu-item-' . $item->ID;
	
				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
	
				if ( $args->has_children && $depth == 0 ){
					$class_names .= ' has-dropdown';
				} elseif ( $args->has_children ){
					$class_names .= ' dropdown-submenu';
				}
	
				if ( in_array( 'current-menu-item', $classes ) )
					$class_names .= ' active';
	
				$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
	
				$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
	
				$output .= $indent . '<li' . $id . $value . $class_names .'>';
	
				$atts = array();
				$atts['target'] = ! empty( $item->target )	? $item->target	: '';
				$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
	
				// If item has_children add atts to a.
				if ( $args->has_children && $depth === 0 ) {
					$atts['href'] = ! empty( $item->url ) ? $item->url : '';
					$atts['data-toggle']	= 'dropdown';
					$atts['class']			= 'dropdown-toggle js-activated';
				} else {
					$atts['href'] = ! empty( $item->url ) ? $item->url : '';
				}
	
				$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
	
				$attributes = '';
				foreach ( $atts as $attr => $value ) {
					if ( ! empty( $value ) ) {
						$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}
	
				$item_output = $args->before;
	
				/*
				 * Glyphicons
				 * ===========
				 * Since the the menu item is NOT a Divider or Header we check the see
				 * if there is a value in the attr_title property. If the attr_title
				 * property is NOT null we apply it as the class name for the glyphicon.
				 */
				if ( ! empty( $item->attr_title ) )
					$item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
				else
					$item_output .= '<a'. $attributes .'>';
	
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				$item_output .= ( $args->has_children && 0 === $depth ) ? '</a>' : '</a>';
				$item_output .= $args->after;
				
				/**
				 * Check if menu item object is a mega menu object.
				 * If it is, display the mega menu content.
				 * Otherwise render elements as normal
				 */
				if( $item->object == 'mega_menu' ) {
					$output .= '<div class="subnav subnav-fullwidth">' . do_shortcode(get_post_field('post_content', $item->object_id)) . '</div>';
				} else {
					$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
				}
	
			}
		}
	
		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth.
		 *
		 * This method shouldn't be called directly, use the walk() method instead.
		 *
		 * @see Walker::start_el()
		 * @since 2.5.0
		 *
		 * @param object $element Data object
		 * @param array $children_elements List of elements to continue traversing.
		 * @param int $max_depth Max depth to traverse.
		 * @param int $depth Depth of current element.
		 * @param array $args
		 * @param string $output Passed by reference. Used to append additional content.
		 * @return null Null on failure with no changes to parameters.
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
	        if ( ! $element )
	            return;
	
	        $id_field = $this->db_fields['id'];
	
	        // Display this element.
	        if ( is_object( $args[0] ) )
	           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
	
	        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	    }
	
		/**
		 * Menu Fallback
		 * =============
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a manu has not been assigned to the theme location in the WordPress
		 * menu manager the function with display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 *
		 * @param array $args passed from the wp_nav_menu function.
		 *
		 */
		public static function fallback( $args ) {
			if ( current_user_can( 'manage_options' ) ) {
	
				extract( $args );
	
				$fb_output = null;
	
				if ( $container ) {
					$fb_output = '<' . $container;
	
					if ( $container_id )
						$fb_output .= ' id="' . $container_id . '"';
	
					if ( $container_class )
						$fb_output .= ' class="' . $container_class . '"';
	
					$fb_output .= '>';
				}
	
				$fb_output .= '<ul';
	
				if ( $menu_id )
					$fb_output .= ' id="' . $menu_id . '"';
	
				if ( $menu_class )
					$fb_output .= ' class="' . $menu_class . '"';
	
				$fb_output .= '>';
				$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
				$fb_output .= '</ul>';
	
				if ( $container )
					$fb_output .= '</' . $container . '>';
	
				echo $fb_output;
			}
		}
	}
}

if(!( function_exists('ebor_get_social_icons') )){
	function ebor_get_social_icons(){
		$icons = array(
			"none" => "None",
			"social_facebook" => "facebook",
			"social_twitter" => "twitter",
			"social_pinterest" => "pinterest",
			"social_googleplus" => "googleplus",
			"social_tumblr" => "tumblr",
			"social_tumbleupon" => "tumbleupon",
			"social_wordpress" => "wordpress",
			"social_instagram" => "instagram",
			"social_dribbble" => "dribbble",
			"social_vimeo" => "vimeo",
			"social_linkedin" => "linkedin",
			"social_rss" => "rss",
			"social_deviantart" => "deviantart",
			"social_share" => "share",
			"social_myspace" => "myspace",
			"social_skype" => "skype",
			"social_youtube" => "youtube",
			"social_picassa" => "picassa",
			"social_googledrive" => "googledrive",
			"social_flickr" => "flickr",
			"social_blogger" => "blogger",
			"social_spotify" => "spotify",
			"social_delicious" => "delicious",
			"social_facebook_circle" => "facebook_circle",
			"social_twitter_circle" => "twitter_circle",
			"social_pinterest_circle" => "pinterest_circle",
			"social_googleplus_circle" => "googleplus_circle",
			"social_tumblr_circle" => "tumblr_circle",
			"social_stumbleupon_circle" => "stumbleupon_circle",
			"social_wordpress_circle" => "wordpress_circle",
			"social_instagram_circle" => "instagram_circle",
			"social_dribbble_circle" => "dribbble_circle",
			"social_vimeo_circle" => "vimeo_circle",
			"social_linkedin_circle" => "linkedin_circle",
			"social_rss_circle" => "rss_circle",
			"social_deviantart_circle" => "deviantart_circle",
			"social_share_circle" => "share_circle",
			"social_myspace_circle" => "myspace_circle",
			"social_skype_circle" => "skype_circle",
			"social_youtube_circle" => "youtube_circle",
			"social_picassa_circle" => "picassa_circle",
			"social_googledrive_alt2" => "googledrive_alt2",
			"social_flickr_circle" => "flickr_circle",
			"social_blogger_circle" => "blogger_circle",
			"social_spotify_circle" => "spotify_circle",
			"social_delicious_circle" => "delicious_circle",
			"social_facebook_square" => "facebook_square",
			"social_twitter_square" => "twitter_square",
			"social_pinterest_square" => "pinterest_square",
			"social_googleplus_square" => "googleplus_square",
			"social_tumblr_square" => "tumblr_square",
			"social_stumbleupon_square" => "stumbleupon_square",
			"social_wordpress_square" => "wordpress_square",
			"social_instagram_square" => "instagram_square",
			"social_dribbble_square" => "dribbble_square",
			"social_vimeo_square" => "vimeo_square",
			"social_linkedin_square" => "linkedin_square",
			"social_rss_square" => "rss_square",
			"social_deviantart_square" => "deviantart_square",
			"social_share_square" => "share_square",
			"social_myspace_square" => "myspace_square",
			"social_skype_square" => "skype_square",
			"social_youtube_square" => "youtube_square",
			"social_picassa_square" => "picassa_square",
			"social_googledrive_square" => "googledrive_square",
			"social_flickr_square" => "flickr_square",
			"social_blogger_square" => "blogger_square",
			"social_spotify_square" => "spotify_square",
			"social_delicious_square" => "delicious_square",
		);
		return $icons;
	}	
}

if(!( function_exists('ebor_get_icons') )){
	function ebor_get_icons(){
		$icons = array(
			'none',
			'arrow_back', 
			'arrow_carrot_up_alt', 
			'arrow_carrot-2down_alt2', 
			'arrow_carrot-2down', 
			'arrow_carrot-2dwnn_alt', 
			'arrow_carrot-2left_alt', 
			'arrow_carrot-2left_alt2', 
			'arrow_carrot-2left', 
			'arrow_carrot-2right_alt', 
			'arrow_carrot-2right_alt2', 
			'arrow_carrot-2right', 
			'arrow_carrot-2up_alt', 
			'arrow_carrot-2up_alt2', 
			'arrow_carrot-2up', 
			'arrow_carrot-down_alt', 
			'arrow_carrot-down_alt2', 
			'arrow_carrot-down', 
			'arrow_carrot-left_alt', 
			'arrow_carrot-left_alt2', 
			'arrow_carrot-left', 
			'arrow_carrot-right_alt', 
			'arrow_carrot-right_alt2', 
			'arrow_carrot-right', 
			'arrow_carrot-up_alt2', 
			'arrow_carrot-up', 
			'arrow_condense_alt', 
			'arrow_condense', 
			'arrow_down_alt', 
			'arrow_down', 
			'arrow_expand_alt', 
			'arrow_expand_alt2', 
			'arrow_expand_alt3', 
			'arrow_expand', 
			'arrow_left_alt', 
			'arrow_left-down_alt', 
			'arrow_left-down', 
			'arrow_left-right_alt', 
			'arrow_left-right', 
			'arrow_left-up_alt', 
			'arrow_left-up', 
			'arrow_left', 
			'arrow_move', 
			'arrow_right_alt', 
			'arrow_right-down_alt', 
			'arrow_right-down', 
			'arrow_right-up_alt', 
			'arrow_right-up', 
			'arrow_right', 
			'arrow_triangle-down_alt', 
			'arrow_triangle-down_alt2', 
			'arrow_triangle-down', 
			'arrow_triangle-left_alt', 
			'arrow_triangle-left_alt2', 
			'arrow_triangle-left', 
			'arrow_triangle-right_alt', 
			'arrow_triangle-right_alt2', 
			'arrow_triangle-right', 
			'arrow_triangle-up_alt', 
			'arrow_triangle-up_alt2', 
			'arrow_triangle-up', 
			'arrow_up_alt', 
			'arrow_up-down_alt', 
			'arrow_up', 
			'arrow-up-down', 
			'icon_adjust-horiz', 
			'icon_adjust-vert', 
			'icon_archive_alt', 
			'icon_archive', 
			'icon_bag_alt', 
			'icon_bag', 
			'icon_balance', 
			'icon_blocked', 
			'icon_book_alt', 
			'icon_book', 
			'icon_box-checked', 
			'icon_box-empty', 
			'icon_box-selected', 
			'icon_briefcase_alt', 
			'icon_briefcase', 
			'icon_building_alt', 
			'icon_building', 
			'icon_calculator_alt', 
			'icon_calendar', 
			'icon_calulator', 
			'icon_camera_alt', 
			'icon_camera', 
			'icon_cart_alt', 
			'icon_cart', 
			'icon_chat_alt', 
			'icon_chat', 
			'icon_check_alt', 
			'icon_check_alt2', 
			'icon_check', 
			'icon_circle-empty', 
			'icon_circle-slelected', 
			'icon_clipboard', 
			'icon_clock_alt', 
			'icon_clock', 
			'icon_close_alt', 
			'icon_close_alt2', 
			'icon_close', 
			'icon_cloud_alt', 
			'icon_cloud-download_alt', 
			'icon_cloud-download', 
			'icon_cloud-upload_alt', 
			'icon_cloud-upload', 
			'icon_cloud', 
			'icon_cog', 
			'icon_cogs', 
			'icon_comment_alt', 
			'icon_comment', 
			'icon_compass_alt', 
			'icon_compass', 
			'icon_cone_alt', 
			'icon_cone', 
			'icon_contacts_alt', 
			'icon_contacts', 
			'icon_creditcard', 
			'icon_currency_alt', 
			'icon_currency', 
			'icon_cursor_alt', 
			'icon_cursor', 
			'icon_datareport_alt', 
			'icon_datareport', 
			'icon_desktop', 
			'icon_dislike_alt', 
			'icon_dislike', 
			'icon_document_alt', 
			'icon_document', 
			'icon_documents_alt', 
			'icon_documents', 
			'icon_download', 
			'icon_drawer_alt', 
			'icon_drawer', 
			'icon_drive_alt', 
			'icon_drive', 
			'icon_easel_alt', 
			'icon_easel', 
			'icon_error-circle_alt', 
			'icon_error-circle', 
			'icon_error-oct_alt', 
			'icon_error-oct', 
			'icon_error-triangle_alt', 
			'icon_error-triangle', 
			'icon_film', 
			'icon_floppy_alt', 
			'icon_floppy', 
			'icon_flowchart_alt', 
			'icon_flowchart', 
			'icon_folder_download', 
			'icon_folder_upload', 
			'icon_folder-add_alt', 
			'icon_folder-add', 
			'icon_folder-alt', 
			'icon_folder-open_alt', 
			'icon_folder-open', 
			'icon_folder', 
			'icon_genius', 
			'icon_gift_alt', 
			'icon_gift', 
			'icon_globe_alt', 
			'icon_globe-2', 
			'icon_globe', 
			'icon_group', 
			'icon_headphones', 
			'icon_heart_alt', 
			'icon_heart', 
			'icon_hourglass', 
			'icon_house_alt', 
			'icon_house', 
			'icon_id_alt', 
			'icon_id-2_alt', 
			'icon_id-2', 
			'icon_id', 
			'icon_image', 
			'icon_images', 
			'icon_info_alt', 
			'icon_info', 
			'icon_key_alt', 
			'icon_key', 
			'icon_laptop', 
			'icon_lifesaver', 
			'icon_lightbulb_alt', 
			'icon_lightbulb', 
			'icon_like_alt', 
			'icon_like', 
			'icon_link_alt', 
			'icon_link', 
			'icon_loading', 
			'icon_lock_alt', 
			'icon_lock-open_alt', 
			'icon_lock-open', 
			'icon_lock', 
			'icon_mail_alt', 
			'icon_mail', 
			'icon_map_alt', 
			'icon_map', 
			'icon_menu-circle_alt', 
			'icon_menu-circle_alt2', 
			'icon_menu-square_alt', 
			'icon_menu-square_alt2', 
			'icon_menu', 
			'icon_mic_alt', 
			'icon_mic', 
			'icon_minus_alt', 
			'icon_minus_alt2', 
			'icon_minus-06', 
			'icon_minus-box', 
			'icon_mobile', 
			'icon_mug_alt', 
			'icon_mug', 
			'icon_music', 
			'icon_ol', 
			'icon_paperclip', 
			'icon_pause_alt', 
			'icon_pause_alt2', 
			'icon_pause', 
			'icon_pencil_alt', 
			'icon_pencil-edit_alt', 
			'icon_pencil-edit', 
			'icon_pencil', 
			'icon_pens_alt', 
			'icon_pens', 
			'icon_percent_alt', 
			'icon_percent', 
			'icon_phone', 
			'icon_piechart', 
			'icon_pin_alt', 
			'icon_pin', 
			'icon_plus_alt', 
			'icon_plus_alt2', 
			'icon_plus-box', 
			'icon_plus', 
			'icon_printer-alt', 
			'icon_printer', 
			'icon_profile', 
			'icon_pushpin_alt', 
			'icon_pushpin', 
			'icon_puzzle_alt', 
			'icon_puzzle', 
			'icon_question_alt', 
			'icon_question_alt2', 
			'icon_question', 
			'icon_quotations_alt', 
			'icon_quotations_alt2', 
			'icon_quotations', 
			'icon_refresh', 
			'icon_ribbon_alt', 
			'icon_ribbon', 
			'icon_rook', 
			'icon_search_alt', 
			'icon_search-2', 
			'icon_search', 
			'icon_shield_alt', 
			'icon_shield', 
			'icon_star_alt', 
			'icon_star-half_alt', 
			'icon_star-half', 
			'icon_star', 
			'icon_stop_alt', 
			'icon_stop_alt2', 
			'icon_stop', 
			'icon_table', 
			'icon_tablet', 
			'icon_tag_alt', 
			'icon_tag', 
			'icon_tags_alt', 
			'icon_tags', 
			'icon_target', 
			'icon_tool', 
			'icon_toolbox_alt', 
			'icon_toolbox', 
			'icon_tools', 
			'icon_trash_alt', 
			'icon_trash', 
			'icon_ul', 
			'icon_upload', 
			'icon_vol-mute_alt', 
			'icon_vol-mute', 
			'icon_volume-high_alt', 
			'icon_volume-high', 
			'icon_volume-low_alt', 
			'icon_volume-low', 
			'icon_wallet_alt', 
			'icon_wallet', 
			'icon_zoom-in_alt', 
			'icon_zoom-in', 
			'icon_zoom-out_alt', 
			'icon_zoom-out', 
			'icon-adjustments',
			'icon-alarmclock',
			'icon-anchor',
			'icon-aperture',
			'icon-attachment',
			'icon-bargraph',
			'icon-basket',
			'icon-beaker',
			'icon-bike',
			'icon-book-open',
			'icon-briefcase',
			'icon-browser',
			'icon-calendar',
			'icon-camera',
			'icon-caution',
			'icon-chat',
			'icon-circle-compass',
			'icon-clipboard',
			'icon-clock',
			'icon-cloud',
			'icon-compass',
			'icon-desktop',
			'icon-dial',
			'icon-document',
			'icon-documents',
			'icon-download',
			'icon-dribbble',
			'icon-edit',
			'icon-envelope',
			'icon-expand',
			'icon-facebook',
			'icon-flag',
			'icon-focus',
			'icon-gears',
			'icon-genius',
			'icon-gift',
			'icon-global',
			'icon-globe',
			'icon-googleplus',
			'icon-grid',
			'icon-happy',
			'icon-hazardous',
			'icon-heart',
			'icon-hotairballoon',
			'icon-hourglass',
			'icon-key',
			'icon-laptop',
			'icon-layers',
			'icon-lifesaver',
			'icon-lightbulb',
			'icon-linegraph',
			'icon-linkedin',
			'icon-lock',
			'icon-magnifying-glass',
			'icon-map-pin',
			'icon-map',
			'icon-megaphone',
			'icon-mic',
			'icon-mobile',
			'icon-newspaper',
			'icon-notebook',
			'icon-paintbrush',
			'icon-paperclip',
			'icon-pencil',
			'icon-phone',
			'icon-picture',
			'icon-pictures',
			'icon-piechart',
			'icon-presentation',
			'icon-pricetags',
			'icon-printer',
			'icon-profile-female',
			'icon-profile-male',
			'icon-puzzle',
			'icon-quote',
			'icon-recycle',
			'icon-refresh',
			'icon-ribbon',
			'icon-rss',
			'icon-sad',
			'icon-scissors',
			'icon-scope',
			'icon-search',
			'icon-shield',
			'icon-speedometer',
			'icon-strategy',
			'icon-streetsign',
			'icon-tablet',
			'icon-target',
			'icon-telescope',
			'icon-toolbox',
			'icon-tools-2',
			'icon-tools',
			'icon-trophy',
			'icon-tumblr',
			'icon-twitter',
			'icon-upload',
			'icon-video',
			'icon-wallet',
			'icon-wine',
			'social_blogger_circle', 
			'social_blogger_square', 
			'social_blogger', 
			'social_delicious_circle', 
			'social_delicious_square', 
			'social_delicious', 
			'social_deviantart_circle', 
			'social_deviantart_square', 
			'social_deviantart', 
			'social_dribbble_circle', 
			'social_dribbble_square', 
			'social_dribbble', 
			'social_facebook_circle', 
			'social_facebook_square', 
			'social_facebook', 
			'social_flickr_circle', 
			'social_flickr_square', 
			'social_flickr', 
			'social_googledrive_alt2', 
			'social_googledrive_square', 
			'social_googledrive', 
			'social_googleplus_circle', 
			'social_googleplus_square', 
			'social_googleplus', 
			'social_instagram_circle', 
			'social_instagram_square',  
			'social_instagram', 
			'social_linkedin_circle', 
			'social_linkedin_square', 
			'social_linkedin', 
			'social_myspace_circle', 
			'social_myspace_square', 
			'social_myspace', 
			'social_picassa_circle', 
			'social_picassa_square', 
			'social_picassa', 
			'social_pinterest_circle', 
			'social_pinterest_square', 
			'social_pinterest', 
			'social_rss_circle', 
			'social_rss_square', 
			'social_rss', 
			'social_share_circle', 
			'social_share_square', 
			'social_share', 
			'social_skype_circle',  
			'social_skype_square', 
			'social_skype', 
			'social_spotify_circle',  
			'social_spotify_square', 
			'social_spotify', 
			'social_stumbleupon_circle', 
			'social_stumbleupon_square', 
			'social_tumbleupon', 
			'social_tumblr_circle', 
			'social_tumblr_square',  
			'social_tumblr', 
			'social_twitter_circle', 
			'social_twitter_square',  
			'social_twitter', 
			'social_vimeo_circle', 
			'social_vimeo_square', 
			'social_vimeo', 
			'social_wordpress_circle',  
			'social_wordpress_square', 
			'social_wordpress', 
			'social_youtube_circle', 
			'social_youtube_square',  
			'social_youtube',
			'pe-7s-cloud-upload',
			'pe-7s-cash',
			'pe-7s-close',
			'pe-7s-bluetooth',
			'pe-7s-cloud-download',
			'pe-7s-way',
			'pe-7s-close-circle',
			'pe-7s-id',
			'pe-7s-angle-up',
			'pe-7s-wristwatch',
			'pe-7s-angle-up-circle',
			'pe-7s-world',
			'pe-7s-angle-right',
			'pe-7s-volume',
			'pe-7s-angle-right-circle',
			'pe-7s-users',
			'pe-7s-angle-left',
			'pe-7s-user-female',
			'pe-7s-angle-left-circle',
			'pe-7s-up-arrow',
			'pe-7s-angle-down',
			'pe-7s-switch',
			'pe-7s-angle-down-circle',
			'pe-7s-scissors',
			'pe-7s-wallet',
			'pe-7s-safe',
			'pe-7s-volume2',
			'pe-7s-volume1',
			'pe-7s-voicemail',
			'pe-7s-video',
			'pe-7s-user',
			'pe-7s-upload',
			'pe-7s-unlock',
			'pe-7s-umbrella',
			'pe-7s-trash',
			'pe-7s-tools',
			'pe-7s-timer',
			'pe-7s-ticket',
			'pe-7s-target',
			'pe-7s-sun',
			'pe-7s-study',
			'pe-7s-stopwatch',
			'pe-7s-star',
			'pe-7s-speaker',
			'pe-7s-signal',
			'pe-7s-shuffle',
			'pe-7s-shopbag',
			'pe-7s-share',
			'pe-7s-server',
			'pe-7s-search',
			'pe-7s-film',
			'pe-7s-science',
			'pe-7s-disk',
			'pe-7s-ribbon',
			'pe-7s-repeat',
			'pe-7s-refresh',
			'pe-7s-add-user',
			'pe-7s-refresh-cloud',
			'pe-7s-paperclip',
			'pe-7s-radio',
			'pe-7s-note2',
			'pe-7s-print',
			'pe-7s-network',
			'pe-7s-prev',
			'pe-7s-mute',
			'pe-7s-power',
			'pe-7s-medal',
			'pe-7s-portfolio',
			'pe-7s-like2',
			'pe-7s-plus',
			'pe-7s-left-arrow',
			'pe-7s-play',
			'pe-7s-key',
			'pe-7s-plane',
			'pe-7s-joy',
			'pe-7s-photo-gallery',
			'pe-7s-pin',
			'pe-7s-phone',
			'pe-7s-plug',
			'pe-7s-pen',
			'pe-7s-right-arrow',
			'pe-7s-paper-plane',
			'pe-7s-delete-user',
			'pe-7s-paint',
			'pe-7s-bottom-arrow',
			'pe-7s-notebook',
			'pe-7s-note',
			'pe-7s-next',
			'pe-7s-news-paper',
			'pe-7s-musiclist',
			'pe-7s-music',
			'pe-7s-mouse',
			'pe-7s-more',
			'pe-7s-moon',
			'pe-7s-monitor',
			'pe-7s-micro',
			'pe-7s-menu',
			'pe-7s-map',
			'pe-7s-map-marker',
			'pe-7s-mail',
			'pe-7s-mail-open',
			'pe-7s-mail-open-file',
			'pe-7s-magnet',
			'pe-7s-loop',
			'pe-7s-look',
			'pe-7s-lock',
			'pe-7s-lintern',
			'pe-7s-link',
			'pe-7s-like',
			'pe-7s-light',
			'pe-7s-less',
			'pe-7s-keypad',
			'pe-7s-junk',
			'pe-7s-info',
			'pe-7s-home',
			'pe-7s-help2',
			'pe-7s-help1',
			'pe-7s-graph3',
			'pe-7s-graph2',
			'pe-7s-graph1',
			'pe-7s-graph',
			'pe-7s-global',
			'pe-7s-gleam',
			'pe-7s-glasses',
			'pe-7s-gift',
			'pe-7s-folder',
			'pe-7s-flag',
			'pe-7s-filter',
			'pe-7s-file',
			'pe-7s-expand1',
			'pe-7s-exapnd2',
			'pe-7s-edit',
			'pe-7s-drop',
			'pe-7s-drawer',
			'pe-7s-download',
			'pe-7s-display2',
			'pe-7s-display1',
			'pe-7s-diskette',
			'pe-7s-date',
			'pe-7s-cup',
			'pe-7s-culture',
			'pe-7s-crop',
			'pe-7s-credit',
			'pe-7s-copy-file',
			'pe-7s-config',
			'pe-7s-compass',
			'pe-7s-comment',
			'pe-7s-coffee',
			'pe-7s-cloud',
			'pe-7s-clock',
			'pe-7s-check',
			'pe-7s-chat',
			'pe-7s-cart',
			'pe-7s-camera',
			'pe-7s-call',
			'pe-7s-calculator',
			'pe-7s-browser',
			'pe-7s-box2',
			'pe-7s-box1',
			'pe-7s-bookmarks',
			'pe-7s-bicycle',
			'pe-7s-bell',
			'pe-7s-battery',
			'pe-7s-ball',
			'pe-7s-back',
			'pe-7s-attention',
			'pe-7s-anchor',
			'pe-7s-albums',
			'pe-7s-alarm',
			'pe-7s-airplay'
		);
		return $icons;	
	}
}