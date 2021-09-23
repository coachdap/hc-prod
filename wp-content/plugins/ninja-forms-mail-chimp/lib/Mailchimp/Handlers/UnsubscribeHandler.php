<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Handlers;

use Mailchimp\http\MailchimpHttpClientInterface;
use NFMailchimp\EmailCRM\Mailchimp\Factories\MailchimpApiService;
use NFMailchimp\EmailCRM\Shared\Contracts\FormActionHandler;
use NFMailchimp\EmailCRM\Shared\Contracts\FormContract;
use NFMailchimp\EmailCRM\Shared\Contracts\SubmissionDataContract;

/**
 * Class UnsubscribeHandler
 *
 * Form action handler for unsurprising someone from Mailchimp
 */
class UnsubscribeHandler implements FormActionHandler
{
	/**
	 *
	 * @var MailchimpApiService
	 */
	protected $mailchimpApiFactory;

	/**
	 *
	 * @var MailchimpHttpClientInterface|null
	 */
	protected $httpClient;

	public function __construct(
		MailchimpApiService $mailchimpApi,
		MailchimpHttpClientInterface $client = null
	) {
		$this->mailchimpApiFactory = $mailchimpApi;
		$this->httpClient = $client;
	}

	/** @inheritDoc */
	public function handle(SubmissionDataContract $submissionData, FormContract $form) : array
	{
		$listId = $submissionData->getValue('listId');
		$apiKey = $submissionData->getValue('apiKey');
		$email = $submissionData->getValue('email_address');
		$mailchimpLists = $this->mailchimpApiFactory->listsApi($apiKey, $this->httpClient);
		try {
			$mailchimpLists->removeMember(
				$listId,
				$email
			);
			return [];
		} catch (\Exception $e) {
			return  [
				'type' => 'error',
				'note' => $e->getMessage()
			];
		}
	}
}
