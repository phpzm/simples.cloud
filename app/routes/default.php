<?php

use Fagoc\Core\App;
use Fagoc\Core\Flow\Router;
use Fagoc\Core\Gateway\Response;

return function (Router $router, Response $response) {

    $router->on('get', '/', function () use ($response) {
        return $response->view('index.phtml', ['title' => 'Hello World!']);
    });

    $router->get('/exercicio/:exercicio', function ($exercicio) use ($response) {
        return $response->view('exercicio.phtml', ['title' => 'Exercício ' . $exercicio]);
    });

    $namespace = App::config('route')->namespace;

    $router->resource('/controller', $namespace . '\Controller');

    $router->otherWise('get', function () {
        return 'Whoops!' . PHP_EOL;
    });
};
