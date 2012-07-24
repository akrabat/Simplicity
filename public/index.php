<?php

// define ROOT_DIR as the parent of this directory
define("ROOT_DIR", realpath(__DIR__. '/..'));

// set up the autoloader
set_include_path(ROOT_DIR . PATH_SEPARATOR . ROOT_DIR.'/library');
function __autoload($classname)
{
    $filename = str_replace('\\', '/', $classname) . '.php';
    if (stream_resolve_include_path($filename)) {
        require $filename;
    }
}

// set up the parameters for the Front Controller
$request = new Simplicity\Request();
$response = new Simplicity\Response();
$viewFilesDirectory = ROOT_DIR . '/Application/View';

// instantiate the front controller, run it and send the response to the browser
$frontController = new Simplicity\FrontController($request, $response, $viewFilesDirectory);
$response = $frontController->run();
$response->send();
