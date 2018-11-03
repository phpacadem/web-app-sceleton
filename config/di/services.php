<?php

return [
    'debug' => DI\factory(function (\Psr\Container\ContainerInterface $c) {
        return $c->get('env') == 'dev';

    }),

    \PhpAcadem\framework\ApplicationInterface::class => DI\factory(function (
        \PhpAcadem\framework\Application $app,
        \Infrastructure\Session\SessionMiddleware $sessionMiddleware,
        \PhpAcadem\domain\Auth\AuthMiddleware $authMiddleware,
        \app\middleware\LayoutMiddleware $layoutMiddleware,
        \Psr\Container\ContainerInterface $c
    ) {

        $app->middleware($sessionMiddleware);
        $app->middleware($authMiddleware);
        $app->middleware($layoutMiddleware);

        foreach ($c->get('viewExtensions') as $extention) {
            $app->getView()->loadExtension($extention);
        }

        return $app;
    }),

    'commands' => [
        \app\command\DbInitCommand::class => DI\factory(function (PDO $pdo) {
            return new \app\command\DbInitCommand($pdo);
        }),
        \app\command\DbDumpCommand::class => DI\factory(function (PDO $pdo) {
            return new \app\command\DbDumpCommand($pdo);
        }),
        \app\command\DbImportCommand::class => DI\factory(function (PDO $pdo) {
            return new \app\command\DbImportCommand($pdo);
        }),
    ]

];