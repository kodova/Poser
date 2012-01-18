<?php 

class Pan implements Cooker{
	
	/**
	 * @var boolean
	 */
	private $clean = false;
	
	public function __construct(){
		$this->clean = (boolean) rand(0, 1);
	}
	
	public function isClean(){
		return $this->clean;
	}
	
	public function clean(){
		$this->clean = true;
	}
	
	public  function cook($crispy, array $bacon){
		//cook the bacon
	} 
	
}