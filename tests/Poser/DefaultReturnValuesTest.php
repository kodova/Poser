<?php

use \Poser\DefaultReturnValues;

class DefaultReturnValuesTest extends PHPUnit_Framework_TestCase 
{
	private $defaultReturnValues = null;
	
    public function setUp() {
		$this->defaultReturnValues = new DefaultReturnValues();
    }

    public function tearDown() {
		$this->defaultReturnValues = null;
    }

	public function testReturnZero() {
		$this->assertEquals(0, $this->defaultReturnValues->returnZero());
	}
	
	public function testReturnNull() {
		$this->assertNull($this->defaultReturnValues->returnNull());
	}
	
	public function testReturnFalse() {
	    $this->assertFalse($this->defaultReturnValues->returnFalse());
	}
	
	public function testReturnString() {
	    $this->assertEquals('', $this->defaultReturnValues->returnString());
	}
	
	public function testReturnArray() {
	    $this->assertEquals(array(), $this->defaultReturnValues->returnArray());
	}
}