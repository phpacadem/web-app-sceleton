<?php

namespace app\controller;


use framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends ControllerAbstract
{

    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $name = $request->getQueryParams()['name'] ?? 'Гость';
        return $this->render('home/index', ['name' => $name]);
    }

}