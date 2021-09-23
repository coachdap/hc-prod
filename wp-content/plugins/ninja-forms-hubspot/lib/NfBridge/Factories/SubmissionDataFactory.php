<?php

namespace NFHubspot\EmailCRM\NfBridge\Factories;

use NFHubspot\EmailCRM\NfBridge\Contracts\SubmissionDataFactoryContract;
use NFHubspot\EmailCRM\Shared\Contracts\FormActionFieldCollection;
use NFHubspot\EmailCRM\Shared\Contracts\SubmissionDataContract;
use NFHubspot\EmailCRM\NfBridge\Entities\SubmissionData;

class SubmissionDataFactory implements SubmissionDataFactoryContract
{

	/** @inheritdoc */
	public function getSubmissionData(array $formActionSubmissionArray, FormActionFieldCollection $actionSettings): SubmissionDataContract
	{
		return new SubmissionData($formActionSubmissionArray, $actionSettings);
	}
}
