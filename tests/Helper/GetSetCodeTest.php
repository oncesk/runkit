<?php

use Runkit\Helper\GetSetCode;

function forTestGetSetCode() {

}

class testSetGetCode {

	use GetSetCode;

	/**
	 * @return \ReflectionFunctionAbstract
	 */
	protected function getReflection() {
		return new \ReflectionFunction('forTestGetSetCode');
	}
}

class GetSetCodeTest extends PHPUnit_Framework_TestCase {

	public function testGetCode() {

	}

	public function testSetCode() {

	}
}