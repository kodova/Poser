<?php

namespace Poser;

use Poser\Invocation\Answer as Answer;


class MockOptions {
	
	/**
	 * @var Poser/Invocation/Answer
	 */
	private $defaultAnswer;
	
	/**
	 * @var string Unique name for the mock
	 */
	private $name = null;
	
	/**
	 * Can static methods be mocked
	 * @var bool
	 */
	private $mockStatic = false;
	
	/**
	 * Gets the default answer for unstubbed methods.
	 *
	 * @return void
	 */
	public function getDefaultAnswer() {
		return $this->defaultAnswer();
	}
		
	/**
	 * Sets the default answer for unstubbed methods. Will be
	 * defaulted to /Poser/Invocation/EmptyValueAnswer
	 *
	 * @param string $defaultAnswer 
	 * @return void
	 */
	public function setDefaultAnswer(Answer $defaultAnswer) {
		$this->defaultAnswer = $defaultAnswer;
	}
	
	/**
	 * Gets the name that has been assigned to the mock by the user.
	 *
	 * @return string the name of the mock or null if the name has not be set.
	 */
	public function getName() {
		return $this->name();
	}

	/**
	 * Sets a name for the mock. This name can be used to look up
	 * the same instance of the mock by using this name.
	 *
	 * @param string $name 
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * Indicates if the mock object can mock static methods
	 *
	 * @return bool
	 */
	public function canMockStatic() {
		return $this->mockStatic();
	}
		
	/**
	 * Sets a flag that will configure the mock so it can stub static alls. This
	 * should only be used when need as you can not call real methods on the mocked
	 * class if this is set to true.
	 *
	 * @param bool $mockStatic 
	 * @return void
	 */
	public function setMockStatic($mockStatic) {
		$this->mockStatic = $mockStatic;
	}
	
}
