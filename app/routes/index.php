<?php

use Simples\Core\App;
use Simples\Core\Flow\Router;

/**
 * @param Router $router
 */
return function (Router $router) {

    $router->on('cli', '/migration', function() {
        return 'migration';
    });

    $menu = [
        '/home' => 'Home',
        '/whoops' => 'Whoops',
        '/api' => 'API',
        '/site/' => 'SITE',
        '/api/exercicio/*' => 'Exercício',
        '/app/context/controller' => 'Controller',
    ];

    $callback = function ($data) use ($router) {
        return $router->response()->view('index.phtml', ['title' => 'Hello World!', 'menu' => $data['menu']]);
    };

    $router
        ->in('menu', $menu)
        ->on('get', '/', $callback)
        ->on('get', '/index', $callback)
        ->on('get', '/home', $callback);

    $router
        ->group('*', '/api', 'app/routes/nested/api.php')
        ->group('get', '/site', 'app/routes/nested/site.php');

    $router
        ->resource('/app/context/controller', App::config('route')->namespace . '\Controller')
        ->otherWise('get', function () {
            return 'Whoops!' . PHP_EOL;
        });
};
