<?php
namespace Runkit;

/**
 * Class RunkitOverride
 * @package Runkit
 */
interface RunkitOverride {

	/**
	 * @return $this
	 */
	public function setOverrideMode();

	/**
	 * @return boolean
	 */
	public function overrideObjects();
}