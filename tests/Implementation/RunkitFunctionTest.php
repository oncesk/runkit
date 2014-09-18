<?php

function testConstructor() {
	return rand(1, 3);
}
function testConstructor2() {

}

function testRename() {

}

function testInvoke() {
	return 'Success';
}

function testRedefine() {
	return 'Test';
}

function testRedefineWithArgs($a, $b = 1) {
	return $a + $b;
}

function testRemove() {

}

use Runkit\Runkit;
use Runkit\Implementation\RunkitFunction;

class RunkitFunctionTest extends PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$func = new RunkitFunction('testConstructor');
		$this->assertEquals('testConstructor', $func->getName());
		$this->assertInstanceOf('\Runkit\ArgumentsCollection', $func->getArguments());

		$this->setExpectedException('RuntimeException', 'Name should be string and not empty');
		$func = new RunkitFunction('');
		$func = new RunkitFunction(array());
	}

	public function testConstructorWithDifferentReflectionFunction() {
		$this->setExpectedException('RuntimeException', 'Reflection getName not equal with name which you provides');
		$func = new RunkitFunction('testConstructor', new ReflectionFunction('testConstructor2'));
	}

	public function testConstructorInternalPHPFunction() {
		$this->setExpectedException('\RuntimeException', 'You can not works with internal PHP functions, only user defined');
		$func = new RunkitFunction('strlen');
	}

	public function testGetName() {
		$func = new RunkitFunction('test');
		$this->assertEquals('test', $func->getName());
	}

	public function testGetType() {
		$func = new RunkitFunction('test');
		$this->assertEquals(Runkit::TYPE_FUNCTION, $func->getType());
	}

	public function testGetArguments() {
		$func = new RunkitFunction('test');
		$this->assertInstanceOf('\Runkit\ArgumentsCollection', $func->getArguments());
	}

	public function testRename() {
		$func = new RunkitFunction('testRename');
		$this->assertEquals('testRename', $func->getName());
		$this->assertFalse(function_exists('testRename_renamed'));
		$this->assertTrue($func->rename('testRename_renamed'));
		$this->assertTrue(function_exists('testRename_renamed'));
		$this->assertFalse(function_exists('testRename'));
		$this->assertEquals('testRename_renamed', $func->getName());

		$this->assertTrue($func->rename('testRename'));
		$this->assertEquals('testRename', $func->getName());
		$this->assertTrue(function_exists('testRename'));
		$this->assertFalse(function_exists('testRename_renamed'));

		$this->assertTrue($func->rename('testRename'));
		$this->assertEquals('testRename', $func->getName());

		$this->setExpectedException('RuntimeException', 'Can not rename function testRename to testConstructor because function exists');
		$func->rename('testConstructor');
	}

	public function testRedefine() {
		$func = new RunkitFunction('testRedefine');
		$this->assertEquals(array(), $func->getArguments()->getAll());
		$this->assertEquals("return 'Test';", trim($func->getCode()->get()));
		$func->getArguments()->add('$part1');
		$this->assertEquals(array('$part1'), $func->getArguments()->getAll());
		$this->assertTrue($func->redefine());
		$this->assertTrue(function_exists('testRedefine'));
		$this->assertEquals("return 'Test';", trim($func->getCode()->get()));
		$this->assertTrue($func->getArguments()->hasArgument('$part1'));
		$reflection = new ReflectionFunction('testRedefine');
		$this->assertEquals($reflection->getNumberOfParameters(), count($func->getArguments()->getAll()));
		$this->assertEquals('$' . $reflection->getParameters()[0]->getName(), $func->getArguments()->getAll()[0]);

		$func->getArguments()->add('$part2 = " world!"');
		$func->getCode()->set('return $part1 . $part2;');
		$this->assertTrue($func->redefine());

		$reflection = new ReflectionFunction('testRedefine');
		$parameters = $reflection->getParameters();
		$this->assertEquals($reflection->getNumberOfParameters(), count($func->getArguments()->getAll()));
		$this->assertEquals('$' . $parameters[0]->getName(), $func->getArguments()->getAll()[0]);
		$this->assertTrue($parameters[1]->isOptional());
		$this->assertEquals(' world!', $parameters[1]->getDefaultValue());
		$this->assertEquals('Hello world!', testRedefine('Hello'));
		$this->assertEquals('Hello world, this is works!', testRedefine('Hello', ' world, this is works!'));
	}

	public function testRemove() {
		$func = new RunkitFunction('DynamicFunctionForRemove');
		$this->assertTrue($func->redefine());
		$this->assertTrue(function_exists('DynamicFunctionForRemove'));
		$this->assertTrue($func->remove());
		$this->assertFalse(function_exists('DynamicFunctionForRemove'));

		$this->assertTrue(function_exists('testRemove'));
		$func = new RunkitFunction('testRemove');
		$this->assertTrue($func->remove());
		$this->assertFalse(function_exists('testRemove'));
	}

	public function testInvoke() {
		$func = new RunkitFunction('testInvoke');
		$this->assertEquals('Success', $func());

		$func = new RunkitFunction('testInvokeDynamic');
		$func->getCode()->set('return "Invoked";');
		$this->assertTrue($func->define());
		$this->assertEquals('Invoked', $func());

		$func = new RunkitFunction('testInvokeDynamic2');
		$this->setExpectedException('RuntimeException', 'Function ' . $func->getName() . ' is not defined');
		$func();
	}
}