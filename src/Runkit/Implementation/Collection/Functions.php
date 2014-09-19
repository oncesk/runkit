<?php
namespace Runkit\Implementation\Collection;

use Runkit\Factory;
use Runkit\Helper\Reflection;
use Runkit\Runkit;
use Runkit\RunkitFunction;

/**
 * Class Functions
 * @package Runkit\Implementation\Collection
 */
class Functions extends AbstractCollection {

	/**
	 * @param string $name
	 *
	 * @return RunkitFunction|null
	 */
	public function get($name) {
		return parent::get($name);
	}

	/**
	 * @param RunkitFunction $item
	 *
	 * @return bool
	 */
	protected function addInternal($item) {
		return Factory::getExecutor()->addFunction($item->getName(), $item->getArguments(), $item->getCode());
	}

	/**
	 * @param RunkitFunction $item
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
		return Runkit::TYPE_FUNCTION;
	}

	/**
	 * @param Runkit $item
	 *
	 * @throws \RuntimeException
	 */
	protected function checkObjectInstance(Runkit $item) {
		if (!($item instanceof RunkitFunction)) {
			throw new \RuntimeException('Item should be instance of RunkitFunction');
		}
	}
}