<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsGroupsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsListFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsListsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsMergeFieldsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetInterestCategoriesFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetInterestsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\SubscribesViaApi;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Account;
use NFMailchimp\EmailCRM\Mailchimp\Entities\SingleList;

interface ActionFactoryService
{

	/**
	 * Create action to get lists from API
	 *
	 * @return GetsListFromApi
	 */
	public function getListAction(): GetsListFromApi;

		/**
	 * Create action to get lists from API
	 *
	 * @return GetsListsFromApi
	 */
	public function getListsAction(): GetsListsFromApi;

	/**
	 * Create action to get merge fields from API
	 *
	 * @param SingleList $list
	 * @return GetsMergeFieldsFromApi
	 */
	public function getMergeFieldsAction(SingleList $list): GetsMergeFieldsFromApi;

			/**
	 * Create action to get a collection of interest categories from API
	 *
	 * @return GetInterestCategoriesFromApi
	 */
	public function getInterestCategoriesAction(): GetInterestCategoriesFromApi;

				/**
		 * Return GetInterests action the gets a collection of interests from API
		 * @return GetInterestsFromApi
		 */
	public function getInterestsAction(): GetInterestsFromApi;
	/**
	 * Create action to get interest groups via API
	 *
	 * @param SingleList $list
	 * @return GetsGroupsFromApi
	 */
	public function getGroupsAction(SingleList $list) : GetsGroupsFromApi;

	/**
	 * Get account property
	 *
	 * @return Account
	 */
	public function getAccount(): Account;

	/**
	 * Set account property
	 *
	 * @param Account $account
	 * @return ActionFactory
	 */
	public function setAccount(Account $account): ActionFactory;
}
