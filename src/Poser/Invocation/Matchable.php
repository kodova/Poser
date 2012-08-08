<?php

namespace Poser\Invocation;

interface Matchable extends Invokable{

	/**
	 * Returns true if the invocation matches the current object
	 *
	 * @param \Poser\Invocation\Invocation|\Poser\Invocation\Matchable $invocation
	 * @return bool
	 */
	public function matches(Matchable $invocation);
}