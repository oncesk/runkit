<?php
namespace Runkit\Implementation\Collection;

use Runkit\Factory;
use Runkit\RunkitProperty;
use Runkit\Runkit;
use Runkit\Helper\Reflection;

/**
 * Class Properties
 * @package Runkit\Implementation\Collection
 */
class Properties extends AbstractCollection {

	/**
	 * @var string
	 */
	protected $class;

	/**
	 * @param string|null $class
	 */
	public function __construct($class = null) {
		if ($class) {
			$this->class = $class;

			$propertyClass = Factory::$propertyClass;
			foreach (Reflection::getClass($class)->getProperties() as $property) {
				$this->add(new $propertyClass($class, $property->getName(), $property));
			}
		}
	}

	/**
	 * @param string $name
	 *
	 * @return RunkitProperty|null
	 */
	public function get($name) {
		return parent::get($name);
	}

	/**
	 * @param RunkitProperty $item
	 *
	 * @return mixed
	 */
	protected function addInternal($item) {
		return Factory::getExecutor()->addProperty($item);
	}

	/**
	 * @param RunkitProperty $item
	 *
	 * @return boolean
	 */
	protected function removeInternal($item) {
		return $item->remove();
	}

	/**
	 * @return integer
	 */
	protected function getCollectionType() {
		return Runkit::TYPE_PROPERTY;
	}

	/**
	 * @param Runkit $item
	 *
	 * @throws \RuntimeException
	 */
	protected function checkObjectInstance(Runkit $item) {
		if (!($item instanceof RunkitProperty)) {
			throw new \RuntimeException('Item should be instance of Runkit\RunkitProperty');
		}
	}
}