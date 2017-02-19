<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;


ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors',  E_ALL);
ini_set('display_startup_errors', E_ALL);

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
