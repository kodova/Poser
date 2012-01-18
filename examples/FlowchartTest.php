<?php

require_once '../lib/Poser.php';
require_once 'Bacon.php';
require_once 'Cooker.php';
require_once 'Dog.php';
require_once 'OutputWriter.php';
require_once 'Flowchart.php';
require_once 'HickoryBacon.php';
require_once 'Pan.php';
require_once 'Topper.php';

use Poser as p;

class FlowchartTest extends PHPUnit_Framework_TestCase{
	/**
	 * @var Flowchart
	 */	
	private $flowchart = null;

	/**
	 * @var House
	 */
	private $house = null;
	
	/**
	 * @var Person
	 */
	private $person = null;
	
	/**
	 * @var Dog
	 */
	private $dog = null;
	
	public function setUp(){
		$this->house = p::build('House')->mockStatic(true)->mock();
		$this->person = p::build('Person')->mockStatic(true)->mock();
		$this->dog = p::mock('Dog');
		
		$this->flowchart = new Flowchart($this->house, $this->person, $this->dog);
	}
	
	public function tearDown(){
		$this->flowchart = null;
		$this->house;
		$this->person;
		$this->dog;
	}
	
	public function testWhatToEatWhenBacon(){
		p::when($this->person->wantsBacon())->thenReturn(true);
		
		$this->flowchart->whatToEat();
		
		p::verify($this->person)->write(p::anything());
	}
	
}