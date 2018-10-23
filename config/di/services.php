<?php


use League\Plates\Engine;
use League\Route\Strategy\ApplicationStrategy;
use Slim\Views\PhpRenderer;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;

$sources = [

];

$services = [
    'debug' => DI\factory(function (\Psr\Container\ContainerInterface $c) {
        return $c->get('env') == 'dev';

    }),
    \PhpAcadem\framework\Application::class => DI\factory(function (Engine $view, ApplicationStrategy $strategy, $debug) {
        $app = new PhpAcadem\framework\Application();

        $app->setStrategy($strategy);

        $app->setView($view);

        $app->middleware(new \PhpAcadem\framework\middleware\ErrorHandlerMiddleware($view, $debug));

        return $app;

    })->parameter('debug', DI\get('debug')),

    ApplicationStrategy::class => DI\factory(function (\Psr\Container\ContainerInterface $c) {
        $strategy = new ApplicationStrategy();
        $strategy->setContainer($c);
        return $strategy;
    }),
    Engine::class => DI\factory(function (\Psr\Container\ContainerInterface $c) {
        $view = new League\Plates\Engine($c->get('templatePath'), 'phtml');
        return $view;
    }),
    PhpRenderer::class => DI\factory(function (\Psr\Container\ContainerInterface $c) {
        $view = new PhpRenderer($c->get('templatePath'));
        return $view;
    }),
    EmitterInterface::class => DI\factory(function () {
        return new \Zend\HttpHandlerRunner\Emitter\SapiEmitter();
    }),


];

foreach ($sources as $source) {
    $services = array_replace($services, require($source));
}
return $services;
