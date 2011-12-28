<?php

namespace Poser\Proxy;


class ObjectCache {
	
	private $type = array();
	private $name = array();
	
	public function lookupByName($name) {
		if(isset($this->name[$name])){
			return $this->name[$name];
		}
		return null;
	}
	
	public function lookupByType($type) {
		if (isset($this->type[$type])) {
			return $this->type[$type];
		}
		return null;
	}
	
	public function add($name, $obj){
		$class = new ReflectionClass($obj);
		$type = $class->getName();
		$this->type[$type] = $obj;
		$this->name[$name] = $obj;
	}
}
