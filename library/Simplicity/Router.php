<?php
/**
 * @package     Simplicity
 * @author      Rob Allen <rob@akrabat.com>
 * @copyright   2012 Rob Allen.
 * @license     MIT License - see LICENSE file
 * @link        http://phpfundamentals.com
 */
namespace Simplicity;

/**
 * The Router class determines the controller and action to be used. It does
 * this by inspecting the $_GET, $_POST and then the server's PATH_INFO.
 * 
 * For $_GET and $_POST, the parameters "controller" and "action" are looked 
 * for. For path_info, the first two segements of the url after the base url
 * are assumed to be controller and then action.
 * 
 * The default controller in 'index' and the default action is 'index. 
 * 
 * Note that the returned controller name must start with a capital letter and 
 * that the returned action name must start with a lower case letter as these
 * are mapped directly to class name and method name respectively.
 */
class Router
{
    /**
     * Find out the name of the controller and action that is requested
     */
    public function route($request)
    {
        $controller = 'index';
        $action = 'index';

        // get first
        $controller = $request->getGetParameter('controller', $controller);
        $action = $request->getGetParameter('action', $action);

        // then post
        $controller = $request->getPostParameter('controller', $controller);
        $action = $request->getPostParameter('action', $action);

        // finally check the path_info here

        return array(ucfirst($controller), lcfirst($action));
    }
}
