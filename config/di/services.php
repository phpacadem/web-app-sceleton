<?php


$sources = [

];

$services = [
    'debug' => DI\factory(function (\Psr\Container\ContainerInterface $c) {
        return $c->get('env') == 'dev';

    }),

    \PhpAcadem\framework\ApplicationInterface::class => DI\factory(function (
        \PhpAcadem\framework\Application $app,
        \Infrastructure\Session\SessionMiddleware $sessionMiddleware,
        \Auth\AuthMiddleware $authMiddleware
    ) {

        $app->middleware($sessionMiddleware);
        $app->middleware($authMiddleware);

        return $app;
    }),

];

foreach ($sources as $source) {
    $services = array_replace($services, require($source));
}
return $services;
