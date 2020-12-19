<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\Factories;

use \Smuuf\BetterExceptions\Internals\MetaInfos\MetaInfoInterface;
use \Smuuf\BetterExceptions\Internals\Exceptions\ErrorException;

abstract class MetaInfoFactory {

	private const METAINFO_FACTORY_CLASS_TEMPLATE =
		__NAMESPACE__ . "\\Versions\\Php%s\\%sMetaInfoFactory";

	private static function getSpecificMetaInfoFactory(\Throwable $ex): string {

		// Get correct meta factory for current PHP version and the passed exception class.
		$exType = get_class($ex);
		$ver = PHP_MAJOR_VERSION;
		$class = sprintf(self::METAINFO_FACTORY_CLASS_TEMPLATE, $ver, $exType);

		if (!class_exists($class)) {
			throw new ErrorException(sprintf(
				"PHP version %d not supported for '$exType'"
				. " (meta factory '$class' is missing)",
				$ver
			));
		}

		return $class;

	}

	public static function buildFromException(
		\Throwable $ex
	): MetaInfoInterface {

		$specificFactory = self::getSpecificMetaInfoFactory($ex);
		return $specificFactory::buildFromException($ex);

	}

}
