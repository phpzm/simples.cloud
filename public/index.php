<?php

define('__APP_ROOT__', dirname(__DIR__));

require_once __APP_ROOT__ . '/vendor/autoload.php';

use Fagoc\Core\App;

$output = App::run();

echo $output;
