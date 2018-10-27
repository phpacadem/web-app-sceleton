<?php
return [
    \User\UserManager::class => DI\factory(function (PDO $pdo) {
        return new \User\UserManager($pdo);
    }),
    \User\UserServiceInterface::class => DI\factory(function (\User\UserManager $userManager) {
        return new \User\UserService($userManager);
    }),

    'commands' => [
        \User\command\InitCommand::class => DI\factory(function (PDO $pdo, \User\UserServiceInterface $userService) {
            return new \User\command\InitCommand($pdo, $userService);
        }),
    ],

];