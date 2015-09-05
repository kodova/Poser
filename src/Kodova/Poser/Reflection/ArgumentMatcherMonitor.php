<?php

namespace Kodova\Poser\Reflection;

use Hamcrest\Matcher;
use Kodova\Poser\DefaultReturnValues;
use Kodova\Poser\Exception\PoserException;
use SplDoublyLinkedList;

class ArgumentMatcherMonitor {
	/**
	 * @var SplDoublyLinkedList
	 */
	private $argumentList = null;
	/**
	 * @var DefaultReturnValues
	 */
	private $defaultReturnValues = null;
			
	function __construct() {
		$this->reset();
		$this->defaultReturnValues = new DefaultReturnValues();
	}
	
	public function reset() {
		$this->argumentList = new SplDoublyLinkedList(SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_KEEP);
	}

	
	public function pullMatchers() {
		$matchers = $this->argumentList;
		$this->reset();
		return $matchers;
	}
	
	public function validateState() {
		if (!$this->argumentList->isEmpty()) {
			throw new PoserException("Invalid state for argument matcher");
			/*
				TODO need to throw a real exception
			*/
		}
	}
	
	/**
	 * @param Matcher $matcher
	 * @return DefaultReturnValues
	 */
	public function reportMatcher(Matcher $matcher) {
		$this->argumentList->push($matcher);
		return $this->defaultReturnValues;
	}
}
