<?php

use \Poser\Proxy\Generator\NewGenerator as NewGenerator;


class NewGeneratorTest extends PHPUnit_Framework_TestCase  {
	
	public function testGetClassDeclarationWithNamespace() {
		$namespace = 'Helpers\Test';
		$name = 'MethodClass';
	    $toMock = "$namespace\\$name";
		
		$generator = new NewGenerator($toMock);
		$class = $generator->getClassDeclaration();
		
		$this->assertEquals($name, $class->getClassName(), 'The class names to not match');
		$this->assertEquals(array('\Poser\Proxy\SubstituteProxy'), $class->getImplements());
		$this->assertNull($class->getExtends(), 'The class should not extend anything');
	}
	
	public function testGetClassDeclarationPearName() {
	    $toMock = 'Helpers_Test_MethodClass';
		
		$generator = new NewGenerator($toMock);
		$class = $generator->getClassDeclaration();
		
		$this->assertEquals($toMock, $class->getClassName(), 'The class names to not match');
		$this->assertEquals(array('\Poser\Proxy\SubstituteProxy'), $class->getImplements());
		$this->assertNull($class->getExtends(), 'The class should not extend anything');
	}

	public function testGetMethodsToProxy() {
	    $toMock = 'Helpers\Test\MethodClass';
		
		$generator = new NewGenerator($toMock);
		$methods = $generator->getMethodsToProxy();
		
		$this->assertEmpty($methods);
	}
	
	public function testGenerate() {
		$toMock = 'Helpers\Test\DoNotUseClass';
		$generator = new NewGenerator($toMock);
		$obj = $generator->generate();
		
		$this->assertTrue(is_a($obj, $toMock));
	}
}
