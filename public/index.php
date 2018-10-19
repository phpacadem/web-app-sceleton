<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

chdir(dirname(__DIR__));
require "vendor/autoload.php";


//var_dump($q);

try {

    $request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

    $router = new League\Route\Router;

    $router->get('/', 'app\controller\HomeController::indexAction');
    $router->get('/blog/{id:number}', 'app\controller\BlogController::indexAction');


    $response = $router->dispatch($request);

    $emitter = new \Zend\HttpHandlerRunner\Emitter\SapiEmitter();
    $emitter->emit($response);


} catch (\Throwable $e) {
    dump($e);
}