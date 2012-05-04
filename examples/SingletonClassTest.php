<?php

class SingletonClassTest extends PHPUnit_Framework_TestCase{


	protected function setUp() {

	}

	protected function tearDown() {

	}

	public function testGetFoo(){
		$mock = build("SingletonClass")->mockSingleton();
		$value = "chicken";
		when($mock->getFoo())->thenReturn($value);
		$singleton = SingletonClass::getInstance();
		$this->assertEquals($singleton->getFoo(), $value);
	}
}
