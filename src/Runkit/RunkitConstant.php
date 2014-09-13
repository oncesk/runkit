<?php
namespace Runkit;

use Runkit\RunkitReflection;

/**
 * Class RunkitConstant
 * @package Runkit
 */
class RunkitConstant implements IRunkitConstant {

	use RunkitReflection;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @var string|null
	 */
	protected $className;

	/**
	 * @var array
	 */
	protected static $constants = array();

	/**
	 * @param string $name
	 * @param null|mixed $value
	 *
	 * @throws \RuntimeException
	 */
	public function __construct($name, $value = null) {
		if (!is_string($name) || empty($name)) {
			throw new \RuntimeException('Invalid constant name');
		}
		if (strpos($name, '::') !== false) {
			$parts = explode('::', $name);
			$this->className = $parts[0];
			$this->name = $parts[1];
		} else {
			$this->name = $name;
		}
		$this->value = $value;
		$this->loadConstantInfo();
	}

	/**
	 * Return constant name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Return full name with class name if it exists
	 *
	 * @return string
	 */
	public function getFullName() {
		$className = $this->getClassName();
		if ($className) {
			return $className . '::' . $this->getName();
		}
		return $this->getName();
	}

	/**
	 * @param bool|int|null|string $value
	 * @param bool                 $rewriteIfExists
	 *
	 * @return $this|mixed
	 * @throws \RuntimeException
	 */
	public function setValue($value, $rewriteIfExists = true) {
		if (
			is_string($value) ||
			is_bool($value) ||
			is_integer($value) ||
			is_null($value)
		) {
			if (!runkit_constant_add($this->name, $value)) {
				throw new \RuntimeException('RunkitConstant::add - can not add constant ' . $this->name);
			}
		} else {
			throw new \RuntimeException('RunkitConstant::add - Invalid value type');
		}
		return $this;
	}

	/**
	 * @return boolean if constant exists in class was returned true else false
	 */
	public function exists() {
		if (array_key_exists($this->getName(), self::$constants)) {

		}
	}

	/**
	 * Name of constant class
	 *
	 * @return string or null if constant define for global namespace
	 */
	public function getClassName() {
		return $this->className;
	}

	/**
	 * @param $className
	 *
	 * @return $this
	 */
	public function setClassName($className) {
		if (is_string($className) && !empty($className)) {
			$this->className = $className;
		}
		return $this;
	}

	protected function loadConstantInfo() {
		$className = $this->getClassName();
		if ($className && !array_key_exists($className, self::$constants)) {
			self::$constants[$className] = $this->getConstants($className);
		}
	}
}