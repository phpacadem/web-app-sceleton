<?php

chdir(dirname(__DIR__));
require "vendor/autoload.php";


//var_dump($q);

try {

    $request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

    $name = $request->getQueryParams()['name'] ?? 'Гость';

    $response = new \Zend\Diactoros\Response\HtmlResponse('Привет ' . $name . '!');

    $emitter = new \Zend\HttpHandlerRunner\Emitter\SapiEmitter();
    $emitter->emit($response);

//    $application = new \Phalcon\Mvc\Application($di);
//
//    $response = $application->handle()->getContent();
//    echo $response;

} catch (\Throwable $e) {
    dump($e);
}