<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\Processors;

use \Smuuf\BetterExceptions\Internals\Exceptions\ErrorException;

abstract class ProcessorFactory {

	private const PROCESSOR_CLASS_TEMPLATE =
		__NAMESPACE__ . "\\Php%s\\%sProcessor";

	private static function getSpecificProcessor(\Throwable $ex): string {

		// Get correct processor for current PHP version and the passed
		// exception.
		$exType = get_class($ex);
		$ver = PHP_MAJOR_VERSION;
		$class = sprintf(self::PROCESSOR_CLASS_TEMPLATE, $ver, $exType);

		if (!class_exists($class)) {
			throw new ErrorException(sprintf(
				"Cannot create better exception from '$exType'"
				. " for PHP %s"
				. " (processor '$class' is missing)",
				$ver
			));
		}

		return $class;

	}

	public static function getProcessorFor(\Throwable $ex): string {

		$processor = self::getSpecificProcessor($ex);
		if (!is_subclass_of($processor, ProcessorInterface::class, true)) {
			throw new ErrorException("Invalid processor class '$processor'");
		}

		return $processor;

	}

}
