<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$root =	dirname(__FILE__) . "/..";
$paths = array(
    "$root/src",
    "$root/test",
	"$root/test/Helpers"
);

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
	'Kodova\Poser' => $paths,
	'Helpers' => $paths
));
$loader->register();

unset($root, $paths, $loader);

