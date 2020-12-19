<?php

declare(strict_types=1);

// Targeting return type error.

function a_ret(): string {
	return new Ns1\ClassA;
}

function b_ret(): ?int {
	return new Ns1\ClassA;
}

function c_ret(): string {
	return 456;
}

function d_ret(): ?int {
	return 'nope string';
}

function e_ret(): Ns2\ClassB {
	return '';
}

function f_ret(): Ns2\ClassB {
	return new Ns1\ClassA;
}

function g_ret(): ?Ns2\ClassB {
	return '';
}

function h_ret(): ?Ns2\ClassB {
	return new Ns1\ClassA;
}
