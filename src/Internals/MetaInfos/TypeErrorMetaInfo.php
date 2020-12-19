<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Internals\MetaInfos;

use \Smuuf\BetterExceptions\Internals\Factories\BetterTypeErrorFactory;

class TypeErrorMetaInfo implements MetaInfoInterface {

	/** @var int TypeError subtype. */
	protected int $subtype;

	/** @var string Exception message. */
	protected string $message;

	/** @var array<string> List of expected types. */
	protected array $expected;

	/** @var string Actual type passed or returned. */
	protected string $actual;

	/** @var int|null Argument index, if this error is of argument subtype. */
	protected ?int $argumentIndex;

	/**
	 * @param array<string> $expected List of expected types.
	 */
	public function __construct(
		string $message,
		int $subtype,
		array $expected,
		string $actual,
		?int $argumentIndex = null
	) {

		$this->message = $message;
		$this->subtype = $subtype;
		$this->expected = $expected;
		$this->actual = $actual;
		$this->argumentIndex = $argumentIndex;

	}

	public function getMessage(): string {
		return $this->message;
	}

	public function getSubtype(): int {
		return $this->subtype;
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

	public function getArgumentIndex(): int {
		return $this->argumentIndex;
	}

	public function intoException(): \Throwable {
		return BetterTypeErrorFactory::buildFromMetaInfo($this);
	}

}
