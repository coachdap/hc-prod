<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Actions;

use Mailchimp\MailchimpLists;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsListsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Account;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Lists;

/**
 * Gets a collection of lists from remote API
 */
class GetLists implements GetsListsFromApi
{

	/**
	 * @var MailchimpLists
	 */
	protected $client;

	/**
	 * @var Account
	 */
	protected $account;

	/**
	 * GetLists constructor.
	 * @param MailchimpLists $client
	 * @param Account $account
	 */
	public function __construct(MailchimpLists $client, Account $account)
	{
		$this->client = $client;
		$this->account = $account;
	}

	/**
	 * Request collection of lists from remote API
	 *
		 * If exception is returned, return empty Lists
		 *
	 * @return Lists
	 * @throws \Exception
	 */
	public function requestLists(): Lists
	{
		try {
			$r = $this->client->getLists(['count' => 500 ]);
			return Lists::fromArray((array) $r->lists);
		} catch (\Exception $e) {
					return new Lists();
		}
	}
}
