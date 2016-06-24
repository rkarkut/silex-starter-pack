<?php

namespace Ex\Core;

use Silex\Application;
use Silex\Application\SecurityTrait;
use Silex\Application\TranslationTrait;
use Silex\Application\TwigTrait;
use Silex\Application\UrlGeneratorTrait;

/**
 * Main application class.
 */
class ExApplication extends Application
{
    use TwigTrait;
    use TranslationTrait;
    use UrlGeneratorTrait;
    use SecurityTrait;
}