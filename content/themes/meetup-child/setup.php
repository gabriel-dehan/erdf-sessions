<?php
require_once('db/es_db_fields.php');

function es_setup_customize_fields() {
  $es_fields = new ES_DB_Fields;
  $es_fields->customize_fields();
}

function es_setup_create_user_events() {
  $users_events = new ES_DB_UsersEvents;
  $users_events->create_table();
}

add_action( 'after_setup_theme', 'es_setup_customize_fields' );
add_action( 'after_setup_theme', 'es_setup_create_user_events' );
