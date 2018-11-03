<?php
/**
 * @var \PhpAcadem\framework\route\Router $router
 */

// Routes
use app\route\RouteMap;


//public

$router->get('/section/{section:slug}/', 'app\controller\content\ArticleController::indexAction')
    ->setName(RouteMap::CONTENT_ARTICLE_INDEX);
$router->get('/article/{slug:slug}/', 'app\controller\content\ArticleController::showAction')
    ->setName(RouteMap::CONTENT_ARTICLE_SHOW);
$router->get('/page/{slug:slug}/', 'app\controller\content\PageController::showAction')
    ->setName(RouteMap::CONTENT_PAGE_SHOW);


//admin

$router->group('/admin/section', function (\League\Route\RouteGroup $router) {

    $router->get('//', 'app\controller\content\admin\SectionController::indexAction')
        ->setName(RouteMap::CONTENT_ADMIN_SECTION_INDEX);

    $router->get('/new', 'app\controller\content\admin\SectionController::editAction')
        ->setName(RouteMap::CONTENT_ADMIN_SECTION_NEW);
    $router->post('/section/new', 'app\controller\content\admin\SectionController::editAction')
        ->setName('section.new.save');

    $router->get('/edit/{id:number}', 'app\controller\content\admin\SectionController::editAction')
        ->setName(RouteMap::CONTENT_ADMIN_SECTION_EDIT);
    $router->post('/edit/{id:number}', 'app\controller\content\admin\SectionController::editAction')
        ->setName('section.edit.save');
})
    ->setName(RouteMap::CONTENT_ADMIN_SECTION)
    ->middleware($container->get(\PhpAcadem\domain\Rbac\AuthorizationMiddleware::class));

$router->group('/admin/article', function (\League\Route\RouteGroup $router) {
    $router->get('/{id:number}/', 'app\controller\content\admin\ArticleController::indexAction')
        ->setName(RouteMap::CONTENT_ADMIN_ARTICLE_INDEX);

    $router->get('/new/{section_id:number}/', 'app\controller\content\admin\ArticleController::editAction')
        ->setName(RouteMap::CONTENT_ADMIN_ARTICLE_NEW);
    $router->post('/new/{section_id:number}/', 'app\controller\content\admin\ArticleController::editAction')
        ->setName('section.new.save');

    $router->get('/edit/{id:number}/', 'app\controller\content\admin\ArticleController::editAction')
        ->setName(RouteMap::CONTENT_ADMIN_ARTICLE_EDIT);
    $router->post('/edit/{id:number}/', 'app\controller\content\admin\ArticleController::editAction')
        ->setName('section.edit.save');

})
    ->setName(RouteMap::CONTENT_ADMIN_ARTICLE)
    ->middleware($container->get(\PhpAcadem\domain\Rbac\AuthorizationMiddleware::class));

$router->group('/admin/page', function (\League\Route\RouteGroup $router) {

    $router->get('//', 'app\controller\content\admin\PageController::indexAction')
        ->setName(RouteMap::CONTENT_ADMIN_PAGE_INDEX);

    $router->get('/new/', 'app\controller\content\admin\PageController::editAction')
        ->setName(RouteMap::CONTENT_ADMIN_PAGE_NEW);
    $router->post('/new/', 'app\controller\content\admin\PageController::editAction')
        ->setName('page.new.save');

    $router->get('/edit/{id:number}/', 'app\controller\content\admin\PageController::editAction')
        ->setName(RouteMap::CONTENT_ADMIN_PAGE_EDIT);
    $router->post('/edit/{id:number}/', 'app\controller\content\admin\PageController::editAction')
        ->setName('page.edit.save');
})
    ->setName(RouteMap::CONTENT_ADMIN_PAGE)
    ->middleware($container->get(\PhpAcadem\domain\Rbac\AuthorizationMiddleware::class));


$router->group('/admin/menu', function (\League\Route\RouteGroup $router) {

    $router->get('//', 'app\controller\content\admin\MenuController::indexAction')
        ->setName(RouteMap::CONTENT_ADMIN_MENU_INDEX);

    $router->get('/new/', 'app\controller\content\admin\MenuController::editAction')
        ->setName(RouteMap::CONTENT_ADMIN_MENU_NEW);
    $router->post('/new/', 'app\controller\content\admin\MenuController::editAction')
        ->setName('menu.new.save');

    $router->get('/edit/{id:number}/', 'app\controller\content\admin\MenuController::editAction')
        ->setName(RouteMap::CONTENT_ADMIN_MENU_EDIT);
    $router->post('/edit/{id:number}/', 'app\controller\content\admin\MenuController::editAction')
        ->setName('menu.edit.save');
})
    ->setName(RouteMap::CONTENT_ADMIN_MENU)
    ->middleware($container->get(\PhpAcadem\domain\Rbac\AuthorizationMiddleware::class));

