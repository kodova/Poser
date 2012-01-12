<?php

namespace Poser\Invocation;

interface Matchable extends Invokable{
	
	/**
	 * Returns true if the invocation matches the current object
	 *
	 * @param Invocation $invocation 
	 * @return bool
	 */
	public function matches(Matchable $invocation);
}