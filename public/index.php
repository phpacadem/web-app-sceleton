<?php

define('PROJECT_ROOT', dirname(__DIR__));
require PROJECT_ROOT . "/vendor/autoload.php";

try {

    $container = require PROJECT_ROOT . '/config/bootstrap.php';

    $request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();


    /** @var \PhpAcadem\framework\Application $app */
    $app = $container->get(\PhpAcadem\framework\Application::class);


    $app->get('/', 'app\controller\HomeController::indexAction');
    $app->get('/blog/{id:number}', 'app\controller\BlogController::indexAction');

    try {
        $response = $app->dispatch($request);
    } catch (\League\Route\Http\Exception\NotFoundException $e) {
        $response = new \Zend\Diactoros\Response\HtmlResponse($app->getView()->render('error/404', [
            'request' => $request,
        ]), 404);
    }

    /** @var \Zend\HttpHandlerRunner\Emitter\EmitterInterface $emitter */
    $emitter = $container->get(\Zend\HttpHandlerRunner\Emitter\EmitterInterface::class);
    $emitter->emit($response);


} catch (\Throwable $e) {
    dump($e);
}