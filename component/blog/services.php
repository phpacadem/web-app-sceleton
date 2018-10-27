<?php
return [
    \Blog\PostManager::class => DI\factory(function (PDO $pdo) {
        return new \Blog\PostManager($pdo);
    }),

    'commands' => [
        \Blog\command\InitCommand::class => DI\factory(function (PDO $pdo, \User\UserServiceInterface $userService) {
            return new \Blog\command\InitCommand($pdo, $userService);
        }),
    ],
];