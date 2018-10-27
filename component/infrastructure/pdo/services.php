<?php

return [
    PDO::class => DI\factory(function ($pdoConfig) {
        return new \PDO(
            $pdoConfig['dsn'],
            $pdoConfig['username'],
            $pdoConfig['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );

    })->parameter('pdoConfig', DI\get('pdo')),
];