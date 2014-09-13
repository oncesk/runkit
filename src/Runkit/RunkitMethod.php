<?php
namespace Runkit;

/**
 * Class RunkitMethod
 * @package Runkit
 */
class RunkitMethod extends RunkitFunction implements IRunkitMethod {

	/**
	 * @var integer
	 */
	protected $access = IRunkitMethod::ACCESS_PUBLIC;

	/**
	 * @var IRunkitClass
	 */
	protected $runkitClass;

	/**
	 * @param       $name
	 * @param array $arguments
	 */
	public function __construct($name, array $arguments = array()) {
		$this->name = $name;
		$this->arguments = $arguments;
	}

	/**
	 * @return integer
	 */
	public function getType() {
		return IRunkit::TYPE_METHOD;
	}

	/**
	 * @return int
	 */
	public function getAccess() {
		return $this->access;
	}

	/**
	 * @param const $access
	 *
	 * @return IRunkitMethod
	 */
	public function setAccess($access) {
		if (
			$access == self::ACCESS_PUBLIC ||
			$access == self::ACCESS_PROTECTED ||
			$access == self::ACCESS_PRIVATE
		) {
			$this->access = $access;
		}
		return $this;
	}

	/**
	 * @param IRunkitClass $class
	 *
	 * @return IRunkitMethod
	 */
	public function setRunkitClass(IRunkitClass $class) {
		$this->runkitClass = $class;
		return $this;
	}

	/**
	 * @return IRunkitClass
	 */
	public function getRunkitClass() {
		return $this->runkitClass;
	}

	/**
	 * @throws \RuntimeException
	 *
	 * @return bool|void
	 */
	public function add() {
		$runkitClass = $this->getRunkitClass();
		if (!$runkitClass) {
			throw new \RuntimeException('Runkit class is not set');
		}
		$arguments = $this->getArguments();
		return runkit_method_add(
			$runkitClass->getName(),
			$this->getName(),
			!empty($arguments) ? implode(', ', $arguments) : '',
			$this->getCode(),
			$this->getAccess()
		);
	}

	/**
	 * @param string $name
	 *
	 * @return IRunkitFunction
	 * @throws \RuntimeException
	 */
	public function copy($name) {
		if ($name == $this->getName()) {
			throw new \RuntimeException('Method name is the same as current method');
		}
		if (!is_string($name) || empty($name)) {
			throw new \RuntimeException('New method name is empty or invalid type');
		}
		$copy = new self($this->getName());
		$copy->setArguments($this->getArguments());
		$copy->setAccess($this->getAccess());
		$copy->setRunkitClass($this->getRunkitClass());
		if ($copy->add()) {
			return $copy;
		}
		throw new \RuntimeException('Can not copy ' . $this->getName() . ' to ' . $name);
	}

	/**
	 * @param $className
	 * @param $methodName
	 *
	 * @throws \RuntimeException
	 *
	 * @return IRunkitMethod
	 */
	public function copyToClass($className, $methodName) {
		$copy = new self($methodName);
		$copy->setAccess($this->getAccess());
		$copy->setArguments($this->getArguments());
		$copy->setRunkitClass($className);
		if ($copy->add()) {
			return $copy;
		}
		throw new \RuntimeException('Can not copy ' . $this->getName() . ' to ' . $className . '::' . $methodName);
	}

	/**
	 * @return bool
	 */
	public function remove() {
		return runkit_method_remove($this->getRunkitClass()->getName(), $this->getName());
	}

	/**
	 * @return bool
	 */
	public function redefine() {
		$arguments = $this->getArguments();
		return runkit_method_redefine(
			$this->getRunkitClass()->getName(),
			$this->getName(),
			!empty($arguments) ? implode(', ', $arguments) : '',
			$this->getCode(),
			$this->getAccess()
		);
	}

	/**
	 * @param string $name
	 * @throws \RuntimeException
	 *
	 * @return bool|void
	 */
	public function rename($name) {
		if ($name == $this->getName()) {
			throw new \RuntimeException('New name the same');
		}
		return runkit_method_rename(
			$this->getRunkitClass()->getName(),
			$this->getName(),
			$name
		);
	}
}