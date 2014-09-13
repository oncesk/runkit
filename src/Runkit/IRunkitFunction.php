<?php
namespace Runkit;

/**
 * Class IRunkitFunction
 * @package Runkit
 */
interface IRunkitFunction extends IRunkit {

	/**
	 * @return array
	 */
	public function getArguments();

	/**
	 * @param array $arguments
	 *
	 * @return IRunkitFunction
	 */
	public function setArguments(array $arguments = array());

	/**
	 * @return string|null
	 */
	public function getCode();

	/**
	 * @param $code
	 *
	 * @return IRunkitMethod
	 */
	public function setCode($code);

	/**
	 * @throws \RuntimeException
	 *
	 * @return boolean
	 */
	public function add();

	/**
	 * Redefine function with new argumentns and new code
	 *
	 * @return boolean
	 */
	public function redefine();

	/**
	 * Remove function from scope
	 *
	 * @return boolean
	 */
	public function remove();

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function rename($name);

	/**
	 * @param string $name
	 * @throws \RuntimeException
	 *
	 * @return IRunkitFunction
	 */
	public function copy($name);
}