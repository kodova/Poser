<?php

namespace Poser\Verification;

use Poser\Verification\VerificationException;
use Poser\Invocation\Invocation;

class TimesException extends VerificationException{

	/**
	 * @var \Poser\Invocation\Invocation[]
	 */
	private $invocations = null;

	/**
	 * @var int
	 */
	private $expected;

	/**
	 * @param int $expected
	 * @param \Poser\Invocation\Invocation[] $invocations
	 */
	public function __construct($expected, $invocations){
		$this->invocations = $invocations;
		$this->expected = $expected;

		$total = sizeof($invocations);
		$message = "Expected to be invoked {$this->expected} times but was invoked $total times:";
		foreach($invocations as $invocation){
			$message .= "\n\t-> " . $invocation;
		}

		parent::__construct($message);
	}

}
