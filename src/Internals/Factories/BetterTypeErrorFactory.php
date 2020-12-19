<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\Factories;

use \Smuuf\BetterExceptions\Types\BetterTypeError;
use \Smuuf\BetterExceptions\Types\ReturnTypeError;
use \Smuuf\BetterExceptions\Types\ArgumentTypeError;
use \Smuuf\BetterExceptions\Internals\Exceptions\ErrorException;
use \Smuuf\BetterExceptions\Internals\MetaInfos\TypeErrorMetaInfo;

abstract class BetterTypeErrorFactory {

	public static function buildFromMetaInfo(
		TypeErrorMetaInfo $meta
	): BetterTypeError {

		$subtype = $meta->getSubtype();

		switch ($subtype) {
			case BetterTypeError::RETURN_TYPEERROR:
				return new ReturnTypeError(
					$meta->getMessage(),
					$meta->getExpected(),
					$meta->getActual()
				);
			case BetterTypeError::ARGUMENT_TYPEERROR:
				return new ArgumentTypeError(
					$meta->getMessage(),
					$meta->getExpected(),
					$meta->getActual(),
					$meta->getArgumentIndex()
				);
		}

		throw new ErrorException(
			"Unexpected TypeError meta info subtype '$subtype'"
		);

	}

}
