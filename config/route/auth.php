<?php
/**
 * @var \PhpAcadem\framework\route\Router $router
 */

// Routes


$router->get('/auth', 'app\controller\AuthController::logoutAction');
$router->post('/auth', 'app\controller\AuthController::indexAction');
