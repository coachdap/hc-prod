<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use Mailchimp\http\MailchimpHttpClientInterface;
use Mailchimp\MailchimpLists;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Account;

/**
 * Factory for generating instances of Mailchimp API clients
 */
class MailchimpApi implements MailchimpApiService
{

	/**
	 * @var MailchimpHttpClientInterface
	 */
	protected $client;

	/**
	 * Get API client for lists API
	 *
	 * @param string $apiKey
	 * @param MailchimpHttpClientInterface|null $httpClient
	 * @return MailchimpLists
	 */
	public function listsApi(string $apiKey, ?MailchimpHttpClientInterface $httpClient = null): MailchimpLists
	{
		if (!$httpClient) {
			if ($this->client) {
				return new MailchimpLists($apiKey, 'user', [], $this->client);
			}
			return new MailchimpLists($apiKey);
		}
		return new MailchimpLists($apiKey, 'user', [], $httpClient);
	}

	/**
	 * Get API client for lists, by account
	 *
	 * @param Account $account
	 * @return MailchimpLists
	 */
	public function listsApiFromAccount(Account $account): MailchimpLists
	{
		return $this->listsApi($account->getApiKey());
	}

	/**
	 * @param MailchimpHttpClientInterface|null $httpClient
	 * @return MailchimpApiService
	 */
	public function setDefaultClient(MailchimpHttpClientInterface $httpClient = null): MailchimpApiService
	{
		$this->client = $httpClient;
		return  $this;
	}
}
