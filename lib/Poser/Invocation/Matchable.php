<?php

namespace Poser\Invocation;

use \Poser\Invocation\Invocation as Invocation;

interface Matchable {
	
	/**
	 * Returns true if the invocation matches the current object
	 *
	 * @param Invocation $invocation 
	 * @return bool
	 */
	public function matches(Invocation $invocation);

	
}