<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\Processors\Base;

use \Smuuf\BetterExceptions\Types\ReturnTypeError;
use \Smuuf\BetterExceptions\Types\ArgumentTypeError;
use \Smuuf\BetterExceptions\Internals\RegexMatcher;
use \Smuuf\BetterExceptions\Internals\Processors\ProcessorInterface;

abstract class BaseTypeErrorProcessor implements ProcessorInterface {

	public static function process(\Throwable $ex): ?\Throwable {

		$msg = $ex->getMessage();

		// Try if this TypeError is about a type of passed argument.
		if ($match = RegexMatcher::matchEither(static::getArgumentTypeRegexes(), $msg)) {

			static::processMatch($match);
			return new ArgumentTypeError(
				$msg,
				$match['expected'],
				$match['actual'],
				(int) $match['index']
			);

		}

		// Try if this TypeError is about a type of returned value.
		if ($match = RegexMatcher::match(static::getReturnTypeRegex(), $msg)) {

			static::processMatch($match);
			return new ReturnTypeError(
				$msg,
				$match['expected'],
				$match['actual']
			);

		}

		return null;

	}

	/**
	 * Prepare match data into expected form. This is done in-place.
	 *
	 * @param array<int|string> $match Array of matches from `preg_match()`.
	 */
	abstract protected static function processMatch(array &$match): void;

	/**
	 * Return list of regexes matching the message of general \TypeError
	 * that represents an argument type error.
	 *
	 * @return array<string>
	 */
	abstract protected static function getArgumentTypeRegexes(): array;

	/**
	 * Returns regex matching the message of general \TypeError that represents
	 * a return type error.
	 */
	abstract protected static function getReturnTypeRegex(): string;

}
