<?php

if (!defined('JSON_PRESERVE_ZERO_FRACTION')) {
    define('JSON_PRESERVE_ZERO_FRACTION', 1024);
}

return [
    'env' => 'dev', // 'test', 'prod'
    'templatePath' => __DIR__ . '/../../src/app/view/',
];

