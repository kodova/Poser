<?php

use Poser as p;
use Poser\MockOptions;
use Poser\PoserCore;
use Poser\MockBuilder;
use Poser\Stubbing\Stubbable;
use Poser\Verification\Times;
use Poser\Verification\VerifiableType;
use Hamcrest_Matchers as hm;

/**
 * @see Poser::mock()
 * @param $class
 * @param Poser\MockOptions $options
 * @return mixed
 */
function mock($class, MockOptions $options = null){
	return p::mock($class, $options);
}

/**
 * @see Poser::mockSingleton()
 * @param $class
 * @param Poser\MockOptions $options
 * @return mixed
 */
function mockSingleton($class, MockOptions $options){
	return p::mockSingleton($class, $options);
}

/**
 * @see Poser::build()
 * @param $class
 * @return Poser\MockBuilder
 */
function build($class){
	return p::build($class);
}

/**
 * @see Poser::when()
 * @param $mockInvocation
 * @return Poser\Stubbing\Stubbable
 */
function when($mockInvocation){
	return p::when($mockInvocation);
}

/**
 * @see Poser::verify()
 * @param $mock
 * @param Poser\Verification\VerifiableType $times
 * @return mixed
 */
function verify($mock, VerifiableType $times = null){
	return p::verify($mock, $times);
}

/**
 * @see Poser::atLeastOnce()
 * @return Poser\Verification\Times
 */
function atLeastOnce(){
	return p::atLeastOnce();
}

/**
 * @see Poser::atLeast()
 * @param $count
 */
function atLeast($count){
	return p::atMost($count);
}

/**
 * @see Poser::times()
 * @param $count
 * @return Poser\Verification\Times
 */
function times($count){
	return p::times($count);
}

/**
 * @see Poser::once()
 * @return Poser\Verification\Times
 */
function once(){
	return p::times(1);
}

/**
 * @see Poser::verifyZeroInteractions()
 * @param $mocks
 */
function verifyZeroInteractions($mocks){
	p::verifyZeroInteractions($mocks);
}

/**
 * @see Poser::any()
 * @param $class
 * @return null
 */
function any($class){
	return p::any($class);
}

/**
 * @see Poser::eq()
 * @param $val
 * @return null
 */
function eq($val){
	return p::eq($val);
}

/**
 * @see Poser::equalTo()
 * @param $val
 * @return null
 */
function equalTo($val){
	return p::equalTo($val);
}

/**
 * @see Poser::anything()
 * @param string $description
 * @return null
 */
function anything($description = 'ANYTHING'){
	return p::anything($description);
}

/**
 * @see Poser::anArray()
 * @return array
 */
function anArray(){
	return p::anArray();
}

/**
 * @see Poser::hasKey()
 * @param $key
 * @return array
 */
function hasKey($key){
	return p::hasKey($key);
}

/**
 * @see Poser::hasEntry()
 * @param $key
 * @param $value
 * @return array
 */
function hasEntry($key, $value){
	return p::hasEntry($key, $value);
}

/**
 * @see Poser::emptyArray()
 * @return array()
 */
function emptyArray(){
	return p::emptyArray();
}

/**
 * @see Poser::not()
 * @param $value
 * @return null
 */
function not($value){
	return p::not($value);
}