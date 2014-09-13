<?php
namespace Runkit;

/**
 * Class IRunkitConstant
 * @package Runkit
 */
interface IRunkitConstant extends IRunkit {

	/**
	 * Return full name with class name if it exists
	 *
	 * @return string
	 */
	public function getFullName();

	/**
	 * Return current constant value
	 *
	 * @throws \RuntimeException
	 * @return mixed
	 */
	public function getValue();

	/**
	 * @param string|null|boolean|integer $value
	 * @param bool $rewriteIfExists
	 *
	 * @return mixed
	 */
	public function setValue($value, $rewriteIfExists = true);

	/**
	 * @return boolean if constant exists in class was returned true else false
	 */
	public function exists();

	/**
	 * @return boolean result of removing constant from clas
	 */
	public function remove();

	/**
	 * Name of constant class
	 *
	 * @return string or null if constant define for global namespace
	 */
	public function getClassName();

	/**
	 * @param string $className
	 *
	 * @return IRunkitConstant
	 */
	public function setClassName($className);
}