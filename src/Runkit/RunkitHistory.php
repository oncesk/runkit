<?php
namespace Runkit;

/**
 * Class RunkitHistory
 * @package Runkit
 */
class RunkitHistory implements IRunkitHistory {

	private $new = array();
	private $deleted = array();
	private $redefined = array();
	private $backup = array();

	/**
	 * @param IRunkit $backup
	 *
	 * @return IRunkitHistory
	 */
	public function setBackup(IRunkit $backup) {
		$this->backup[$backup->getName()] = $backup;
		return $this;
	}

	/**
	 * @param IRunkit $new
	 *
	 * @return IRunkitHistory
	 */
	public function setNew(IRunkit $new) {
		$this->new[$new->getName()] = $new;
		return $this;
	}

	/**
	 * @param IRunkit $deleted
	 *
	 * @return IRunkitHistory
	 */
	public function setDeleted(IRunkit $deleted) {
		$this->deleted[$deleted->getName()] = $deleted;
		return $this;
	}

	/**
	 * @param IRunkit $redefined
	 *
	 * @return IRunkitHistory
	 */
	public function setRedefined(IRunkit $redefined) {
		$this->redefined[$redefined->getName()] = $redefined;
		return $this;
	}

	/**
	 * @return IRunkitMethod[]|IRunkitConstant[]
	 */
	public function getBackup() {
		return $this->backup;
	}

	/**
	 * @return IRunkitMethod[]|IRunkitConstant[]
	 */
	public function getRedefined() {
		return $this->redefined;
	}

	/**
	 * @return IRunkitMethod[]|IRunkitConstant[]
	 */
	public function getNew() {
		return $this->new;
	}

	/**
	 * @return IRunkitMethod[]|IRunkitConstant[]
	 */
	public function getDeleted() {
		return $this->deleted;
	}
}