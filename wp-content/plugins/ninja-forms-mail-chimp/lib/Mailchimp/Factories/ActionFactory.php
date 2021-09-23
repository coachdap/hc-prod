<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use Mailchimp\MailchimpLists;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetGroups;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetList;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetLists;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetMergeFields;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetInterestCategories;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetInterests;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetSegments;
use NFMailchimp\EmailCRM\Mailchimp\Actions\SubscribeToList;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsGroupsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsListFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsListsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetInterestCategoriesFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetInterestsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetSegmentsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsMergeFieldsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\SubscribesViaApi;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Account;
use NFMailchimp\EmailCRM\Mailchimp\Entities\SingleList;

/**
 * Factory for creating actions
 *
 */
class ActionFactory implements ActionFactoryService
{

	/**
	 * @var MailchimpApiService
	 */
	protected $mailchimpApi;

	/**
	 * @var Account
	 */
	protected $account;

	/**
	 * Mailchimp API client
	 *
	 * @var MailchimpLists
	 */
	private $client;

	/**
	 * ActionFactory constructor.
	 * @param MailchimpApiService $mailchimpApi
	 */
	public function __construct(MailchimpApiService $mailchimpApi)
	{
		$this->mailchimpApi = $mailchimpApi;
	}

	private function getClient(): MailchimpLists
	{
		if (!$this->client) {
			$this->client = $this->mailchimpApi->listsApi($this->account->getApiKey());
		}
		return $this->client;
	}

	/**
	 * Create action to get a list from API
	 *
	 * @return GetsListFromApi
	 */
	public function getListAction(): GetsListFromApi
	{
		return (new GetList($this->getClient(), $this->account) );
	}

	/**
	 * Create action to get a collection of lists from API
	 *
	 * @return GetsListsFromApi
	 */
	public function getListsAction(): GetsListsFromApi
	{
		return (new GetLists($this->getClient(), $this->account) );
	}

	/**
	 * Create action to get a collection of interest categories from API
	 *
	 * @return GetInterestCategoriesFromApi
	 */
	public function getInterestCategoriesAction(): GetInterestCategoriesFromApi
	{
		return (new GetInterestCategories($this->getClient(), $this->account) );
	}

		/**
		 * Return GetInterests action the gets a collection of interests from API
		 * @return GetInterestsFromApi
		 */
	public function getInterestsAction(): GetInterestsFromApi
	{
		   return ( new GetInterests($this->getClient()));
	}
	/**
	 * Create action to get a collection of segments from API
	 *
	 * @return GetSegmentsFromApi
	 */
	public function getSegmentsAction(): GetSegmentsFromApi
	{
		return (new GetSegments($this->getClient()) );
	}

	/**
	 * Create action to get merge fields from API
	 *
	 * @param SingleList $list
	 * @return GetsMergeFieldsFromApi
	 */
	public function getMergeFieldsAction(SingleList $list): GetsMergeFieldsFromApi
	{
		return (new GetMergeFields($this->getClient(), $list) );
	}


	/**
	 * @param SingleList $list
	 * @return GetsGroupsFromApi
	 */
	public function getGroupsAction(SingleList $list): GetsGroupsFromApi
	{
		return new GetGroups($this->getClient(), $list);
	}

	/**
	 * Get account property
	 *
	 * @return Account
	 */
	public function getAccount(): Account
	{
		return $this->account;
	}

	/**
	 * Set account property
	 *
	 * @param Account $account
	 * @return ActionFactory
	 */
	public function setAccount(Account $account): ActionFactory
	{
		$this->client = null;
		$this->account = $account;
		return $this;
	}
}
