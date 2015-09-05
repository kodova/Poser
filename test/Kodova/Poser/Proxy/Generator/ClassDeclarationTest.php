<?php

use Kodova\Poser\Proxy\Generator\ClassDeclaration as ClassDeclaration;

class ClassDeclarationTest extends PHPUnit_Framework_TestCase 
{
    public function setUp() {
    }

    public function tearDown() {
    }

	public function testGetSetProperties() {
		$implements = array('test');

	    $dec = new ClassDeclaration();
		$dec->setNamespace('Poser\Proxy');
		$dec->setClassName('ProxyFactory');
		$dec->setExtends('Factory');
		$dec->setImplements($implements);
		
		$this->assertEquals('Poser\Proxy', $dec->getNamespace());
		$this->assertEquals('ProxyFactory', $dec->getClassName());
		$this->assertEquals('Factory', $dec->getExtends());
		$this->assertEquals($implements, $dec->getImplements());
	}
	
	public function testGetDeclarationWithClassName() {
		$className = 'testClass';
		$declaration = "class $className";
		
		$dec = new ClassDeclaration();
		$dec->setClassName($className);
		
		$this->assertEquals($declaration, $dec->getDeclaration());
	}
	
	public function testGetDeclarationWithExtends() {
	    $className = 'TestClass';
		$extends = 'Foo';
		$declaration = "class $className extends $extends";
		
		$dec = new ClassDeclaration();
		$dec->setClassName($className);
		$dec->setExtends($extends);
		
		$this->assertEquals($declaration, $dec->getDeclaration());
	}
	
	public function testGetDeclarationWithExtendsAndImplements() {
	    $className = 'TestClass';
		$extends = 'Foo';
		$implements = array('Bar', 'Test');
		$declaration = "class $className extends $extends implements " . implode(', ', $implements);
		
		$dec = new ClassDeclaration();
		$dec->setClassName($className);
		$dec->setExtends($extends);
		$dec->setImplements($implements);
		
		$this->assertEquals($declaration, $dec->getDeclaration());
	}
}