<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use NFMailchimp\EmailCRM\Mailchimp\Factories\ConvertSubmissionDataToSubscriberFactoryService;
use NFMailchimp\EmailCRM\Shared\Contracts\SubmissionDataContract;
use NFMailchimp\EmailCRM\Mailchimp\Actions\ConstructSubscriber;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\ConvertSubmissionDataToSubscriberContract;
use NFMailchimp\EmailCRM\Mailchimp\Actions\ConvertSubmissionDataToSubscriber;

/**
 * Construct an IterateSubscribeFormActoin
 *
 */
class ConvertSubmissionDataToSubscriberFactory implements ConvertSubmissionDataToSubscriberFactoryService
{
	
	/**
	 * Return a properly construct IterateSubscribeFormAction object
	 * @param SubmissionDataContract $submissionData
	 * @param ConstructSubscriber $constructSubscriber
	 * @return IterateSubscribeFormActionContract
	 */
	public function getConvertSubmissionDataToSubscriber(
		SubmissionDataContract $submissionData,
		ConstructSubscriber $constructSubscriber
	): ConvertSubmissionDataToSubscriberContract {
		
		return new ConvertSubmissionDataToSubscriber($submissionData, $constructSubscriber);
	}
}
