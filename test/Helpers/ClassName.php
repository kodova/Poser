<?php

namespace Helpers;

/**
 * Used to create unique class names for testing
 *
 * @package default
 */
class ClassName {
	private static $count = 100;

	public static function getName($name = 'Foo') {
		return $name . self::$count++;
	}

}
