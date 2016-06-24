<?php

namespace Ex\Controllers;

use Ex\Core\ExApplication;
use Ex\Domain\Users\UsersService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UsersController
 * @package Ex\Controllers
 */
class UsersController
{
    /**
     * @param ExApplication $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ExApplication $app)
    {
        if (!$app['security.authorization_checker']->isGranted('ROLE_USER')) {
            $app->abort('405', 'Nieprawidłowy adres url.');
        }

        return $app->render('site/users/index.twig');
    }

    /**
     * @param ExApplication $app
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(ExApplication $app, Request $request)
    {
        return $app->render('site/users/login.twig', [
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ]);
    }
}