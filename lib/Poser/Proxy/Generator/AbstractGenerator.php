<?php

namespace Poser\Proxy\Generator;


abstract class AbstractGenerator {
	
	/**
	 * The class to be mocked
	 *
	 * @var \ReflectionClass
	 */
	private $toMock;

	/**
	 * @param string $toMock The class that needs to be mocked
	 */
	function __construct($toMock) {
		$this->toMock = new \ReflectionClass($toMock);
	}
	
	/**
	 * Gets a Class Declaration to the proxy being generated
	 *
	 * @return Poser\Proxy\Generator\ClassDeclaration
	 */
	abstract function getClassDeclaration();
	
	/**
	 * The methods that need to be proxied
	 *
	 * @return array[ReflectionMethod]
	 */
	abstract function getMethodsToProxy();

	
	public function generate() {
		$proxiedMethods = $this->generateProxyMethdos();
		$proxyHandler = $this->generateProxyHandler();
		$declaration = $this->getClassDeclaration()->getDeclaration();
		$constructor = $this->generateConstructor();
		return "
			$declaration {
				$constructor
				
				$proxyHandler
				
				$proxiedMethods
			}";
	}
	
	private function generateProxyMethdos(){
		$methods = $this->getMethodsToProxy();
		$output = '';
		foreach($methods as $method){	
			$name = $method->getName();
			$params = $this->generateMethodParameters($method);
			$output .= "
				public function $name($params) {
					\$this->__call('$name', func_get_args());
				}\n";
		}
		return $output;
	}
	
	private function generateMethodParameters(\ReflectionMethod $method) {
		$params = $method->getParameters();
		$output = array();
		foreach($params as $param){
			try {
				$class = $param->getClass();
				$type = ( $class == null ) ? '' : $class->getName();
			} catch (ReflectionException $e) {
				$type = '';
			}
			$name = $param->name;
			$output[] = ($param->isOptional()) ? "$type \$$name = null" : "$type \$$name";
		}
		return implode(', ', $output);
	}
	
	private function generateConstructor() {
		$constructor = $this->toMock->getConstructor();
		if ($constructor == null) {
			return;
		}
		if ($constructor->getNumberOfParameters() > 0) {
			throw new GeneratorException('An empty contructor is required to create a proxy that extends an existing class.');
		}
		
		return "
				function __construct() {
					parent::__construct();
				}
		";
	}
	
	private function generateProxyHandler(){
		return "
				public function __call(\$method, \$args) {
					/*
						TODO Need to complete this
					*/
				}\n";
	}
		
	protected function getToMock(){
		return $this->toMock;
	}
}
