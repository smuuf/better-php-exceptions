<?php

declare(strict_types=1);

use \Tester\Assert;

use \Smuuf\BetterExceptions\Types\ReturnTypeError;

require __DIR__ . '/../../bootstrap.php';

require __DIR__ . '/data/bettertypeerror.classes.php';
require __DIR__ . '/data/returntypeerror.fns.php';

//
// Return type type errors to BetterTypeError.
//

//
//
//

$bex = get_better_exception('a_ret');
Assert::type(ReturnTypeError::class, $bex);
Assert::same(['string'], $bex->getExpected());
Assert::same(object_or_classname(Ns1\ClassA::class), $bex->getActual());

//
//
//

$bex = get_better_exception('b_ret');
Assert::type(ReturnTypeError::class, $bex);
Assert::same(['int', 'null'], $bex->getExpected());
Assert::same(object_or_classname(Ns1\ClassA::class), $bex->getActual());

//
//
//

$bex = get_better_exception('c_ret');
Assert::type(ReturnTypeError::class, $bex);
Assert::same(['string'], $bex->getExpected());
Assert::same('int', $bex->getActual());

//
//
//

$bex = get_better_exception('d_ret');
Assert::type(ReturnTypeError::class, $bex);
Assert::same(['int', 'null'], $bex->getExpected());
Assert::same('string', $bex->getActual());

//
//
//

$bex = get_better_exception('e_ret');
Assert::type(ReturnTypeError::class, $bex);
Assert::same([Ns2\ClassB::class], $bex->getExpected());
Assert::same('string', $bex->getActual());

//
//
//

$bex = get_better_exception('f_ret');
Assert::type(ReturnTypeError::class, $bex);
Assert::same([Ns2\ClassB::class], $bex->getExpected());
Assert::same(Ns1\ClassA::class, $bex->getActual());

//
//
//

$bex = get_better_exception('g_ret');
Assert::type(ReturnTypeError::class, $bex);
Assert::same([Ns2\ClassB::class, 'null'], $bex->getExpected());
Assert::same('string', $bex->getActual());

//
//
//

$bex = get_better_exception('h_ret');
Assert::type(ReturnTypeError::class, $bex);
Assert::same([Ns2\ClassB::class, 'null'], $bex->getExpected());
Assert::same(Ns1\ClassA::class, $bex->getActual());
