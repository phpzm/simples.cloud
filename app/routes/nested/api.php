<?php

use Simples\Core\Flow\Router;

return function (Router $router) {

    $router->get('/*', function($parameter, $data) use ($router) {

        return $router->response()->view('index.phtml', ['title' => 'API / ' . $parameter, 'menu' => $data['menu']]);
    });
};