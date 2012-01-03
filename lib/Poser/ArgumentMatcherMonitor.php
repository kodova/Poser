<?php

namespace Poser;

use Hamcrest_Matcher;
use SplDoublyLinkedList;

class ArgumentMatcherMonitor {
	
	private $argumentList = null;
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
			throw new Exception\PoserException("Invalid state for argument matcher");
			/*
				TODO need to throw a real exception
			*/
		}
	}
	
	public function reportMatcher(Hamcrest_Matcher $matcher) {
		$this->argumentList->push($matcher);
		return $this->defaultReturnValues;
	}
}
