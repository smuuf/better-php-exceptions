<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Types;

abstract class BetterTypeError extends \TypeError {

	public const ARGUMENT_TYPEERROR = 1;
	public const RETURN_TYPEERROR = 2;

	/** @var string Exception message. */
	protected $message;

	/** @var array<string> List of expected types. */
	protected array $expected;

	/** @var string List of actual types. */
	protected string $actual;

	/**
	 * @param array<string> $expected List of expected types.
	 */
	public function __construct(
		string $message,
		array $expected,
		string $actual
	) {

		parent::__construct($message);
		$this->expected = $expected;
		$this->actual = $actual;

	}

	/**
	 * @return array<string> List of expected types.
	 */
	public function getExpected(): array {
		return $this->expected;
	}

	public function getActual(): string {
		return $this->actual;
	}

}
