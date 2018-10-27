<?php

namespace app\controller;


use Auth\AuthMiddleware;
use PhpAcadem\framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PersonalController extends ControllerAbstract
{

    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {

        $user = $request->getAttribute(AuthMiddleware::ATTRIBUTE) ?? null;

        $name = $user ? $user->getLogin() : 'Гость';
        return $this->render('home/index', ['name' => $name]);
    }

}