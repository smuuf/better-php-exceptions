<?php

declare(strict_types=1);

// Targeting argument type error.

function a_arg(int $argA) {
	return;
}

function b_arg(string $argA) {
	return;
}

function c_arg(array $argA) {
	return;
}

function d_arg($argA, int $argB) {
	return;
}

function e_arg($argA, string $argB, Ns1\ClassA $argC) {
	return;
}

function f_arg($argA, ?int $argB) {
	return;
}

function g_arg($argA, ?Ns1\ClassA $argD) {
	return;
}
