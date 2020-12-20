<?php

declare(strict_types=1);

use \Tester\Assert;

use \Smuuf\BetterExceptions\Types\UnknownNamedParameterError;

require __DIR__ . '/../../bootstrap.php';

//
// \Error to UnknownNamedParameterError.
//

function unknown_named_parameter_fn($foo, $bar) {
    return [$foo, $bar];
}

$bex = get_better_exception(
	'unknown_named_parameter_fn',
	...['foo' => 123, 'bar' => 234, 'baz' => 345, 'xyz' => 'yay']
);
Assert::type(UnknownNamedParameterError::class, $bex);
Assert::same('baz', $bex->getParameterName());
