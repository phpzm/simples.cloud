<?php

use Simples\Core\Flow\Router;

return function (Router $router) {

    $router->get('/*', function($parameter, $data) use ($router) {

        return $router->response()->view('index.phtml', ['title' => 'SITE / ' . $parameter, 'menu' => $data['menu']]);
    });
};