<?php

class SingletonClass {

	private static $instance = null;

	private $foo = null;

	private function __construct(){
		$this->foo = "bar";
	}

	/**
	 * @static
	 * @return SingletonClass
	 */
	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new SingletonClass();
		}

		return self::$instance;
	}

	public function getFoo() {
		return $this->foo;
	}

}
