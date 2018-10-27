<?php

return call_user_func(function () {

    $containerBuilder = new \PhpAcadem\framework\container\ContainerBuilder();

    $containerBuilder->setConfigDir(__DIR__);

    $container = $containerBuilder->build();

    if (!defined('ENV_DEV')) {
        define('ENV_DEV', $container->get('env') === 'dev' ? true : false);
    }

    ini_set('display_errors', ENV_DEV ? true : false);
    error_reporting(ENV_DEV ? E_ALL : 0);

    return $container;
});
