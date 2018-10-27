<?php

use PhpAcadem\framework\console\ApplicationInterface;

define('PROJECT_ROOT', dirname(__DIR__));

require PROJECT_ROOT . "/vendor/autoload.php";

try {

    $container = require PROJECT_ROOT . '/config/bootstrap.php';

    /** @var ApplicationInterface $cli */
    $cli = $container->get(ApplicationInterface::class);

    $cli->run();

} catch (\Throwable $e) {
    dump($e);
}