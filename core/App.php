<?php

namespace Fagoc\Core;

use Fagoc\Core\Gateway\Request;
use Fagoc\Core\Gateway\Response;
use Fagoc\Core\Flow\Router;

/**
 * Class App
 * @package Core
 */
class App
{
    /**
     * @var Request
     */
    private static $REQUEST = null;

    /**
     * @var Response
     */
    private static $RESPONSE = null;

    /**
     * @return mixed
     */
    public static function run()
    {
        $router = new Router(self::request());

        self::$RESPONSE = new Response();

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
     * @param array $files
     * @return Router
     */
    public static function routes(Router $router, array $files = null)
    {
        $files = $files ? $files : self::config('route')->files;

        foreach ($files as $file) {
            /** @noinspection PhpIncludeInspection */
            $callable = require_once __APP_ROOT__ . '/' . $file;
            if (is_callable($callable)) {
                $callable($router, self::$RESPONSE);
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
        return null;
    }

    /**
     * @param $uri
     * @param bool $print
     * @return string
     */
    public static function route($uri, $print = true)
    {
        $route = '//' . self::request()->getUrl() . '/' . ($uri{0} === '/' ? substr($uri, 1) : $uri);
        if ($print) {
            out($route);
        }
        return $route;
    }
}