<?php
namespace Runkit\Implementation;

use Runkit\Collection;
use Runkit\Factory;
use Runkit\Helper\GetSetReflection;
use Runkit\Implementation\Collection\Constants;
use Runkit\Implementation\Collection\Methods;
use Runkit\Implementation\Collection\Properties;
use Runkit\Runkit;

/**
 * Class RunkitClass
 * @package Runkit\Implementation
 */
class RunkitClass implements \Runkit\RunkitClass {

	use GetSetReflection;

	/**
	 * @var string|object
	 */
	protected $class;

	/**
	 * @var Collection
	 */
	protected $constants;

	/**
	 * @var Collection
	 */
	protected $properties;

	/**
	 * @var Collection
	 */
	protected $methods;

	/**
	 * @param string|object    $class
	 * @param \ReflectionClass $reflection
	 *
	 * @throws \RuntimeException
	 */
	public function __construct($class, \ReflectionClass $reflection = null) {
		if (is_string($class)) {
			if (!class_exists($class)) {
				throw new \RuntimeException('Class ' . $class . ' is not defined');
			}
		}
		$this->class = $class;
		$this->constants = Factory::createConstantCollection();
		$this->properties = Factory::createPropertyCollection($class);
		$this->methods = Factory::createMethodCollection($class);
	}

	/**
	 * @return string
	 */
	public function getName() {
		return is_object($this->class) ? get_class($this->class) : $this->class;
	}

	/**
	 * @return integer
	 */
	public function getType() {
		return Runkit::TYPE_CLASS;
	}

	/**
	 * @return Collection|Constants
	 */
	public function constants() {
		return $this->constants;
	}

	/**
	 * @return Collection|Methods
	 */
	public function methods() {
		return $this->methods;
	}

	/**
	 * @return Collection|Properties
	 */
	public function properties() {
		return $this->properties;
	}

	/**
	 * @return \ReflectionClass
	 */
	protected function createReflection() {
		return new \ReflectionClass($this->getName());
	}
}