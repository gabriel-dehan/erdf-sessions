<?php
function require_all($folder){ foreach (glob("{$folder}/*.php") as $filename) { require_once($filename); } }

require_all("templates");
require_once('notify.php');
require_once('actions.php');
