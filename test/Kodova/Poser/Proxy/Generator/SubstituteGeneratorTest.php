<?php

use Kodova\Poser\MockOptions;
use Kodova\Poser\Proxy\Generator\SubstituteGenerator;

class SubstituteGeneratorTest extends PHPUnit_Framework_TestCase  {
	
	
	public function testGetClassDeclarationWithNamespace() {
		$namespace = 'Helpers\Test';
		$name = 'MethodClass';
		$options = new MockOptions();
	    $toMock = "$namespace\\$name";
		
		$generator = new SubstituteGenerator($toMock, $options);
		$class = $generator->getClassDeclaration();
		
		$this->assertEquals($name, $class->getClassName(), 'The class names to not match');
		$this->assertEquals(array('\Poser\Proxy\SubstituteProxy'), $class->getImplements());
		$this->assertNull($class->getExtends(), 'The class should not extend anything');
	}
	
	public function testGetClassDeclarationPearName() {
	    $toMock = 'Helpers_Test_MethodClass';
	    $options = new MockOptions();
		
		$generator = new SubstituteGenerator($toMock, $options);
		$class = $generator->getClassDeclaration();
		
		$this->assertEquals($toMock, $class->getClassName(), 'The class names to not match');
		$this->assertEquals(array('\Poser\Proxy\SubstituteProxy'), $class->getImplements());
		$this->assertNull($class->getExtends(), 'The class should not extend anything');
	}

	public function testGetMethodsToProxy() {
	    $toMock = 'Helpers\Test\MethodClass';
	    $options = new MockOptions();
		
		$generator = new SubstituteGenerator($toMock, $options);
		$methods = $generator->getMethodsToProxy();
		
		$this->assertEmpty($methods);
	}
	
	public function testGenerate() {
		$toMock = 'Helpers\Test\DoNotUseClass';
		$options = new MockOptions();
		$generator = new SubstituteGenerator($toMock, $options);
		$obj = $generator->generate();
		
		$this->assertTrue(is_a($obj, $toMock));
	}
	
	public function testGetConstants(){
		$toMock = 'Helpers\Test\MethodClass';
		$const = array('TEST' => 1, 'TEST2' => 2);
		$options = new MockOptions();
		$options->setConstants($const);
		
		$generator = new SubstituteGenerator($toMock, $options);
		$constants = $generator->getConstants();
		
		$this->assertEquals($const, $constants);
	}
	
	public function testGenerateWithConstants(){
		$toMock = 'ThisDoesNotExist';
		$options = new MockOptions();
		$options->setConstants(array('TEST' => 3));
		
		$generator = new \Kodova\Poser\Proxy\Generator\SubstituteGenerator($toMock, $options);
		$obj = $generator->generate();
		
		$this->assertEquals(ThisDoesNotExist::TEST, 3);
	}
}
