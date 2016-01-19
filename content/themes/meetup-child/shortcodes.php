<?php

function next_events() {
?>
<ul>
<?php
  $args = array(
    'post_type' => 'revision',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'caller_get_posts'=> 1
    );

    $query = null;
    $query = new WP_Query($args);
    if( $query->have_posts() ) {
      while ($query->have_posts()) : $query->the_post();
    ?>
    <li>
        <a href="<?php the_permalink() ?>">
            <?php the_title(); ?>
        </a>
    </li>
    <?php
    endwhile;
    }
    wp_reset_query();  // Restore global post data stomped by the_post().


    ?>
</ul>
    <?php
}
add_shortcode( 'next_events', 'next_events' );
