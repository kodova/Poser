<?php

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

	/**
	 * @var Cooker
	 */
	private $cooker = null;
	
	public function setUp(){
		$this->house = build('House')->mockStatic(true)->mock();
		$this->dog = mock('Dog');
		$this->cooker = mock('Cooker');
		$this->person = build('Person')->mockStatic(true)->constants(array('YES' => 0, 'NO' => 1))->mock();
		$this->flowchart = new Flowchart($this->house, $this->person, $this->dog);
	}
	
	public function tearDown(){
		$this->flowchart = null;
		$this->house = null;
		$this->person = null;
		$this->dog = null;
	}

	public function testWhatToEatWhenBacon(){
		when($this->person->wantsBacon())->thenReturn(true);
		
		$this->flowchart->whatToEat();
		
		verify($this->person, times(2))->write(anything());
	}
	
	public function testWhatToEatWhenNotBacon(){
		when($this->person->wantsBacon())->thenReturn(false);
	
		$this->flowchart->whatToEat();
	
		verify($this->person, times(3))->write(anything());
	}
	
	public function testCookBaconWhenLikesCrispy(){
		$bacon = array();
		when($this->house->getCooker())->thenReturn($this->cooker);
		when($this->person->likesCrispyBacon())->thenReturn(Person::YES);
		
		$this->flowchart->cookBacon();
		
		verify($this->cooker)->cook(true, array());
	}
	
}