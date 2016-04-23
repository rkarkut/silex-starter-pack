<?php

namespace Ex\Core;

use Silex\Application;
use Silex\Application\TranslationTrait;
use Silex\Application\TwigTrait;
use Silex\Application\UrlGeneratorTrait;

class ExApplication extends Application
{
    use TwigTrait;
    use TranslationTrait;
    use UrlGeneratorTrait;
}