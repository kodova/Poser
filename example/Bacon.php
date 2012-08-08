<?php 

interface Bacon{
	
	/**
	 * The thickness of the bacon
	 * @return float 
	 */
	public function getThickness();
	
	/**
	 * The flavor of the bacon
	 * @return string
	 */
	public function flavor();
}