<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Actions;

use Mailchimp\MailchimpLists;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetInterestsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Interests;

/**
 * Gets a collection of interests from remote API
 */
class GetInterests implements GetInterestsFromApi
{

	/** @var MailchimpLists */
	protected $api;

	/**
	 * List Id
	 * @var string
	 */
	protected $listId;

	/**
	 * Construct GetInterests action
	 * @param MailchimpLists $api API client library
	 */
	public function __construct(MailchimpLists $api)
	{
		$this->api = $api;
	}

	/** @inheritdoc */
	public function requestInterests(string $listId, string $interestCategoryId): Interests
	{
		try {
			$r = $this->api->getInterests($listId, $interestCategoryId, ['count' => 500]);
			$interests = Interests::fromArray((array) $r->interests);
			$interests->setListId($listId);
			return $interests;
		} catch (\Exception $e) {
			throw $e;
		}
	}
}
