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
 * The Request object contains convenience methods for accessing $_GET, $_POST
 * and $_SERVER so that you don't need to keep checking for the existance of
 * the key.
 * We also store the name of the controller and the name of the action in the
 * routeParameters property, so that they are accessible in the controller 
 * and in the view if needed.
 */
class Request
{
    public $routeParameters;

    /**
     * Retrieve a value from $_GET
     */
    public function getGetParameter($name, $default='')
    {
        $value = $default;
        if (array_key_exists($name, $_GET)) {
            $value = $_GET[$name];
        }
        return $value;
    }

    /**
     * Retrieve a value from $_POST
     */
    public function getPostParameter($name, $default='')
    {
        $value = $default;
        if (array_key_exists($name, $_POST)) {
            $value = $_POST[$name];
        }
        return $value;
    }

    /**
     * Retrieve a value from $_SERVER
     */
    public function getServerParameter($name, $default='')
    {
        $value = $default;
        if (array_key_exists($name, $_SERVER)) {
            $value = $_SERVER[$name];
        }
        return $value;
    }

    /**
     * Retrieve a value from the $routeParameters
     * The two valid values for $name are "controller" and "action"
     */
    public function getRouteParameter($name, $default='')
    {
        $value = $default;
        if (array_key_exists($name, $this->routeParameters)) {
            $value = $this->routeParameters[$name];
        }
        return $value;
    }
}
