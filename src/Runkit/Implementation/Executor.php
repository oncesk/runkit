<?php
namespace Runkit\Implementation;

use Runkit\Runkit;

/**
 * Class Executor
 * @package Runkit\Implementation
 */
class Executor implements \Runkit\Executor {

	/**
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return boolean
	 */
	public function addConstant($name, $value) {
		if (!function_exists('runkit_constant_add')) {
			return false;
		}
		return runkit_constant_add(
			$name,
			$value
		);
	}

	/**
	 * @param RunkitFunction $function
	 *
	 * @return boolean
	 */
	public function addFunction(\Runkit\RunkitFunction $function) {
		if (!function_exists('runkit_function_add')) {
			return false;
		}
		return runkit_function_add(
			$function->getName(),
			(string) $function->getArguments(),
			$function->getCode()->get()
		);
	}

	/**
	 * @param \Runkit\RunkitMethod $method
	 *
	 * @return boolean
	 */
	public function addMethod(\Runkit\RunkitMethod $method) {
		if (!function_exists('runkit_method_add')) {
			return false;
		}
		return runkit_method_add(
			$method->getClass(),
			$method->getName(),
			(string) $method->getArguments(),
			$method->getCode()->get(),
			$method->getAccess()
		);
	}

	/**
	 * @param \Runkit\RunkitFunction $property
	 *
	 * @return boolean
	 */
	public function addProperty(\Runkit\RunkitProperty $property) {
		if (!function_exists('runkit_default_property_add')) {
			return false;
		}
		$classValue = $property->getClass();
		$class = is_object($classValue) ? get_class($classValue) : $classValue;

		$flags = $property->getOverrideMode() ? $property->getAccess() | Runkit::OVERRIDE_OBJECTS : $property->getAccess();

		return runkit_default_property_add(
			$class,
			$property->getName(),
			$property->getValue(),
			$flags
		);
	}

	/**
	 * @param RunkitConstant $constant
	 *
	 * @return boolean
	 */
	public function redefineConstant(\Runkit\RunkitConstant $constant) {
		if (!function_exists('runkit_constant_redefine')) {
			return false;
		}
		return runkit_constant_redefine(
			$constant->getName(),
			$constant->getValue()
		);
	}

	/**
	 * @param RunkitFunction $function
	 *
	 * @return boolean
	 */
	public function redefineFunction(\Runkit\RunkitFunction $function) {
		if (!function_exists('runkit_function_redefine')) {
			return false;
		}
		return runkit_function_redefine(
			$function->getName(),
			(string) $function->getArguments(),
			$function->getCode()->get()
		);
	}

	/**
	 * @param \Runkit\RunkitMethod $method
	 *
	 * @return boolean
	 */
	public function redefineMethod(\Runkit\RunkitMethod $method) {
		if (!function_exists('runkit_method_redefine')) {
			return false;
		}
		return runkit_method_redefine(
			$method->getClass(),
			$method->getName(),
			(string) $method->getArguments(),
			$method->getCode()->get(),
			$method->getAccess()
		);
	}

	/**
	 * @param RunkitProperty $property
	 *
	 * @return boolean
	 */
	public function redefineProperty(\Runkit\RunkitProperty $property) {
		if (!function_exists('runkit_default_property_add')) {
			return false;
		}
		return runkit_default_property_add(
			$property->getClass(),
			$property->getName(),
			$property->getValue(),
			$property->getAccess() | Runkit::OVERRIDE_OBJECTS
		);
	}

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function removeConstant($name) {
		if (!function_exists('runkit_constant_remove')) {
			return false;
		}
		return runkit_constant_remove(
			$name
		);
	}

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function removeFunction($name) {
		if (!function_exists('runkit_function_remove')) {
			return false;
		}
		return runkit_function_remove(
			$name
		);
	}

	/**
	 * @param string $class
	 * @param string $method
	 *
	 * @return boolean
	 */
	public function removeMethod($class, $method) {
		if (!function_exists('runkit_method_remove')) {
			return false;
		}
		return runkit_method_remove(
			$class,
			$method
		);
	}

	/**
	 * @param string $class
	 * @param string $property
	 *
	 * @return boolean
	 */
	public function removeProperty($class, $property) {
		if (!function_exists('runkit_default_property_remove')) {
			return false;
		}
		return runkit_default_property_remove(
			$class,
			$property
		);
	}

	/**
	 * @param RunkitConstant $constant
	 * @param string         $newName
	 *
	 * @return boolean
	 */
	public function renameConstant(\Runkit\RunkitConstant $constant, $newName) {
		if ($constant->remove()) {
			return $this->addConstant($newName, $constant->getValue());
		}
		return false;
	}

	/**
	 * @param string $oldName
	 * @param string $newName
	 *
	 * @return boolean
	 */
	public function renameFunction($oldName, $newName) {
		if (!function_exists('runkit_function_rename')) {
			return false;
		}
		return runkit_function_rename(
			$oldName,
			$newName
		);
	}

	/**
	 * @param string $className
	 * @param string $name
	 * @param string $newName
	 *
	 * @return boolean
	 */
	public function renameMethod($className, $name, $newName) {
		if (!function_exists('runkit_method_rename')) {
			return false;
		}
		return runkit_method_rename(
			$className,
			$name,
			$newName
		);
	}

	/**
	 * @param RunkitProperty $property
	 * @param string         $newName
	 *
	 * @return boolean
	 */
	public function renameProperty(\Runkit\RunkitProperty $property, $newName) {
		if (!function_exists('runkit_default_property_add')) {
			return false;
		}
		if ($property->remove()) {
			return runkit_default_property_add(
				$property->getClass(),
				$newName,
				$property->getValue(),
				$property->getAccess()
			);
		}
		return false;
	}
}