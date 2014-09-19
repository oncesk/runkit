<?php
namespace Runkit;

/**
 * Class Access
 * @package Runkit
 */
interface Access {

	const ACCESS_PUBLIC = RUNKIT_ACC_PUBLIC;
	const ACCESS_PROTECTED = RUNKIT_ACC_PROTECTED;
	const ACCESS_PRIVATE = RUNKIT_ACC_PRIVATE;

	/**
	 * @return int
	 */
	public function getAccess();

	/**
	 * @param integer $access
	 *
	 * @return RunkitMethod
	 */
	public function setAccess($access);
}