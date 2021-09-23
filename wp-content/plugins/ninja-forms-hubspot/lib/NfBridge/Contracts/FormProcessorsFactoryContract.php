<?php

namespace NFHubspot\EmailCRM\NfBridge\Contracts;

use NFHubspot\EmailCRM\Shared\Contracts\FormActionFieldCollection;
use NFHubspot\EmailCRM\Shared\Contracts\SubmissionDataContract;
use NFHubspot\EmailCRM\Shared\Contracts\FormContract;
use NFHubspot\EmailCRM\NfBridge\Actions\ConfigureApiSettings;
use NFHubspot\EmailCRM\NfBridge\Actions\getApiSettingsValues;
use NFHubspot\EmailCRM\NfBridge\Entities\ApiSettings;
use NFHubspot\EmailCRM\WpBridge\Contracts\WpHooksContract;
use NF_Abstracts_ModelFactory;

/**
 * Contract for a NF Form Processors Contract
 */
interface FormProcessorsFactoryContract
{

	/**
	 * Return a WPContract object
	 *
	 * Provide access to Wordpress methods or mocked version
	 * @return WPContract
	 */
	public function getWpHooks(): WpHooksContract;

	/**
	 * Create submission data from a NF form submission
		 *
		 * @param array $formActionSubmissionArray
		 * @param FormActionFieldCollection $actionSettings
		 * @param ApiSettings $apiSettings
		 * @return SubmissionDataContract
		 */
	public function getSubmissionData(
		array $formActionSubmissionArray,
		FormActionFieldCollection $actionSettings,
		ApiSettings $apiSettings
	): SubmissionDataContract;

	/**
	 * Construct NF settings configuration from ApiSettings
	 * @param ApiSettings $apiSettings
	 */
	public function getConfigureApiSettings(ApiSettings $apiSettings): ConfigureApiSettings;

	/**
	 * Return a form contract from a given NF form model factory
	 * @param NF_Abstracts_ModelFactory $nfFormModelFactory
	 * @return FormContract
	 */
	public function getForm(NF_Abstracts_ModelFactory $nfFormModelFactory): FormContract;


	/**
	 *
	 * @param ApiSettings $apiSettings
	 * @return getApiSettingsValues
	 */
	public function getGetApiSettingsValues(ApiSettings $apiSettings): getApiSettingsValues;
}
