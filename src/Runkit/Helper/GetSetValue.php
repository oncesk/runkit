<?php
namespace Runkit\Helper;

/**
 * Class GetSetValue
 * @package Runkit\Helper
 */
trait GetSetValue {

	protected $value;

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param mixed $value
	 *
	 * @return boolean
	 */
	public function setValue($value) {
		$this->value = $value;
		return true;
	}
}