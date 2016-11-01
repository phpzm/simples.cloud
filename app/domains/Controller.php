<?php

namespace Fagoc;

use Simples\Core\Flow\Controller as FlowController;

/**
 * Class Controller
 * @package Fagoc
 */
class Controller extends FlowController
{
    /**
     * @SWG\Post(path="/user",
     *   tags={"user"},
     *   summary="Create user",
     *   description="This can only be done by the logged in user.",
     *   operationId="createUser",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Created user object",
     *     required=false,
     *     @SWG\Schema(ref="#/definitions/User")
     *   ),
     *   @SWG\Response(response="default", description="successful operation")
     * )
     * @param array $data
     * @return \Simples\Core\Gateway\Response
     */
    public function index(array $data)
    {
        return parent::index($data);
    }
}