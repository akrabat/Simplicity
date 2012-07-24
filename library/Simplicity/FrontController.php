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

/**
 * The front controller accepts all requests to the web application and 
 * executes the correct controller action method. The controller action method
 * returns either a Response object or an array of key/value pairs which are
 * parameters for the view script. If an array is returned, then the front 
 * controller will instantiate a View object to render the correct view
 * script and assign the result to the Response's content property.
 * 
 * The view script that is called is ControllerName/actionName.phtml within the
 * $viewFilesDirectory.
 * 
 */
class FrontController
{
    public function run(Request $request, Response $response, $viewFilesDirectory)
    {
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
            $view = new View($viewFilesDirectory);
            $content = $view->render($filename, $result);
            $response->content = $content;
        }

        return $response;
    }
}
