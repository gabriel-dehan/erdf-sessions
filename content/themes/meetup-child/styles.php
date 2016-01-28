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

function front_css() {
    $tec_path = content_url() . '/plugins/the-events-calendar/';

    $front_css = get_stylesheet_directory_uri() . '/assets/css/dist/front.css';
    $tec_css = $tec_path . '/src/resources/css/tribe-events-full.min.css';
    $tec_theme_css = $tec_path . '/src/resources/css/tribe-events-theme.min.css';
    wp_enqueue_style( 'tec-css', $tec_css );
    wp_enqueue_style( 'tec-theme-css', $tec_theme_css );
    wp_enqueue_style( 'front-css', $front_css );
}

add_action( 'wp_enqueue_scripts', 'front_css', 11 );
