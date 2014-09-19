<?php
namespace Runkit\Helper;

use Runkit\Access;

/**
 * Class GetSetAccess
 * @package Runkit\Helper
 */
trait GetSetAccess {

	/**
	 * @var integer
	 */
	protected $access = Access::ACCESS_PUBLIC;

	/**
	 * @return int
	 */
	public function getAccess() {
		return $this->access;
	}

	/**
	 * @param integer $access
	 *
	 * @return \Runkit\RunkitMethod
	 */
	public function setAccess($access) {
		if (
			$access == Access::ACCESS_PUBLIC ||
			$access == Access::ACCESS_PROTECTED ||
			$access == Access::ACCESS_PRIVATE
		) {
			$this->access = $access;
		}
		return $this;
	}
}