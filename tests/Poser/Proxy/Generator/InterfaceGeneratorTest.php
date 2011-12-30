<?php

use \Poser\Proxy\Generator\InterfaceGenerator as InterfaceGenerator;

class InterfaceGeneratorTest extends PHPUnit_Framework_TestCase 
{
    public function setUp() {
    }

    public function tearDown() {
    }
	
	public function testGetClassDeclaration() {
	    $toMock = "Poser\\Invocation\\Invocation";
		$name = "InvocationImpl";
		
		$generator = new InterfaceGenerator($toMock, $name);
		
		$classDec = $generator->getClassDeclaration();
		
		$this->assertContains($toMock, $classDec->getImplements(), false, "Does not implement the given interface");
	}
	
	public function testGetMethodsToProxy() {
	    $toMock = "Poser\\Invocation\\Invocation";
		$name = "InvocationImpl";
		$class = new ReflectionClass($toMock);
		
		$generator = new InterfaceGenerator($toMock, $name);
		
		$results = $generator->getMethodsToProxy();
		
		$this->assertContainsOnly('ReflectionMethod', $results, false, "Needs to return only ReflectionMethods");
		$this->assertEquals($class->getMethods(ReflectionMethod::IS_PUBLIC), $results, "Needs to return all public methdos");
	}
	
	public function testGenearte() {
	    $toMock = $toMock = "Poser\\Invocation\\Invocation";
		$name = \Helpers\ClassName::getName('InvocationImp');
		
		$generator = new InterfaceGenerator($toMock, $name);
		
		$classDef = $generator->generate();
		$obj = $generator->generate();
		
		$class = new ReflectionClass($obj);
		
		$this->assertContains($toMock, $class->getInterfaceNames(), 'The generated class does not implement the mocked class');
	}
	
	/**
	 * @expectedException \Poser\Proxy\Generator\GeneratorException
	*/
	public function testShouldNotGenerateDueToNonInterface() {
	    $toMock = 'Poser\Invocation\EmptyValueAnswer';
		$name = \Helpers\ClassName::getName('InvocationImp');
		
		$generator = new InterfaceGenerator($toMock, $name);
	}
}