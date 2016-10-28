<?php

use Simples\Core\App;
use Simples\Core\Flow\Router;

/**
 * @param Router $router
 */
return function (Router $router) {

    $menu = [
        '/home' => 'Home',
        '/whoops' => 'Whoops',
        '/api/exercicio/*' => 'Exercício',
        '/api' => 'API',
        '/site/' => 'SITE',
        '/path/to/controller' => 'Controller',
    ];

    $callback = function ($data) use ($router) {
        return $router->response()->view('index.phtml', ['title' => 'Hello World!', 'menu' => $data['menu']]);
    };

    $router
        ->in('menu', $menu)
        ->on('*', '/', $callback)
        ->on('*', '/index', $callback)
        ->on('*', '/home', $callback);

    $router
        ->nested('get', '/api', 'app/routes/nested/api.php')
        ->nested('get', '/site', 'app/routes/nested/site.php');

    $router
        ->resource('/path/to/controller', App::config('route')->namespace . '\Controller')
        ->otherWise('get', function () {
            return 'Whoops!' . PHP_EOL;
        });
};
