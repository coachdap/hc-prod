<?php


namespace NFHubspot\EmailCRM\Shared\Contracts;

use NFHubspot\EmailCRM\CfBridge\Entities\Form;
use NFHubspot\EmailCRM\CfBridge\Entities\ProcessorData;
use NFHubspot\EmailCRM\CfBridge\Processor;
use NFHubspot\EmailCRM\Shared\Contracts\SubmissionDataContract as SubmissionData;

/**
 * Interface FormActionHandler
 *
 * A callback function for Ninja Forms action or Caldera Forms processor
 */
interface FormActionHandler
{

	/**
	 * Process the data
	 *
	 * @param SubmissionData $submissionData
	 * @param FormContract $form
	 * @return mixed
	 */
	public function handle(SubmissionData $submissionData, FormContract $form) :array;
}
