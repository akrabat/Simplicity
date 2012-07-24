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

        return array('message' => "Hello World: 1 > 2");
    }

    public function testAction()
    {
        return array('message' => "This is a test");
    }

    public function redirectAction()
    {
        $this->response->statusCode = '302';
        $this->response->setHeader('Location', 'http://www.example.com');
        return $this->response;
    }    
}
