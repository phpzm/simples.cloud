<?php

use Fagoc\Core\App;
use Fagoc\Core\Flow\Router;
use Fagoc\Core\Gateway\Response;

return function (Router $router, Response $response) {

    $menu = [
        '/home/' => 'Home',
        '/exercicio/6/' => 'Exercício 6',
        '/exercicio/7/' => 'Exercício 7',
        '/exercicio/8/' => 'Exercício 8',
    ];

    $namespace = App::config('route')->namespace;


    /**
     * @doc one callback, a lot of routes
     */
    $home = function () use ($response, $menu) {
        return $response->view('index.phtml', ['title' => 'Hello World!', 'menu' => $menu]);
    };

    $router->on('*', '/', $home);
    $router->on('*', '/index', $home);
    $router->on('*', '/home', $home);


    /**
     * @doc use method with verbs of http requests
     */
    $router->get('/exercicio/:exercicio', function ($exercicio) use ($response, $menu) {
        return $response->view('exercicio.phtml', ['title' => 'Exercício ' . $exercicio, 'menu' => $menu]);
    });

    /**
     * @doc resources creates a block of routes
     */
    $router->resource('/controller', $namespace . '\Controller');


    /**
     * @doc if do not match any routes go to otherWise
     */
    $router->otherWise('get', function () {
        return 'Whoops!' . PHP_EOL;
    });
};
