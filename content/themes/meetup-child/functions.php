<?php
require('kint/Kint.class.php');

require_once('setup.php');
require_once('event-manager.php');
require_once('login-handler.php');

function es_event_find_users($event) {
    $event_manager = new EventManager($event);
    return $event_manager->find_users();
}

/*
 * Possible solution for Single Event page 404 errors where the WP_Query has an attachment set
 * IMPORTANT: Flush permalinks after pasting this code: http://tri.be/support/documentation/troubleshooting-404-errors/
 */
function tribe_attachment_404_fix () {
    if (class_exists('TribeEvents')) {
        remove_action( 'init', array( TribeEvents::instance(), 'init' ), 10 );
        add_action( 'init', array( TribeEvents::instance(), 'init' ), 1 );
    }
}
add_action( 'after_setup_theme', 'tribe_attachment_404_fix' );
