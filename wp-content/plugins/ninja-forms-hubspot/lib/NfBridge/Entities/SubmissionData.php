<?php

namespace NFHubspot\EmailCRM\NfBridge\Entities;

use NFHubspot\EmailCRM\Shared\Contracts\SubmissionDataContract;
use NFHubspot\EmailCRM\NfBridge\Entities\ActionSettings;

/**
 * Represents one form's submission data
 */
class SubmissionData extends \NFHubspot\EmailCRM\Shared\Entities\SubmissionData implements SubmissionDataContract
{


	/**
	 * Return array of action setting keys
	 * @return array
	 */
	public function getSubmissionKeys()
	{
		/** @var ActionSettings $settings */
		$settings = $this->fields;

		$keys = array_keys($settings->getActionSettings());

		return $keys;
	}

	/**
	 * Return submission values matching field collection keys
	 * @return array
	 */
	public function getKeyedSubmissionData(): array
	{

		$keyedSubmissionData = [];

		$arrayKeys = $this->getSubmissionKeys();

		foreach ($arrayKeys as $key) {
			if ($this->hasValue($key)) {
				$keyedSubmissionData[$key] = $this->getValue($key);
			}
		}

		return $keyedSubmissionData;
	}

	// phpcs:enable
}
