<?php
//require_once __DIR__ . '/../../src/autoload.php';

use Runkit\Implementation\Collection\Arguments;

class ArgumentsCollectionTest extends PHPUnit_Framework_TestCase {

	public function testGetAll() {
		$collection = new Arguments();
		$arguments = array(
			'$a', '$b'
		);
		$collection->setArguments($arguments);
		$this->assertEquals($arguments, $collection->getAll());

		$collection = new Arguments();
		$collection->add('$a')->add('$b');
		$this->assertEquals($arguments, $collection->getAll());
	}

	public function testHasArgument() {
		$collection = new Arguments();
		$collection->add('$a');
		$this->assertEquals(true, $collection->hasArgument('$a'));
		$this->assertEquals(false, $collection->hasArgument('$b'));
		$collection->add('$b');
		$this->assertEquals(true, $collection->hasArgument('$b'));
	}

	public function testSetArguments() {
		$collection = new Arguments();
		$arguments = array('$a');
		$this->assertEquals($collection, $collection->setArguments($arguments));
		$this->assertEquals($arguments, $collection->getAll());
	}

	public function testAdd() {
		$collection = new Arguments();
		$this->assertEquals($collection, $collection->add('$a'));
		$this->assertEquals($collection, $collection->add('$b'));
		$this->setExpectedException('RuntimeException', 'Argument $a already defined');
		$collection->add('$a');
	}
}