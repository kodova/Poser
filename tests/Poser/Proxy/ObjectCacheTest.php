<?php

use \Poser\Proxy\ObjectCache;
    
class ObjectCacheTest extends PHPUnit_Framework_TestCase {
    
	/**
	 * @var ObjectCache
	 */
    private $objectCache;
		
    public function setUp() {
		$this->objectCache = new ObjectCache();
    }
    
    public function tearDown() {
		$this->objectCache = null;
    }
	
	public function testAdd() {
		$obj = new stdClass();
		$name = "foo";
	    $this->objectCache->add($name, $obj);
	
		$this->assertEquals($obj, $this->objectCache->lookupByName($name));
	}
	
	public function testLookupByName() {
	    $obj1 = new stdClass();
		$obj2 = new stdClass();
		$name = 'foo';
		
	    $this->objectCache->add($name, $obj1);
		$this->objectCache->add('bar', $obj2);
	
		$this->assertEquals($obj1, $this->objectCache->lookupByName($name));
	}
	
	public function testLookupByNameWithNoExistingValue() {
		$obj = new stdClass();
		$this->objectCache->add('foo', $obj);
		
		$this->assertNull($this->objectCache->lookupByName('bar'));
	}
	
	public function testLookupByType() {
		$obj = new stdClass();
		$this->objectCache->add('foo', $obj);
		
		$this->assertEquals($obj, $this->objectCache->lookupByType('stdClass'));
	}
	
	public function testLookupByTypeWithNoExistingValue() {
		$obj = new stdClass();
		$this->objectCache->add('foo', $obj);
		
		$this->assertNull($this->objectCache->lookupByType('Foo'));
	}
}