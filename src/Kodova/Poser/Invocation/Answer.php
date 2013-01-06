<?php

namespace Kodova\Poser\Invocation;

interface Answer{

	/**
	 * A interface that will used to answer to invoked mehtods stubbed calls
	 *
	 * @param Invocation $invocation 
	 * @return mixed The value to be retuned
	 */
	public function answer(Invocation $invocation);
}