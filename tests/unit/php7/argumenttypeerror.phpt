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

$bex = get_better_exception('strlen', []);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['string'], $bex->getExpected());
Assert::same('array', $bex->getActual());
Assert::same(1, $bex->getArgumentIndex());

$bex = get_better_exception('strlen', new Ns2\ClassB);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['string'], $bex->getExpected());
Assert::same(object_or_classname(Ns2\ClassB::class), $bex->getActual());
Assert::same(1, $bex->getArgumentIndex());

$bex = get_better_exception('in_array', '', new Ns2\ClassB);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['array'], $bex->getExpected());
Assert::same(object_or_classname(Ns2\ClassB::class), $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('in_array', '', new Ns2\ClassB);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['array'], $bex->getExpected());
Assert::same(object_or_classname(Ns2\ClassB::class), $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

//
//
//

// Function a() - wrong argument type: string instead of int.
$bex = get_better_exception('a_arg', 'some string');
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int'], $bex->getExpected());
Assert::same('string', $bex->getActual());
Assert::same(1, $bex->getArgumentIndex());

// Function a() - wrong argument type: ClassA instance instead of int.
$bex = get_better_exception('a_arg', new Ns1\ClassA);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int'], $bex->getExpected());
Assert::same(object_or_classname(Ns1\ClassA::class), $bex->getActual());
Assert::same(1, $bex->getArgumentIndex());

//
//
//

// Function b() - wrong argument type: array instead of string.
$bex = get_better_exception('b_arg', ['yay array']);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['string'], $bex->getExpected());
Assert::same('array', $bex->getActual());
Assert::same(1, $bex->getArgumentIndex());

// Function b() - wrong argument type: ClassA instance instead of string.
$bex = get_better_exception('b_arg', new Ns1\ClassA);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['string'], $bex->getExpected());
Assert::same(object_or_classname(Ns1\ClassA::class), $bex->getActual());
Assert::same(1, $bex->getArgumentIndex());

//
//
//

// Function c() - wrong argument type: number instead of array.
$bex = get_better_exception('c_arg', 123456);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['array'], $bex->getExpected());
Assert::same('int', $bex->getActual());
Assert::same(1, $bex->getArgumentIndex());

// Function c() - wrong argument type: ClassA instance instead of array.
$bex = get_better_exception('c_arg', new Ns1\ClassA);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['array'], $bex->getExpected());
Assert::same(object_or_classname(Ns1\ClassA::class), $bex->getActual());
Assert::same(1, $bex->getArgumentIndex());

//
//
//

// Function d() - wrong argument type: number instead of array.
$bex = get_better_exception('d_arg', 123456, 'some string');
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int'], $bex->getExpected());
Assert::same('string', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

// Function d() - wrong argument type: ClassA instance instead of array.
$bex = get_better_exception('d_arg', 'whatever', new Ns1\ClassA);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int'], $bex->getExpected());
Assert::same(object_or_classname(Ns1\ClassA::class), $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

//
//
//

$bex = get_better_exception(
	'e_arg',
	123, // Whatever.
	456, // Should be string.
	789.01 // Should be object.
);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['string'], $bex->getExpected());
Assert::same('int', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception(
	'e_arg',
	123, // Whatever.
	'correct string', // Should be string.
	789.01 // Should be object.
);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same([Ns1\ClassA::class], $bex->getExpected());
Assert::same('float', $bex->getActual());
Assert::same(3, $bex->getArgumentIndex());

$bex = get_better_exception(
	'e_arg',
	123, // Whatever.
	[], // Should be string.
	new Ns1\ClassA // Should be object.
);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['string'], $bex->getExpected());
Assert::same('array', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception(
	'e_arg',
	123, // Whatever.
	'yay string', // Should be string.
	new Ns2\ClassB // Should be object.
);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same([Ns1\ClassA::class], $bex->getExpected());
Assert::same(Ns2\ClassB::class, $bex->getActual());
Assert::same(3, $bex->getArgumentIndex());

//
//
//

$bex = get_better_exception('f_arg', 123, []);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int', 'null'], $bex->getExpected());
Assert::same('array', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('f_arg', 123, 10.4);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int', 'null'], $bex->getExpected());
Assert::same('float', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('f_arg', 123, new Ns2\ClassB);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same(['int', 'null'], $bex->getExpected());
Assert::same(object_or_classname(Ns2\ClassB::class), $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

//
//
//

$bex = get_better_exception('g_arg', 123, []);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same([Ns1\ClassA::class, 'null'], $bex->getExpected());
Assert::same('array', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('g_arg', 123, 10.4);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same([Ns1\ClassA::class, 'null'], $bex->getExpected());
Assert::same('float', $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());

$bex = get_better_exception('g_arg', 123, new Ns2\ClassB);
Assert::type(ArgumentTypeError::class, $bex);
Assert::same([Ns1\ClassA::class, 'null'], $bex->getExpected());
Assert::same(Ns2\ClassB::class, $bex->getActual());
Assert::same(2, $bex->getArgumentIndex());
