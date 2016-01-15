<?php

function admin_css() {
    $admin_stylesheet = get_stylesheet_directory_uri() . '/assets/css/admin.css';
    $bs_stylesheet = get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css';
    $bs_theme_stylesheet = get_stylesheet_directory_uri() . '/assets/css/bootstrap-theme.min.css';

    wp_enqueue_style( 'admin_css', $admin_stylesheet );
    wp_enqueue_style( 'bs', $bs_stylesheet );
    wp_enqueue_style( 'bs_theme', $bs_theme_stylesheet );
}
add_action('admin_print_styles', 'admin_css', 11 );

function home_css() {
    $home_css = get_stylesheet_directory_uri() . '/assets/css/home.css';
    wp_enqueue_style( 'home-css', $home_css );
}

add_action( 'wp_enqueue_scripts', 'home_css', 11 );
