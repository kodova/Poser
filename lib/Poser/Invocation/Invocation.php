<?php

namespace Poser\Invocation;	


class Invocation implements Invokable, Matchable {
	
	private $mock;
	private $arguments;
	private $matchers;
	
	function __construct($mock, $method, $args, $matchers) {
		$this->mock = $mock;
		$this->arguments = $args;
		$this->matchers = $matchers;
		
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
	

	public function getMethod(){
		return $this->method;
	}
	

	public function getArguments(){
		return $this->arguments;
	}
	

	public function callRealMethod(){
		/*
			TODO Need to implement this method
		*/
	}
	
	public function matches(Invocation $invocation){
		
	}
}
