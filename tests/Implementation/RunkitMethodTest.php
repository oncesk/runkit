<?php

class TestRunkitMethod {

	public function test() {

	}

	public function testArgs($a, $b = 11, $c = array()) {

	}
}

use Runkit\Implementation\RunkitMethod;
use Runkit\Runkit;

class RunkitMethodTest extends PHPUnit_Framework_TestCase {

	private $class = 'TestRunkitMethod';

	public function testConstructor() {
		$method = new RunkitMethod($this->class, 'test');
		$this->assertEquals('test', $method->getName());
		$this->assertEquals($this->class, $method->getClass());
		$this->assertEquals(array(), $method->getArguments()->getAll());

		$method = new RunkitMethod($this->class, 'testArgs');
		$this->assertEquals(3, $method->getArguments()->count());
	}

	public function testGetName() {
		$method = new RunkitMethod($this->class, 'test');
		$this->assertEquals('test', $method->getName());
	}

	public function testGetType() {
		$method = new RunkitMethod($this->class, 'test');
		$this->assertEquals(Runkit::TYPE_METHOD, $method->getType());
	}

	public function testGetClass() {
		$method = new RunkitMethod($this->class, 'test');
		$this->assertEquals($this->class, $method->getClass());

		$class = new TestRunkitMethod();
		$method = new RunkitMethod($class, 'test');
		$this->assertEquals($class, $method->getClass());
	}

	public function testGetArguments() {
		$method = new RunkitMethod($this->class, 'test');
		$this->assertInstanceOf('Runkit\ArgumentsCollection', $method->getArguments());
	}

	public function testIsDefined() {
		$method = new RunkitMethod($this->class, 'test');
		$this->assertTrue($method->isDefined());
		$this->assertTrue(method_exists($this->class, $method->getName()));

		$method = new RunkitMethod($this->class, 'notExistedMethod');
		$this->assertFalse($method->isDefined());
		$this->assertFalse(method_exists($this->class, $method->getName()));

		$this->assertTrue($method->define());
		$this->assertTrue($method->isDefined());
		$this->assertTrue(method_exists($method->getClass(), $method->getName()));
		$this->assertTrue($method->remove());
	}

	public function testDefine() {
		$method = new RunkitMethod($this->class, 'testDefine');
		$method->getCode()->set('return "BEFORE" . $this->testDefine2() . "AFTER";');
		$this->assertTrue($method->define());
		$this->assertTrue($method->isDefined());

		$method2 = new RunkitMethod($this->class, 'testDefine2');
		$method2->getCode()->set('return " MIDDLE ";');
		$this->assertTrue($method2->define());
		$this->assertTrue($method2->isDefined());

		$obj = new TestRunkitMethod();
		$this->assertTrue(method_exists($obj, $method->getName()));
		$this->assertTrue(method_exists($obj, $method2->getName()));
		$this->assertEquals(' MIDDLE ', $obj->testDefine2());
		$this->assertEquals('BEFORE MIDDLE AFTER', $obj->testDefine());
	}

	public function testRedefine() {
		$method = new RunkitMethod($this->class, 'testDefine2');
		$method->getArguments()->add('$str');
		$method->getCode()->set('return "$str";');
		$this->assertTrue($method->redefine());

		$method2 = new RunkitMethod($this->class, 'testDefine');
		$method2->getArguments()->add('$str');
		$method2->getCode()->set('return "BEFORE " . $this->testDefine2($str) . " AFTER";');
		$this->assertTrue($method2->redefine());

		$obj = new TestRunkitMethod();
		$this->assertEquals('test', $obj->testDefine2('test'));
		$this->assertEquals('BEFORE test AFTER', $obj->testDefine('test'));
	}

	public function testRemove() {
		$method = new RunkitMethod($this->class, 'testDefine2');
		$this->assertTrue($method->isDefined());
		$this->assertTrue(method_exists($method->getClass(), $method->getName()));
		$this->assertTrue($method->remove());
		$this->assertFalse($method->isDefined());
		$this->assertFalse(method_exists($method->getClass(), $method->getName()));

		$obj = new TestRunkitMethod();
		$this->assertFalse(method_exists($obj, $method->getName()));
	}

	public function testRename() {
		$method = new RunkitMethod($this->class, 'test');
		$this->assertTrue($method->isDefined());
		$this->assertTrue($method->rename('testTest'));
		$this->assertFalse(method_exists($method->getClass(), 'test'));
		$this->assertTrue($method->isDefined());
		$this->assertTrue(method_exists($method->getClass(), $method->getName()));
	}
}