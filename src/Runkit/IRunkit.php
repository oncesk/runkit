<?php
namespace Runkit;

/**
 * Class IRunkit
 * @package Runkit
 */
interface IRunkit {

	const TYPE_CLASS = 0;
	const TYPE_METHOD = 1;
	const TYPE_CONSTANT = 2;
	const TYPE_FUNCTION = 3;

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return integer
	 */
	public function getType();
}