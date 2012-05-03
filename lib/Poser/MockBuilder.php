<?php

namespace Poser;

use Poser\Invocation\Answer as Answer;
use	Poser\Invocation\EmptyValueAnswer as EmptyValueAnswer;
use Poser\MockOptions as MockOptions;
use Poser\PoserCore as PoserCore;

class MockBuilder {
	/**
	 * @var String
	 */
	private $name;
	/**
	 * @var Answer
	 */
	private $defaultAnswer;
	/**
	 * @var boolean
	 */
	private $mockStatic;
	/**
	 * @var PoserCore
	 */
	private $poserCore;
	/**
	 * @var string
	 */
	private $class;
	/**
	 * @var array[string]
	 */
	private $constants = array();
	
	/**
	 * @param PoserCore $poserCore
	 * @param string $class
	 */
	function __construct(PoserCore $poserCore, $class) {
		$this->defaultAnswer = new EmptyValueAnswer();
		$this->name = null;
		$this->mockStatic = false;
		$this->poserCore = $poserCore;
		$this->class = $class;
	}
	
	/**
	 * A name used to uniquely identify the mock object. Can
	 * be used to retrieve the mock object at a later time.
	 *
	 * @param string $name 
	 * @return MockBuilder
	 */
	public function name($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * Sets if the mock object will mock static calls. this
	 * should only be used when necessary since it limits other
	 * functionality
	 *
	 * @param boolean $mockStatic
	 * @return MockBuilder
	 */
	public function mockStatic($mockStatic){
		$this->mockStatic = $mockStatic;
		return $this;
	}
	
	/**
	 * A convince method that will create a mock object and 
	 * set a static call to a given method that will return a
	 * instance of itself, a mock object
	 * 
	 * @param string $method the method that gets singleton instance. defaults to getInstance
	 * @return mixed
	 */
	public function mockSingleton($method = 'getInstance') {
		$mock = $this->mock();		
		return $mock;
	}

	/**
	 * Used to set the default answer to non-stubbed calls
	 *
	 * @param \Poser\Invocation\Answer $answer
	 * @return MockBuilder
	 */
	public function defaultAnswer(Answer $answer) {
		$this->defaultAnswer = $answer;
		return $this;
	}
	
	/**
	 * Values to be added as a constant.
	 * 
	 * @param array $constants Keys will be the constant name and values will be the value
	 * @return \Poser\MockBuilder
	 */
	public function constants($constants){
		$this->constants = array_merge($this->constants, $constants);
		return $this;
	}
	
	/**
	 * Creates and returns the mock built by the builder
	 *
	 * @return mixed The mocked object
	 */
	public function mock() {
		$options = new MockOptions();
		$options->setDefaultAnswer($this->defaultAnswer);
		$options->setName($this->name);
		$options->setMockStatic($this->mockStatic);
		return $this->poserCore->mock($this->class, $options);
	}
}
