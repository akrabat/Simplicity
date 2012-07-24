<?php
/**
 * @package     Simplicity
 * @author      Rob Allen <rob@akrabat.com>
 * @copyright   2012 Rob Allen.
 * @license     MIT License - see LICENSE file
 * @link        http://phpfundamentals.com
 */
namespace Simplicity;

class Router
{
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

        // finally check the path_info 


        $params = array(
            'controller' => $controller,
            'action' => $action,
        );
        return $params;

    }


}