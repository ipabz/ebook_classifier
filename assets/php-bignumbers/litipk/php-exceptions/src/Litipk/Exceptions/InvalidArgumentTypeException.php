<?php

namespace Litipk\Exceptions;

/**
 * @author  Andreu Correa Casablanca <castarco@litipk.com>
 */
final class InvalidArgumentTypeException extends \InvalidArgumentException
{
	/**
	 * List of expected types
	 * @var array<string>
	 */
	private $expected_types;

	/**
	 * Given type
	 * @var string
	 */
	private $given_type;

	/**
	 * @param array     $expected_types The list of expected types for the problematic argument
	 * @param string    $given_type     The typpe of the problematic argument
	 * @param string    $message        See Exception definition
	 * @param integer   $code           See Exception definition
	 * @param Exception $previous       See Exception definition
	 */
	public function __construct (array $expected_types, $given_type, $message = "", $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);

		if ($expected_types === null || empty($expected_types) || $given_type === null || !is_string($given_type)) {
			throw new \LogicException("InvalidArgumentTypeException requires valid \$expected_types and \$given_type parameters.");
		}

		if (in_array($given_type, $expected_types)) {
			throw new \LogicException("It's a nonsense to raise an InvalidArgumentTypeException when \$given_type is in \$expected_types.");
		}

		$this->expected_types = $expected_types;
		$this->given_type = $given_type;
	}

	/**
	 * Returns the list of expected types
	 * 
	 * @return array<string>
	 */
	public function getExpectedTypes ()
	{
		return $this->expected_types;
	}

	/**
	 * Returns the given type
	 * 
	 * @return string
	 */
	public function getGivenType ()
	{
		return $this->given_type;
	}
}
