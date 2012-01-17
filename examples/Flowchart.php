<?php 

class Flowchart extends OutputWriter{

	/**
	 * @var House
	 */
	private $house;
	
	/**
	 * @var Person;
	 */
	private $person;
	

	public function run(){
		if($this->person->isHungry()){
			$this->person->write("Im hungey");
			$this->whatToEat();	
		}else{
			return;
		}
	}
	
	
	public function whatToEat(){
		$this->person->write("What should I eat?");
		if ($this->person->wantsBacon()){
			
		}else{
			
		}
	}
	
}