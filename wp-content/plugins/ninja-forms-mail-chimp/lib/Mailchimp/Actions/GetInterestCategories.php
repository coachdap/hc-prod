<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Actions;

use Mailchimp\MailchimpLists;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetInterestCategoriesFromApi;

use NFMailchimp\EmailCRM\Mailchimp\Entities\InterestCategories;

/**
 * Gets a collection of interest categories from remote API
 */
class GetInterestCategories implements GetInterestCategoriesFromApi
{

	/** @var MailchimpLists */
	protected $api;

	/**
	 * Construct GetInterestCategories action
	 * @param MailchimpLists $api
	 */
	public function __construct(MailchimpLists $api)
	{
		$this->api = $api;
	}

	/** @inheritDoc */
	public function requestInterestCategories(string $listId): InterestCategories
	{
		try {
			$r = $this->api->getInterestCategories($listId, ['count' => 500]);
			$interestCategories = InterestCategories::fromArray((array) $r->categories);

			$interestCategories->setListId($listId);

			return $interestCategories;
		} catch (\Exception $e) {
			throw $e;
		}
	}
}
