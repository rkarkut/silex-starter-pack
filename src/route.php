<?php

use Ex\Controllers\IndexController;
use Ex\Controllers\PostsController;

$app['posts.controller'] = $app->share(function() use ($app) {
    return new PostsController();
});

$app['index.controller'] = $app->share(function() use ($app) {
    return new IndexController();
});

$app->get('/posts', 'posts.controller:index')->bind('posts_index');

$app->get('/',  'index.controller:home')->bind('homepage');
