<?php
namespace Runkit\Implementation\Collection;

use Runkit\Factory;
use Runkit\Runkit;
use Runkit\RunkitConstant;

/**
 * Class Constants
 * @package Runkit\Implementation\Collection
 */
class Constants extends AbstractCollection {

	/**
	 * @param RunkitConstant $item
	 *
	 * @return mixed
	 */
	protected function addInternal($item) {
		return Factory::getExecutor()->addConstant($item->getName(), $item->getValue());
	}

	/**
	 * @param Runkit $item
	 *
	 * @return boolean
	 */
	protected function removeInternal($item) {
		return Factory::getExecutor()->removeConstant($item->getName());
	}

	/**
	 * @return integer
	 */
	protected function getCollectionType() {
		return Runkit::TYPE_CONSTANT;
	}

	/**
	 * @param Runkit $item
	 *
	 * @throws \RuntimeException
	 */
	protected function checkObjectInstance(Runkit $item) {
		if (!($item instanceof RunkitConstant)) {
			throw new \RuntimeException('Item should be instance of RunkitConstant');
		}
	}
}