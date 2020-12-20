<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\Processors\Php8;

use \Smuuf\BetterExceptions\Internals\RegexMatcher;
use \Smuuf\BetterExceptions\Internals\Processors\ProcessorInterface;
use \Smuuf\BetterExceptions\Types\UnknownNamedParameterError;

abstract class ErrorProcessor implements ProcessorInterface {

	protected const UNKNOWN_NAMED_PARAMETER_ERROR_REGEX =
		'#Unknown named parameter \$(?<name>[a-zA-z0-9-_]+)#';

	public static function process(\Throwable $ex): ?\Throwable {

		$msg = $ex->getMessage();

		// Is this \Error is about an unknown named parameter?
		if ($match = RegexMatcher::match(self::UNKNOWN_NAMED_PARAMETER_ERROR_REGEX, $msg)) {
			return new UnknownNamedParameterError($msg, $match['name']);
		}

		return null;

	}

}
