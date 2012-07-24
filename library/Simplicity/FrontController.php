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

    public function __construct(Request $request, Response $response, $viewFilesDirectory)
    {
        $this->request = $request;
        $this->response = $response;
        $this->viewFilesDirectory = $viewFilesDirectory;
    }

    public function run()
    {
        $request  = $this->request;
        $response = $this->response;

        // Routing: find out which controller and action is to be run
        $router = new Router();
        list($controller, $action) = $router->route($request);

        // store to request in case the view or controller need them
        $request->routingParameters['controller'] = $controller;
        $request->routingParameters['action'] = $action;

        // Dispatching: run the requested action method within the controller class
        $controllerName = 'Application\\Controller\\' . $controller . 'Controller';
        $actionName = $action . 'Action';
        $controllerClass = new $controllerName($request, $response);
        $result = $controllerClass->$actionName();
        if(!($result instanceof Response)) {
            // The result isn't a Response object, then we need to render a view script
            $filename = "$controller/$action.phtml";
            $view = new View($this->viewFilesDirectory);
            $content = $view->render($filename, $result);
            $response->content = $content;
        }

        return $response;
    }
}