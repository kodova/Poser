<?php 

namespace Poser\Verification;

use Poser\Invocation\Invocation;
use Poser\Invocation\InvocationContainer;

interface VerifiableType{
	
	public function verify(Invocation $mock, InvocationContainer $invocationContainer);
	
}