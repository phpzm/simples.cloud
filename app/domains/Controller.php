<?php

namespace Fagoc;

/**
 * Class Controller
 * @package Fagoc
 */
class Controller
{
    /**
     * @return string
     */
    public function index()
    {
        return 'index';
    }

    /**
     * @return string
     */
    public function create()
    {
        return 'create';
    }

    /**
     * @return string
     */
    public function store()
    {
        return 'store';
    }

    /**
     * @param $id
     * @return string
     */
    public function show($id)
    {
        return 'show: ' . $id;
    }

    /**
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        return 'edit: ' . $id;
    }

    /**
     * @param $id
     * @return string
     */
    public function update($id)
    {
        return 'update: ' . $id;
    }

    /**
     * @param $id
     * @return string
     */
    public function destroy($id)
    {
        return 'destroy: ' . $id;
    }

}