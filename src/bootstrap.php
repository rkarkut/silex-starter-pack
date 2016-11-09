<?php

use Ex\Domain\Users\UserProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Loader\YamlFileLoader;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Ex\Core\ExApplication();

error_reporting(E_ALL);

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', realpath(__DIR__ . '/..'));
}

$env = getenv('APP_ENV');

$env = in_array($env, ['local', 'prod', 'beta', 'tests']) ? $env : 'local';

ErrorHandler::register();

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\HttpFragmentServiceProvider());

$app->register(new Igorw\Silex\ConfigServiceProvider(ROOT_DIR . '/config/config_' . $env . '.yml'));

ExceptionHandler::register($app['debug']);

$app['security.access_rules'] = [
    ['^/_admin', 'ROLE_ADMIN'],
    ['^/user', 'ROLE_USER'],
];


$app['security.role_hierarchy'] = [
    'ROLE_ADMIN' => ['ROLE_USER'],
    'ROLE_USER' => ['ROLE_GUEST'],
];

$app->register(new Silex\Provider\SecurityServiceProvider(), [
    'security.firewalls' => [
        'admin' => $app['config']['security']['admin'],
        'user' => [
            'pattern' => $app['config']['security']['user']['pattern'],
            'anonymous' => $app['config']['security']['user']['anonymous'],
            'form' => $app['config']['security']['user']['form'],
            'logout' => $app['config']['security']['user']['logout'],
            'users' => $app->share(function() use ($app) {
                return new UserProvider($app['db']);
            })
        ],
    ]
]);

$app->register(new Silex\Provider\DoctrineServiceProvider(), $app['config']['database']);

$app->register(new Silex\Provider\MonologServiceProvider(), [
    'monolog.name' => 'silex',
    'monolog.logfile' => ROOT_DIR . '/logs/' . $env . '.log',
    'monolog.level' => Monolog\Logger::ERROR
]);

$app['swiftmailer.transport'] = Swift_MailTransport::newInstance();
$app['swiftmailer.spooltransport']->getSpool()->flushQueue($app['swiftmailer.transport']);


$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => [
        ROOT_DIR . '/src/views'
    ]
]);

$app->register(new Silex\Provider\TranslationServiceProvider(), [
    'locale_fallbacks' => ['en'],
]);

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
    $translator->addLoader('yaml', new YamlFileLoader());

    $translator->addResource('yaml', ROOT_DIR . '/locales/en.yml', 'en');
    $translator->addResource('yaml', ROOT_DIR . '/locales/de.yml', 'de');
    $translator->addResource('yaml', ROOT_DIR . '/locales/fr.yml', 'fr');

    return $translator;
}));

if ($app['debug']) {
    $app->register(new WebProfilerServiceProvider(), [
        'profiler.cache_dir' => ROOT_DIR . '/cache/profiler',
        'profiler.mount_prefix' => '/_profiler', // this is the default
    ]);

    $app->register(new Sorien\Provider\DoctrineProfilerServiceProvider());
}

if (!$app['debug']) {

    $app->error(function(\Exception $e, $code) use ($app) {
        $app['monolog']->addDebug($e->getMessage());

        switch ($code) {
            case 404:
                $message = 'The requested page could not be found.';
                break;
            default:
                $message = 'We are sorry, but something went terribly wrong.';
        }

        return new Response($message);
    });
}

require 'route.php';

return $app;
