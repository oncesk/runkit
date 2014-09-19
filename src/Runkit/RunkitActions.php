<?php
namespace Runkit;

/**
 * Class RunkitActions
 * @package Runkit
 */
interface RunkitActions {

	/**
	 * @return boolean
	 */
	public function define();

	/**
	 * @return boolean
	 */
	public function isDefined();

	/**
	 * Redefine function with new argumentns and new code
	 *
	 * @return boolean
	 */
	public function redefine();

	/**
	 * @param string $name
	 * @throws \RuntimeException
	 *
	 * @return boolean
	 */
	public function rename($name);

	/**
	 * @return boolean
	 */
	public function remove();
}