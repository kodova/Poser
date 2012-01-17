<?php 

class Oven implements Cooker{
	
	public function cook(){
		//apply heat
	}
	
	public function requireFlipping(){
		return false;
	}
	
}