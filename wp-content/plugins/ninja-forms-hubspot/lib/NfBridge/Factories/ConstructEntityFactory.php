<?php

namespace NFHubspot\EmailCRM\NfBridge\Factories;

use NFHubspot\EmailCRM\NfBridge\Actions\ConstructActionSetting;
use NFHubspot\EmailCRM\NfBridge\Actions\ConstructActionSettings;
use NFHubspot\EmailCRM\NfBridge\Contracts\ConstructEntityFactoryContract;

/**
 * Factory to provide actions that construct or configure entities
 *
 */
class ConstructEntityFactory implements ConstructEntityFactoryContract
{

	/**
	 *
	 * @return ConstructActionSetting
	 */
	public function constructActionSetting()
	{
		return new ConstructActionSetting();
	}

	/**
	 *
	 * @return ConstructActionSettings
	 */
	public function constructActionSettings()
	{
		return new ConstructActionSettings();
	}
}
