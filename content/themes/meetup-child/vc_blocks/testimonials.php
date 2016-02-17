<?php

/**
 * The Shortcode
 */
function es_testimonials_shortcode( $atts ) {
	extract(
		shortcode_atts(
			array(
				'pppage' => '999',
				'filter' => 'all'
			), $atts
		)
	);

	/**
	 * Initial query args
	 */
	$query_args = array(
		'post_type' => 'testimonial',
		'posts_per_page' => $pppage
	);

	if (!( $filter == 'all' )) {
		if( function_exists( 'icl_object_id' ) ){
			$filter = (int)icl_object_id( $filter, 'testimonial_category', true);
		}
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'testimonial_category',
				'field' => 'id',
				'terms' => $filter
			)
		);
	}

	/**
	 * Finally, here's the query.
	 */
	$block_query = new WP_Query( $query_args );

	ob_start();
?>

	<div class="testimonials-container">
		<ul class="testimonials-list">

			<?php
				if ( $block_query->have_posts() ) : while ( $block_query->have_posts() ) : $block_query->the_post();

					the_title('<li><h3>', '</h3><p class="lead">'. get_the_content() .'</p></li>');

				endwhile;
				else :
			?>

				<li>
					<?php get_template_part('loop/content','none'); ?>
				</li>

			<?php
				endif;
				wp_reset_query();
			?>

		</ul>
	</div>

<?php
	$output = ob_get_contents();
	ob_end_clean();

	return $output;
}
add_shortcode( 'meetup_testimonials', 'es_testimonials_shortcode' );

/**
 * The VC Functions
 */
function es_testimonials_shortcode_vc() {
	vc_map(
		array(
			"icon" => 'meetup-vc-block',
			"name" => __("Testimonials", 'meetup'),
			"base" => "meetup_testimonials",
			"category" => __('Meetup - WP Theme', 'meetup'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __("Show How Many Posts?", 'meetup'),
					"param_name" => "pppage",
					"value" => '8',
					"description" => ''
				),
			)
		)
	);

}
add_action( 'vc_before_init', 'es_testimonials_shortcode_vc');
