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

class View
{
    protected $request;
    protected $response;
    protected $fileDirectory;
    protected $filename;

    public function __construct($fileDirectory, Request $request, Response $response)
    {
        $this->fileDirectory = $fileDirectory;
        $this->request = $request;
        $this->response = $response;
    }

    public function render($parameters = array(), $filename = null)
    {
        $this->setFilename($filename);

        $this->parameters = $parameters;
        ob_start();
        require $this->fileDirectory . '/' . $this->getFilename();
        $content = ob_get_clean();
        return $content;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->parameters)) {
            return $this->parameters[$name];
        }
    }

    public function getFilename()
    {
        if (!$this->filename) {
            $request = $this->getRequest();
            $controller = $request->getRouteParameter('controller');
            $action = $request->getRouteParameter('action');


            $this->filename = ucfirst($controller) . '/' . lcfirst($action) . '.phtml';
        }
        return $this->filename;
    }

    public function setFilename($name)
    {
        $this->filename = $name;
        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }
    
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }
    
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }
    
    public function getFileDirectory()
    {
        return $this->fileDirectory;
    }
    
    public function setFileDirectory($fileDirectory)
    {
        $this->fileDirectory = $fileDirectory;
        return $this;
    }

}