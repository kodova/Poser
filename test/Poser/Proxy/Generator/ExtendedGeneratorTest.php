<?php

use \Poser\Proxy\Generator\ExtendedGenerator as ExtendedGenerator;

class ExtendedGeneratorTest extends PHPUnit_Framework_TestCase 
{
    public function setUp() {
	
    }

    public function tearDown() {
	
    }
	
	public function testGetClassDeclaration() {
		$toMock = 'Helpers\Test\MethodClass';
		$name = \Helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
		$classDec = $generator->getClassDeclaration();
		
		$this->assertEquals($toMock, $classDec->getExtends(), 'The class to extend does not match');
	}
	
	public function testGetMethodsToProxy() {
		$toMock = 'Helpers\Test\MethodClass';
		$name = \Helpers\ClassName::getName('Generator');
		
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
		$toMock = 'Helpers\Test\AbstractClass';
		$name = \Helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
		$obj = $generator->generate();

		$this->assertTrue(is_a($obj, $toMock), "The generated object is not of type $toMock");
	}
	
	public function testGenearteClass() {
		$toMock = 'Helpers\Test\MethodClass';
		$name = \Helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);
		$obj = $generator->generate();
	
		$this->assertTrue(is_a($obj, $toMock), "The generated object is not of type $toMock");
	}
	
	public function testGenerateClassWithEmptyConstructor() {
	    $toMock = 'Helpers\Test\ConstructorNoArgClass';
		$name = \Helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);	
		$obj = $generator->generate();
		
		$this->assertTrue(is_a($obj, $toMock), "The generated object is not of type $toMock");
	}

	/**
	 * @test
	 */
	public function shouldGenerateClassWithOptionalParamsInConstructor() {
		$toMock = 'Helpers\Test\ConstructorOptionalArgClass';
		$name = \Helpers\ClassName::getName('Generator');

		$generator = new ExtendedGenerator($toMock, $name);
		$obj = $generator->generate();

		$this->assertTrue(is_a($obj, $toMock), "The generated object is not of type $toMock");
	}
	
	/**
	 * @expectedException \Poser\Proxy\Generator\GeneratorException
	*/
	public function testShouldNotGenerateDueToMockRequiringConstructorWithArgs() {
	    $toMock = 'Helpers\Test\ConstructorArgClass';
		$name = \Helpers\ClassName::getName('Generator');
		
		$generator = new ExtendedGenerator($toMock, $name);	
		$classDef = $generator->generate();
	}
	
	/**
	 * @expectedException \Poser\Proxy\Generator\GeneratorException
	*/
	public function testShouldNotGenerateDueToFinalClass() {
	    $toMock = '\Helpers\Test\FinalClass';
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