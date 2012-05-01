<?php

namespace Poser\Verification;

use Poser\Invocation\Matchable;

use Poser\Invocation\Invocation;

use Poser\Invocation\InvocationContainer;

use Poser\Exception\PoserException;

class Times implements VerifiableType{
	
	protected $wantedCount;
	
	/**
	 * @param integer $count
	 */
	public function __construct($count){
		if($count < 0){
			throw new PoserException("You can not have a negative value for invocation counts");
		}
		$this->wantedCount = $count;
	}
	
	/**
	 * @param \Poser\Invocation\Invocation $wanted
	 * @param \Poser\Invocation\InvocationContainer $invocationContainer
	 * @throws \Poser\Exception\PoserException
	 */
	public function verify(Invocation $wanted, InvocationContainer $invocationContainer){
		$invocations = $invocationContainer->getInvocations(function(Matchable $invocation) use ($wanted){
			return $wanted->matches($invocation);
		});

		$actual = sizeof($invocations);
		if ($this->wantedCount < $actual){
			throw new PoserException(sprintf("The method %s was invoked %d times when %d was expected", $wanted->getMethodName(), $actual, $this->wantedCount));
		}elseif ($this->wantedCount == 0 && $actual > 0){
			throw new PoserException(sprintf("The method %s was invoked when it never should have been", $wanted->getMethodName()));
		}elseif ($this->wantedCount > $actual){
			throw new PoserException(sprintf("The method %s was only invoked %d times when it should have been %d", $wanted->getMethodName(), $actual, $this->wantedCount));
		}
	}
	
	
	
	public function __toString(){
		return "Wanted invocations count: " . $this->wantedCount;
	}
}