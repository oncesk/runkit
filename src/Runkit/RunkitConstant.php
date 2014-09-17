<?php
namespace Runkit;

/**
 * Class RunkitConstant
 * @package Runkit
 */
interface RunkitConstant extends Runkit, RunkitActions {

	/**
	 * @param string $name
	 * @throws \RuntimeException
	 */
	public function __construct($name);

	/**
	 * @return mixed
	 */
	public function getValue();

	/**
	 * @param mixed $value
	 *
	 * @return boolean
	 */
	public function setValue($value);
}