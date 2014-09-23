<?php
use Runkit\Factory;

function testFunctionForFactory() {

}

class RunkitFactoryTest extends PHPUnit_Framework_TestCase {

	public function testCreateFunction() {
		$function = Factory::createFunction('factoryFunction');
		$this->assertInstanceOf('Runkit\RunkitFunction', $function);
	}

	public function testCreateCode() {
		$code = Factory::createCode();
		$this->assertInstanceOf('Runkit\Code', $code);

		$reflection = new ReflectionFunction('testFunctionForFactory');
		$code = Factory::createCode($reflection);
		$this->assertInstanceOf('Runkit\Code', $code);
	}
}