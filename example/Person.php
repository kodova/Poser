<?php 

class Person extends OutputWriter{
	
	const YES = "0";
	const NO = "1";
	const MAYBE = "2";
	
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
	public function wantsBacon(){
		$val = rand(0, 1);
		return (boolean) $val; 
	}

	/**
	 * (non-PHPdoc)
	 * @see OutputWriter::getName()
	 */
	public function getName(){
		return $this->name;
	}

	public function cleanPan(){
		//do some cleaning
	}
	
	/**
	 * @return boolean
	 */
	public function wearingPants(){
		return (boolean) rand(0, 1);
	}
	
	public function putPantsOn($color){
		//get some pants of a color and put them on
	}
	
	/**
	 * @return number
	 */
	public function likesCrispyBacon(){
		return rand(0, 2);
	}

	public function cleanCooker(Cooker $cooker){
		$cooker->clean();
	}
	
	public function giveSomeToDog(){
		return (boolean) rand(0, 1);
	}
}