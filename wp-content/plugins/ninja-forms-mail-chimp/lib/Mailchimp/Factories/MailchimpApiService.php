<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use Mailchimp\http\MailchimpHttpClientInterface;
use Mailchimp\MailchimpLists;

/**
 * Defines contract for Mailchimp API factories
 */
interface MailchimpApiService
{
	/**
	 * Get API client for lists API
	 *
	 * @param string $apiKey
	 * @param MailchimpHttpClientInterface|null $httpClient
	 * @return MailchimpLists
	 */
	public function listsApi(string  $apiKey, ?MailchimpHttpClientInterface $httpClient = null): MailchimpLists;


	/**
	 * @param MailchimpHttpClientInterface|null $httpClient
	 * @return MailchimpApiService
	 */
	public function setDefaultClient(MailchimpHttpClientInterface $httpClient = null):  MailchimpApiService;
}
