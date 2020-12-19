<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\MetaInfos;

interface MetaInfoInterface {

	public function intoException(): \Throwable;

}
