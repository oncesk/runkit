<?php
namespace Runkit\Helper;

/**
 * Class Reflection
 * @package Runkit\Helper
 */
class Reflection {

	/**
	 * @var \ReflectionFunction[]
	 */
	private static $functions = array();

	/**
	 * @var \ReflectionClass[]
	 */
	private static $classes = array();

	/**
	 * @param string $name
	 *
	 * @return \ReflectionFunction
	 */
	public static function getFunction($name) {
		if (!array_key_exists($name, self::$functions)) {
			self::$functions[$name] = new \ReflectionFunction($name);
		}
		return self::$functions[$name];
	}

	/**
	 * @param $class
	 *
	 * @return \ReflectionClass
	 */
	public static function getClass($class) {
		if (!array_key_exists($class, self::$classes)) {
			self::$classes[$class] = new \ReflectionClass($class);
		}
		return self::$classes[$class];
	}

	/**
	 * @param      $class
	 * @param null $filter
	 *
	 * @return \ReflectionMethod[]
	 */
	public static function getClassMethods($class, $filter = null) {
		return self::getClass($class)->getMethods($filter);
	}

	/**
	 * @param $class
	 * @param $method
	 *
	 * @return \ReflectionMethod
	 */
	public static function getClassMethod($class, $method) {
		return self::getClass($class)->getMethod($method);
	}
}