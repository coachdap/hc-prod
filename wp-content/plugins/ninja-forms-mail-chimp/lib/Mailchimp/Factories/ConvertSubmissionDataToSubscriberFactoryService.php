<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use NFMailchimp\EmailCRM\Mailchimp\Contracts\ConvertSubmissionDataToSubscriberContract;
use NFMailchimp\EmailCRM\Shared\Contracts\SubmissionDataContract;
use NFMailchimp\EmailCRM\Mailchimp\Actions\ConstructSubscriber;

/**
 * Construct an IterateSubscribeFormActoin
 *
 */
interface ConvertSubmissionDataToSubscriberFactoryService
{
	
	/**
	 * Return a properly construct IterateSubscribeFormAction object
	 * @param SubmissionDataContract $submissionData
	 * @param ConstructSubscriber $constructSubscriber
	 * @return ConvertSubmissionDataToSubscriberContract
	 */
	public function getConvertSubmissionDataToSubscriber(
		SubmissionDataContract $submissionData,
		ConstructSubscriber $constructSubscriber
	): ConvertSubmissionDataToSubscriberContract;
}
