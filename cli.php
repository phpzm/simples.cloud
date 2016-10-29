<?php

define('__APP_ROOT__', __DIR__);

require_once __APP_ROOT__ . '/vendor/autoload.php';

use Simples\Core\App;

$output = App::output();

App::cli($output);