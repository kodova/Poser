<?php

use Kodova\Poser\Proxy\Generator\ExtendedGenerator as ExtendedGenerator;
use Kodova\Poser\Helpers as helpers;

class ExtendedGeneratorTest extends PHPUnit_Framework_TestCase 
{
    public function setUp() {
	
    }

    public function tearDown() {
	
    }
	
	public function testGetClassDeclaration() {
		$toMock = 'Kodova\Poser\Helpers\Test\MethodClass';
		$name = helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
		$classDec = $generator->getClassDeclaration();
		
		$this->assertEquals($toMock, $classDec->getExtends(), 'The class to extend does not match');
	}
	
	public function testGetMethodsToProxy() {
		$toMock = 'Kodova\Poser\Helpers\Test\MethodClass';
		$name = helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
		$proxyMethods = $generator->getMethodsToProxy();
		
		$class = new \ReflectionClass($toMock);
		$methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);

		/*
			TODO Need to properly assert that expected methods are present
		*/
		// $this->assertEquals($methods, $proxyMethods, 'The methods to proxy do not match');
	}
	
	public function testGenearteAbstract() {
		$toMock = 'Kodova\Poser\Helpers\Test\AbstractClass';
		$name = helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
		$obj = $generator->generate();

		$this->assertTrue(is_a($obj, $toMock), "The generated object is not of type $toMock");
	}
	
	public function testGenearteClass() {
		$toMock = 'Kodova\Poser\Helpers\Test\MethodClass';
		$name = helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
		$obj = $generator->generate();
	
		$this->assertTrue(is_a($obj, $toMock), "The generated object is not of type $toMock");
	}
	
	public function testGenerateClassWithEmptyConstructor() {
	    $toMock = 'Kodova\Poser\Helpers\Test\ConstructorNoArgClass';
		$name = helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);	
		$obj = $generator->generate();
		
		$this->assertTrue(is_a($obj, $toMock), "The generated object is not of type $toMock");
	}

	/**
	 * @test
	 */
	public function shouldGenerateClassWithOptionalParamsInConstructor() {
		$toMock = 'Kodova\Poser\Helpers\Test\ConstructorOptionalArgClass';
		$name = helpers\ClassName::getName('Generator');

		$generator = new ExtendedGenerator($toMock, $name);
		$obj = $generator->generate();

		$this->assertTrue(is_a($obj, $toMock), "The generated object is not of type $toMock");
	}
	
	/**
	 * @expectedException \Kodova\Poser\Proxy\Generator\GeneratorException
	*/
	public function testShouldNotGenerateDueToMockRequiringConstructorWithArgs() {
	    $toMock = 'Kodova\Poser\Helpers\Test\ConstructorArgClass';
		$name = helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);	
		$classDef = $generator->generate();
	}
	
	/**
	 * @expectedException \Kodova\Poser\Proxy\Generator\GeneratorException
	*/
	public function testShouldNotGenerateDueToFinalClass() {
	    $toMock = 'Kodova\Poser\Helpers\Test\FinalClass';
		$name = helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
	}
	
	/**
	 * @expectedException \Kodova\Poser\Proxy\Generator\GeneratorException
	*/
	public function testShouldNotGenerateDueToBeingAnInterface() {
		$toMock = 'Kodova\Poser\Invocation\Answer';
		$name = helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
	}
}