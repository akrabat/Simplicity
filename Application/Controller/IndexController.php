<?php

namespace Application\Controller;

use Simplicity\Request;
use Simplicity\Response;

class IndexController
{
    protected $request;
    protected $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function indexAction()
    {
        return array('message' => "Hello World");
    }

    public function testAction()
    {
        return array('message' => "This is a test");
    }    
}