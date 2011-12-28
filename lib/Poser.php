<?php

require_once 'Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader as YamlFileLoader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Config\FileLocator;
use Poser\MockOptions as MockOptions;
use Poser\MockBuilder as MockBuilder;

/**
 * undocumented class
 *
 * @package default
 */
class Poser {
	
	private static $poserCore = null;
	
	/**
	 * Creates a new mock of a class
	 *
	 * @package default
	 */
	public static function mock($class, MockOptions $options){
		return static::build($class)->mcok();
	}
	
	public static function mockSingleton($class, MockOptions $options){
		return static::build($class)->mockSingleton();
	}
	
	/**
	 * Used to build a more advanced or custom mock object
	 *
	 * @param string $class The class to be mocked
	 * @return MockBuilder a builder use to create mock
	 */
	public static function build($class){
		return new MockBuilder($this->poserCore, $class);
	}
	
	private static function getPoserCore(){
		if(null == self::$poserCore){
			$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
			$loader->registerNamespaces(array(
				'Symfony' => explode(PATH_SEPARATOR, get_include_path()),
				'Poser' => __DIR__
			));
			$loader->register();
			
			$container = new Symfony\Component\DependencyInjection\ContainerBuilder();
			$configLoader = new YamlFileLoader($container, new FileLocator(__DIR__));
			$configLoader->load('container.yml');
			self::$poserCore = $container->get('poserCore');
		}
		
		return self::$poserCore;
	}
	
	/**
	 * undocumented function
	 *
	 * @param PoserCore $poserCore 
	 * @return void
	 */
	public static function setPoserCore(PoserCore $poserCore){
		static::$poserCore = $poserCore;
	}
}
