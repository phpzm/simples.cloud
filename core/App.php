<?php

namespace Fagoc\Core;

use Fagoc\Core\Routing\Request;
use Fagoc\Core\Routing\Router;

/**
 * Class App
 * @package Core
 */
class App
{
    /**
     * @var null
     */
    private static $REQUEST = null;

    /**
     * @return mixed
     */
    public static function run()
    {
        $router = new Router(self::request());

        self::routes($router);

        return $router->run();
    }

    /**
     * @return Request
     */
    public static function request()
    {
        if (!self::$REQUEST) {
            self::$REQUEST = new Request();
        }
        return self::$REQUEST;
    }

    /**
     * @param $name
     * @return object
     */
    public static function config($name)
    {
        $config = [];
        $filename = path(true, 'app', 'config', $name . '.php');
        if (file_exists($filename)) {
            /** @noinspection PhpIncludeInspection */
            $config = require $filename;
        }
        return (object)$config;
    }

    /**
     * @param Router $router
     * @return Router
     */
    private static function routes(Router $router)
    {
        $route = self::config('route');

        foreach ($route->files as $file) {
            /** @noinspection PhpIncludeInspection */
            $callable = require_once __APP_ROOT__ . '/' . $file;
            if (is_callable($callable)) {
                $callable($router);
            }
        }

        return $router;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $get = 'get' . ucfirst($name);
        if (method_exists(self::request(), $get)) {
            return self::request()->$get();
        }
    }
}