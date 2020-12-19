<?php

declare(strict_types=1);

//
// These are separate to avoid syntax errors when using PHP 7.
//

// Targeting return type error.

function a_ret(): string {
	return new Ns1\ClassA;
}

function b_ret(): int|null {
	return new Ns1\ClassA;
}

function c_ret(): string {
	return 456;
}

function d_ret(): null|int {
	return 'nope string';
}

function e_ret(): Ns2\ClassB {
	return '';
}

function f_ret(): Ns2\ClassB {
	return new Ns1\ClassA;
}

function g_ret(): null|Ns2\ClassB {
	return '';
}

function h_ret(): Ns2\ClassB|null|int {
	return new Ns1\ClassA;
}
