<?php
function wpbootstrap_scripts_with_jquery()
{
    wp_enqueue_script( 'bootstrap-script', get_stylesheet_directory_uri() . '/assets/vendor/bootstrap.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'bootstrap-init', get_stylesheet_directory_uri() . '/assets/js/bootstrap.init.js', array( 'bootstrap-script' ) );
}

add_action( 'admin_enqueue_scripts', 'wpbootstrap_scripts_with_jquery' );

function admin_scripts() {
    wp_enqueue_script( 'single-event', get_stylesheet_directory_uri() . '/assets/js/single-event.js', array( 'jquery' ) );
}

add_action( 'admin_enqueue_scripts', 'admin_scripts' );

function front_scripts() {
   wp_enqueue_script( 'home-calendar', get_stylesheet_directory_uri() . '/assets/js/home-calendar.js', array( 'jquery' ) );
}

add_action( 'wp_enqueue_scripts', 'front_scripts' );