<?php


$sources = [

];

$services = [
    'debug' => DI\factory(function (\Psr\Container\ContainerInterface $c) {
        return $c->get('env') == 'dev';

    }),
    PDO::class => DI\factory(function ($pdoConfig) { //todo
        return new \PDO(
            $pdoConfig['dsn'],
            $pdoConfig['username'],
            $pdoConfig['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );

    })->parameter('pdoConfig', DI\get('pdo')),



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
