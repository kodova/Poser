<?php

use Poser\MockOptions;

use \Poser\Proxy\Generator\NewGenerator as NewGenerator;


class NewGeneratorTest extends PHPUnit_Framework_TestCase  {
	
	
	public function testGetClassDeclarationWithNamespace() {
		$namespace = 'Helpers\Test';
		$name = 'MethodClass';
		$options = new MockOptions();
	    $toMock = "$namespace\\$name";
		
		$generator = new NewGenerator($toMock, $options);
		$class = $generator->getClassDeclaration();
		
		$this->assertEquals($name, $class->getClassName(), 'The class names to not match');
		$this->assertEquals(array('\Poser\Proxy\SubstituteProxy'), $class->getImplements());
		$this->assertNull($class->getExtends(), 'The class should not extend anything');
	}
	
	public function testGetClassDeclarationPearName() {
	    $toMock = 'Helpers_Test_MethodClass';
	    $options = new MockOptions();
		
		$generator = new NewGenerator($toMock, $options);
		$class = $generator->getClassDeclaration();
		
		$this->assertEquals($toMock, $class->getClassName(), 'The class names to not match');
		$this->assertEquals(array('\Poser\Proxy\SubstituteProxy'), $class->getImplements());
		$this->assertNull($class->getExtends(), 'The class should not extend anything');
	}

	public function testGetMethodsToProxy() {
	    $toMock = 'Helpers\Test\MethodClass';
	    $options = new MockOptions();
		
		$generator = new NewGenerator($toMock, $options);
		$methods = $generator->getMethodsToProxy();
		
		$this->assertEmpty($methods);
	}
	
	public function testGenerate() {
		$toMock = 'Helpers\Test\DoNotUseClass';
		$options = new MockOptions();
		$generator = new NewGenerator($toMock, $options);
		$obj = $generator->generate();
		
		$this->assertTrue(is_a($obj, $toMock));
	}
	
	public function testGetConstants(){
		$toMock = 'Helpers\Test\MethodClass';
		$const = array('TEST' => 1, 'TEST2' => 2);
		$options = new MockOptions();
		$options->setConstants($const);
		
		$generator = new NewGenerator($toMock, $options);
		$constants = $generator->getConstants();
		
		$this->assertEquals($const, $constants);
	}
	
	public function testGenerateWithConstants(){
		$toMock = 'ThisDoesNotExist';
		$options = new MockOptions();
		$options->setConstants(array('TEST' => 3));
		
		$generator = new \Poser\Proxy\Generator\NewGenerator($toMock, $options);
		$obj = $generator->generate();
		
		$this->assertEquals(ThisDoesNotExist::TEST, 3);
	}
}
