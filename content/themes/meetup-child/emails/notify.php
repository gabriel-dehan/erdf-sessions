<?php

function set_mail_html_content_type() {
    return 'text/html';
}

function notify( $user, $event, $email, $cc_admin = false ) {
    $subject =  call_user_func(current_filter() . '_subject', $user, $event, $email);
    $message =  call_user_func(current_filter() . '_template', $user, $event, $email);

    add_filter( 'wp_mail_content_type', 'set_mail_html_content_type' );

    if ($cc_admin) {
        wp_mail( $email, $subject, $message, 'CC: <' . get_option( 'admin_email' ) . '>;');
    } else {
        wp_mail( $email, $subject, $message );
    }

    remove_filter( 'wp_mail_content_type', 'set_mail_html_content_type' );
}

function notify_cc_admin( $user, $event, $email ) {
    notify( $user, $event, $email, true);
}