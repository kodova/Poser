<?php

namespace Poser\Proxy\Generator;

/**
 * Represents a declaration in a object form
 */
class ClassDeclaration {
	
	private $extends = null;
	private $implements = array();
	private $className = null;
	private $namespace = null;
	
	public function setImplements(array $implements) {
		$this->implements = $implements;
	}
	
	public function __call($name, $args) {
		//get the property name
		$property = substr($name, 3);
		$property[0] = strtolower($property[0]);
		
		//get the prefix
		if (strstr($name, 'get')) {
			return $this->$property;
		} elseif (strstr($name, 'set')) {
			$arg = isset($args[0]) ? $args[0] : null;
			$this->$property = $arg;
		} else {
			throw new \Poser\Exception\UndefinedPropertyException($property, get_class());
		}
	}
	
	/**
	 * Returns the declartion in string form that does not include
	 * the curly braces.
	 * <code>
     * class Foo extneds Bar implements Fooable
     * </code>
	 * @return string
	 */
	public function getDeclaration() {
		$dec = 'class ' . $this->className;
		if ($this->extends != null) {
			$dec .= ' extends ' . $this->extends;
		}
		if (sizeof($this->implements) > 0) {
			$dec .= ' implements ' . implode(', ', $this->implements);
		}
		return $dec;
	}
}
