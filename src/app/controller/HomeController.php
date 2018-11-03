<?php

namespace app\controller;


use PhpAcadem\domain\User\UserInterface;
use PhpAcadem\framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends ControllerAbstract
{

    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $user = $request->getAttribute(UserInterface::class) ?? null;

        $name = $user ? $user->getLogin() : 'Гость';
        return $this->render('home/index', ['name' => $name]);
    }

}