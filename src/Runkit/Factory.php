<?php
namespace Runkit;

/**
 * Class Factory
 * @package Runkit
 */
class Factory {

	/**
	 * @var string
	 */
	public static $constantClass = '\Runkit\Implementation\RunkitConstant';

	/**
	 * @var string
	 */
	public static $methodClass = '\Runkit\Implementation\RunkitMethod';

	/**
	 * @var string
	 */
	public static $executorClass = '\Runkit\Implementation\Executor';

	/**
	 * @var string
	 */
	public static $codeClass = '\Runkit\Implementation\Code';

	/**
	 * @var string
	 */
	public static $propertyClass = '\Runkit\Implementation\RunkitProperty';

	/**
	 * @var string
	 */
	public static $functionClass = '\Runkit\Implementation\RunkitFunction';

	/**
	 * @var Executor
	 */
	private static $executor;

	/**
	 * @return Executor
	 */
	public static function getExecutor() {
		if (self::$executor) {
			return self::$executor;
		}
		$class = self::$executorClass;
		return self::$executor = new $class();
	}

	/**
	 * @param \ReflectionFunctionAbstract|null $reflection
	 *
	 * @return Code
	 */
	public static function createCode($reflection) {
		$class = self::$codeClass;
		$object = new $class($reflection);
		if (!($object instanceof Code)) {
			throw new \RuntimeException($class . ' should be instance of \Runkit\Code');
		}
		return $object;
	}

	/**
	 * @param string              $name
	 * @param \ReflectionFunction $reflection
	 *
	 * @return RunkitFunction
	 * @throws \RuntimeException
	 */
	public static function createFunction($name, \ReflectionFunction $reflection = null) {
		$class = self::$functionClass;
		if (!class_exists($class)) {
			throw new \RuntimeException($class . ' is not defined');
		}
		$object = new $class($name, $reflection);
		if (!($object instanceof RunkitFunction)) {
			throw new \RuntimeException($class . ' should implement RunkitFunction interface');
		}
		return $object;
	}

	/**
	 * @param string $name
	 * @param null   $value
	 *
	 * @throws \RuntimeException
	 * @return RunkitConstant
	 */
	public static function createConstant($name, $value = null) {
		$class = self::$constantClass;
		$object = new $class($name, $value);
		if (!($object instanceof RunkitConstant)) {
			throw new \RuntimeException('Invalid inherits of Constant');
		}
		return $object;
	}

	/**
	 * @param $name
	 *
	 * @return RunkitMethod
	 * @throws \RuntimeException
	 */
	public static function createMethod($name) {
		$class = self::$methodClass;
		$object = new $class($name);
		if (!($object instanceof RunkitMethod)) {
			throw new \RuntimeException('Invalid inherits of RunkitMethod');
		}
		return $object;
	}

	/**
	 * @return Collection
	 */
	public static function createConstantCollection() {

	}

	/**
	 * @return Collection
	 */
	public static function createMethodCollection($class = null) {

	}

	/**
	 * @return Collection
	 */
	public static function createPropertyCollection($class = null) {

	}

	/**
	 * @return Collection
	 */
	public static function createFunctionCollection() {

	}
}