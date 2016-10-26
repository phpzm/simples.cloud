<?php

namespace Fagoc\Core\Flow;

use Fagoc\Core\Gateway\Request;

/**
 * Class Router
 * @package Fagoc\Core\Flow
 */
class Router
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var array
     */
    private $routes = [];
    /**
     * @var object
     */
    private $route;

    /**
     * Router constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $method
     * @param $uri
     * @param $callback
     */
    public function on($method, $uri, $callback)
    {
        if ($method === '*') {
            $method = ['get', 'post', 'put', 'patch', 'delete'];
        }
        $methods = explode(',', $method);

        foreach ($methods as $method) {

            $method = strtoupper($method);
            if (!isset($this->routes[$method])) {
                $this->routes[$method] = [];
            }
            $peaces = explode('/', $uri);
            foreach ($peaces as $key => $value) {
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
    }

    /**
     * @param $uri
     * @param $class
     */
    public function resource($uri, $class)
    {
        $resource = [
            ['method' => 'GET', 'uri' => 'index', 'callable' => 'index'],

            ['method' => 'GET', 'uri' => '', 'callable' => 'index'],
            ['method' => 'GET', 'uri' => 'create', 'callable' => 'create'],
            ['method' => 'POST', 'uri' => '', 'callable' => 'store'],
            ['method' => 'GET', 'uri' => ':id', 'callable' => 'show'],
            ['method' => 'GET', 'uri' => ':id/edit', 'callable' => 'edit'],
            ['method' => 'PUT,PATCH', 'uri' => ':id', 'callable' => 'update'],
            ['method' => 'DELETE', 'uri' => ':id', 'callable' => 'destroy'],
        ];
        foreach ($resource as $item) {
            $item = (object) $item;
            $this->on($item->method, $uri . '/' . $item->uri, $class . '@' . $item->callable);
        }
    }

    /**
     * @param $method
     * @param $callback
     */
    public function otherWise($method, $callback)
    {
        $this->on($method, '/(.*)', $callback);
    }

    /**
     * @return mixed
     */
    public function run()
    {
        $method = $this->request->getMethod();
        if (!isset($this->routes[$method])) {
            return null;
        }

        foreach ($this->routes[$method] as $route => $callback) {
            if (preg_match($route, $this->request->getUri(), $params)) {

                array_shift($params);
                $this->route = (object)['method' => $method, 'route' => $route, 'callback' => $callback];

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
    private function resolve($callback, $params)
    {
        if (!is_callable($callback)) {
            $peaces = explode('@', $callback);
            if (!isset($peaces[1])) {
                return null;
            }
            $callback = [$peaces[0], $peaces[1]];
        }
        return call_user_func_array($callback, $params);
    }
}
