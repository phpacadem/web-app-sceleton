<?php

namespace app\controller\content\admin;


use League\Route\Http\Exception\NotFoundException;
use PhpAcadem\domain\Content\MenuManager;
use PhpAcadem\framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MenuController extends ControllerAbstract
{
    /** @var  MenuManager */
    protected $menuManager;


    /**
     * MenuController constructor.
     * @param MenuManager $menuManager
     */
    public function __construct(MenuManager $menuManager)
    {
        $this->menuManager = $menuManager;
    }

    public function indexAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $menus = $this->menuManager->findAll(false);

        return $this->render('content/menu/admin/index', ['menus' => $menus]);

    }


    public function editAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $id = $args['id'] ?? null;

        if ($id) {
            $menu = $this->menuManager->findById($id);

            if (empty($menu)) {
                throw new NotFoundException('not found');
            }
        }


        if ('POST' === strtoupper($request->getMethod())) {

            $requestData = $request->getParsedBody();

            if (!empty($menu)) {
                $menu = $this->menuManager->fill($menu, $requestData);
            } else {
                $menu = $this->menuManager->create($requestData);
            }

            $this->menuManager->save($menu);
        }
        $params = [];
        if (isset($menu)) {
            $params['menu'] = $menu;
        }

        return $this->render('content/menu/admin/form', $params);
    }

}