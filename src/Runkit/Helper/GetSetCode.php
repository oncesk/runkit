<?php
namespace Runkit\Helper;

use Runkit\Factory;
use Runkit\Code;

/**
 * Class GetSetCode
 * @package Runkit
 */
trait GetSetCode {

	/**
	 * @var Code
	 */
	protected $code;

	/**
	 * @return Code
	 */
	public function getCode() {
		if ($this->code === null) {
			$this->code = Factory::createCode($this->getReflection());
		}
		return $this->code;
	}

	/**
	 * @param Code $code
	 *
	 * @return $this
	 */
	public function setCode(Code $code) {
		if ($code->isValid()) {
			$this->code = $code;
		}
		return $this;
	}

	/**
	 * @return \ReflectionFunctionAbstract
	 */
	abstract protected function getReflection();
}