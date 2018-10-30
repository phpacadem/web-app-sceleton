<?php

use PhpAcadem\framework\ApplicationInterface;

define('PROJECT_ROOT', dirname(__DIR__));

require PROJECT_ROOT . "/vendor/autoload.php";

try {

    $container = require PROJECT_ROOT . '/config/bootstrap.php';

    /** @var \PhpAcadem\framework\Application $app */
    $app = $container->get(ApplicationInterface::class);


    // Routes
    $app->get('/', 'app\controller\HomeController::indexAction');


    $app->get('/blog/{id:number}', 'app\controller\BlogController::indexAction');

    $app->get('/personal', 'app\controller\PersonalController::indexAction')
        ->middleware($container->get(\PhpAcadem\domain\Auth\AuthRequiredMiddleware::class));

    $app->get('/auth', 'app\controller\AuthController::logoutAction');
    $app->post('/auth', 'app\controller\AuthController::indexAction');


    // Handle
    $response = $app->handle();


    // Emmit
    /** @var \Zend\HttpHandlerRunner\Emitter\EmitterInterface $emitter */
    $emitter = $container->get(\Zend\HttpHandlerRunner\Emitter\EmitterInterface::class); //спрятать в $app
    $emitter->emit($response);


} catch (\Throwable $e) {

    ob_clean();
    http_response_code(503);
    echo file_get_contents(__DIR__ . '/html/error500.html');

    try {
        $container
            ->get(\Psr\Log\LoggerInterface::class)
            ->critical('Неперехваченное исключение', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTrace(),
            ]);

    } catch (\Throwable $e1) {

    }

    if (true || ENV_DEV) {
//        throw $e;
        dump($e);
    }
}