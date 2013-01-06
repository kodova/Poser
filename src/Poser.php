<?php

require 'vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Kodova\Poser\MockOptions;
use Kodova\Poser\PoserCore;
use Kodova\Poser\MockBuilder;
use Kodova\Poser\Stubbing\Stubbable;
use Kodova\Poser\Verification\Times;
use Kodova\Poser\Verification\VerifiableType;
use Hamcrest_Matchers as hm;

/**
 * The base poser object used for working with all mocked objects. All interactions with creating, stubbing, and
 * verifying mock objects should be through here or using the global_functions.php functions.
 */
class Poser {

	private static $poserCore = null;


    /**
     * Creates a new instance of a mocked object that inherits from the given class. This can be interfaces,
     * concrete classes and abstract classes
     *
     * @param string $class The fully qualified name of the class you would like to mock.
     * @param \Kodova\Poser\MockOptions $options
     * @return mixed A mocked instance of the given class
     */
	public static function mock($class, MockOptions $options = null) {
		if($options == null){
			return self::build($class)->mock();
		} else {
			return self::getPoserCore()->mock($class, $options);
		}
	}

	/**
	 * This is a convince method for mocking a singleton method on a class. It will create a default stub
	 * for a static invocation of getInstance() and return a instance of the mock object
	 *
	 * @param string $class The fully qualified name of the class you would like to mock.
	 * @return mixed A mocked object
	 */
	public static function mockSingleton($class){
		return static::build($class)->mockSingleton();
	}

	/**
	 * Used to build a more advanced or custom mock objects by returning you an instance of the MockBuilder object.
	 * This object can be used to configure the mock object prior to creating an instance of the mock. You should
	 * Poser::mock() when no special configuration is needed.
	 * @param $class
	 * @return MockBuilder
	 */
	public static function build($class){
		$core = self::getPoserCore();
		return new MockBuilder($core, $class);
	}
	
	/**
	 * Used to create a stub for a mocked object method calls. You can use this to return 
	 * values when the default return value is not desired.
	 * @param mixed $mockInvocation A method that has been invoked
	 * @return Stubbable
	 */
	public static function when($mockInvocation){
		$core = self::getPoserCore();
		return $core->when($mockInvocation);
	}
	
	/**
	 * Retuns a single instance of the PoserCore object that controls everything.
	 * @return PoserCore
	 */
	private static function getPoserCore(){
		if(null == self::$poserCore){
			$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
			$loader->registerNamespaces(array(
				'Symfony' => explode(PATH_SEPARATOR, get_include_path()),
				'Kodova\Poser' => __DIR__
			));
			$loader->registerPrefix("Hamcrest", explode(PATH_SEPARATOR, get_include_path()));
			$loader->register();
			
			$container = new Symfony\Component\DependencyInjection\ContainerBuilder();
			$configLoader = new YamlFileLoader($container, new FileLocator(__DIR__));
			$configLoader->load('Poser/container.yml');
			self::$poserCore = $container->get('poserCore');
		}
		
		return self::$poserCore;
	}

    /**
     * Sets the poser core to use for this poser object
     * @static
     * @param Kodova\Poser\PoserCore $poserCore
     */
	public static function setPoserCore(PoserCore $poserCore){
		static::$poserCore = $poserCore;
	}
	

	//-- Verification --//
    /**
     * This will verify that given invocation actually occurred on a mock object. This will match the exact
     * invocation arguments unless matchers are used. When using matchers for arguments then you need to
     * supply matchers for all arguments, there is no mixing a matching.
     * @param $mock A mocked object to verify actions on
     * @param \Kodova\Poser\Verification\VerifiableType $times The number of times a method should have been invoked, default 1;
     * @return mixed A instance of the mock object
     */
	public static function verify($mock, VerifiableType $times = null){
		if($times == null){
			$times = self::times(1);
		}
		return self::getPoserCore()->verify($mock, $times);
	}
	
	/**
	 * Ensures that a stub is invoked at 1 or more times
	 * @return Times
	 */
	public static function atLeastOnce() {
		self::atLeast(1);
	}
	
	/**
	 * Ensures that the given mock was invoked a given
	 * number of times or more.
	 * @param int $count
	 */
	public static function atLeast($count){
		//TODO need to implement this
	}
	
	/**
	 * Allows a stubed method to be invoked no more than 
	 * a given number of times.
	 * @param int $count
	 */
	public static function atMost($count){
		//TODO need to implement this
	}

	/**
	 * Used to verify that a method was never invoked on a mock with matching arguments
	 * @return Times
	 */
	public static function never() {
		return times(0);
	}
	
	/**
	 * Ensures that a given mock was invoked exactly the number of times given.
	 * @param int $count
	 * @return Times
	 */
	public static function times($count){
		return new Times($count);
	}
	
	/**
	 * Verifies that there were zero interactions with a given set of mocks
	 * @param mixed $mocks
	 */
	public static function verifyZeroInteractions($mocks){
		self::getPoserCore()->verifyZeroInteractions($mocks);
	}
	
	
	//---- Matchers ----//
	/**
	 * Is the value an instance of a particular type?
	 * @param $class
	 * @return null
	 */
	public static function any($class){
		return self::getPoserCore()->reportMatcher(hm::any($class))->returnNull();
	}

	/**
	 * Alias to equalTo
	 * @see Poser::equalTo()
	 * @param $val
	 * @return null
	 */
	public static function eq($val){
		return self::equalTo($val);
	}

	/**
	 * Is the value equal to another value, as tested by the use of the "=="
	 * @param $val
	 * @return null
	 */
	public static function equalTo($val){
		return self::getPoserCore()->reportMatcher(hm::equalTo($val))->returnNull();
	}

	/**
	 * This matcher matches any other parameter
	 * @param string $description
	 * @return null
	 */
	public static function anything($description = 'ANYTHING'){
		return self::getPoserCore()->reportMatcher(hm::anything($description))->returnNull();
	}

	/**
	 * Matches only if the parameter is an array
	 * @return array
	 */
	public static function anArray(){
		return self::getPoserCore()->reportMatcher(hm::anArray())->returnArray();
	}

	/**
	 * Matches only if the parameter is an array and has the given key
	 * @param $key
	 * @return array
	 */
	public static function hasKey($key){
		return self::getPoserCore()->reportMatcher(hm::hasKey($key))->returnArray();
	}

	/**
	 * Matches only if the parameter is an array and has given value
	 * @param $item
	 * @return array
	 */
	public static function hasValue($item){
		return self::getPoserCore()->reportMatcher(hm::hasValue($item))->returnArray();
	}

	/**
	 * Matches only if the parameter is an array and has the given key with the matching value.
	 * @param $key
	 * @param $value
	 * @return array
	 */
	public static function hasEntry($key, $value){
		return self::getPoserCore()->reportMatcher(hm::hasEntry($key, $value))->returnArray();
	}

	/**
	 * Matches when an parameter is an empty array
	 * @return array
	 */
	public static function emptyArray(){
		return self::getPoserCore()->reportMatcher(hm::emptyArray())->returnArray();
	}

	/**
	 * Matches when the given value does not match the parameter
	 * @param $value
	 * @return null
	 */
	public static function not($value){
		return self::getPoserCore()->reportMatcher(hm::not($value))->returnNull();
	}
}
