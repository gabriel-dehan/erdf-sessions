<?php
function es_mail_sign() {
    return "Mathieu Moreau";
}

foreach (glob(get_stylesheet_directory() . "/emails/templates/*.php") as $template) {
    require_once("templates/" . basename($template));
}

require_once('actions.php');
require_once('notify.php');
