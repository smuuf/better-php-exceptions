<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions;

use \Smuuf\BetterExceptions\Internals\Factories\MetaInfoFactory;

/**
 * Unified interface for creating better exceptions from existing PHP extension
 * objects.
 */
abstract class BetterException {

	public static function from(\Throwable $ex): \Throwable {
		return MetaInfoFactory::buildFromException($ex)->intoException();
	}

}
