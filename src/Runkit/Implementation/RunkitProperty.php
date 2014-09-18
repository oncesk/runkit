<?php
namespace Runkit\Implementation;

use Runkit\Factory;
use Runkit\Helper\GetSetAccess;
use Runkit\Helper\GetSetReflection;
use Runkit\Helper\GetSetValue;
use Runkit\Runkit;

/**
 * Class RunkitProperty
 * @package Runkit\Implementation
 */
class RunkitProperty implements \Runkit\RunkitProperty {

	use GetSetAccess;
	use GetSetReflection;
	use GetSetValue;

	/**
	 * @var string
	 */
	protected $class;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @param string              $class
	 * @param string              $property
	 * @param \ReflectionProperty $reflection
	 *
	 * @throws \RuntimeException
	 */
	public function __construct($class, $property, \ReflectionProperty $reflection = null) {
		if (is_string($class)) {
			if (empty($class)) {
				throw new \RuntimeException('Class name can not be empty');
			}
			if (!class_exists($class)) {
				throw new \RuntimeException('Class is not defined');
			}
		}
		$this->class = $class;
		if (!is_string($property) || empty($property)) {
			throw new \RuntimeException('Property can not be null and should be string');
		}
		$this->name = $property;
		$this->setReflection($reflection);
	}

	/**
	 * @return string
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return integer
	 */
	public function getType() {
		return Runkit::TYPE_PROPERTY;
	}

	/**
	 * @return boolean
	 */
	public function isDefined() {
		return property_exists($this->getClass(), $this->getName());
	}

	/**
	 * @return boolean
	 */
	public function define() {
		return $this->isDefined() ? $this->redefine() : Factory::getExecutor()->addProperty($this);
	}

	/**
	 * Redefine function with new argumentns and new code
	 *
	 * @return boolean
	 */
	public function redefine() {
		return $this->isDefined() ? Factory::getExecutor()->redefineProperty($this) : $this->define();
	}

	/**
	 * @return boolean
	 */
	public function remove() {
		return Factory::getExecutor()->removeProperty($this->getClass(), $this->getName());
	}

	/**
	 * @param string $name
	 *
	 * @throws \RuntimeException
	 *
	 * @return boolean
	 */
	public function rename($name) {
		if ($this->getName() == $name) {
			return true;
		}
		if (property_exists($this->getClass(), $name)) {
			throw new \RuntimeException('Property ' . $name . ' already defined in ' . $this->getClass());
		}
		return Factory::getExecutor()->renameProperty($this, $name);
	}

	/**
	 * @return \ReflectionProperty
	 */
	protected function createReflection() {
		return new \ReflectionProperty($this->getClass(), $this->getName());
	}
}