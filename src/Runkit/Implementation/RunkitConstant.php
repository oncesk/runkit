<?php
namespace Runkit\Implementation;

use Runkit\Factory;
use Runkit\Helper\GetSetValue;
use Runkit\Runkit;

/**
 * Class RunkitConstant
 * @package Runkit\Implementation
 */
class RunkitConstant implements \Runkit\RunkitConstant {

	use GetSetValue;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @param string $name
	 * @throws \RuntimeException
	 */
	public function __construct($name) {
		if (empty($name) || !is_string($name)) {
			throw new \RuntimeException('Invalid constant name, it should be string and not empty');
		}
		$this->name = $name;
		if (defined($name)) {
			$this->setValue(constant($name));
		}
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
		return Runkit::TYPE_CONSTANT;
	}

	/**
	 * @return boolean
	 */
	public function isDefined() {
		return defined($this->getName());
	}

	/**
	 * @return boolean
	 */
	public function define() {
		return $this->isDefined() ? $this->redefine() : Factory::getExecutor()->addConstant($this->getName(), $this->getValue());
	}

	/**
	 * Redefine function with new argumentns and new code
	 *
	 * @return boolean
	 */
	public function redefine() {
		return $this->isDefined() ? Factory::getExecutor()->redefineConstant($this) : $this->define();
	}

	/**
	 * @return boolean
	 */
	public function remove() {
		return Factory::getExecutor()->removeConstant($this->getName());
	}

	/**
	 * @param string $name
	 *
	 * @throws \RuntimeException
	 *
	 * @return boolean
	 */
	public function rename($name) {
		if (defined($name)) {
			throw new \RuntimeException('Constant with name ' . $name . ' already defined');
		}
		if ($this->getName() == $name) {
			return true;
		}
		if (Factory::getExecutor()->renameConstant($this, $name)) {
			$this->name = $name;
			return true;
		}
		return false;
	}
}