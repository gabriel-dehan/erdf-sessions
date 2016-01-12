<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = '';
extract(shortcode_atts(array(
    'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'font_color'      => '',
    'padding'         => '',
    'margin_bottom'   => '',
    'css' => '',
    'background_style' => '',
    'single_link' => '',
    'scroll_id' => '',
    'mpfour' => '',
    'ogv' => '',
    'webm' => '',
    'map' => '',
    'color_style' => 'light-wrapper'
), $atts));

wp_enqueue_script( 'wpb_composer_front_js' );

if( 'image-left' == $background_style ){
	
	preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $css, $image);
	if(!( isset($image[0][0]) ))
		$image[0][0] = false;
	
	if($scroll_id)
		$output .= '<a id="'. ebor_sanitize_title($scroll_id) .'" class="in-page-link" href="#"></a>';
	
	$output .= '<section class="image-with-text '. esc_attr($color_style) .' preserve-3d">
		
		<div class="go-left side-image col-md-6 col-sm-4">
			<div class="background-image-holder">
				<img class="background-image" alt="Background Image" src="'. $image[0][0] .'">
			</div>
		</div>
		
		<div class="container vertical-align">
			<div class="row">
				<div class="col-md-5 col-md-offset-7 col-sm-7 col-sm-offset-5">';
	
	$el_class = $this->getExtraClass($el_class);
	
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . ' ', $this->settings['base'], $atts );
	
	$output .= '<div class="'.$css_class.'">';
	$output .= wpb_js_remove_wpautop($content);
	$output .= '</div>'.$this->endBlockComment('row');
	
	$output .= '</div></div></div></section>';
	
} elseif( 'image-right' == $background_style ){
	
	preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $css, $image);
	if(!( isset($image[0][0]) ))
		$image[0][0] = false;
		
	if($scroll_id)
		$output .= '<a id="'. ebor_sanitize_title($scroll_id) .'" class="in-page-link" href="#"></a>';
	
	$output .= '<section class="image-with-text '. esc_attr($color_style) .' preserve-3d">

		  <div class="container vertical-align">
			  <div class="row">
			      <div class="col-md-5 col-sm-7">
			    	  <div class="row">';
			    	  
	$el_class = $this->getExtraClass($el_class);
	
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . ' ', $this->settings['base'], $atts );
	
	$output .= '<div class="'.$css_class.'">';
	$output .= wpb_js_remove_wpautop($content);
	$output .= '</div>'.$this->endBlockComment('row');
	
	$output .= '</div></div></div></div>
	
	<div class="go-right side-image col-sm-4 col-md-6">
		<div class="background-image-holder">
			<img class="background-image" alt="Background Image" src="'. $image[0][0] .'">
		</div>
	</div>
	
	</section>';
			    	
} elseif( 'parallax' == $background_style ){
	
	preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $css, $image);
	if(!( isset($image[0][0]) ))
		$image[0][0] = false;
		
	if($scroll_id)
		$output .= '<a id="'. ebor_sanitize_title($scroll_id) .'" class="in-page-link" href="#"></a>';
	
	$output .= '<section class="strip-divider primary-overlay ebor-parallax">
		      <div class="background-image-holder parallax-background">
		          <img class="background-image" alt="Background Image" src="'. $image[0][0] .'">
		      </div>
		      
		      <div class="container">
		          <div class="row">';
			    	  
	$el_class = $this->getExtraClass($el_class);
	
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . ' ', $this->settings['base'], $atts );
	
	$output .= '<div class="'.$css_class.'">';
	$output .= wpb_js_remove_wpautop($content);
	$output .= '</div>'.$this->endBlockComment('row');
	
	$output .= '</div></div></section>';
			    	
} elseif( 'video' == $background_style ){
	
	preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $css, $image);
	if(!( isset($image[0][0]) ))
		$image[0][0] = false;
		
	if($scroll_id)
		$output .= '<a id="'. ebor_sanitize_title($scroll_id) .'" class="in-page-link" href="#"></a>';
	
	$output .= '<section class="strip-divider primary-overlay ebor-parallax">
	
		      <div class="background-image-holder parallax-background">
		          <img class="background-image" alt="Background Image" src="'. $image[0][0] .'">
		      </div>
		      
		      <div class="video-wrapper">
		      	<video autoplay muted loop>
		      		<source src="'. esc_url($webm) .'" type="video/webm">
		      		<source src="'. esc_url($mpfour) .'" type="video/mp4">
		      		<source src="'. esc_url($ogv) .'" type="video/ogg">	
		      	</video>
		      </div>
		      
		      <div class="container">
		          <div class="row">';
			    	  
	$el_class = $this->getExtraClass($el_class);
	
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . ' ', $this->settings['base'], $atts );
	
	$output .= '<div class="'.$css_class.'">';
	$output .= wpb_js_remove_wpautop($content);
	$output .= '</div>'.$this->endBlockComment('row');
	
	$output .= '</div></div></section>';
			    	
} elseif( 'map' == $background_style ){
	
	if($scroll_id)
		$output .= '<a id="'. ebor_sanitize_title($scroll_id) .'" class="in-page-link" href="#"></a>';
	
	$output .= '<section class="'. esc_attr($color_style) .'">
		<div class="container vertical-align">
			<div class="row">
				<div class="col-md-5 col-sm-6">
					<div class="row">';
					
					$el_class = $this->getExtraClass($el_class);
					
					$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . ' ', $this->settings['base'], $atts );
					
					$output .= '<div class="'.$css_class.'">';
					$output .= wpb_js_remove_wpautop($content);
					$output .= '</div>'.$this->endBlockComment('row');
					
					$output .= '</div>
				</div>
			</div><!--end of row-->
		</div><!--end of container-->
	
		<div class="map-holder col-md-6 col-sm-4">
			'. htmlspecialchars_decode(rawurldecode(base64_decode( $map ))) .'
		</div>
	</section>';
			    	
} elseif( 'full' == $background_style ){
	
	$el_class = $this->getExtraClass($el_class);
	
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
	
	$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
	
	if($scroll_id)
		$output .= '<a id="'. ebor_sanitize_title($scroll_id) .'" class="in-page-link" href="#"></a>';
	
	$output .= '<section class="'. $background_style .' '.$css_class.'"'.$style.'>';
	$output .= wpb_js_remove_wpautop($content);
	$output .= '</section>'.$this->endBlockComment('row');

} else {
	
	$el_class = $this->getExtraClass($el_class);
	
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
	
	$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
	
	if($scroll_id)
		$output .= '<a id="'. ebor_sanitize_title($scroll_id) .'" class="in-page-link" href="#"></a>';
	
	$output .= '<section class="'. esc_attr($color_style) .' '. $background_style .' '.$css_class.'"'.$style.'><div class="container"><div class="row">';
	$output .= wpb_js_remove_wpautop($content);
	$output .= '</div></div></section>'.$this->endBlockComment('row');

}

echo $output;