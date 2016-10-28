<?php

namespace Simples\Core\Flow;

use Simples\Core\Gateway\Request;
use Simples\Core\Gateway\Response;

/**
 * Class Controller
 * @package Simples\Core\Flow
 */
class Controller
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
     * @var string
     */
    private $view = '';

    /**
     * @var object
     */
    private $route = null;

    /**
     * @param Request $request
     * @param Response $response
     * @param object $route
     */
    public function __construct(Request $request, Response $response, $route = null)
    {
        $this->request = $request;
        $this->response = $response;

        $this->route = $route;
        $this->view = isset($route->uri) ? $route->uri : '';
    }

    /**
     * @return string
     */
    public function index()
    {
        $view = $this->view('/index');
        return $this->response()->view($view . '/index.php', [
            'title' => 'Simples\Core\Flow\Controller@index',
            'view' => $view
        ]);
    }

    /**
     * @return string
     */
    public function create()
    {
        $view = $this->view('/create');
        return $this->response()->view($view . '/form.php', [
            'title' => 'Simples\Core\Flow\Controller@create',
            'view' => $view
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function show($id)
    {
        $view = $this->view('/' . $id);
        return $this->response()->view($view . '/form.php', [
            'title' => 'Simples\Core\Flow\Controller@show',
            'id' => $id,
            'view' => $view
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $view = $this->view('/' . $id . '/edit');
        return $this->response()->view($view . '/form.php', [
            'title' => 'Simples\Core\Flow\Controller@edit',
            'id' => $id,
            'view' => $view
        ]);
    }

    /**
     * @return string
     */
    public function store()
    {
        $view = $this->view('');
        return $this->response()->view($view . '/form.php', [
                'title' => 'Simples\Core\Flow\Controller@store',
                'input' => $this->request->all(),
                'view' => $view
            ]
        );
    }

    /**
     * @param $id
     * @return string
     */
    public function update($id)
    {
        $view = $this->view('/' . $id);
        return $this->response()->view($view . '/form.php', [
                'title' => 'Simples\Core\Flow\Controller@update',
                'id' => $id,
                'input' => $this->request->all(),
                'view' => $view
            ]
        );
    }

    /**
     * @param $id
     * @return string
     */
    public function destroy($id)
    {
        $view = $this->view('/' . $id);
        return $this->response()->view($view . '/form.php', [
                'title' => 'Simples\Core\Flow\Controller@destroy',
                'id' => $id,
                'view' => $view
            ]
        );
    }

    /**
     * @param $relative
     * @return mixed
     */
    private function view($relative)
    {
        return str_replace($relative, '', $this->view);
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

}