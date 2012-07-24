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
    protected $getParameters;
    protected $postParameters;
    protected $serverParameters;
    protected $routingParameters;


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


    // ========================================================================
    // Getters and Setters for properties
    // ========================================================================

    public function getGetParameters()
    {
        return $this->getParameters;
    }
    
    public function setGetParameters($getParameters)
    {
        $this->getParameters = $getParameters;
        return $this;
    }

    public function getPostParameters()
    {
        return $this->postParameters;
    }
    
    public function setPostParameters($postParameters)
    {
        $this->postParameters = $postParameters;
        return $this;
    }

    public function getServerParameters()
    {
        return $this->serverParameters;
    }
    
    public function setServerParameters($serverParameters)
    {
        $this->serverParameters = $serverParameters;
        return $this;
    }

    public function getRoutingParameters()
    {
        return $this->routingParameters;
    }
    
    public function setRoutingParameters($routingParameters)
    {
        $this->routingParameters = $routingParameters;
        return $this;
    }
}