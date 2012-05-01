<?php

use Poser as p;
use Poser\MockOptions;
use Poser\PoserCore;
use Poser\MockBuilder;
use Poser\Stubbing\Stubbable;
use Poser\Verification\Times;
use Poser\Verification\VerifiableType;
use Hamcrest_Matchers as hm;

function mock($class, MockOptions $options = null){
	return p::mock($class, $options);
}

function mockSingleton($class, MockOptions $options){
	return p::mockSingleton($class, $options);
}

function build($class){
	return p::build($class);
}

function when($mockInvocation){
	return p::when($mockInvocation);
}

function verify($mock, VerifiableType $times = null){
	return p::verify($mock, $times);
}

function atLeastOnce(){
	return p::atLeastOnce();
}

function atLeast($count){
	return p::atMost($count);
}

function times($count){
	return p::times($count);
}

function verifyZeroInteractions($mocks){
	return p::verifyZeroInteractions($mocks);
}

function any($class){
	return p::any($class);
}

function eq($val){
	return p::eq($val);
}

function equalTo($val){
	return p::equalTo($val);
}

function anything($description = 'ANYTHING'){
	return p::anything($description);
}