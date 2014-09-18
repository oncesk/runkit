<?php
namespace Runkit;

/**
 * Class RunkitMethod
 * @package Runkit
 */
interface RunkitMethod extends Runkit, ArgumentsProvider, CodeOwner, RunkitActions, Access {

	/**
	 * @param string            $class
	 * @param string            $method
	 * @param array             $arguments
	 * @param \ReflectionMethod $reflection
	 *
	 * @throws \RuntimeException
	 */
	public function __construct($class, $method, array $arguments = array(), \ReflectionMethod $reflection = null);

	/**
	 * @return string
	 */
	public function getClass();
}