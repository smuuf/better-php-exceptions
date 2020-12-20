<?php

declare(strict_types=1);

use \Smuuf\BetterExceptions\BetterException;

require __DIR__ . '/../vendor/autoload.php';

\Tester\Environment::setup();

/**
 * In some contexts PHP 7 refers to, for example, class Ns1\ClassA as
 * 'object' and in other contexts it uses the actual name 'Ns1\Class A'.
 *
 * Apparently when a native type (int, string, etc.) is typehinted,
 * instead of class name the exception message refers to 'object'.
 *
 * Which complicates our tests for supporting multiple PHP versions.
 * So this is a little helper for easier testing.
 */
function object_or_classname($object) {

	if (PHP_MAJOR_VERSION === 7) {
		return 'object';
	} else {

		// Can be aither string (class name) or an actual object.
		return is_string($object)
			? $object
			: get_class($object);

	}

}

/**
 * Convert any throwable to a better exception (or, if not possible, a new
 * exception will be thrown by us).
 */
function get_better_exception(callable $fn, ...$args) {

	try {
		$fn(...$args);
	} catch (\Throwable $ex) {
		return BetterException::from($ex);
	}

	throw new \LogicException("Expected exception but got nothing :(");

}

/**
 * Test-driven-development helper for creating new mapping - create new test for
 * new mapping and use this helper to see the original exception message.
 *
 * (Yes, an exception would be printed out anyway by PHP or by Tester, but
 * then would terminate. This way you can set up multiple cases and see all
 * messages at once.)
 */
function print_exception_message(callable $fn, ...$args) {

	try {
		$fn(...$args);
	} catch (\Throwable $ex) {

		$class = get_class($ex);
		$parents = implode(' extends ', class_parents($ex));
		echo sprintf("Exception: %s (extends $parents)\n", $class);
		echo "  Message: {$ex->getMessage()}\n";

	}

}
