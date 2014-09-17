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
	 * @param array $arguments
	 */
	public function __construct(array $arguments = array()) {
		$this->arguments = $arguments;
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