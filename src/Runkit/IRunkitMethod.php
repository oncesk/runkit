<?php
namespace Runkit;

/**
 * Class IRunkitMethod
 * @package Runkit
 */
interface IRunkitMethod extends IRunkitFunction {

	const ACCESS_PUBLIC = RUNKIT_ACC_PUBLIC;
	const ACCESS_PROTECTED = RUNKIT_ACC_PROTECTED;
	const ACCESS_PRIVATE = RUNKIT_ACC_PRIVATE;

	/**
	 * @return int
	 */
	public function getAccess();

	/**
	 * @param const $access
	 *
	 * @return IRunkitMethod
	 */
	public function setAccess($access);

	/**
	 * @param IRunkitClass $class
	 *
	 * @return IRunkitMethod
	 */
	public function setRunkitClass(IRunkitClass $class);

	/**
	 * @return IRunkitClass
	 */
	public function getRunkitClass();

	/**
	 * @param $className
	 * @param $methodName
	 *
	 * @throws \RuntimeException
	 *
	 * @return IRunkitMethod
	 */
	public function copyToClass($className, $methodName);
}