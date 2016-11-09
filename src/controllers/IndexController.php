<?php
namespace Ex\Controllers;

use Ex\Core\ExApplication;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\User\User;

/**
 * Class IndexController
 * @package Ex\Controllers
 */
class IndexController
{``
    /**
     * @param ExApplication $app
     * @return Response
     */
    public function home(ExApplication $app)
    {
        return $app->render('site/index.twig');
    }

    /**
     * @param ExApplication $app
     * @param Request $request
     * @return Response
     */
    public function encodePassword(ExApplication $app, Request $request)
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
        /** @var MessageDigestPasswordEncoder $encoder */
        $password = $encoder->encodePassword($password, $user->getSalt());

        return new Response($password);
    }
}