<?php

require __DIR__ . '/../library/Simplicity/Autoloader.php';

$map = array(
    'Application' => realpath(__DIR__ . '/..'),
    'Simplicity' => realpath(__DIR__ . '/../library'),
);
$autoloader = new Simplicity\Autoloader($map);

$frontController = new Simplicity\FrontController();

$response = $frontController->run();
$response->send();
