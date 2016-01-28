<?php

function set_mail_html_content_type() {
    return 'text/html';
}

function notify( $user, $event, $email ) {
    $subject =  call_user_func(current_filter() . '_subject', $user, $event, $email);
    $message =  call_user_func(current_filter() . '_template', $user, $event, $email);

    add_filter( 'wp_mail_content_type', 'set_mail_html_content_type' );
    wp_mail( $email, $subject, $message );
    remove_filter( 'wp_mail_content_type', 'set_mail_html_content_type' );
}
