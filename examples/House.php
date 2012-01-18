<?php

class House{
	
	/**
	 * @var array[Bacon]
	 */
	private $baconStock = array();
	
	/**
	 * @var Cooker
	 */
	private $cooker = null;
	
	public function __construct(Cooker $cooker, $baconStock){
		$this->cooker = $cooker;
		$this->baconStock = $baconStock;
	}
		
	public function baconInStock(){
		return (sizeof($this->baconStock) > 0);
	}
	
	/**
	 * @param integer $amount
	 * @return array
	 */
	public function getRawBacon($amount){
		if($amount > $this->baconStock){
			throw new Exception("Not enough bacon", 1);
		}
		
		$portion = array_slice($this->baconStock, 0, $amount);
		$this->baconStock = array_slice($this->baconStock, 0, sizeof($this->baconStock) - $amount);
		return $portion;
	}
	
	/**
	 * @param array[Bacon] $bacon
	 */
	public function stockRawBacon($bacon){
		$this->baconStock = array_merge($this->baconStock , $bacon);
	}

	/**
	 * @return Cooker
	 */
	public function getCooker(){
		return $this->cooker;
	}
}