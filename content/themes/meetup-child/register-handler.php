<?php

add_action( 'wpum_after_register_form_template', function() {
  wp_enqueue_script('login-handler', get_stylesheet_directory_uri() . '/login-handler.js', array('jquery'));
});
