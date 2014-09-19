<?php
namespace Runkit;

/**
 * Class CodeOwner
 * @package Runkit
 */
interface CodeOwner {

	/**
	 * @return Code
	 */
	public function getCode();

	/**
	 * @param Code $code
	 *
	 * @return $this
	 */
	public function setCode(Code $code);
}