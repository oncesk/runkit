<?php
namespace Runkit;

use Runkit\RunkitConstant;
use Runkit\RunkitMethod;

/**
 * Class Executor
 * @package Runkit
 */
interface Executor {

	/**
	 * @param string $name
	 * @param mixed $value
	 *
	 * @return boolean
	 */
	public function addConstant($name, $value);

	/**
	 * @param RunkitFunction $function
	 *
	 * @return boolean
	 */
	public function addFunction(\Runkit\RunkitFunction $function);

	/**
	 * @param RunkitMethod $method
	 *
	 * @return boolean
	 */
	public function addMethod(\Runkit\RunkitMethod $method);

	/**
	 * @param RunkitProperty $property
	 *
	 * @return boolean
	 */
	public function addProperty(\Runkit\RunkitProperty $property);

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function removeConstant($name);

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function removeFunction($name);

	/**
	 * @param string $class
	 * @param string $method
	 *
	 * @return boolean
	 */
	public function removeMethod($class, $method);

	/**
	 * @param string $class
	 * @param string $property
	 *
	 * @return boolean
	 */
	public function removeProperty($class, $property);

	/**
	 * @param string $oldName
	 * @param string $newName
	 *
	 * @return boolean
	 */
	public function renameFunction($oldName, $newName);

	/**
	 * @param string $className
	 * @param string $name
	 * @param string $newName
	 *
	 * @return boolean
	 */
	public function renameMethod($className, $name, $newName);

	/**
	 * @param RunkitConstant $constant
	 * @param string         $newName
	 *
	 * @return boolean
	 */
	public function renameConstant(\Runkit\RunkitConstant $constant, $newName);

	/**
	 * @param RunkitProperty $property
	 * @param string         $newName
	 *
	 * @return boolean
	 */
	public function renameProperty(\Runkit\RunkitProperty $property, $newName);

	/**
	 * @param RunkitFunction $function
	 *
	 * @return boolean
	 */
	public function redefineFunction(\Runkit\RunkitFunction $function);

	/**
	 * @param RunkitMethod $method
	 *
	 * @return boolean
	 */
	public function redefineMethod(\Runkit\RunkitMethod $method);

	/**
	 * @param RunkitConstant $constant
	 *
	 * @return boolean
	 */
	public function redefineConstant(\Runkit\RunkitConstant $constant);

	/**
	 * @param RunkitProperty $property
	 *
	 * @return boolean
	 */
	public function redefineProperty(\Runkit\RunkitProperty $property);
}