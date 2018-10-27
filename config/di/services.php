<?php

return [
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

    'commands' => [
        \app\command\DbInitCommand::class => DI\factory(function (PDO $pdo) {
            return new \app\command\DbInitCommand($pdo);
        }),
    ]

];