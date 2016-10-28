<?php

define('__APP_ROOT__', dirname(__DIR__));

require_once __APP_ROOT__ . '/vendor/autoload.php';

use Simples\Core\App;

$output = App::output();

App::headers($output);

App::body($output);
