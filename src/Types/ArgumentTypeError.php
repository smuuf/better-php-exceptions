<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Types;

class ArgumentTypeError extends BetterTypeError {

	/** @var int Argument index, if this error is of argument subtype. */
	protected int $argumentIndex;

	public function __construct(
		string $message,
		array $expected,
		string $actual,
		int $argumentIndex
	) {

		parent::__construct($message, $expected, $actual);
		$this->argumentIndex = $argumentIndex;

	}

	public function getArgumentIndex(): int {
		return $this->argumentIndex;
	}

}
