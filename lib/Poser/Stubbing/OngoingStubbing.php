<?php

namespace Poser\Stubbing;

interface OngoingStubbing {
	
	/**
	 * Sets the value to be returned when the mothod is called. If more than 
	 * argument is supplied it will return the arguments in consecutive calls 
	 * in the order they appear as parameters.
	 *
	 * @param mixed $args a list of args to return.
	 * @return OngoingStubbing
	 */
	public function thenReturn($args);
	
	/**
	 * Sets the exeception that will be thrown when the method is invoked.
	 *
	 * @param Exception $exception 
	 * @return OngoingStubbing
	 */
	public function thenThrow(Exception $exception);
	
	/**
	 * Sets a generic answer to the invoked method
	 *
	 * @param Answer $answer 
	 * @return OngoingStubbing
	 */
	public function thenAnswer(Answer $answer);
	
	/**
	 * This is an alias for thenAnswer.
	 * @see OngoingStubbing::thenAnswer()
	 *
	 * @param Answer $answer 
	 * @return OngoingStubbing
	 */
	public function then(Answer $answer);
	
	
	/**
	 * Retuns the mock that was used for the stubbing.
	 *
	 * @return void
	 */
	public function getMock();
}
