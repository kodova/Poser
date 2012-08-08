<?php

namespace Poser\Proxy\Generator;

use Poser\Exception\UndefinedPropertyException;

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

	/**
	 * Returns the declartion in string form that does not include
	 * the curly braces.
	 * <code>
     * class Foo exceeds Bar implements Fooable
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
	
	public function getType() {
		return $this->namespace . '\\' . $this->className;
	}

	public function getExtends() {
		return $this->extends;
	}

	public function setExtends($extends) {
		$this->extends = $extends;
	}

	public function getImplements() {
		return $this->implements;
	}

	public function getClassName() {
		return $this->className;
	}

	public function setClassName($className) {
		$this->className = $className;
	}

	public function getNamespace() {
		return $this->namespace;
	}

	public function setNamespace($namespace) {
		$this->namespace = $namespace;
	}
}
