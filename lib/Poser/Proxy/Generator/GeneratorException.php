<?php

namespace Poser\Proxy\Generator;

/**
 * An exception for runtime error when generation dynamic proxyies.
 *
 * @package default
 */
class GeneratorException extends \Exception {

	function __construct($message, Exception $e = null) {
		parent::__construct($message, 0, $e);
	}
}
