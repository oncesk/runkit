<?php
namespace Runkit;

/**
 * Class RunkitActions
 * @package Runkit
 */
interface Runkit {

	const TYPE_CLASS = 0;
	const TYPE_METHOD = 1;
	const TYPE_CONSTANT = 2;
	const TYPE_FUNCTION = 3;
	const TYPE_PROPERTY = 4;

	const OVERRIDE_OBJECTS = RUNKIT_OVERRIDE_OBJECTS;

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return integer
	 */
	public function getType();
}