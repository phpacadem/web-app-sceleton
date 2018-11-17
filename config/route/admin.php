<?php
/**
 * @var \PhpAcadem\framework\route\Router $router
 */

// Routes
use app\route\RouteMap;


//public

$router->get('/admin/', 'app\controller\admin\AdminController::indexAction')
    ->setName(RouteMap::ADMIN)
    ->middleware($container->get(\PhpAcadem\domain\Rbac\AuthorizationMiddleware::class));

