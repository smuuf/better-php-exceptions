<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals;

abstract class RegexMatcher {

	/** @var bool If true debugging info is printed to STDOUT. */
	public static bool $debug = false;

	/**
	 * Matches regex and returns the match array. If the regex didn't match,
	 * returns null.
	 *
	 * @return array<int|string>|null Array of matches or null if not matched.
	 */
	public static function match(string $rx, string $subject): ?array {

		if (self::$debug) {
			echo "- Matching string:\n\t$subject";
		}

		if (preg_match($rx, $subject, $match)) {

			if (self::$debug) {
				echo "\n  OK\n";
			}

			return $match;

		}

		if (self::$debug) {
			echo "\n  FAIL\n";
		}

		return null;

	}

	/**
	 * Matches regexes given as a list and returns match array for the first
	 * regex that matched. If no regex matched, returns null.
	 *
	 * @param array<string> $rxs List of regexes to try.
	 * @return array<int|string>|null Array of matches or null if not matched.
	 */
	public static function matchEither(array $rxs, string $subject): ?array {

		foreach ($rxs as $rx) {
			if ($match = self::match($rx, $subject)) {
				return $match;
			}
		}

		return null;

	}

}
