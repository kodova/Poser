<?php 

interface Cooker{
	
	public function cook(); 
	
	/**
	 * @return boolean
	 */
	public function requireFlipping();
	
}