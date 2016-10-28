<?php

use Simples\Core\Flow\Router;

return function (Router $router) {

    $router->get('/', function($data) use ($router) {

        return $router->response()->view('index.phtml', ['title' => 'API', 'menu' => $data['menu']]);
    });

    $router->get('/exercicio/*', function ($exercicio, $data) use ($router) {
        return $router->response()->view('exercicio/index.php', [
            'title' => 'Exercício ' . $exercicio, 'menu' => $data['menu']
        ]);
    });
};