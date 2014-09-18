<?php

class RunkitPropertyTestClass {

	public $publicProperty = 12;
	protected $protectedProperty = 'protected';
	private $privateProperty = 'wow, private';
}

use Runkit\Runkit;
use Runkit\Implementation\RunkitProperty;

class RunkitPropertyTest extends PHPUnit_Framework_TestCase {

	public function testConstruct() {
		$prop = new RunkitProperty('RunkitPropertyTestClass', 'test');
		$this->assertEquals('RunkitPropertyTestClass', $prop->getClass());
		$this->assertEquals('test', $prop->getName());

		$class = new RunkitPropertyTestClass();
		$prop = new RunkitProperty($class, 'test');
		$this->assertEquals($class, $prop->getClass());
	}

	public function testConstructorWithInvalidProperty() {
		$this->setExpectedException('RuntimeException', 'Property can not be null and should be string');
		new RunkitProperty('RunkitPropertyTestClass', '');
	}

	public function testConstructorExceptionInvalidClassType() {
		$this->setExpectedException('RuntimeException', 'Invalid class type, type - array');
		$class = new RunkitProperty(array(), 'test');
	}

	public function testConstructorExceptionEmptyClass() {
		$this->setExpectedException('RuntimeException', 'Class name can not be empty');
		$prop = new RunkitProperty('', 'test');
	}

	public function testConstructorExceptionNotDefinedClass() {
		$this->setExpectedException('RuntimeException', 'Class is not defined');
		$prop = new RunkitProperty('NotDefinedClass', 'test');
	}

	public function testGetClass() {
		$prop = new RunkitProperty('RunkitPropertyTestClass', 'test');
		$this->assertEquals('RunkitPropertyTestClass', $prop->getClass());

		$class = new RunkitPropertyTestClass();
		$prop = new RunkitProperty($class, 'test');
		$this->assertEquals($class, $prop->getClass());
	}

	public function testGetName() {
		$prop = new RunkitProperty('RunkitPropertyTestClass', 'test');
		$this->assertEquals('test', $prop->getName());
	}

	public function testGetType() {
		$prop = new RunkitProperty('RunkitPropertyTestClass', 'test');
		$this->assertEquals(Runkit::TYPE_PROPERTY, $prop->getType());
	}
}