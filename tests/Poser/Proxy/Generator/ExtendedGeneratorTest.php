<?php

use \Poser\Proxy\Generator\ExtendedGenerator as ExtendedGenerator;

class ExtendedGeneratorTest extends PHPUnit_Framework_TestCase 
{
    public function setUp() {
	
    }

    public function tearDown() {
	
    }
	
	public function testGetClassDeclaration() {
		$toMock = 'Poser\Proxy\Generator\AbstractGenerator';
		$name = \Helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
		$classDec = $generator->getClassDeclaration();
		
		$this->assertEquals($name, $classDec->getClassName(), "Class names do not match");
		$this->assertEquals($toMock, $classDec->getExtends(), 'The class to extend does not match');
	}
	
	public function testGetMethodsToProxy() {
		$toMock = 'Poser\Proxy\Generator\AbstractGenerator';
		$name = \Helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
		$proxyMethods = $generator->getMethodsToProxy();
		
		$class = new \ReflectionClass($toMock);
		$methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
		$constructor = $class->getMethod('__construct');
		$methods = array_diff($methods, array($constructor));
		
		$this->assertEquals($methods, $proxyMethods, 'The methods to proxy do not match');
	}
	
	public function testGenearteAbstract() {
		$toMock = 'Helpers\AbstractClass';
		$name = \Helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
		$classDef = $generator->generate();
		eval($classDef);
		$obj = new $name();

		$this->assertTrue(is_a($obj, $toMock), "The generated object is not of type $toMock");
	}
	
	public function testGenearteClass() {
		$toMock = 'Poser\Invocation\EmptyValueAnswer';
		$name = \Helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
		$classDef = $generator->generate();
		eval($classDef);
		$obj = new $name();
	
		$this->assertTrue(is_a($obj, $toMock), "The generated object is not of type $toMock");
	}
	
	/**
	 * @expectedException \Poser\Proxy\Generator\GeneratorException
	*/
	public function testShouldNotGenerateDueToFinalClass() {
	    $toMock = '\Helpers\FinalClass';
		$name = \Helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
	}
	
	/**
	 * @expectedException \Poser\Proxy\Generator\GeneratorException
	*/
	public function testShouldNotGenerateDueToBeingAnInterface() {
		$toMock = '\Poser\Invocation\Answer';
		$name = \Helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
	}
}