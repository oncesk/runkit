<?php
namespace Runkit\Implementation\Collection;

use Runkit\Runkit;
use Runkit\Factory;
use Runkit\RunkitMethod;
use Runkit\Helper\Reflection;

/**
 * Class Methods
 * @package Runkit\Collection
 */
class Methods extends AbstractCollection {

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

			$methodClass = Factory::$methodClass;
			foreach (Reflection::getClassMethods($class) as $method) {
				$this->add(new $methodClass($class, $method->getName(), array(), $method));
			}
		}
	}

	/**
	 * @param string $name
	 *
	 * @return RunkitMethod|null
	 */
	public function get($name) {
		return parent::get($name);
	}

	/**
	 * @param RunkitMethod $item
	 *
	 * @return mixed
	 */
	protected function addInternal($item) {
		return Factory::getExecutor()->addMethod($item);
	}

	/**
	 * @param RunkitMethod $item
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
		return Runkit::TYPE_METHOD;
	}

	/**
	 * @param Runkit $item
	 *
	 * @throws \RuntimeException
	 */
	protected function checkObjectInstance(Runkit $item) {
		if (!($item instanceof RunkitMethod)) {
			throw new \RuntimeException('Item should be instance of RunkitMethod');
		}
	}
}