<?php

use Simples\Core\Flow\Router;

return function (Router $router) {

    $router
        ->get('/', function ($data) use ($router) {

            return $router->response()->view('index.phtml', ['title' => 'SITE', 'menu' => $data['menu']]);
        })
        ->get('/data', function ($data) {

            return $data;
        });

};