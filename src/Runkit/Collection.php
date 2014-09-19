<?php
namespace Runkit;

/**
 * Class Collection
 * @package Runkit\Collection
 */
interface Collection extends \IteratorAggregate, \Countable, \Traversable {

	/**
	 * @param string $name
	 *
	 * @return Runkit|null
	 */
	public function get($name);

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function has($name);

	/**
	 * @param RunkitFunction|RunkitFunction $item
	 * @throws \RuntimeException
	 *
	 * @return boolean
	 */
	public function add($item);

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function remove($name);
}