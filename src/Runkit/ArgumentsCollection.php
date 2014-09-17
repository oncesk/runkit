<?php
namespace Runkit;

/**
 * Class Arguments
 * @package Runkit
 */
interface ArgumentsCollection {

	/**
	 * @return array
	 */
	public function getAll();

	/**
	 * @param string $argument
	 *
	 * @return boolean
	 */
	public function hasArgument($argument);

	/**
	 * @param array $arguments
	 *
	 * @return $this
	 */
	public function setArguments(array $arguments = array());

	/**
	 * @param string $argument
	 * @throws \RuntimeException
	 *
	 * @return ArgumentsCollection
	 */
	public function add($argument);

	/**
	 * @return string
	 */
	public function __toString();
}