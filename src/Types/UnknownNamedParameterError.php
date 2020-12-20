<?php

declare(strict_types=1);

namespace Smuuf\BetterExceptions\Types;

use \Smuuf\BetterExceptions\Types\Base\BetterError;

class UnknownNamedParameterError extends BetterError {

	/** @var string Name of the passed unknown parameter. */
	protected string $parameterName;

	public function __construct(
		string $message,
		string $parameterName
	) {

		parent::__construct($message);
		$this->parameterName = $parameterName;

	}

	public function getParameterName(): string {
		return $this->parameterName;
	}

}
