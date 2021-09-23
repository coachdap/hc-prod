<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use NFMailchimp\EmailCRM\Mailchimp\Entities\ExceptionDiagnostics;
use NFMailchimp\EmailCRM\Mailchimp\Handlers\DiagnoseException;

/**
 * Class DiagnoseExceptionFactory
 *
 * Factory provides diagnostic information about exceptions we catch in API calls
 */
class DiagnoseExceptionFactory implements DiagnoseExceptionService
{
	/**
	 * @var array
	 */
	protected $config;

	/**
	 * DiagnoseExceptionFactory constructor.
	 * @param array $config
	 */
	public function __construct(array $config = [])
	{
		$this->config = !empty($config) ? $config : (array)json_decode(file_get_contents(
			dirname(__FILE__, 2) . '/Config/ExceptionDiagnostics.json'
		), true);
	}

	/**
	 * Create a Diagnose Exception handler
	 *
	 * @return DiagnoseException
	 */
	public function handler(): DiagnoseException
	{
		return new DiagnoseException(
			$this->entity()
		);
	}

	/**
	 * Create an Exception Diagnostics handler
	 *
	 * @return ExceptionDiagnostics
	 */
	public function entity(): ExceptionDiagnostics
	{
		return ExceptionDiagnostics::fromArray($this->config);
	}
}
