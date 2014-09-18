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
