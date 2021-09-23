<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Actions;

use Mailchimp\MailchimpLists;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetSegmentsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Actions\ListAction;
use NFMailchimp\EmailCRM\Mailchimp\Entities\SingleList;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Segments;

/**
 * Gets a collection of interest categories from remote API
 */
class GetSegments implements GetSegmentsFromApi
{

	/** @var MailchimpLists */
	protected $api;

	/**
	 *
	 * @param MailchimpLists $api
	 */
	public function __construct(MailchimpLists $api)
	{
		$this->api = $api;
	}

	/**
	 * @param string $listId
	 * @return Segments
	 * @throws \Exception
	 */
	public function requestSegments(string $listId): Segments
	{
		try {
			$r = $this->api->getSegments($listId, ['count' => 500]);
			$segments = Segments::fromArray((array)$r->segments);
			$segments->setListId($listId);
			return $segments;
		} catch (\Exception $e) {
			throw $e;
		}
	}
}
