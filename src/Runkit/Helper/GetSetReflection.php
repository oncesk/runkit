<?php
namespace Runkit\Helper;

/**
 * Class GetSetReflection
 * @package Runkit
 */
trait GetSetReflection {

	/**
	 * @var \ReflectionFunctionAbstract
	 */
	protected $reflection;

	/**
	 * @param $reflection
	 *
	 * @return $this
	 */
	protected function setReflection($reflection) {
		$this->reflection = $reflection;
		return $this;
	}

	/**
	 * @return \ReflectionFunction|null
	 */
	protected function getReflection() {
		if ($this->reflection) {
			return $this->reflection;
		}
		return $this->reflection = $this->createReflection();
	}

	/**
	 * @return \ReflectionFunctionAbstract|null
	 */
	abstract protected function createReflection();
}