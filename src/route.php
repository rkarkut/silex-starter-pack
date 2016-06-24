<?php

use Ex\Controllers\Admin\AdminController;
use Ex\Controllers\IndexController;
use Ex\Controllers\UsersController;

$app['index.controller'] = $app->share(function() use ($app) {
    return new IndexController();
});

$app['user.controller'] = $app->share(function() use ($app) {
    return new UsersController();
});

$app['admin.controller'] = $app->share(function() use ($app) {
    return new AdminController();
});

$app->get('/',  'index.controller:home')->bind('homepage');

/** admin **/
$app->get('/admin/', 'admin.controller:index');
$app->get('/auth/login-admin', 'admin.controller:login');

$app->get('/encode-password',  'index.controller:encodePassword');

/** user **/
$app->get('/auth/login-user', 'user.controller:login')->bind('user_login');

$app->get('/user/', 'user.controller:index')->bind('user_profile');