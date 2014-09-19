<?php
use Runkit\Implementation\Code;

function phpUnitTestCodeFunction() {
	return rand(1, 5);
}

class CodeTest extends PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$code = new Code();
		$this->assertInstanceOf('\Runkit\Implementation\Code', $code);
		$this->assertInstanceOf('\Runkit\Code', $code);

		$code = new Code($this->createReflection());
		$this->assertInstanceOf('\Runkit\Implementation\Code', $code);
		$this->assertInstanceOf('\Runkit\Code', $code);
	}

	public function testToString() {
		$code = new Code();
		$this->assertEquals('', $code);

		$code = new Code($this->createReflection());
		$this->assertEquals('return rand(1, 5);', trim($code));
	}

	public function testGet() {
		$code = new Code();
		$this->assertEquals('', $code->get());

		$code = new Code($this->createReflection());
		$this->assertEquals('return rand(1, 5);', trim($code->get()));
	}

	public function testSet() {
		$code = new Code();
		$this->assertEquals('', $code);
		$code->set('return 1;');
		$this->assertEquals('return 1;', $code->get());
	}

	public function testIsValid() {
		$code = new Code();
		$code->set('return 1;');
		$this->assertEquals(true, $code->isValid());

		$code = new Code($this->createReflection());
		$this->assertEquals(true, $code->isValid());
	}

	protected function createReflection($name = 'phpUnitTestCodeFunction') {
		return new ReflectionFunction($name);
	}
}
