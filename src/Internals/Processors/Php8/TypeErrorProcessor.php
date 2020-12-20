<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\Processors\Php8;

use \Smuuf\BetterExceptions\Internals\Processors\Base\BaseTypeErrorProcessor;

abstract class TypeErrorProcessor extends BaseTypeErrorProcessor {

	protected const RETURN_TYPEERROR_REGEX = <<<RX
		@
			Return\ value
			.*?
			((of\ type\ ) | (an\ instance\ of\ ))
			(?<expected>[\\\\a-z0-9?|]+)
			(?<ornull>\ or\ null)?
			.*?
			(\ instance\ of)?\ (?<actual>[\\\\a-z0-9]+)\ returned
		@xi
		RX;

	protected const ARGUMENT_TYPEERROR_REGEXES = [
		<<<RX
			@
				Argument\ \#(?<index>\d+)
				.*?
				of\ type\ (?<expected>[\\\\a-z0-9?|]+)
				,\ (instance\ of\ )?(?<actual>[\\\\a-z0-9]+)\ given
			@xi
		RX,
		<<<RX
			@
				expects\ parameter\ (?<index>\d+)\ to\ be
				\ (?<expected>[\\\\a-z0-9?|]+)
				(?<ornull>\ or\ null)?
				,\ (?<actual>[\\\\a-z0-9]+)\ given
			@xi
		RX,
	];

	protected static function processMatch(array &$match): void {

		// BetterTypeError expects list of expected types..
		$expected = explode('|', $match['expected']);
		foreach ($expected as &$type) {

			// Check if this type is nullable (e.g. '?int').
			if ($type[0] === '?') {
				// If so, add 'null' to the list of expected types and remove
				// the questionmark character from the original type.
				$expected[] = 'null';
				$type = substr($type, 1);
			}

		}

		$match['expected'] = $expected;

	}

	protected static function getArgumentTypeRegexes(): array {
		return self::ARGUMENT_TYPEERROR_REGEXES;
	}

	protected static function getReturnTypeRegex(): string {
		return self::RETURN_TYPEERROR_REGEX;
	}

}
