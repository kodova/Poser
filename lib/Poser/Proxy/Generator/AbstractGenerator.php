<?php

namespace Poser\Proxy\Generator;


abstract class AbstractGenerator implements Generator{
	
	/**
	 * The class to be mocked
	 *
	 * @var \ReflectionClass
	 */
	private $toMock;
	
	/**
	 * The type of class to generate
	 *
	 * @var string
	 */
	protected $mockType;

	/**
	 * @param string $toMock The class that needs to be mocked
	 */
	function __construct($toMock) {
		$this->mockType = $toMock;
	}
	
	/**
	 * Gets a Class Declaration to the proxy being generated
	 *
	 * @return ClassDeclaration
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
		$classDeclaration = $this->getClassDeclaration();
		$declaration = $classDeclaration->getDeclaration();
		$namepace = (null != $classDeclaration->getNamespace()) ? "namespace {$classDeclaration->getNamespace()};" : '';
		$classType = $classDeclaration->getType();
		
		$classDef = "
			$namepace
		
			$declaration {
				$proxyHandler
				
				$proxiedMethods
				
			}";
		eval($classDef);
		return new $classType();
	}
	
	private function generateProxyMethdos(){
		$methods = $this->getMethodsToProxy();
		$output = '';
		foreach($methods as $method){	
			$name = $method->getName();
			$params = $this->generateMethodParameters($method);
			$output .= "
				public function $name($params) {
					return \$this->__call('$name', func_get_args());
				}\n";
		}
		return $output;
	}
	
	private function generateMethodParameters(\ReflectionMethod $method) {
		$params = array();
		foreach($method->getParameters() as $param){
			$passByRef = ($param->isPassedByReference()) ? '&' : '';
			$typeClass = $param->getClass();
			$typeHint = (null != $typeClass) ? $typeClass->getName() : '';
			$name = $param->getName();
			$default = '';
			if ($param->isDefaultValueAvailable()) {
				$defaultValue = ($param->getDefaultValue() == null) ? 'null' : $param->getDefaultValue();
				$default = "= $defaultValue";
			}
			$params[] = "$typeHint $passByRef\$$name $default";
		}
		return implode(', ', $params);
	}
	
	private function generateProxyHandler(){
		$id = uniqid();
		
		return "
				private \$proxy;
				private \$id = '$id';
				
				public function setProxy(\$proxy) {
					\$this->proxy = \$proxy;
				}
				
				public function getProxy() {
					return \$this->proxy;
				}
		
				public function __call(\$method, \$args) {
					return \$this->proxy->handle(\$method, \$args);
				}\n
				
				public function getId() {
					return \$this->id;
				}
				
				public function equals(\$object) {
					return (is_a(\$object, __CLASS__) && \$object->getId() == \$this->getId());
				}
		";
	}
		
	protected function getToMock(){
		//need to lazy load this. when creating new classes we need not to laod the existing class
		if($this->toMock == null){
			$this->toMock = new \ReflectionClass($this->mockType);
		}
		
		return $this->toMock;
	}
	
	protected function getProxyName($type) {
		$parts = explode('\\', $type);
		return end($parts) . '_Poser' . uniqid();
	}
}
