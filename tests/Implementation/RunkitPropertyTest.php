<?php

class RunkitPropertyTestClass {

	public $publicProperty = 12;
	protected $protectedProperty = 'protected';
	private $privateProperty = 'wow, private';
}

use Runkit\Runkit;
use Runkit\Implementation\RunkitProperty;
use Runkit\Access;

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

	public function testIsDefined() {
		$prop = new RunkitProperty('RunkitPropertyTestClass', 'test');
		$this->assertFalse($prop->isDefined());
		$this->assertFalse(property_exists('RunkitPropertyTestClass', 'test'));
		$prop->setValue(400);
		$this->assertTrue($prop->define());
		$this->assertTrue($prop->isDefined());
		$this->assertTrue(property_exists('RunkitPropertyTestClass', 'test'));

		$prop = new RunkitProperty('RunkitPropertyTestClass', 'publicProperty');
		$this->assertTrue($prop->isDefined());

		$prop = new RunkitProperty('RunkitPropertyTestClass', 'privateProperty');
		$this->assertTrue($prop->isDefined());
	}

	public function testGetAccess() {
		$prop = new RunkitProperty('RunkitPropertyTestClass', 'test');
		$this->assertEquals(Access::ACCESS_PUBLIC, $prop->getAccess());
		$prop->setAccess(Access::ACCESS_PROTECTED);
		$this->assertEquals(Access::ACCESS_PROTECTED, $prop->getAccess());

		$prop = new RunkitProperty('RunkitPropertyTestClass', 'publicProperty');
		$this->assertEquals(Access::ACCESS_PUBLIC, $prop->getAccess());

		$prop = new RunkitProperty('RunkitPropertyTestClass', 'protectedProperty');
		$this->assertEquals(Access::ACCESS_PROTECTED, $prop->getAccess());

		$prop = new RunkitProperty('RunkitPropertyTestClass', 'privateProperty');
		$this->assertEquals(Access::ACCESS_PRIVATE, $prop->getAccess());
	}
}