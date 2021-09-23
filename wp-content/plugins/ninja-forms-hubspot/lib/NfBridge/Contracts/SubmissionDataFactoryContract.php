<?php

namespace NFHubspot\EmailCRM\NfBridge\Contracts;

use NFHubspot\EmailCRM\Shared\Contracts\FormActionFieldCollection;
use NFHubspot\EmailCRM\Shared\Contracts\SubmissionDataContract;

interface SubmissionDataFactoryContract
{

	/**
	 * Creates submission data from a NF form submission
	 * @param array $formActionSubmissionArray
	 * @param FormActionFieldCollection $actionSettings
	 * @return SubmissionDataContract
	 */
	public function getSubmissionData(
		array $formActionSubmissionArray,
		FormActionFieldCollection $actionSettings
	): SubmissionDataContract;
}
