<?php
namespace Runkit;

/**
 * Class RunkitFunction
 * @package Runkit
 */
interface RunkitFunction extends Runkit, CodeOwner, RunkitActions, ArgumentsProvider {

	/**
	 * @param string              $name
	 * @param \ReflectionFunction $reflection
	 *
	 * @throws \RuntimeException
	 */
	public function __construct($name, \ReflectionFunction $reflection = null);

	/**
	 * @throws \RuntimeException
	 * @return mixed
	 */
	public function __invoke();
}