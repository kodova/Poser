<?php

use \Poser\Proxy\Generator\GeneratorFactory as GeneratorFactory;
use \Poser\MockOptions as MockOptions;
    
class GeneratorFactoryTest extends PHPUnit_Framework_TestCase {
    
    private $generatorFactory;
    
    public function setUp() {
        $this->generatorFactory = new GeneratorFactory();
    }
    
    public function tearDown() {
        $this->generatorFactory = null;
    }
    
    public function testGetGeneratorForInterfaceClass(){
        $toMock = 'Helpers\Test\InterfaceClass';
        $options = new MockOptions();
        
        $generator = $this->generatorFactory->getGenerator($toMock, $options);
        
        $this->assertTrue(is_a($generator, 'Poser\Proxy\Generator\InterfaceGenerator'));
    }
    
    public function testGetGeneratorForAbstractClass(){
        $toMock = 'Helpers\Test\AbstractClass';
        $options = new MockOptions();
        
        $generator = $this->generatorFactory->getGenerator($toMock, $options);
        
        $this->assertTrue(is_a($generator, 'Poser\Proxy\Generator\ExtendedGenerator'));
    }
    
    public function testGetGeneratorForConcreteClass(){
        $toMock = 'Helpers\Test\MethodClass';
        $options = new MockOptions();
        
        $generator = $this->generatorFactory->getGenerator($toMock, $options);
        
        $this->assertTrue(is_a($generator, 'Poser\Proxy\Generator\ExtendedGenerator'));
    }
    
    public function testGetGeneratorForStaticMocks(){
        $toMock = 'Helpers\Test\MethodClass';
        $options = new MockOptions();
        $options->setMockStatic(true);
        
        $generator = $this->generatorFactory->getGenerator($toMock, $options);
        
        $this->assertTrue(is_a($generator, 'Poser\Proxy\Generator\NewGenerator'));
    }
}