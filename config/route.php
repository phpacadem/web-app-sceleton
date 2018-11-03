<?php
/**
 * @var \PhpAcadem\framework\route\Router $router
 */

$routeDir = __DIR__ . '/route';
foreach (scandir($routeDir) as $filename) {
    $path = $routeDir . '/' . $filename;
    if (is_file($path)) {
        require $path;
    }
}
