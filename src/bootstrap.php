<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Loader\YamlFileLoader;

require_once __DIR__.'/../vendor/autoload.php';

$app = new \Ex\Core\ExApplication();

error_reporting(E_ALL);

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', realpath(__DIR__.'/..'));
}

$env = getenv('APP_ENV');
$env = in_array($env, ['local', 'prod', 'beta', 'tests']) ? $env : 'local';

ErrorHandler::register();

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->register(new Igorw\Silex\ConfigServiceProvider(ROOT_DIR . '/config/config_'.$env.'.yml'));

ExceptionHandler::register($app['debug']);


$app->register(new Silex\Provider\DoctrineServiceProvider(), $app['config']['database']);

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.name' => 'silex',
    'monolog.logfile' => ROOT_DIR . '/logs/'.$env.'.log',
    'monolog.level'   => Monolog\Logger::ERROR
));

$app['swiftmailer.transport'] = Swift_MailTransport::newInstance();
$app['swiftmailer.spooltransport']->getSpool()->flushQueue($app['swiftmailer.transport']);


$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => [
        ROOT_DIR . '/src/views'
    ]
));

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
    $translator->addLoader('yaml', new YamlFileLoader());

    $translator->addResource('yaml', ROOT_DIR.'/locales/en.yml', 'en');
    $translator->addResource('yaml', ROOT_DIR.'/locales/de.yml', 'de');
    $translator->addResource('yaml', ROOT_DIR.'/locales/fr.yml', 'fr');

    return $translator;
}));

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => // see below
));


$app->error(function (\Exception $e, $code) use ($app) {

    if ($app['debug']) {
        return;
    }

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

require 'route.php';

return $app;
