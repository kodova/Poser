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
	
	public function name($name) {
		$this->name = $name;
	}
	
	public function mockStatic($mockStatic){
		$this->mockStatic = $mockStatic;
	}
	
	/**
	 * Used to set the de
	 *
	 * @param Poser/Invocation/Answer $answer 
	 * @return void
	 */
	public function defaultAnswer(Answer $answer) {
		$this->defaultAnswer = $defaultAnswer;
	}
	
	public function mock() {
		$options = new MockOptions();
		$options->setDefaultAnswer($this->defaultAnswer);
		$options->setName($this->name);
		$options->setMockStatick($this->mockStatic);
		return $poserCore->mock($this->class, $options);
	}
}
