<?php

namespace Kodova\Poser\Invocation;

use Kodova\Poser\Exception\PoserException;
use Kodova\Poser\Reflection\TypedMethod;
use SplDoublyLinkedList;
use Kodova\Poser\Proxy\SubstituteProxy;
use ReflectionClass;

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
	 * @var boolean
	 */
	private $stubbed = false;

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
		
		if (is_a($mock, 'Kodova\Poser\Proxy\SubstituteProxy')) {
			$this->method = null;
		} else {
			$class = new ReflectionClass($mock);
			$this->method =  new TypedMethod($class->getName(), $method);
		}
	}

	/**
	 * @return mixed
	 */
	public function getMock(){
		return $this->mock;
	}

	/**
	 * @return null|TypedMethod
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
		//TODO need to implement this
	}

	/**
	 * @param Matchable $invocation
	 * @return bool
	 * @throws PoserException
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
		$this->stubbed = true;
	}

	/**
	 * @return array
	 */
	public function getStackTrace() {
		return $this->stackTrace;
	}

	public function wasStubbed(){
		return $this->stubbed;
	}

	function __toString() {
		$call = $this->stackTrace[2];
		$text = sprintf("%s#%s line %d", $call['class'], $call['function'], $call['line']);
		for($i = 3; $i < sizeof($this->stackTrace); $i++){
			$call = $this->stackTrace[$i];
			$line = (isset($call['line'])) ? $call['line'] : "<unknown line>";
			$text .= sprintf("\n\t\t%s#%s line %d", $call['class'], $call['function'], $line);
		}
		return $text;
	}
}
