<?php

declare(strict_types=1);

//
// These are separate to avoid syntax errors when using PHP 7.
//

// Targeting argument type error.

function h_arg($argA, int|float $argB) {
	return;
}

function i_arg($argA, int|float|null $argB) {
	return;
}

function j_arg($argA, ?string $argB) {
	return;
}

function k_arg($argA, null|false|Ns1\ClassA|string $argD) {
	return;
}
