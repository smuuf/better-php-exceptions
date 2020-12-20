<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\Processors;

interface ProcessorInterface {

	/**
	 * Return a new, better instance of \Throwable from the original \Throwable.
	 */
	public static function process(\Throwable $ex): ?\Throwable;

}
