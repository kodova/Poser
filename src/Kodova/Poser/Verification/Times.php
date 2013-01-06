<?php

namespace Kodova\Poser\Verification;

use Kodova\Poser\Invocation\Matchable;

use Kodova\Poser\Invocation\Invocation;

use Kodova\Poser\Invocation\InvocationContainer;

use Kodova\Poser\Exception\PoserException;

class Times implements VerifiableType{
	
	protected $wantedCount;

	/**
	 * @param int $count
	 * @throws \Kodova\Poser\Exception\PoserException
	 */
	public function __construct($count){
		if($count < 0){
			throw new PoserException("You can not have a negative value for invocation counts");
		}
		$this->wantedCount = $count;
	}

	/**
	 * @param \Kodova\Poser\Invocation\Invocation $wanted
	 * @param \Kodova\Poser\Invocation\InvocationContainer $invocationContainer
	 * @throws TimesException
	 */
	public function verify(Invocation $wanted, InvocationContainer $invocationContainer){
		$invocations = $invocationContainer->getInvocations(function(Invocation $invocation) use ($wanted){
			if($invocation->wasStubbed()){
				return false;
			}
			return $wanted->matches($invocation);
		});

		$actual = sizeof($invocations);
		if ($this->wantedCount == 0 && $actual > 0){
			throw new TimesException($this->wantedCount, $invocations);
		}elseif ($this->wantedCount < $actual){
			throw new TimesException($this->wantedCount, $invocations);
		}elseif ($this->wantedCount > $actual){
			throw new TimesException($this->wantedCount, $invocations);
		}
	}
	
	
	
	public function __toString(){
		return "Wanted invocations count: " . $this->wantedCount;
	}
}