<?php
/**
 * @package     Simplicity
 * @author      Rob Allen <rob@akrabat.com>
 * @copyright   2012 Rob Allen.
 * @license     MIT License - see LICENSE file
 * @link        http://phpfundamentals.com
 */
namespace Simplicity;

use Simplicity\Request;
use Simplicity\Response;
use Simplicity\Router;
use Simplicity\View;
use \Exception;

class FrontController
{
    protected $request;
    protected $response;
    protected $viewFilesDirectory;

    public function __construct(Request $request = null, Response $response = null)
    {
        $this->setRequest($request);
        $this->setResponse($response);

        $this->setViewFilesDirectory(__DIR__ . '/../../Application/View');
    }

    public function run()
    {
        $request  = $this->getRequest();
        $response = $this->getResponse();

        $routingParameters = $this->route($request);
        $request->setRoutingParameters($routingParameters);

        $result = $this->dispatch($request, $response);
        if(!($result instanceof Response)) {
            $view = new View($this->getViewFilesDirectory(), $request, $response);
            $response->setContent($view->render($result));
        }

        return $response;
    }

    protected function route($request)
    {
        $router = new Router();
        return $router->route($request);
    }

    protected function dispatch(Request $request, Response $response)
    {
        $controller = $request->getRouteParameter('controller', 'index1');
        $action = $request->getRouteParameter('action', 'index1');

        $controllerName = 'Application\\Controller\\'.ucfirst($controller) . 'Controller';
        if (!class_exists($controllerName)) {
            die('oops');
        }
        $controller = new $controllerName($request, $response);

        $actionName = lcfirst($action) . 'Action';
        if (!is_callable(array($controller, $actionName))) {
            throw new Exception("Cannot find action method $actionName in $controllerName");
        }

        $result = $controller->$actionName();

        return $result;
    }

    // ========================================================================
    // Getters and Setters for properties
    // ========================================================================

    public function getViewFilesDirectory()
    {
        return $this->viewFilesDirectory;
    }
    
    public function setViewFilesDirectory($viewFilesDirectory)
    {
        $this->viewFilesDirectory = $viewFilesDirectory;
        return $this;
    }

    public function getRequest()
    {
        if (!$this->request) {
            $this->request = new Request;
        }
        return $this->request;
    }
    
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    public function getResponse()
    {
        if (!$this->response) {
            $this->response = new Response;
        }
        return $this->response;
    }
    
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }
}