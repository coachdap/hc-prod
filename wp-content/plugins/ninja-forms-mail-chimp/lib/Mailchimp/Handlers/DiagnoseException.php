<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Handlers;

// Mailchimp
use NFMailchimp\EmailCRM\Mailchimp\Entities\ExceptionDiagnostic;
use NFMailchimp\EmailCRM\Mailchimp\Entities\ExceptionDiagnostics;

/**
 * Provides diagnostics for a given exception in context
 *
 */
class DiagnoseException
{

	/**
	 * Exception Diagnostics
	 * @var ExceptionDiagnostics
	 */
	protected $exceptionDiagnostics;

	/**
	 *
	 * @param ExceptionDiagnostics $exceptionDiagnostics
	 */
	public function __construct(ExceptionDiagnostics $exceptionDiagnostics)
	{
		$this->exceptionDiagnostics = $exceptionDiagnostics;
	}

	/**
	 * Return diagnostic array from Exception string
	 * @param string $exceptionString
	 * @param string $context
	 * @return array
	 */
	public function handle(string $exceptionString, string $context = ''): array
	{
		/** @var ExceptionDiagnostic $exceptionDiagnostic */
		$diagnostics = [];
		foreach ($this->exceptionDiagnostics->getExceptionDiagnostics() as $exceptionDiagnostic) {
			$matchString = stripos($exceptionString, $exceptionDiagnostic->getExceptionStringMatch());

			if (is_int($matchString)) {
				$diagnostic = $exceptionDiagnostic->getDiagnosticCollection();

				if ('default' === $exceptionDiagnostic->getContext() && empty($diagnostics)) {
					// add default diagnostic only if context match has not been found
					$diagnostics = $diagnostic;
				} elseif ($context === $exceptionDiagnostic->getContext()) {
					// add matched context diagnostic, overriding default if present
					$diagnostics = $diagnostic;
				}
			}
		}
		
		return $diagnostics;
	}
}
