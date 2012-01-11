<?php

namespace Poser\Invocation;

interface Invokable{
	
	/**
	 * Returns a instance of the mocked object that was invoked;
	 *
	 * @return mixed the object that has been mocked.
	 */
	public function getMock();
	
	/**
	 * Gets the mehtod name that was invoked
	 *
	 * @return Poser\Reflection\TypedMethod The method being invocked
	 */
	public function getMethod();
	
	/**
	 * Gets the arguments that where passed to the invocation
	 *
	 * @return array
	 */
	public function getArguments();
	
	/**
	 * Calls the real method of the class that is being mocked. This may
	 * throw exception from either the real method or if becuase the real
	 * class was not loaded for some mocks.
	 *
	 * @return mixed the value retuned from the real method
	 * @throws Exception
	 */
	public function callRealMethod();
	
}