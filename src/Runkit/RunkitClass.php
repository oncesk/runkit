<?php
namespace Runkit;

use Runkit\Collection;

/**
 * Class IClass
 * @package Runkit\Item
 */
interface RunkitClass extends Runkit {

	/**
	 * @param string|object    $class
	 * @param \ReflectionClass $reflection
	 * @throws \RuntimeException
	 */
	public function __construct($class, \ReflectionClass $reflection = null);

	/**
	 * @return Collection
	 */
	public function methods();

	/**
	 * @return Collection
	 */
	public function constants();

	/**
	 * @return Collection
	 */
	public function properties();
}