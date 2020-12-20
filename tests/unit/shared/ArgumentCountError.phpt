<?php

declare(strict_types=1);

use \Tester\Assert;

use \Smuuf\BetterExceptions\Types\ArgumentCountError;

require __DIR__ . '/../../bootstrap.php';

//
// \Error to UnknownNamedParameterError.
//

function argument_count_error_1($a) {
    return $a;
}

function argument_count_error_2($a, $b, $c) {
    return $a + $b + $c;
}

function argument_count_error_3($a, $b, $c = null, $d) {
    return $a + $b + $c + $d;
}

function argument_count_error_4($a, $b, $c, $d = null) {
    return $a + $b + $c + $d;
}

function argument_count_error_5($a, ...$b) {
    return $a + $b;
}

function argument_count_error_6($a, $b = null, ...$c) {
    return $a + $b + $c;
}

//
//
//

$bex = get_better_exception('argument_count_error_1');
Assert::type(ArgumentCountError::class, $bex);
Assert::same(1, $bex->getExpected());
Assert::same(0, $bex->getActual());

//
//
//

$bex = get_better_exception('argument_count_error_2');
Assert::type(ArgumentCountError::class, $bex);
Assert::same(3, $bex->getExpected());
Assert::same(0, $bex->getActual());

$bex = get_better_exception('argument_count_error_2', 1);
Assert::type(ArgumentCountError::class, $bex);
Assert::same(3, $bex->getExpected());
Assert::same(1, $bex->getActual());

$bex = get_better_exception('argument_count_error_2', 1, 2);
Assert::type(ArgumentCountError::class, $bex);
Assert::same(3, $bex->getExpected());
Assert::same(2, $bex->getActual());

//
//
//

$bex = get_better_exception('argument_count_error_3', );
Assert::type(ArgumentCountError::class, $bex);
Assert::same(4, $bex->getExpected());
Assert::same(0, $bex->getActual());

$bex = get_better_exception('argument_count_error_3', 1);
Assert::type(ArgumentCountError::class, $bex);
Assert::same(4, $bex->getExpected());
Assert::same(1, $bex->getActual());

$bex = get_better_exception('argument_count_error_3', 1, 2);
Assert::type(ArgumentCountError::class, $bex);
Assert::same(4, $bex->getExpected());
Assert::same(2, $bex->getActual());

$bex = get_better_exception('argument_count_error_3', 1, 2, 3);
Assert::type(ArgumentCountError::class, $bex);
Assert::same(4, $bex->getExpected());
Assert::same(3, $bex->getActual());

//
//
//

$bex = get_better_exception('argument_count_error_4', );
Assert::type(ArgumentCountError::class, $bex);
Assert::same(3, $bex->getExpected());
Assert::same(0, $bex->getActual());

$bex = get_better_exception('argument_count_error_4', 1);
Assert::type(ArgumentCountError::class, $bex);
Assert::same(3, $bex->getExpected());
Assert::same(1, $bex->getActual());

$bex = get_better_exception('argument_count_error_4', 1, 2);
Assert::type(ArgumentCountError::class, $bex);
Assert::same(3, $bex->getExpected());
Assert::same(2, $bex->getActual());

//
//
//

$bex = get_better_exception('argument_count_error_5');
Assert::type(ArgumentCountError::class, $bex);
Assert::same(1, $bex->getExpected());
Assert::same(0, $bex->getActual());

//
//
//

$bex = get_better_exception('argument_count_error_6');
Assert::type(ArgumentCountError::class, $bex);
Assert::same(1, $bex->getExpected());
Assert::same(0, $bex->getActual());
