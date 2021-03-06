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

	public function testSetAccess() {
		$prop = new RunkitProperty('RunkitPropertyTestClass', 'test');
		$prop->setAccess(Access::ACCESS_PRIVATE);
		$this->assertEquals(Access::ACCESS_PRIVATE, $prop->getAccess());
	}

	public function testDefine() {
		$prop = new RunkitProperty('RunkitPropertyTestClass', 'testMe');
		$prop->setValue(1);
		$this->assertFalse($prop->isDefined());
		$this->assertTrue($prop->define());
		$this->assertTrue($prop->isDefined());
		$this->assertTrue(property_exists('RunkitPropertyTestClass', 'testMe'));
		$class = new RunkitPropertyTestClass();
		$this->assertEquals(1, $class->testMe);

		$class = new RunkitPropertyTestClass();
		$prop = new RunkitProperty($class, 'testMeForObject');
		$prop->setValue(404);
		$this->assertTrue($prop->define());
		$this->assertTrue($prop->isDefined());
		$this->assertTrue(property_exists($class, 'testMeForObject'));
		$this->assertEquals(404, $prop->getValue());
		$this->assertFalse(isset($class->testMeForObject));

		$class = new RunkitPropertyTestClass();
		$prop = new RunkitProperty($class, 'testMeForObjectOverride');
		$prop->setValue(400);
		$prop->setOverrideMode();
		$this->assertFalse(isset($class->testMeForObjectOverride));
		$this->assertFalse(property_exists($class, 'testMeForObjectOverride'));
		$this->assertTrue($prop->define());
		$this->assertTrue(property_exists($class, 'testMeForObjectOverride'));
		$this->assertTrue(isset($class->testMeForObjectOverride));
		$this->assertEquals(400, $class->testMeForObjectOverride);
	}

	public function testRedefine() {
		$prop = new RunkitProperty('RunkitPropertyTestClass', 'publicProperty');
		$this->assertTrue($prop->isDefined());
		$this->assertTrue(property_exists('RunkitPropertyTestClass', 'publicProperty'));
		$this->assertEquals(12, $prop->getValue());
		$this->assertEquals(Access::ACCESS_PUBLIC, $prop->getAccess());

		$prop->setValue(13);
		$this->assertTrue($prop->redefine());
		$this->assertEquals(13, $prop->getValue());
		$newProp = new RunkitProperty('RunkitPropertyTestClass', 'publicProperty');
		$this->assertEquals(13, $newProp->getValue());
		$class = new RunkitPropertyTestClass();
		$this->assertEquals(13, $class->publicProperty);

		$newProp->setAccess(Access::ACCESS_PROTECTED);
		$this->assertTrue($newProp->redefine());
		$reflection = new \ReflectionProperty('RunkitPropertyTestClass', 'publicProperty');
		$this->assertTrue($reflection->isProtected());
		$this->assertFalse($reflection->isPublic());
	}

	public function testRemove() {
		$prop = new RunkitProperty('RunkitPropertyTestClass', 'publicProperty');
		$this->assertTrue($prop->isDefined());
		$this->assertTrue($prop->remove());
		$this->assertFalse($prop->isDefined());
		$this->assertFalse(property_exists($prop->getClass(), $prop->getName()));

		$newProp = new RunkitProperty('RunkitPropertyTestClass', 'testRemove');
		$this->assertTrue($newProp->define());
		$this->assertTrue($newProp->isDefined());
		$this->assertTrue($newProp->remove());
		$this->assertFalse($newProp->isDefined());
		$this->assertFalse(property_exists($newProp->getClass(), $newProp->getName()));
	}

	public function testRename() {
		$prop = new RunkitProperty('RunkitPropertyTestClass', 'testRename');
		$this->assertFalse($prop->isDefined());
		$this->assertFalse(property_exists($prop->getClass(), $prop->getName()));
		$this->assertTrue($prop->define());
		$this->assertTrue($prop->isDefined());
		$this->assertTrue($prop->rename('testRenameProperty'));
		$this->assertTrue($prop->isDefined());
		$this->assertEquals('testRenameProperty', $prop->getName());
		$this->assertFalse(property_exists($prop->getClass(), 'testRename'));
	}
}