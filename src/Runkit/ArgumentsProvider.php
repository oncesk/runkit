<?php
namespace Runkit;

/**
 * Class ArgumentsProvider
 * @package Runkit\Item
 */
interface ArgumentsProvider {

	/**
	 * @return ArgumentsCollection
	 */
	public function getArguments();
}