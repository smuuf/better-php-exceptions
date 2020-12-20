<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\Processors\Base;

use \Smuuf\BetterExceptions\Types\ArgumentCountError;
use \Smuuf\BetterExceptions\Internals\RegexMatcher;
use \Smuuf\BetterExceptions\Internals\Processors\ProcessorInterface;

abstract class BaseArgumentCountErrorProcessor implements ProcessorInterface {

	protected const REGEX =
		'#(?<actual>\d+) passed.*(?<expected>\d+) expected#';

	public static function process(\Throwable $ex): ?\Throwable {

		$msg = $ex->getMessage();

		// Is this \Error is about an unknown named parameter?
		if ($match = RegexMatcher::match(self::REGEX, $msg)) {
			return new ArgumentCountError(
				$msg,
				(int) $match['expected'],
				(int) $match['actual']
			);
		}

		return null;

	}

}
