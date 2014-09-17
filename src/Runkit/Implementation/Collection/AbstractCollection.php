<?php
namespace Runkit\Implementation\Collection;

use Runkit\Collection;
use Runkit\Runkit;
use Runkit\RunkitConstant;
use Runkit\RunkitFunction;
use Runkit\RunkitMethod;

abstract class AbstractCollection implements Collection {

	/**
	 * @var Runkit[]
	 */
	protected $items = array();

	/**
	 * @param RunkitFunction|RunkitFunction|RunkitConstant $item
	 *
	 * @throws \RuntimeException
	 *
	 * @return boolean
	 */
	public function add($item) {
		if ($item->getType() == $this->getCollectionType() && $this->checkObjectInstance($item)) {
			if ($this->addInternal($item)) {
				$this->items[$item->getName()] = $item;
				return true;
			}
		}
		return false;
	}

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function remove($name) {
		if ($this->has($name)) {
			$item = $this->get($name);
			if ($this->removeInternal($item)) {
				unset($this->items[$name]);
				return true;
			} else {
				return false;
			}
		}
		return true;
	}

	/**
	 * @param string $name
	 *
	 * @return RunkitMethod|RunkitFunction|RunkitConstant|null
	 */
	public function get($name) {
		return $this->has($name) ? $this->items[$name] : null;
	}

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function has($name) {
		return array_key_exists($name, $this->items);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Retrieve an external iterator
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return \Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 */
	public function getIterator() {
		return new \ArrayIterator($this->items);
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Count elements of an object
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 *       The return value is cast to an integer.
	 */
	public function count() {
		return count($this->items);
	}

	/**
	 * @param Runkit $item
	 *
	 * @return mixed
	 */
	abstract protected function addInternal($item);

	/**
	 * @param RunkitFunction|RunkitConstant|RunkitMethod $item
	 *
	 * @return boolean
	 */
	abstract protected function removeInternal($item);

	/**
	 * @return integer
	 */
	abstract protected function getCollectionType();

	/**
	 * @param Runkit $item
	 *
	 * @throws \RuntimeException
	 */
	abstract protected function checkObjectInstance(Runkit $item);
}