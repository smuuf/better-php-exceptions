<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\Factories\Versions\Php7;

use \Smuuf\BetterExceptions\Types\BetterTypeError;
use \Smuuf\BetterExceptions\Internals\RegexMatcher;
use \Smuuf\BetterExceptions\Internals\MetaInfos\TypeErrorMetaInfo;
use \Smuuf\BetterExceptions\Internals\Exceptions\ErrorException;

abstract class TypeErrorMetaInfoFactory {

	private const RETURN_TYPEERROR_REGEX = <<<RX
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

	private const ARGUMENT_TYPEERROR_REGEXES = [
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

	public static function buildFromException(
		\TypeError $ex
	): TypeErrorMetaInfo {

		$msg = $ex->getMessage();

		// Try if this TypeError is about a type of passed argument.
		if ($match = RegexMatcher::matchEither(self::ARGUMENT_TYPEERROR_REGEXES, $msg)) {
			return self::buildForSubtype(BetterTypeError::ARGUMENT_TYPEERROR, $msg, $match);
		}

		// Try if this TypeError is about a type of returned value.
		if ($match = RegexMatcher::match(self::RETURN_TYPEERROR_REGEX, $msg)) {
			return self::buildForSubtype(BetterTypeError::RETURN_TYPEERROR, $msg, $match);
		}

		throw new ErrorException("Unable to parse meta info from '$msg'");

	}

	/**
	 * @param array<int|string> $match Array of matches from `preg_match()`.
	 */
	private static function buildForSubtype(
		int $subtype,
		string $msg,
		array $match
	): TypeErrorMetaInfo {

		// BetterTypeError expects list of expected types..
		$expected = [$match['expected']];

		// Also if a 'null' was a possible expected type, add it into the list.
		if ($match['ornull']) {
			$expected[] = 'null';
		}

		$actual = $match['actual'];

		// Only argument type TypeErrors have information about the argument's
		// index.
		if (isset($match['index'])) {
			$index = (int) $match['index'];
		} else {
			$index = null;
		}

		return new TypeErrorMetaInfo($msg, $subtype, $expected, $actual, $index);

	}

}
