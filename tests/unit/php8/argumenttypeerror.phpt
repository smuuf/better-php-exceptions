<?php

declare(strict_types=1);

use \Tester\Assert;

use \Smuuf\BetterExceptions\Types\ArgumentTypeError;

require __DIR__ . '/../../bootstrap.php';

require __DIR__ . '/data/bettertypeerror.classes.php';
require __DIR__ . '/data/argumenttypeerror.fns.php';

//
// Argument type TypeErrors to BetterTypeError.
//

//
//
//

$bex = get_better_exception('h_arg', 123, []);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int', 'float'], $bex->getExpected());
Assert::same('array', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('h_arg', 123, 'yay string');
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int', 'float'], $bex->getExpected());
Assert::same('string', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('h_arg', 123, new Ns2\ClassB);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int', 'float'], $bex->getExpected());
Assert::same(Ns2\ClassB::class, $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

//
//
//

$bex = get_better_exception('i_arg', 123, 'yay string');
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int', 'float', 'null'], $bex->getExpected());
Assert::same('string', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('i_arg', 123, []);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int', 'float', 'null'], $bex->getExpected());
Assert::same('array', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('i_arg', 123, new Ns2\ClassB);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int', 'float', 'null'], $bex->getExpected());
Assert::same(Ns2\ClassB::class, $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

//
//
//

$bex = get_better_exception('j_arg', 123, 123.45);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['string', 'null'], $bex->getExpected());
Assert::same('float', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('j_arg', 123, []);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['string', 'null'], $bex->getExpected());
Assert::same('array', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('j_arg', 123, new Ns2\ClassB);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['string', 'null'], $bex->getExpected());
Assert::same(Ns2\ClassB::class, $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

//
//
//

$bex = get_better_exception('k_arg', 123, 456);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same([Ns1\ClassA::class, 'string', 'false', 'null'], $bex->getExpected());
Assert::same('int', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('k_arg', 123, []);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same([Ns1\ClassA::class, 'string', 'false', 'null'], $bex->getExpected());
Assert::same('array', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('k_arg', 123, new Ns2\ClassB);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same([Ns1\ClassA::class, 'string', 'false', 'null'], $bex->getExpected());
Assert::same(Ns2\ClassB::class, $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());
