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
        '/exercicio/*' => 'Exercício',
        '/path/to/controller' => 'Controller',
    ];

    $namespace = App::config('route')->namespace;


    /**
     * @doc one callback, a lot of routes
     */
    $home = function () use ($router, $menu) {
        return $router->response()->view('index.phtml', ['title' => 'Hello World!', 'menu' => $menu]);
    };

    $router->on('*', '/', $home);
    $router->on('*', '/index', $home);
    $router->on('*', '/home', $home);


    /**
     * @doc use method with verbs of http requests
     */
    $router->get('/exercicio/*', function ($exercicio) use ($router, $menu) {
        return $router->response()->view('exercicio/index.php', ['title' => 'Exercício ' . $exercicio, 'menu' => $menu]);
    });

    /**
     * @doc resources creates a block of routes
     */
    $router->resource('/path/to/controller', $namespace . '\Controller');


    /**
     * @doc if do not match any routes go to otherWise
     */
    $router->otherWise('get', function () {
        return 'Whoops!' . PHP_EOL;
    });
};
