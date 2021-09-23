<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Actions;

use Mailchimp\MailchimpLists;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsMergeFieldsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Entities\MergeVars;
use NFMailchimp\EmailCRM\Mailchimp\Entities\SingleList;

/**
 * Get Merge vars for a list
 */
class GetMergeFields implements GetsMergeFieldsFromApi
{

	/** @var MailchimpLists */
	protected $api;
	/** @var SingleList */
	protected $list;

	/**
	 * GetMergeFields constructor.
	 * @param MailchimpLists $api
	 */
	public function __construct(MailchimpLists $api)
	{
		$this->api = $api;
	}

	/**
	 * Request merge vars from remote API
	 *
	 * @param string $listId
	 * @return MergeVars
	 * @throws \Exception
	 */
	public function requestMergeFields(string $listId): MergeVars
	{
		try {
			$r = $this->api->getMergeFields($listId, ['count' => 500]);
			$mergeVars = MergeVars::fromArray((array)$r->merge_fields);

			return $mergeVars;
		} catch (\Exception $e) {
			throw $e;
		}
	}
}
