<?php
namespace Runkit;

/**
 * Class RunkitFunction
 * @package Runkit
 */
class RunkitFunction implements IRunkitFunction {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $code;

	/**
	 * @var array
	 */
	protected $arguments = array();

	/**
	 * @var \ReflectionFunction
	 */
	protected $reflection;

	/**
	 * @param string $name
	 * @throws \RuntimeException
	 */
	public function __construct($name) {
		if (!is_string($name) || empty($name)) {
			throw new \RuntimeException('Invalid name');
		}
		$this->name = $name;
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
		return IRunkit::TYPE_FUNCTION;
	}

	/**
	 * @param $code
	 *
	 * @return IRunkitMethod
	 */
	public function setCode($code) {
		if (is_string($code)) {
			$this->code = $code;
		}
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCode() {
		if ($this->code === null && function_exists($this->getName())) {
			$reflection = $this->getReflection();
			$this->code = $this->fetchCode(
				$reflection->getFileName(),
				$reflection->getStartLine(),
				$reflection->getEndLine()
			);
		}
		return $this->code;
	}

	/**
	 * @param array $arguments
	 *
	 * @return IRunkitFunction
	 */
	public function setArguments(array $arguments = array()) {
		$this->arguments = $arguments;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getArguments() {
		return $this->arguments;
	}

	/**
	 * @throws \RuntimeException
	 *
	 * @return boolean
	 */
	public function add() {
		if (function_exists($this->getName())) {
			throw new \RuntimeException('Function ' . $this->getName() . ' already exists');
		}
		$arguments = $this->getArguments();
		return runkit_function_add(
			$this->getName(),
			!empty($arguments) ? implode(', ', $arguments) : '',
			$this->getCode()
		);
	}

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function rename($name) {
		if (is_string($name) && !empty($name)) {
			if (runkit_function_rename($this->getName(), $name)) {
				$this->name = $name;
				return true;
			}
		}
		return false;
	}

	/**
	 * Redefine function with new argumentns and new code
	 *
	 * @return boolean
	 */
	public function redefine() {
		$arguments = $this->getArguments();
		return runkit_function_redefine(
			$this->getName(),
			!empty($arguments) ? implode(',', $arguments) : '',
			(string) $this->getCode()
		);
	}

	/**
	 * Remove function from scope
	 *
	 * @return boolean
	 */
	public function remove() {
		return function_exists($this->getName()) ? runkit_function_remove($this->getName()) : true;
	}

	/**
	 * @param string $name
	 *
	 * @throws \RuntimeException
	 *
	 * @return IRunkitFunction
	 */
	public function copy($name) {
		$copy = new self($name);
		$copy
			->setArguments($this->getArguments())
			->setCode($this->getCode());
		if ($copy->add()) {
			return $copy;
		}
		throw new \RuntimeException('Can not copy function ' . $this->getName());
	}

	public function __invoke() {
		return $this->getReflection()->invokeArgs(func_get_args());
	}

	/**
	 * @return \ReflectionFunction
	 */
	protected function getReflection() {
		if ($this->reflection) {
			return $this->reflection;
		}
		return $this->reflection = new \ReflectionFunction($this->getName());
	}

	/**
	 * @param $file
	 * @param $startLine
	 * @param $endLine
	 *
	 * @return string
	 */
	protected function fetchCode($file, $startLine, $endLine) {
		if (!file_exists($file)) {
			return '';
		}
		return implode(
			'',
			array_slice(
				file($file),
				$startLine,
				$endLine - $startLine - 1
			)
		);
	}
}