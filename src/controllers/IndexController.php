<?php

namespace Ex\Controllers;

use Ex\Core\ExApplication;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;

/**
 * Class IndexController
 * @package Ex\Controllers
 */
class IndexController
{
    /**
     * @param ExApplication $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(ExApplication $app)
    {
        return $app->render('site/index.twig');
    }

    /**
     * @param Application $app
     * @param Request $request
     */
    public function encodePassword(Application $app, Request $request)
    {
        if (!$app['debug']) {
            $app->abort(404, 'Page not found');
        }

        $password = $request->get('password');

        if (empty($password)) {
            $app->abort(404, 'Page not found');
        }

        $user = new User('test', $password);

        $encoder = $app['security.encoder_factory']->getEncoder($user);
        $password = $encoder->encodePassword($password, $user->getSalt());

        die($password);
    }
}