<?php

namespace Poser\Proxy\Generator;

/**
 * A generic representation of a class generator that will create a
 * class definition.
 *
 * @package default
 */
interface Generator{
	
	/**
	 * Returns a object that is a proxy for a type
	 *
	 * @return mixed
	 */
	public function generate();
}
