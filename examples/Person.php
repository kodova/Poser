<?php 

class Person extends OutputWriter{
	
	private $name;
	
	public function __construct($name){
		$this->name = $name;
	}
	
	/**
	 * @return boolean
	 */
	public function isHungry(){
		return true;
	}
	
	/**
	 * @return boolean
	 */
	public function wantBancon(){
		$val = rand(1, 0);
		return (boolean) $val; 
	}

	/**
	 * (non-PHPdoc)
	 * @see OutputWriter::getName()
	 */
	public function getName(){
		return $this->name;
	}	
}