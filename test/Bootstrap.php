<?php

require_once 'Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader as YamlFileLoader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Config\FileLocator;


$root =	dirname(__FILE__) . "/..";
$paths = array(
    "$root/src",
    "$root/test",
	"$root/test/Helpers"
);

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespaces(array(
	'Symfony' => explode(PATH_SEPARATOR, get_include_path()),
	'Poser' => $paths,
	'Helpers' => $paths
));
$loader->registerPrefix('Hamcrest', explode(PATH_SEPARATOR, get_include_path()));
$loader->register();

unset($root, $paths, $loader);

