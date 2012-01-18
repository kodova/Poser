<?php

class Topper implements Dog{
	
	/**
	 * (non-PHPdoc)
	 * @see Dog::wantsBacon()
	 */
	public function wantsBacon(){
		return (boolean) rand(0, 1);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Dog::getName()
	 */
	public function getName(){
		return "Topper";
	}
	
}