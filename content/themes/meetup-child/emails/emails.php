<?php
foreach (glob(get_stylesheet_directory() . "/emails/templates/*.php") as $template) {
    require_once("templates/" . basename($template));
}

require_once('actions.php');
require_once('notify.php');
