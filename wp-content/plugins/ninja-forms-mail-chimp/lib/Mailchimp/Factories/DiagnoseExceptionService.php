<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use NFMailchimp\EmailCRM\Mailchimp\Entities\ExceptionDiagnostics;
use NFMailchimp\EmailCRM\Mailchimp\Handlers\DiagnoseException;

interface DiagnoseExceptionService
{
	/**
	 * Create a Diagnose Exception handler
	 *
	 * @return DiagnoseException
	 */
	public function handler(): DiagnoseException;

	/**
	 * Create an Exception Diagnostics handler
	 *
	 * @return ExceptionDiagnostics
	 */
	public function entity(): ExceptionDiagnostics;
}
