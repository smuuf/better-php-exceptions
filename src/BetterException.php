<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions;

use \Smuuf\BetterExceptions\Internals\Exceptions\ErrorException;
use \Smuuf\BetterExceptions\Internals\Processors\ProcessorFactory;

/**
 * Unified interface for creating better exceptions from existing PHP exception
 * objects.
 */
abstract class BetterException {

	public static function from(\Throwable $ex): \Throwable {

		$processor = ProcessorFactory::getProcessorFor($ex);
		$better = $processor::process($ex);

		if (!$better) {
			throw new ErrorException(
				"Processor '$processor' was unable to create better exception"
				. " from '$ex'"
			);
		}

		return $better;

	}

}
