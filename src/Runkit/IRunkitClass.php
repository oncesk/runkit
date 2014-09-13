<?php
namespace Runkit;

/**
 * Class IRunkitClass
 * @package Runkit
 */
interface IRunkitClass extends IRunkit {

	/**
	 * @return IRunkitMethod[]
	 */
	public function getMethods();

	/**
	 * @param string $name
	 * @throws \RuntimeException
	 *
	 * @return IRunkitMethod
	 */
	public function getMethod($name);

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function hasMethod($name);

	/**
	 * @param IRunkitMethod $method
	 *
	 * @return boolean
	 */
	public function addMethod(IRunkitMethod $method);

	/**
	 * @return IRunkitConstant[]
	 */
	public function getConstants();

	/**
	 * @param string $name
	 * @throws \RuntimeException
	 *
	 * @return mixed
	 */
	public function getConstant($name);

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function hasConstant($name);

	/**
	 * @param IRunkitConstant $constant
	 *
	 * @return boolean
	 */
	public function addConstant(IRunkitConstant $constant);

	/**
	 * @return RunkitMethodHistory|IRunkitHistory
	 */
	public function getMethodsHistory();

	/**
	 * @return RunkitConstantHistory|IRunkitHistory
	 */
	public function getConstantsHistory();
}