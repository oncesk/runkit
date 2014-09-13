<?php
namespace Runkit;

/**
 * Class IRunkitHistory
 * @package Runkit
 */
interface IRunkitHistory {

	/**
	 * @param IRunkit $deleted
	 *
	 * @return IRunkitHistory
	 */
	public function setDeleted(IRunkit $deleted);

	/**
	 * @return IRunkitMethod[]|IRunkitConstant[]
	 */
	public function getDeleted();

	/**
	 * @param IRunkit $new
	 *
	 * @return IRunkitHistory
	 */
	public function setNew(IRunkit $new);

	/**
	 * @return IRunkitMethod[]|IRunkitConstant[]
	 */
	public function getNew();

	/**
	 * @param IRunkit $redefined
	 *
	 * @return IRunkitHistory
	 */
	public function setRedefined(IRunkit $redefined);

	/**
	 * @return IRunkitMethod[]|IRunkitConstant[]
	 */
	public function getRedefined();

	/**
	 * @param IRunkit $backup
	 *
	 * @return mixed
	 */
	public function setBackup(IRunkit $backup);

	/**
	 * @return IRunkitMethod[]|IRunkitConstant[]
	 */
	public function getBackup();
}