<?php
namespace Runkit\Implementation;

/**
 * Class Code
 * @package Runkit\Implementation
 */
class Code implements \Runkit\Code {

	/**
	 * @var string
	 */
	protected $code = '';

	/**
	 * @param \ReflectionFunctionAbstract|null $reflection
	 */
	public function __construct(\ReflectionFunctionAbstract $reflection = null) {
		if ($reflection) {
			$this->code = $this->fetchCode($reflection);
		}
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return (string) $this->code;
	}

	/**
	 * @return string
	 */
	public function get() {
		return $this->code;
	}

	/**
	 * @param string $code
	 *
	 * @return boolean
	 */
	public function set($code) {
		if ($this->validateCode($code)) {
			$this->code = $code;
			return true;
		}
		return false;
	}

	/**
	 * @return boolean
	 */
	public function isValid() {
		if ($this->code) {
			return $this->validateCode($this->code);
		}
		return true;
	}

	/**
	 * @param string $code
	 *
	 * @return boolean
	 */
	protected function validateCode($code) {
		if (function_exists('runkit_lint')) {
			return runkit_lint($code);
		}
		return true; // expected as code valid if runkit_lint not defined
	}

	/**
	 * @param \ReflectionFunctionAbstract $reflection
	 *
	 * @return string
	 */
	protected function fetchCode(\ReflectionFunctionAbstract $reflection) {
		$file = $reflection->getFileName();
		if (!file_exists($file)) {
			return '';
		}
		$startLine = $reflection->getStartLine();
		return implode(
			'',
			array_slice(
				file($file),
				$startLine,
				$reflection->getEndLine() - $startLine - 1
			)
		);
	}
}