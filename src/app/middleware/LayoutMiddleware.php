<?php

namespace app\middleware;


use PhpAcadem\domain\Content\MenuManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Session\SessionInterface;

class LayoutMiddleware implements MiddlewareInterface
{
    /** @var MenuManager */
    protected $menuManger;

    /**
     * LayoutMiddleware constructor.
     * @param MenuManager $menuManger
     * @param SessionInterface $session
     */
    public function __construct(MenuManager $menuManger, SessionInterface $session)
    {
        $this->menuManger = $menuManger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $menu = $this->menuManger->getMenu();
        $layoutData = ['menu' => $menu];
        return $handler->handle($request->withAttribute('layoutData', $layoutData));

    }


}