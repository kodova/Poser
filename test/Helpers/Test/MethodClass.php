<?php

namespace Helpers\Test;


class MethodClass {
	
	private final function privateFinalFoo(){
		return "private final foo";
	}
	
	private function privateFoo(){
		return 'private foo';
	}

	public function noArgsFoo() {
		return 'no args foo';
	}
	
	public function reqArgsFoo($bar, $message) {
		return 'req args foo';
	}
	
	public function optArgsFoo($bar = 'foo', $foo = 1, $message = null) {
		return 'opt args foo';
	}
	
	public function mixedArgsFoo($bar, $foo = 'bar') {
		return 'mixed args foo';
	}
	
	public function typeHintArgsFoo(FinalClass $finalClass, AbstractClass $abstractClass = null) {
		return 'typehint args foo';
	}
	
	public static function staticFoo(){
		return 'static foo';
	}
	
	public function __call($name, $args) {
		return "call";
	}
}

