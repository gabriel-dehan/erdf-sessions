<?php

function set_mail_html_content_type() {
    return 'text/html';
}

function notify( $email, $type ) {
    $subject = "C'est onb mec" . $email;
    $message = '<h1>Congratulations!</h1> <p>Your article is now online and
is sure to receives trillions of comments. Please do hang around and answer any questions
viewers may have!</p>';

    add_filter( 'wp_mail_content_type', 'set_mail_html_content_type' );
    wp_mail( 'dehan.gabriel@gmail.com', $subject, $message );
    remove_filter( 'wp_mail_content_type', 'set_mail_html_content_type' );
}
