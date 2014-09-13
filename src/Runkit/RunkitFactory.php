<?php
namespace Runkit;

/**
 * Class RunkitFactory
 * @package Runkit
 */
class RunkitFactory {

	/**
	 * @var string
	 */
	public static $constantClass = '\Runkit\RunkitConstant';

	/**
	 * @var string
	 */
	public static $methodClass = '\Runkit\RunkitMethod';

	/**
	 * @var string
	 */
	public static $constantHistoryClass = '\Runkit\RunkitConstantHistory';

	/**
	 * @var string
	 */
	public static $methodHistoryClass = '\Runkit\RunkitMethodHistory';

	/**
	 * @param string $name
	 * @param null   $value
	 *
	 * @throws \RuntimeException
	 * @return IRunkitConstant
	 */
	public static function createConstant($name, $value = null) {
		$class = self::$constantClass;
		$object = new $class($name, $value);
		if (!($object instanceof IRunkitConstant)) {
			throw new \RuntimeException('Invalid inherits of Constant');
		}
		return $object;
	}

	/**
	 * @param $name
	 *
	 * @return IRunkitMethod
	 * @throws \RuntimeException
	 */
	public static function createMethod($name) {
		$class = self::$methodClass;
		$object = new $class($name);
		if (!($object instanceof IRunkitMethod)) {
			throw new \RuntimeException('Invalid inherits of Method');
		}
		return $object;
	}

	/**
	 * @return IRunkitHistory
	 * @throws \RuntimeException
	 */
	public static function createMethodHistory() {
		$class = self::$methodHistoryClass;
		$object = new $class();
		if (!($object instanceof IRunkitHistory)) {
			throw new \RuntimeException('Invalid inherits');
		}
		return $object;
	}

	/**
	 * @return IRunkitHistory
	 * @throws \RuntimeException
	 */
	public static function createConstantsHistory() {
		$class = self::$constantHistoryClass;
		$object = new $class();
		if (!($object instanceof IRunkitHistory)) {
			throw new \RuntimeException('Invalid inherits');
		}
		return $object;
	}
}