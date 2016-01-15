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