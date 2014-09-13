<?php
namespace Runkit;

/**
 * Class RunkitReflection
 * @package Runkit
 */
trait RunkitReflection {

	/**
	 * @param string $className
	 *
	 * @return array
	 */
	protected function _getConstants($className) {
		$class = new \ReflectionClass($className);
		return $class->getConstants();
	}

	/**
	 * @param string $className
	 * @param null   $filter
	 *
	 * @return IRunkitMethod[]
	 */
	protected function _getMethods($className, $filter = null) {
		$class = new \ReflectionClass($className);
		$runkitMethods = array();
		foreach ($class->getMethods($filter) as $method) {
			$runkitMethod = RunkitFactory::createMethod($method->getName());
			$runkitMethods[$method->getName()] = $runkitMethod;
		}
		return $runkitMethods;
	}
}