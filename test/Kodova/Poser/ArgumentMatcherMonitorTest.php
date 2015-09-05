<?php

use Hamcrest\Matchers as hm;
use Kodova\Poser\Reflection\ArgumentMatcherMonitor;


class ArgumentMatcherMonitorTest extends PHPUnit_Framework_TestCase {

    /**
     * @var ArgumentMatcherMonitor null
     */
	private $argMonitor = null;
	
    public function setUp() {
		$this->argMonitor = new ArgumentMatcherMonitor();
    }
    
    public function tearDown() {
		$this->argMonitor = null;
    }

	public function testReportMatchers() {
		$this->argMonitor->reportMatcher(hm::nullValue());
		$this->argMonitor->reportMatcher(hm::anything());
		
		$matchers = $this->argMonitor->pullMatchers();
		$this->assertEquals(2, $matchers->count(), 'The number of matchers set don not equal the number of matchers pulled');
	}

	public function testPullMatchers() {
	    $this->argMonitor->reportMatcher(hm::nullValue());
		$this->argMonitor->reportMatcher(hm::anything());
		
		$matchers = $this->argMonitor->pullMatchers();
		$this->assertEquals(2, $matchers->count(), 'The number of matchers set don not equal the number of matchers pulled');
		//verify the order of the matchers.
		$this->assertTrue(is_a($matchers[0], \Hamcrest\Core\IsNull::class), 'the matchers are out of order');
		$this->assertTrue(is_a($matchers[1], \Hamcrest\Core\IsAnything::class), 'the matchers are out of order');
	}
	
	public function testReset() {
		$this->argMonitor->reportMatcher(hm::nullValue());
		$this->argMonitor->reportMatcher(hm::anything());
		
		$this->argMonitor->reset();
		
		$matchers = $this->argMonitor->pullMatchers();
		$this->assertEquals(0, $matchers->count(), 'Matchers should be empty after reset');
	}
	
	public function testValidateState() {
	    $this->argMonitor->reportMatcher(hm::nullValue());
		$this->argMonitor->reportMatcher(hm::anything());
		
		$this->argMonitor->reset();
		$this->argMonitor->validateState();
	}
	
	/**
	 * @expectedException Kodova\Poser\Exception\PoserException
	*/
	public function testNotValidateDateDueToMatchersExisting() {
	    $this->argMonitor->reportMatcher(hm::nullValue());
		$this->argMonitor->reportMatcher(hm::anything());
		
		$this->argMonitor->validateState();
	}
}