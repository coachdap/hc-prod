<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use NFMailchimp\EmailCRM\Mailchimp\Entities\ExceptionDiagnostics;
use NFMailchimp\EmailCRM\Shared\Entities\GlobalSettings;

/**
 * Returns configured entities
 */
class ConfigurationFactory
{

/**
	 * Root directory
	 * @var string
	 */
	protected $dir;
	
	public function __construct($dir)
	{
		$this->dir =$dir;
	}
	
	/**
	 * Get Mailchimp ExceptionDiagnostics
	 * @return ExceptionDiagnostics
	 */
	public function getExceptionDiagnostics(): ExceptionDiagnostics
	{
		
		$json = file_get_contents($this->dir. '/Config/ExceptionDiagnostics.json');
		$array = json_decode($json, true);
		return ExceptionDiagnostics::fromArray($array);
	}
	/**
	 * Get Mailchimp Global Settings
	 * @return GlobalSettings
	 */
	public function getGlobalSettings(): GlobalSettings
	{
		
		$json = file_get_contents($this->dir. '/Config/GlobalSettings.json');
		$array = json_decode($json, true);
		return GlobalSettings::fromArray($array);
	}
}
