<?php
namespace Runkit;

/**
 * Class CodeOwner
 * @package Runkit
 */
interface Code {

	/**
	 * @param \ReflectionFunctionAbstract|null $reflection
	 */
	public function __construct(\ReflectionFunctionAbstract $reflection = null);

	/**
	 * @return string
	 */
	public function get();

	/**
	 * @param string $code
	 *
	 * @return boolean
	 */
	public function set($code);

	/**
	 * @return boolean
	 */
	public function isValid();

	/**
	 * @return string
	 */
	public function __toString();
}