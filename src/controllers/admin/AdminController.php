<?php
namespace Ex\Controllers\Admin;

use Ex\Core\ExApplication;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminController
 * @package Ex\Controllers\Admin
 */
class AdminController
{
    /**
     * @param ExApplication $app
     * @return Response
     */
    public function index(ExApplication $app)
    {
        return $app->render('admin/index.twig');
    }

    /**
     * @param ExApplication $app
     * @param Request $request
     *
     * @return Response
     */
    public function login(ExApplication $app, Request $request)
    {
        return $app->render('admin/login.twig', [
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ]);
    }
}