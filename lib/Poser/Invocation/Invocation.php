<?php

namespace Poser\Invocation;	

use Poser\Exception\PoserException;

use Poser\Reflection\TypedMethod;
use SplDoublyLinkedList;

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
	 * 
	 * 
	 * @param mixed $mock
	 * @param string $method
	 * @param array $args
	 * @param SplDoublyLinkedList $matchers
	 */
	function __construct($mock, $method, $args, SplDoublyLinkedList $matchers) {
		$this->mock = $mock;
		$this->arguments = $args;
		$this->matchers = $matchers;
		$this->methodName = $method;
		
		if (is_a($mock, 'Poser\Proxy\SubstituteProxy')) {
			$this->method = null;
		} else {
			$class = new \ReflectionClass($mock);
			$this->method =  new \Poser\Reflection\TypedMethod($class->getName(), $method);
		}
	}
	
	public function getMock(){
		return $this->mock;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Poser\Invocation.Invokable::getMethod()
	 */
	public function getMethod(){
		return $this->method;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Poser\Invocation.Invokable::getMethodName()
	 */
	public function getMethodName(){
		return $this->methodName; 
	}

	/**
	 * (non-PHPdoc)
	 * @see Poser\Invocation.Invokable::getArguments()
	 */
	public function getArguments(){
		return $this->arguments;
	}
	

	public function callRealMethod(){
		/*
			TODO Need to implement this method
		*/
	}
	
	public function matches(Matchable $invocation){
		//if not the same mock then they do not match
		if (!$this->mock->equals($invocation->getMock()) || $this->getMethodName() != $invocation->getMethodName() || sizeOf($this->getArguments()) != sizeOf($invocation->getArguments())) {
			return false;
		}
		
		if ($this->matchers != null && $this->matchers->count() > 0){
			$matchers = $this->matchers;
			
			if(is_a($this->mock, "\Poser\Proxy\SubstituteProxy")){
				if(sizeof($this->arguments) != sizeof($this->matchers)){
					throw new PoserException("You need to matchers for all required parameters");
				}
			}else{
				$requiredCount = $this->getMethod()->getNumberOfRequiredParameters();
				if ($requiredCount > $matchers->count()) {
					throw new PoserException("You need to matchers for all required parameters");
				}
			}
			
			$argsToMatch = $invocation->getArguments();
			for ($i = 0; $i < $matchers->count(); $i++){
				$matcher = $matchers[$i];
				$argument = $argsToMatch[$i];
				if(!$matcher->matches($argument)){
					return false;
				}
			}
			return true;			
		}else{ //match exact args only
			$argsA = $this->getArguments();
			$argsB = $invocation->getArguments();
			
			for($i = 0; $i < sizeof($argsA); $i++){
				$argA = $argsA[$i];
				$argB = $argsB[$i];
				if ($argA != $argB){
					return false;
				}
			}
			return true;
		}
	}
	
	public function markStubbed(){
		//TODO need to implement this
	}
}
