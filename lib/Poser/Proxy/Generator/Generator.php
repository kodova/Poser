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
	 * Returns a class definition that can be evaled into real class
	 *
	 * @return String
	 */
	public function generate();
}
