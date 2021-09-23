<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Actions;

use Mailchimp\MailchimpLists;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsListFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Account;
use NFMailchimp\EmailCRM\Mailchimp\Entities\SingleList;

/**
 * Gets a list from remote API
 */
class GetList implements GetsListFromApi
{

	/**
	 * @var MailchimpLists
	 */
	protected $client;

	/**
	 * GetList constructor.
	 * @param MailchimpLists $client
	 * @param Account $account
	 */
	public function __construct(MailchimpLists $client)
	{
		$this->client = $client;
	}

	/**
	 * Request list details from remote API
	 *
	 * @param string $listId
	 * @return SingleList
	 * @throws \Exception
	 */
	public function requestList(string $listId) : SingleList
	{
		try {
			$r = $this->client->getList($listId);
			return SingleList::fromArray((array)$r);
		} catch (\Exception $e) {
			throw $e;
		}
	}
}
