<?php

abstract class OutputWriter{
	
	abstract function getName();
	
	public function write($message){
		$name = $this->getName();
		echo sprintf("%s: %s/n", $name, $message);
	}
	
}