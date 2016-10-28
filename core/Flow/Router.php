<?php

namespace Simples\Core\Flow;

use Simples\Core\App;
use Simples\Core\Gateway\Request;
use Simples\Core\Gateway\Response;

/**
 * Class Router
 * @package Simples\Core\Flow
 */
class Router
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var object
     */
    private $route;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    public $debug = [];

    /**
     * Router constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;

        $this->uri = $this->request->getUri();
        $this->method = $this->request->getMethod();
    }

    /**
     * @param $name
     * @param $arguments
     * @return Router
     */
    public function __call($name, $arguments)
    {
        return $this->on($name, $arguments[0], $arguments[1]);
    }

    /**
     * @param $method
     * @param $uri
     * @param $callback
     * @return $this
     */
    public function on($method, $uri, $callback)
    {
        $methods = explode(',', $method);
        if ($method === '*') {
            $methods = ['get', 'post', 'put', 'patch', 'delete'];
        }

        foreach ($methods as $method) {

            $method = strtoupper($method);
            if (!isset($this->routes[$method])) {
                $this->routes[$method] = [];
            }
            $peaces = explode('/', $uri);
            foreach ($peaces as $key => $value) {
                $peaces[$key] = str_replace('*', '(.*)', $peaces[$key]);
                if (strpos($value, ':') === 0) {
                    $peaces[$key] = '(\w+)';
                }
            }
            if ($peaces[(count($peaces) - 1)]) {
                $peaces[] = '';
            }
            $pattern = str_replace('/', '\/', implode('/', $peaces));
            $route = '/^' . $pattern . '$/';

            $this->routes[$method][$route] = $callback;
        }

        return $this;
    }

    /**
     * @param $uri
     * @param $class
     * @return $this
     */
    public function resource($uri, $class)
    {
        $resource = [
            ['method' => 'GET', 'uri' => 'index', 'callable' => 'index'],

            ['method' => 'GET', 'uri' => '', 'callable' => 'index'],
            ['method' => 'GET', 'uri' => 'create', 'callable' => 'create'],
            ['method' => 'GET', 'uri' => ':id', 'callable' => 'show'],
            ['method' => 'GET', 'uri' => ':id/edit', 'callable' => 'edit'],

            ['method' => 'POST', 'uri' => '', 'callable' => 'store'],
            ['method' => 'PUT,PATCH', 'uri' => ':id', 'callable' => 'update'],
            ['method' => 'DELETE', 'uri' => ':id', 'callable' => 'destroy'],
        ];
        foreach ($resource as $item) {
            $item = (object)$item;
            $this->on($item->method, $uri . '/' . $item->uri, $class . '@' . $item->callable);
        }

        return $this;
    }

    /**
     * @param $method
     * @param $start
     * @param $files
     * @return $this
     */
    public function nested($method, $start, $files)
    {
        $router = $this;

        $callback = function($parameter) use ($router, $files) {

            if (!is_array($files)) {
                $files = [$files];
            }

            if (!$parameter or func_num_args() === 1) {
                $parameter = '/';
            }

            /** @var Router $router */
            $router->setUri($parameter . '/');

            return App::routes($router->clear(), $files)->run();
        };

        $this->on($method, $start . '*', $callback);

        return $this;
    }

    /**
     * @param $method
     * @param $callback
     * @return Router
     */
    public function otherWise($method, $callback)
    {
        return $this->on($method, '/(.*)', $callback);
    }

    /**
     * @return mixed
     */
    public function run()
    {
        $method = $this->method;
        if (!isset($this->routes[$method])) {
            return null;
        }

        foreach ($this->routes[$method] as $route => $callback) {

            $this->debug[] = [
                'fetch' => [$route, $this->uri]
            ];

            if (preg_match($route, $this->uri, $params)) {

                array_shift($params);
                $this->route = (object)['method' => $method, 'uri' => $this->uri, 'route' => $route, 'callback' => $callback];

                $this->debug[] = [
                    'match' => $this->route
                ];

                return $this->resolve($callback, array_values($params));
            }
        }

        return null;
    }

    /**
     * @param $callback
     * @param $params
     * @return mixed
     */
    private function resolve($callback, array $params)
    {
        if (!is_callable($callback)) {
            $peaces = explode('@', $callback);
            if (!isset($peaces[1])) {
                return null;
            }
            $class = $peaces[0];
            $method = $peaces[1];

            if (method_exists($class, $method)) {

                /** @var \Simples\Core\Flow\Controller $controller */
                $controller = new $class($this->request(), $this->response(), $this->route);

                $callback = [$controller, $method];
            }
        }
        $params[] = $this->data;

        return call_user_func_array($callback, $params);
    }

    /**
     * @return Request
     */
    public function request()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * @return object
     */
    public function route()
    {
        return $this->route;
    }

    /**
     * @param $index
     * @param $value
     * @return $this
     */
    public function in($index, $value)
    {
        $this->data[$index] = $value;

        return $this;
    }

    /**
     * @param $index
     * @param null $default
     * @return mixed
     */
    public function out($index, $default = null)
    {
        return isset($this->data[$index]) ? $this->data[$index] : $default;
    }

    /**
     * @return $this
     */
    private function clear()
    {
        $this->routes = [];

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return Router
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

}
