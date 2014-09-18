<?php

define('RunkitConstantTestRedefine', 1);
define('RunkitConstantTestRename', 22);

class RunkitConstantTesterClass {

	const TEST_DEFINED = 1;

	const CONSTANT_STRING = 'hello';
	const CONSTANT_BOOL = false;
	const CONSTANT_NULL = null;
	const CONSTANT_INT = 15;
	const CONSTANT_FOR_REMOVE = 'remove me';
}

use Runkit\Implementation\RunkitConstant;
use Runkit\Runkit;

class RunkitConstantTest extends PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$const = new RunkitConstant('test');
		$this->assertEquals('test', $const->getName());

		$this->setExpectedException('RuntimeException', 'Invalid constant name, it should be string and not empty');
		$const = new RunkitConstant(null);
		$const = new RunkitConstant(array());
	}

	public function testGetName() {
		$const = new RunkitConstant('test');
		$this->assertEquals('test', $const->getName());
	}

	public function testGetType() {
		$const = new RunkitConstant('test');
		$this->assertEquals(Runkit::TYPE_CONSTANT, $const->getType());
	}

	public function testIsDefined() {
		$const = new RunkitConstant('testIsDefined');
		$this->assertFalse(defined('testIsDefined'));
		$this->assertEquals(defined('testIsDefined'), $const->isDefined());

		$const = new RunkitConstant('RunkitConstantTestRedefine');
		$this->assertEquals(defined('RunkitConstantTestRedefine'), $const->isDefined());

		$const = new RunkitConstant('RunkitConstantTesterClass::TEST_DEFINED');
		$this->assertEquals(defined('RunkitConstantTesterClass::TEST_DEFINED'), $const->isDefined());
	}

	

	public function testRedefine() {
		$const = new RunkitConstant('RunkitConstantTestRedefine');
		$this->assertEquals(1, $const->getValue());
		$const->setValue(2);
		$this->assertEquals(2, $const->getValue());
		$this->assertEquals(true, $const->redefine());
		$this->assertEquals(2, $const->getValue());

		$const = new RunkitConstant('RunkitConstantTestRedefine');
		$this->assertEquals(2, $const->getValue());

		$const = new RunkitConstant('RunkitConstantTestAdd');
		$const->setValue(404);
		$this->assertEquals(true, $const->redefine());
		$this->assertEquals(404, $const->getValue());
		$this->assertEquals(404, constant('RunkitConstantTestAdd'));

		$const = new RunkitConstant('RunkitConstantTestAdd');
		$this->assertEquals(404, $const->getValue());
	}

	public function testRedefineForClass() {
		$class = 'RunkitConstantTesterClass';

		$c1 = $class . '::CONSTANT_STRING';
		$const = new RunkitConstant($c1);
		$this->assertEquals('hello', $const->getValue());
		$const->setValue('hello world');
		$this->assertTrue($const->redefine());
		$this->assertEquals('hello world', constant($c1));

		$c2 = $class . '::CONSTANT_INT';
		$const = new RunkitConstant($c2);
		$this->assertEquals(15, $const->getValue());
		$this->assertEquals(15, constant($c2));
		$const->setValue(404);
		$const->redefine();
		$this->assertEquals(404, $const->getValue());
		$this->assertEquals(404, constant($c2));

		$newConstant = $class . '::NEW_CONST';
		$const = new RunkitConstant($newConstant);
		$const->setValue('this is works!');
		$this->assertEquals('this is works!', $const->getValue());
		$this->assertTrue($const->redefine());
		$this->assertEquals('this is works!', constant($newConstant));
		$this->assertTrue($const->remove());
		$this->assertFalse(defined($newConstant));
	}

	public function testRename() {
		$constant = 'RunkitConstantTestRename';

		$const = new RunkitConstant($constant);
		$this->assertEquals(22, $const->getValue());
		$this->assertTrue($const->rename('RunkitConstantTestRename_renamed'));
		$this->assertEquals('RunkitConstantTestRename_renamed', $const->getName());
		$this->assertTrue(defined('RunkitConstantTestRename_renamed'));
		$this->assertFalse(defined('RunkitConstantTestRename'));
		$this->assertEquals(22, constant('RunkitConstantTestRename_renamed'));
	}

	public function testRenameForClass() {
		$const = new RunkitConstant('RunkitConstantTesterClass::CONSTANT_BOOL');
		$this->assertEquals(false, $const->getValue());
		$this->assertEquals('RunkitConstantTesterClass::CONSTANT_BOOL', $const->getName());
		$this->assertTrue($const->rename('RunkitConstantTesterClass::CONSTANT_BOOL_RENAMED'));
		$this->assertEquals('RunkitConstantTesterClass::CONSTANT_BOOL_RENAMED', $const->getName());
		$this->assertFalse(defined('RunkitConstantTesterClass::CONSTANT_BOOL'));
		$this->assertTrue(defined('RunkitConstantTesterClass::CONSTANT_BOOL_RENAMED'));
		$this->assertEquals(false, $const->getValue());
		$this->assertEquals(false, constant('RunkitConstantTesterClass::CONSTANT_BOOL_RENAMED'));
	}

	public function testRemove() {
		$const = new RunkitConstant('RunkitConstantTestRedefine');
		$this->assertEquals(true, $const->remove());
		$this->assertFalse(defined('RunkitConstantTestRedefine'));

		$const = new RunkitConstant('RunkitConstantTestRemove');
		$const->setValue('2');
		$this->assertEquals(true, $const->redefine());
		$this->assertTrue(defined('RunkitConstantTestRemove'));
		$this->assertEquals('2', constant('RunkitConstantTestRemove'));
		$const->remove();
		$this->assertFalse(defined('RunkitConstantTestRemove'));
	}

	public function testRemoveForClass() {
		$const = new RunkitConstant('RunkitConstantTesterClass::CONSTANT_FOR_REMOVE');
		$this->assertEquals('remove me', $const->getValue());
		$this->assertTrue($const->remove());
		$this->assertFalse(defined('RunkitConstantTesterClass::CONSTANT_FOR_REMOVE'));

		$const = new RunkitConstant('RunkitConstantTesterClass::CONSTANT_FOR_REMOVE_DYNAMIC');
		$const->setValue('remove dynamic constant');
		$this->assertTrue($const->redefine());
		$this->assertTrue(defined('RunkitConstantTesterClass::CONSTANT_FOR_REMOVE_DYNAMIC'));
		$this->assertTrue($const->remove());
		$this->assertFalse(defined('RunkitConstantTesterClass::CONSTANT_FOR_REMOVE_DYNAMIC'));
	}
}