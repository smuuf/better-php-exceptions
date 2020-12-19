# Better PHP Exceptions

## What is it about?

This small project aims to provide **improved user/developer experience** for PHP developers working with native PHP exceptions _(thrown by the PHP interpreter itself in various situations)_.

_Better PHP Exceptions_ can be created from native exceptions via **unified interface**:

```php
use \Smuuf\BetterExceptions\BetterException;

try {
	...
} catch (\Throwable $ex) {
	$better = BetterException::from($ex);
	...
}

```

As an example scenario, both `PHP 7.*` and `PHP 8.0` throw `TypeError` exceptions in three distinct scenarios:

> There are three scenarios where a TypeError may be thrown. The first is where the argument type being passed to a function does not match its corresponding declared parameter type. The second is where a value being returned from a function does not match the declared function return type. The third is where an invalid number of arguments are passed to a built-in PHP function (strict mode only).

~ https://www.php.net/manual/en/class.typeerror.php

Sadly, PHP or the `TypeError` itself does _not_ provide any additional information about the types expected, types passed/returned, or at which position the passed wrong type was present during invocation.

_Was it an argument type error? A return type error? What was it...!?_

**This information is present only in the exception message and it takes an extra parsing effort to get it.** Not to mention the fact that the format of these messages changed from `PHP 7` to `PHP 8` and thus need different parsing rules...

**This is where _Better PHP Exceptions_ come in.**

## Example

```php
<?php

declare(strict_types=1);

include __DIR__ . '/vendor/autoload.php';

use \Smuuf\BetterExceptions\BetterException;

// Yes, it has a wrong return type.
function join_strings(string $a, ?string $b): ?int {
	return "{$a} - {$b}";
}

try {

	// Argument type error.
	join_strings('first', 123);

} catch (\TypeError $ex) {

	// Convert the generic TypeError to something more usable.
	$better = BetterException::from($ex);

	// Now we know that it was an argument type error.
	var_dump($better);
	// object(Smuuf\BetterExceptions\Types\ArgumentTypeError) ...

	// We know that 'string' or 'null' was expected.
	var_dump($better->getExpected());
	// array(2) {
	//   [0]=>
	//   string(6) "string"
	//   [1]=>
	//   string(4) "null"
	// }

	// We know that 'int' was actually passed.
	var_dump($better->getActual());
	// string(3) "int"

	// And it was the second argument that was wrong.
	var_dump($better->getArgumentIndex());
	// int(2)

}

try {

	// Return type error.
	join_strings('first', 'second');

} catch (\TypeError $ex) {

	// Convert the generic TypeError to something more usable.
	$better = BetterException::from($ex);

	// Now we know that it was a return type error.
	var_dump($better);
	// object(Smuuf\BetterExceptions\Types\ReturnTypeError) ...

	// We know that 'int' or 'null' was expected.
	var_dump($better->getExpected());
	// array(2) {
	//   [0]=>
	//   string(3) "int"
	//   [1]=>
	//   string(4) "null"
	// }

	// We know that 'string' was actually passed.
	var_dump($better->getActual());
	// string(6) "string"

}
```

## Which PHP versions?

Even though `PHP 8.0` was released near the end of 2020, PHP 7 is still used extensively and _Better PHP Exceptions_ aim to provide better **exceptions for both current major PHP versions** _(at least for now)_.


## Which native PHP exceptions can be made better?

Currently only a handful _(in fact only a single one, since I needed that for my other project: [`Primi language: A scripting language written in PHP`](https://github.com/smuuf/primi))_. But the **system is built to support easy addition** of more _better exceptions_.

### So... which ones?

- `\TypeError` can be converted into:
	- `\Smuuf\BetterExceptions\Types\ArgumentTypeError`
	- `\Smuuf\BetterExceptions\Types\ReturnTypeError`

