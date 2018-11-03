<?php

if (!defined('JSON_PRESERVE_ZERO_FRACTION')) {
    define('JSON_PRESERVE_ZERO_FRACTION', 1024);
}

return [
    'env' => 'dev', // 'test', 'prod'

    'templatePath' => __DIR__ . '/../../src/app/view',

    'errorHandler' => 'app\controller\ErrorController::indexAction',

    'pdo' => [
        'dsn' => 'sqlite:' . __DIR__ . '/../../db/db.sqlite',
        'username' => '',
        'password' => '',
    ],

    'rbac' => [
        'roles' => [
            'admin' => [],
        ],
        'permissions' => [
            'admin' => [
                'blog.form',
                'blog.save',
            ],
        ],
    ]
];

