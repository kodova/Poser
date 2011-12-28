<?php

namespace Poser;

use Poser\Invocation\Answer as Answer;
use	Poser\Invocation\EmptyValueAnswer as EmptyValueAnswer;
use Poser\MockOptions as MockOptions;
use Poser\PoserCore as PoserCore;

class MockBuilder {
	
	private $name;
	private $defaultAnswer;
	private $mockStaic;
	private $poserCore;
	private $class;
	
	function __construct(PoserCore $poserCore, string $class) {
		$this->defaultAnswer = new EmptyValueAnswer();
		$this->name = null;
		$this->mockStaic = false;
		$this->poserCore = $poserCore;
		$this->class = $class;
	}
	
	/**
	 * A name used to uniquely identify the mock object. Can
	 * be used to retrieve the mock object at a later time.
	 *
	 * @param string $name 
	 * @return void
	 */
	public function name($name) {
		$this->name = $name;
	}
	
	/**
	 * Sets if the mock object will mock static calls. this
	 * should only be used when necessary since it limits other
	 * functionality
	 *
	 * @param bool $mockStatic 
	 * @return void
	 */
	public function mockStatic($mockStatic){
		$this->mockStatic = $mockStatic;
	}
	
	/**
	 * A convince method that will create a mock object and 
	 * set a static call to a given method that will return a
	 * instance of itself, a mock object
	 * 
	 * @param string $method the method that gets singleton instance. defaults to getInstance
	 * @return void
	 */
	public function mockSingleton($method = 'getInstance') {
		$mock = $this->mock()
		
		return $mock;
	}
	
	/**
	 * Used to set the default answer to non-stubbed calls
	 *
	 * @param Poser/Invocation/Answer $answer 
	 * @return void
	 */
	public function defaultAnswer(Answer $answer) {
		$this->defaultAnswer = $defaultAnswer;
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
		$options->setMockStatick($this->mockStatic);
		return $poserCore->mock($this->class, $options);
	}
}
