<?php
namespace Runkit\Item;

use Runkit\ArgumentsCollection;
use Runkit\Helper\GetSetAccess;
use Runkit\Implementation\Collection\Arguments;
use Runkit\Factory;
use Runkit\Helper\Reflection;
use Runkit\Runkit;
use Runkit\Helper\GetSetCode;
use Runkit\Helper\GetSetReflection;
use Runkit\RunkitMethod as RunkitMethodInterface;

/**
 * Class Methods
 * @package Runkit
 */
class RunkitMethod implements RunkitMethodInterface {

	use GetSetReflection;
	use GetSetCode;
	use GetSetAccess;

	/**
	 * @var string
	 */
	protected $class;

	/**
	 * @param string            $class
	 * @param string            $name
	 * @param array             $arguments
	 * @param \ReflectionMethod $reflection
	 *
	 * @throws \RuntimeException
	 */
	public function __construct($class, $name, array $arguments = array(), \ReflectionMethod $reflection = null) {
		if (is_string($class)) {
			if (!class_exists($class)) {
				throw new \RuntimeException('Class ' . $class . ' is not defined');
			}
		} else if (!is_object($class)) {
			throw new \RuntimeException('Class type is not supported, type - ' . gettype($class));
		}
		$this->class = $class;
		$this->name = $name;
		$this->arguments = new Arguments($arguments, $reflection);
		$this->setReflection($reflection);
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
		return Runkit::TYPE_METHOD;
	}

	/**
	 * @return string
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * @return ArgumentsCollection
	 */
	public function getArguments() {
		return $this->arguments;
	}

	/**
	 * Redefine function with new argumentns and new code
	 *
	 * @return boolean
	 */
	public function redefine() {
		return Factory::getExecutor()->redefineMethod($this);
	}

	/**
	 * @return boolean
	 */
	public function remove() {
		if (method_exists($this->getClass(), $this->getName())) {
			return Factory::getExecutor()->removeMethod($this->getClass(), $this->getName());
		}
		return true;
	}

	/**
	 * @param string $name
	 *
	 * @throws \RuntimeException
	 *
	 * @return boolean
	 */
	public function rename($name) {
		if (method_exists($this->getClass(), $this->getName())) {
			if (method_exists($this->getClass(), $name)) {
				throw new \RuntimeException('Method with name ' . $name . ' already exists in class ' . $this->getClass());
			}
			return Factory::getExecutor()->renameMethod($this->getClass(), $this->getName(), $name);
		}
		return false;
	}


	/**
	 * @return \ReflectionFunctionAbstract|null
	 */
	protected function createReflection() {
		if (method_exists($this->getClass(), $this->getName())) {
			return Reflection::getClassMethod($this->getClass(), $this->getName());
		}
		return null;
	}
}