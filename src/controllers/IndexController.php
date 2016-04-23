<?php

namespace Ex\Controllers;

use Silex\Application;

class IndexController
{
    public function home(Application $app)
    {

        print "\n\n<pre>";
        print_r($app->path('posts_index'));
        print "</pre>\n\n";
        die;

        return $app->render('index.twig', array(
            'name' => 'Janke',
        ));
    }
}