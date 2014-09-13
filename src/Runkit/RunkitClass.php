<?php
namespace Runkit;

/**
 * Class RunkitClass
 * @package Runkit
 */
class RunkitClass implements IRunkitClass {

	use RunkitReflection;

	/**
	 * @var IRunkitConstant[][]
	 */
	protected static $constants = array();

	/**
	 * @var IRunkitMethod[][]
	 */
	protected static $methods = array();

	/**
	 * @var IRunkitHistory[]
	 */
	protected static $methodHistory = array();

	/**
	 * @var IRunkitHistory[]
	 */
	protected static $constantsHistory = array();

	/**
	 * @var string
	 */
	protected $className;

	/**
	 * @param $className
	 *
	 * @throws \RuntimeException
	 */
	public function __construct($className) {
		if (!is_string($className) || empty($className)) {
			throw new \RuntimeException('Invalid class name var, is empty or not string given');
		}
		if (!array_key_exists($className, self::$methodHistory)) {
			self::$methodHistory[$className] = RunkitFactory::createMethodHistory();
		}
		if (!array_key_exists($className, self::$constantsHistory)) {
			self::$constantsHistory[$className] = RunkitFactory::createConstantsHistory();
		}
		$this->className = $className;

	}

	/**
	 * @return integer
	 */
	public function getType() {
		return IRunkit::TYPE_CLASS;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->className;
	}

	/**
	 * @return IRunkitConstant[]
	 */
	public function getConstants() {
		if (array_key_exists($this->getName(), self::$constants)) {
			return self::$constants[$this->getName()];
		}
		$constants = array();
		foreach ($this->_getConstants($this->getName()) as $constant => $value) {
			$constObject = RunkitFactory::createConstant($constant, $value);
			$constObject->setClassName($this->getName());
			$constants[$constant] = $constObject;
		}
		return self::$constants[$this->getName()] = $constants;
	}

	/**
	 * @param string $name
	 *
	 * @throws \RuntimeException
	 *
	 * @return mixed
	 */
	public function getConstant($name) {
		$constants = $this->getConstants();
		return $constants[$name];
	}

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function hasConstant($name) {
		$constants = $this->getConstants();
		return array_key_exists($name, $constants);
	}

	/**
	 * @param IRunkitConstant $constant
	 *
	 * @return boolean
	 */
	public function addConstant(IRunkitConstant $constant) {
		$result = runkit_constant_add($this->getName() . '::' . $constant->getName(), $constant->getValue());
		if ($result) {
			self::$constants[$this->getName()][$constant->getName()] = $constant;
		}
		return $result;
	}

	/**
	 * @param IRunkitMethod $method
	 *
	 * @return boolean
	 */
	public function addMethod(IRunkitMethod $method) {
		if ($this->hasMethod($method->getName())) {
			$backupMethodName = $method->getName() . 'RunkitBackup';
			$backupMethod = RunkitFactory::createMethod($backupMethodName);
			if (runkit_method_copy($this->getName(), $backupMethod, $this->getName(), $method->getName())) {
				$this->getMethodsHistory()->setBackup($backupMethod);
				self::$methods[$this->getName()][$backupMethodName] = $backupMethod;
				if (runkit_method_remove($this->getName(), $method->getName())) {
					$this->getMethodsHistory()->setDeleted($method);
					unset(self::$methods[$this->getName()][$method->getName()]);
					return $this->addMethodInternal($method);
				}
			}
		} else {
			return $this->addMethodInternal($method);
		}
		return false;
	}

	/**
	 * @param string $name
	 *
	 * @throws \RuntimeException
	 *
	 * @return IRunkitMethod
	 */
	public function getMethod($name) {
		if (!$this->hasMethod($name)) {
			throw new \RuntimeException('Method [' . $name . '] not defined in class' . $this->getName());
		}
		return $this->getMethods()[$name];
	}

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function hasMethod($name) {
		return array_key_exists($this->getName(), $this->getMethods()) || method_exists($this->getName(), $name);
	}

	/**
	 * @return IRunkitMethod[]
	 */
	public function getMethods() {
		$className = $this->getName();
		if (!array_key_exists($className, self::$methods)) {
			self::$methods[$className] = $this->_getMethods($className);
		}
		return self::$methods[$className];
	}

	/**
	 * @return RunkitMethodHistory
	 */
	public function getMethodsHistory() {
		return self::$methodHistory[$this->getName()];
	}

	/**
	 * @return RunkitConstantHistory|IRunkitHistory
	 */
	public function getConstantsHistory() {
		return self::$constantsHistory[$this->getName()];
	}

	/**
	 * @param IRunkitMethod $method
	 *
	 * @return bool
	 */
	protected function addMethodInternal(IRunkitMethod $method) {
		$arguments = $method->getArguments();
		if (!empty($arguments)) {
			$arguments = implode(', ', $arguments);
		} else {
			$arguments = null;
		}
		if (runkit_method_add($this->getName(), $method->getName(), $arguments, $method->getCode(), $method->getVisibility())) {
			$this->getMethodsHistory()->setNew($method);
			self::$methods[$this->getName()][$method->getName()] = $method;
			return true;
		}
		return false;
	}
}