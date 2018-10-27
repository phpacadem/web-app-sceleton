<?php

return call_user_func(function () {
    if (file_exists(__DIR__ . '/params/params.php')) {
        $params = require __DIR__ . '/params/params.php';
    } else {
        $params = require __DIR__ . '/params/params.php.dist';
    }

    $containerBuilder = new \PhpAcadem\framework\container\ContainerBuilder();
    $containerBuilder->addDefinitions($params);
    $containerBuilder->addDefinitions(__DIR__ . '/container.php');

    $containerBuilder->useAutowiring(true);
    $containerBuilder->useAnnotations(false);


    // this is for production
    if (!empty($params['diCacheProxyDir'])) {
        $containerBuilder->writeProxiesToFile(true, $params['diCacheProxyDir']);
    }
    if (!empty($params['diCacheCompilationDir'])) {
        $containerBuilder->enableCompilation($params['diCacheCompilationDir']);
    }

    $container = $containerBuilder->build();


    if (!defined('ENV_DEV')) {
        define('ENV_DEV', $container->get('env') === 'dev' ? true : false);
    }

    ini_set('display_errors', ENV_DEV ? true : false);
    error_reporting(ENV_DEV ? E_ALL : 0);

    return $container;
});
