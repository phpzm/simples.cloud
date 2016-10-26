<?php

namespace Fagoc\Core\Gateway;

use Fagoc\Core\App;
use Fagoc\Core\Template\Engine;

/**
 * Class Response
 * @package Fagoc\Core\Gateway
 */
class Response
{
    /**
     * @param $view
     * @param $data
     * @return string
     */
    public function view($view, $data = null)
    {
        $app = App::config('app');

        return (new Engine(path(true, $app->views)))->render($view, $data);
    }
}