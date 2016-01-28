<?php

add_action( 'wpum_after_register_form_template', function() {
  wp_enqueue_script('login-handler', get_stylesheet_directory_uri() . '/assets/js/register-handler.js', array('jquery'));
});


add_action( 'wpum/form/register/success', 'es_after_register', 10, 2 );

function es_after_register($user_id, $values) {
    if( array_key_exists( 'responsable_email' , $values['register'] ) )
        update_user_meta( $user_id, 'responsable_email', $values['register']['responsable_email'] );
    if( array_key_exists( 'direction_appartenance' , $values['register'] ) )
        update_user_meta( $user_id, 'direction_appartenance', $values['register']['direction_appartenance'] );
    if( array_key_exists( 'user_phone' , $values['register'] ) )
        update_user_meta( $user_id, 'user_phone', $values['register']['user_phone'] );
}



add_action('wp', 'register_current_url', 1);

function register_current_url() {
    global $wp;
    $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
    $wp_session = WP_Session::get_instance();

    $history = $wp_session['history'] ? $wp_session['history']->toArray() : [];
    if ($history.length > 4) {
        $history = [];
    }
    array_push($history, $current_url);
    $wp_session['history'] = $history;
}

function wpum_redirect_after_registration( $user_id, $values ) {
    hd( wp_get_referer() );die;
    wp_safe_redirect( wp_get_referer() );
    exit;
}
add_action( 'wpum/form/register/success', 'wpum_redirect_after_registration', 10, 2 );
