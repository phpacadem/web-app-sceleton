<?php

namespace app\controller;


use Auth\AuthService;
use PhpAcadem\framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class AuthController extends ControllerAbstract
{

    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        if ('POST' !== strtoupper($request->getMethod())) {
            return $this->failResponse();
        }

        $login = $request->getParsedBody()['sw_login'] ?? null;
        $password = $request->getParsedBody()['sw_password'] ?? null;

        $authService = $this->container->get(AuthService::class);

        $user = $authService->authenticate($login, $password);

        if ($user) {
            return $this->successResponse();
        } else {
            return $this->failResponse();
        }
    }

    protected function failResponse()
    {
        return new JsonResponse([
            'success' => false
        ], 401);
    }

    protected function successResponse()
    {
        return new JsonResponse([
            'success' => true
        ], 200);
    }

    public function logoutAction(ServerRequestInterface $request): ResponseInterface
    {

        $authService = $this->container->get(AuthService::class);

        $authService->logout();
        return $this->successResponse();
    }

}