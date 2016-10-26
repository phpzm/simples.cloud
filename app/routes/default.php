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

    $home = function () use ($response, $menu) {
        return $response->view('index.phtml', ['title' => 'Hello World!', 'menu' => $menu]);
    };

    $router->on('get', '/', $home);
    $router->on('get', '/index', $home);
    $router->on('get', '/home', $home);

    $router->get('/exercicio/:exercicio', function ($exercicio) use ($response, $menu) {
        return $response->view('exercicio.phtml', ['title' => 'Exercício ' . $exercicio, 'menu' => $menu]);
    });

    $namespace = App::config('route')->namespace;

    $router->resource('/controller', $namespace . '\Controller');

    $router->otherWise('get', function () {
        return 'Whoops!' . PHP_EOL;
    });
};
