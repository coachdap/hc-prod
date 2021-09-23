<?php

namespace NFHubspot\EmailCRM\NfBridge\Factories;

use NFHubspot\EmailCRM\NfBridge\Contracts\FormProcessorsFactoryContract;
use NFHubspot\EmailCRM\Shared\Contracts\WPContract;
use NFHubspot\EmailCRM\Shared\Contracts\FormActionFieldCollection;
use NFHubspot\EmailCRM\Shared\Contracts\SubmissionDataContract;
use NFHubspot\EmailCRM\Shared\Contracts\FormContract;
use NFHubspot\EmailCRM\NfBridge\Actions\ConfigureApiSettings;
use NFHubspot\EmailCRM\NfBridge\Actions\GetApiSettingsValues;
use NFHubspot\EmailCRM\NfBridge\Entities\SubmissionData;
use NFHubspot\EmailCRM\NfBridge\Entities\ApiSettings;
use NFHubspot\EmailCRM\NfBridge\Entities\Form;
use NF_Abstracts_ModelFactory;
use NFHubspot\EmailCRM\WpBridge\Contracts\WpHooksContract;
use NFHubspot\EmailCRM\WpBridge\WpHooksApi;

/**
 * Provides classes for NF form processing
 */
class FormProcessorsFactory implements FormProcessorsFactoryContract
{

	/**
	 * WordPress hooks
	 *
	 * @var WpHooksContract
	 */
	protected $wpHooks;

	/**
	 *
	 * @param WpHooksApi $wpHooks
	 */
	public function __construct(WpHooksContract $wpHooks)
	{
		$this->wpHooks = $wpHooks;
	}

	/**
	 * @inheritdoc
	 */
	public function getWpHooks(): WpHooksContract
	{
		return $this->wpHooks;
	}

	/** @inheritDoc */
	public function getSubmissionData(
		array $formActionSubmissionArray,
		FormActionFieldCollection $actionSettings,
		ApiSettings $apiSettings
	): SubmissionDataContract {

		$getApiSettingsValues = $this->getGetApiSettingsValues($apiSettings);
		$keyValuePairs = $getApiSettingsValues->getApiSettingsValues();
		$combinedKeyValuePairs = array_merge($formActionSubmissionArray, $keyValuePairs);
		$submissionData = new SubmissionData($combinedKeyValuePairs, $actionSettings);

		return $submissionData;
	}

	/** @inheritDoc */
	public function getConfigureApiSettings(ApiSettings $apiSettings): ConfigureApiSettings
	{

		return new ConfigureApiSettings($apiSettings);
	}

	/** @inheritdoc */
	public function getForm(NF_Abstracts_ModelFactory $nfFormModelFactory): FormContract
	{
			$settings = $nfFormModelFactory->get_settings();
		   
			$array=[
				'name'=>$settings['title'],
				'id'=>$nfFormModelFactory->get_id()
			];
			
			return new Form($array);
	}


	/** @inheritdoc */
	public function getGetApiSettingsValues(ApiSettings $apiSettings): GetApiSettingsValues
	{

		return new GetApiSettingsValues($apiSettings);
	}
}
