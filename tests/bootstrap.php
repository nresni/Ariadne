<?php
require_once __DIR__ . '/../lib/vendor/doctrine-common/lib/Doctrine/Common/ClassLoader.php';


use Doctrine\Common\ClassLoader;

$classLoader = new ClassLoader('Ariadne\Tests', __DIR__ . '/../tests');
$classLoader->register();

$classLoader = new ClassLoader('Symfony', __DIR__ . '/../lib/vendor/symfony/src');
$classLoader->register();

$classLoader = new ClassLoader('Ariadne', __DIR__ . '/../lib');
$classLoader->register();



$classLoader = new ClassLoader('Zend', __DIR__ . '/../lib/vendor/zend/src');
$classLoader->register();

$classLoader = new ClassLoader('Doctrine', __DIR__ . '/../lib/vendor/doctrine-common/lib');
$classLoader->register();
