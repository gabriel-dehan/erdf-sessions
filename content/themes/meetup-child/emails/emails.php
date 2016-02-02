<?php
function es_mail_sign() {
    return "Formation ERDF de communication en situation d'urgence médiatique";
}

foreach (glob(get_stylesheet_directory() . "/emails/templates/*.php") as $template) {
    require_once("templates/" . basename($template));
}

require_once('actions.php');
require_once('notify.php');
require_once('schedule.php');