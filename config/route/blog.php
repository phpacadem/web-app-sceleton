<?php
/**
 * @var \PhpAcadem\framework\route\Router $router
 */

// Routes

$router->get('/blog/', 'app\controller\BlogController::indexAction')
    ->setName('blog.index');

$router->get('/blog/{id:number}', 'app\controller\BlogController::showAction')
    ->setName('blog.show');

$router->get('/blog/{id:number}/edit', 'app\controller\BlogController::editAction')
    ->middleware($container->get(\PhpAcadem\domain\Rbac\AuthorizationMiddleware::class))
    ->setName('blog.form');

$router->post('/blog/{id:number}/edit', 'app\controller\BlogController::editAction')
    ->middleware($container->get(\PhpAcadem\domain\Rbac\AuthorizationMiddleware::class))
    ->setName('blog.save');

$router->get('/personal', 'app\controller\PersonalController::indexAction')
    ->middleware($container->get(\PhpAcadem\domain\Auth\AuthRequiredMiddleware::class));

