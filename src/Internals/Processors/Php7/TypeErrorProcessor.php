<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\Processors\Php7;

use \Smuuf\BetterExceptions\Internals\Processors\Base\BaseTypeErrorProcessor;

abstract class TypeErrorProcessor extends BaseTypeErrorProcessor {

	protected const RETURN_TYPEERROR_REGEX = <<<RX
		@
			Return\ value
			.*?
			((of\ the\ type\ ) | (an\ instance\ of\ ))
			(?<expected>[\\\\a-z0-9]+)
			(?<ornull>\ or\ null)?
			.*?
			(\ instance\ of)?\ (?<actual>[\\\\a-z0-9]+)\ returned
		@xi
		RX;

	protected const ARGUMENT_TYPEERROR_REGEXES = [
		<<<RX
			@
				Argument\ (?<index>\d+)
				.*?
				of\ (the\ type\ )?(?<expected>[\\\\a-z0-9]+)
				(?<ornull>\ or\ null)?,
				\ (instance\ of\ )?(?<actual>[\\\\a-z0-9]+)\ given
			@xi
		RX,
		<<<RX
			@
				expects\ parameter\ (?<index>\d+)\ to\ be
				\ (?<expected>[\\\\a-z0-9]+)
				(?<ornull>\ or\ null)?
				,\ (?<actual>[\\\\a-z0-9]+)\ given
			@xi
		RX,
	];

	protected static function processMatch(array &$match): void {

		// BetterTypeError class expects list of expected types.
		$expected = [$match['expected']];

		// Also if a 'null' was a possible expected type, add it into the list.
		if ($match['ornull']) {
			$expected[] = 'null';
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
