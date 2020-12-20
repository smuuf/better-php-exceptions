<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Types;

class ArgumentCountError extends \ArgumentCountError {

	/** @var int Number of expected arguments. */
	protected int $expected;

	/** @var int Number of actually passed arguments. */
	protected int $actual;

	public function __construct(
		string $message,
		int $expected,
		int $actual
	) {

		parent::__construct($message);
		$this->expected = $expected;
		$this->actual = $actual;

	}

	public function getExpected(): int {
		return $this->expected;
	}

	public function getActual(): int {
		return $this->actual;
	}


}
