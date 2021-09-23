<?php


namespace NFHubspot\EmailCRM\WpBridge\Database;

use NFHubspot\EmailCRM\WpBridge\Contracts\WpOptionsApiContract;

class WPOptionsApi implements WpOptionsApiContract
{
	/**
	 * @inheritDoc
	 */
	public function updateOption(string $key, $data): void
	{
		update_option($key, $data);
	}

	/**
	 * @inheritDoc
	 */
	public function getOption(string $key)
	{
		return get_option($key);
	}
}
