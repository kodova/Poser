<?php

namespace Kodova\Poser\Invocation;

interface Matchable extends Invokable{

	/**
	 * Returns true if the invocation matches the current object
	 *
	 * @param \Kodova\Poser\Invocation\Invocation|\Kodova\Poser\Invocation\Matchable $invocation
	 * @return bool
	 */
	public function matches(Matchable $invocation);
}