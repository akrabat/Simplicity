<?php
/**
 * @package     Simplicity
 * @author      Rob Allen <rob@akrabat.com>
 * @copyright   2012 Rob Allen.
 * @license     MIT License - see LICENSE file
 * @link        http://phpfundamentals.com
 */
namespace Simplicity;

class Request
{
    public $routingParameters;

    public function getGetParameter($name, $default='')
    {
        $value = $default;
        if (array_key_exists($name, $_GET)) {
            $value = $_GET[$name];
        }
        return $value;
    }

    public function getPostParameter($name, $default='')
    {
        $value = $default;
        if (array_key_exists($name, $_POST)) {
            $value = $_POST[$name];
        }
        return $value;
    }

    public function getServerParameter($name, $default='')
    {
        $value = $default;
        if (array_key_exists($name, $_SERVER)) {
            $value = $_SERVER[$name];
        }
        return $value;
    }

    public function getRouteParameter($name, $default='')
    {
        $value = $default;
        if (array_key_exists($name, $this->routingParameters)) {
            $value = $this->routingParameters[$name];
        }
        return $value;
    }
}