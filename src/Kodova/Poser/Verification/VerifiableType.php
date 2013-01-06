<?php 

namespace Kodova\Poser\Verification;

use Kodova\Poser\Invocation\Invocation;
use Kodova\Poser\Invocation\InvocationContainer;

interface VerifiableType{
	
	public function verify(Invocation $mock, InvocationContainer $invocationContainer);
	
}