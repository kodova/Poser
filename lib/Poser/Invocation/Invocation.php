<?php

namespace Poser\Invocation;	

use Poser\Exception\PoserException;
use Poser\Reflection\TypedMethod;
use SplDoublyLinkedList;
use Poser\Proxy\SubstituteProxy;

class Invocation implements Invokable, Matchable {
	
	/**
	 * @var mixed
	 */
	private $mock;
	/**
	 * @var array
	 */
	private $arguments;
	/**
	 * @var SplDoublyLinkedList
	 */
	private $matchers;
	/**
	 * @var TypedMethod
	 */
	private $method;
	/**
	 * @var string
	 */
	private $methodName;
	/**
	 * @var array
	 */
	private $stackTrace;

	/**
	 *
	 *
	 * @param mixed $mock
	 * @param string $method
	 * @param array $args
	 * @param SplDoublyLinkedList $matchers
	 * @param $stackTrace
	 */
	function __construct($mock, $method, $args, SplDoublyLinkedList $matchers, $stackTrace) {
		$this->mock = $mock;
		$this->arguments = $args;
		$this->matchers = $matchers;
		$this->methodName = $method;
		$this->stackTrace = $stackTrace;
		
		if (is_a($mock, 'Poser\Proxy\SubstituteProxy')) {
			$this->method = null;
		} else {
			$class = new \ReflectionClass($mock);
			$this->method =  new \Poser\Reflection\TypedMethod($class->getName(), $method);
		}
	}

	/**
	 * @return mixed
	 */
	public function getMock(){
		return $this->mock;
	}

	/**
	 * @return null|\Poser\Reflection\TypedMethod
	 */
	public function getMethod(){
		return $this->method;
	}


	/**
	 * @return string
	 */
	public function getMethodName(){
		return $this->methodName; 
	}


	/**
	 * @return array
	 */
	public function getArguments(){
		return $this->arguments;
	}


	/**
	 *
	 */
	public function callRealMethod(){
		/*
			TODO Need to implement this method
		*/
	}

	/**
	 * @param Matchable $invocation
	 * @return bool
	 * @throws \Poser\Exception\PoserException
	 */
	public function matches(Matchable $invocation){
		//if not the same mock then they do not match
		if (!$this->mock->equals($invocation->getMock()) || $this->getMethodName() != $invocation->getMethodName() || sizeOf($this->getArguments()) != sizeOf($invocation->getArguments())) {
			return false;
		}
		
		if ($this->matchers != null && $this->matchers->count() > 0) {
			$matchers = $this->matchers;

			if ($this->mock instanceof SubstituteProxy) {
				if (sizeof($this->arguments) != sizeof($this->matchers)) {
					throw new PoserException("You need to matchers for all required parameters");
				}
			} else {
				$requiredCount = $this->getMethod()->getNumberOfRequiredParameters();
				if ($requiredCount > $matchers->count()) {
					throw new PoserException("You need to matchers for all required parameters");
				}
			}

			$argsToMatch = $invocation->getArguments();
			for ($i = 0; $i < $matchers->count(); $i++) {
				$matcher = $matchers[$i];
				$argument = $argsToMatch[$i];
				if (!$matcher->matches($argument)) {
					return false;
				}
			}
			return true;
		} else { //match exact args only
			$argsA = $this->getArguments();
			$argsB = $invocation->getArguments();

			for ($i = 0; $i < sizeof($argsA); $i++) {
				$argA = $argsA[$i];
				$argB = $argsB[$i];
				if ($argA != $argB) {
					return false;
				}
			}
			return true;
		}
	}

	/**
	 *
	 */
	public function markStubbed(){
		//TODO need to implement this
	}

	/**
	 * @return array
	 */
	public function getStackTrace() {
		return $this->stackTrace;
	}

	function __toString() {
		$call = $this->stackTrace[2];
		$text = sprintf("%s#%s line %d", $call['class'], $call['function'], $call['line']);
		return $text;
	}
}
