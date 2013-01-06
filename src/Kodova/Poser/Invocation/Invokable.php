<?php

namespace Kodova\Poser\Invocation;

use Exception;

interface Invokable{
	
	/**
	 * Returns a instance of the mocked object that was invoked;
	 *
	 * @return mixed the object that has been mocked.
	 */
	public function getMock();
	
	/**
	 * Gets the method that was invoked
	 *
	 * @return \Kodova\Poser\Reflection\TypedMethod The method being invoked
	 */
	public function getMethod();
	
	/**
	 * Gets the method name that was invoked
	 * 
	 * @return string
	 */
	public function getMethodName();
	
	/**
	 * Gets the arguments that where passed to the invocation
	 *
	 * @return array
	 */
	public function getArguments();
	
	/**
	 * Calls the real method of the class that is being mocked. This may
	 * throw exception from either the real method or if because the real
	 * class was not loaded for some mocks.
	 *
	 * @return mixed the value returned from the real method
	 * @throws Exception
	 */
	public function callRealMethod();
	
}