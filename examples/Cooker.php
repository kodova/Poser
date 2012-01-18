<?php 

interface Cooker{
	
	
	/**
	 * @param boolean $crispy
	 * @param array[bacon] $bacon
	 */
	public function cook($crispy, array $bacon); 
	
	
	/**
	 * Cleans the cooking itme
	 */
	public function clean();
	
	/**
	 * @return boolean
	 */
	public function isClean();
}