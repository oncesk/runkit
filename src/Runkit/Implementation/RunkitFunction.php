<?php
namespace Runkit\Implementation;

use Runkit\Factory;
use Runkit\RunkitFunction as RunkitFunctionInterface;
use Runkit\Runkit;
use Runkit\Helper\Reflection;
use Runkit\Helper\GetSetCode;
use Runkit\Helper\GetSetReflection;
use Runkit\ArgumentsCollection;
use Runkit\Implementation\Collection\Arguments;

/**
 * Class Functions
 * @package Runkit
 */
class RunkitFunction implements RunkitFunctionInterface {

	use GetSetReflection;
	use GetSetCode;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var ArgumentsCollection
	 */
	protected $arguments;

	/**
	 * @param string              $name
	 * @param \ReflectionFunction $reflection
	 *
	 * @throws \RuntimeException
	 */
	public function __construct($name, \ReflectionFunction $reflection = null) {
		if (!is_string($name) || empty($name)) {
			throw new \RuntimeException('Name should be string and not empty');
		}
		$this->name = $name;
		if ($reflection) {
			if ($reflection->getName() != $name) {
				throw new \RuntimeException('Reflection getName not equal with name which you provides');
			}
			$this->setReflection($reflection);
		} else {
			if (function_exists($name)) {
				$reflection = $this->getReflection();
			}
		}
		if ($reflection && $reflection->isInternal()) {
			throw new \RuntimeException('You can not works with internal PHP functions, only user defined');
		}
		$this->arguments = new Arguments(array(), $reflection);
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
		return Runkit::TYPE_FUNCTION;
	}

	/**
	 * @return ArgumentsCollection
	 */
	public function getArguments() {
		return $this->arguments;
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 * @throws \RuntimeException
	 */
	public function rename($name) {
		if (is_string($name) && !empty($name)) {
			if ($this->getName() == $name) {
				return true;
			}
			if (function_exists($name)) {
				throw new \RuntimeException('Can not rename function ' . $this->getName() . ' to ' . $name . ' because function exists');
			}
			if (Factory::getExecutor()->renameFunction($this->getName(), $name)) {
				$this->name = $name;
				return true;
			}
		}
		return false;
	}

	/**
	 * @return boolean
	 */
	public function isDefined() {
		return function_exists($this->getName());
	}

	/**
	 * @return boolean
	 */
	public function define() {
		return $this->isDefined() ? $this->redefine() : Factory::getExecutor()->addFunction($this);
	}

	/**
	 * Redefine function with new argumentns and new code
	 *
	 * @return boolean
	 */
	public function redefine() {
		return $this->isDefined() ? Factory::getExecutor()->redefineFunction($this) : $this->define();
	}

	/**
	 * Remove function from scope
	 *
	 * @return boolean
	 */
	public function remove() {
		$name = $this->getName();
		return function_exists($name) ? Factory::getExecutor()->removeFunction($name): true;
	}

	/**
	 * @return mixed
	 */
	public function __invoke() {
		return $this->getReflection()->invokeArgs(func_get_args());
	}

	/**
	 * @return \ReflectionFunctionAbstract|null
	 */
	protected function createReflection() {
		if (function_exists($this->getName())) {
			return Reflection::getFunction($this->getName());
		}
		return null;
	}
}