<?php

use Runkit\Access;
use Runkit\Helper\GetSetAccess;

class testGetSetAccess {

	use GetSetAccess;
}

class GetSetAccessTest extends PHPUnit_Framework_TestCase {

	public function testGetAccess() {
		$obj = new testGetSetAccess();
		$this->assertEquals(Access::ACCESS_PUBLIC, $obj->getAccess());

		$obj->setAccess(Access::ACCESS_PRIVATE);
		$this->assertEquals(Access::ACCESS_PRIVATE, $obj->getAccess());
	}

	public function testSetAccess() {
		$obj = new testGetSetAccess();
		$this->assertEquals(Access::ACCESS_PUBLIC, $obj->getAccess());
		$obj->setAccess(Access::ACCESS_PROTECTED);
		$this->assertEquals(Access::ACCESS_PROTECTED, $obj->getAccess());
	}
}