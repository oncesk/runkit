<?php
namespace Runkit\Implementation\Collection;

use Runkit\ArgumentsCollection;

/**
 * Class Arguments
 * @package Runkit\Collection
 */
class Arguments implements ArgumentsCollection {

	/**
	 * @var array
	 */
	private $arguments = array();

	/**
	 * @var \ReflectionFunctionAbstract
	 */
	private $reflection;

	/**
	 * @param array                       $arguments
	 * @param \ReflectionFunctionAbstract $reflection
	 */
	public function __construct(array $arguments = array(), \ReflectionFunctionAbstract $reflection = null) {
		$this->arguments = $arguments;
		$this->reflection = $reflection;
		if ($reflection) {
			foreach ($reflection->getParameters() as $parameter) {
				if ($parameter->isOptional()) {
					$this->add('$' . $parameter->getName() . ' = ' . $parameter->getDefaultValue());
				} else {
					$this->add('$' . $parameter->getName());
				}
			}
		}
	}

	/**
	 * @return array
	 */
	public function getAll() {
		return $this->arguments;
	}

	/**
	 * @param string $argument
	 *
	 * @return boolean
	 */
	public function hasArgument($argument) {
		return in_array($argument, $this->arguments);
	}

	/**
	 * @param string $argument
	 *
	 * @throws \RuntimeException
	 *
	 * @return ArgumentsCollection
	 */
	public function add($argument) {
		if ($this->hasArgument($argument)) {
			throw new \RuntimeException('Argument ' . $argument . ' already defined');
		}
		$this->arguments[] = $argument;
		return $this;
	}


	/**
	 * @param array $arguments
	 *
	 * @return $this
	 */
	public function setArguments(array $arguments = array()) {
		$this->arguments = $arguments;
		return $this;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return implode(',', $this->getAll());
	}
}