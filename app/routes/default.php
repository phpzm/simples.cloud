<?php

use Fagoc\Core\App;
use Fagoc\Core\Routing\Router;

return function (Router $router) {

    $router->on('get', '/', function () {
        return 'Hello World!' . PHP_EOL;
    });

    $namespace = App::config('route')->namespace;

    $router->resource('/controller', $namespace . '\Controller');

    $router->otherWise('get', function () {
        return 'Whoops!' . PHP_EOL;
    });
};
