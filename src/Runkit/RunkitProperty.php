<?php
/**
 * Created by JetBrains PhpStorm.
 * User: once
 * Date: 9/17/14
 * Time: 2:11 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Runkit;


interface RunkitProperty extends Runkit, RunkitActions, Access, RunkitOverride {

	/**
	 * @param string              $class
	 * @param string              $property
	 * @param \ReflectionProperty $reflection
	 *
	 * @throws \RuntimeException
	 */
	public function __construct($class, $property, \ReflectionProperty $reflection = null);

	/**
	 * @return string
	 */
	public function getClass();

	/**
	 * @param mixed $value
	 *
	 * @return boolean
	 */
	public function setValue($value);

	/**
	 * @return mixed
	 */
	public function getValue();
}