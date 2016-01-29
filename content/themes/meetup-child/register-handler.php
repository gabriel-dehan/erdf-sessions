<?php

add_action( 'wpum_after_register_form_template', function() {
  wp_enqueue_script('login-handler', get_stylesheet_directory_uri() . '/assets/js/register-handler.js', array('jquery'));
});


add_action( 'wpum/form/register/success', 'es_after_register', 9, 2 );

function es_after_register($user_id, $values) {
    if( array_key_exists( 'responsable_email' , $values['register'] ) )
        update_user_meta( $user_id, 'responsable_email', $values['register']['responsable_email'] );
    if( array_key_exists( 'direction_appartenance' , $values['register'] ) )
        update_user_meta( $user_id, 'direction_appartenance', $values['register']['direction_appartenance'] );
    if( array_key_exists( 'user_phone' , $values['register'] ) )
        update_user_meta( $user_id, 'user_phone', $values['register']['user_phone'] );

    return TRUE;
}



add_action('wp', 'retain_queries', 1);

function retain_queries() {
    global $wp;
    //hd($_GET, $wp, $wp->query_string );die;
}

add_action('wp', 'register_current_url', 1);

function register_current_url() {
    global $wp;
    $current_url = home_url( $wp->request );
    $wp_session = WP_Session::get_instance();
    $history = $wp_session['history'] ? $wp_session['history']->toArray() : [];
    $history_size = count($history);

    if ($history_size > 10) {
        $history = [];
    }

    if ($history_size > 0 && isset($_GET['retain_params'])) {
        $history[$history_size - 1] = preg_replace( '/&?retain_params=?\d*/', '', add_query_arg( $_SERVER['QUERY_STRING'], '', $history[$history_size - 1] ) );
    }

    if (! ($history[$history_size - 1] == $current_url ) && !preg_match("/\/register|\/login/", $current_url) ) {
        array_push($history, $current_url);
    }
    $wp_session['history'] = $history;

}

function wpum_redirect_after_registration( $user_id, $values ) {
    $wp_session = WP_Session::get_instance();
    $history = $wp_session['history']->toArray();
    $history_size = count($history);
    $referer = '';

    $userdata = get_userdata( $user_id );

    $data = array();
    $data['user_login']    = $userdata->user_login;
    $data['user_password'] = $values['register']['password'];
    $data['rememberme']    = true;

    $user_login = wp_signon( $data, false );

    if ( $history_size > 0 ) {
        $referer = $history[$history_size - 1];
        wp_redirect( $referer );
    } else {
        wp_redirect( home_url() );
    }

    $wp_session['history'] = [];
    exit;
}

add_action( 'wpum/form/register/success', 'wpum_redirect_after_registration', 10, 2 );

function wpum_redirect_after_login( $user_id, $values ) {
    $wp_session = WP_Session::get_instance();
    $history = $wp_session['history']->toArray();
    $history_size = count($history);
    $referer = '';

    if ( $history_size > 0 ) {
        $referer = $history[$history_size - 1];
        wp_redirect( $referer );
    } else {
        wp_redirect( home_url() );
    }

    $wp_session['history'] = [];
    exit;
}

add_action( 'wp_login', 'wpum_redirect_after_login', 10, 2 );
