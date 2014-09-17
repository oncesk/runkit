<?php
namespace Runkit;

/**
 * Class RunkitActions
 * @package Runkit
 */
interface RunkitActions {

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