<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Actions;

use Mailchimp\MailchimpLists;
use NFMailchimp\EmailCRM\Mailchimp\Entities\SingleList;

abstract class ListAction
{

	/** @var MailchimpLists */
	protected $api;
	/** @var SingleList */
	protected $list;

	/**
	 * GetMergeFields constructor.
	 * @param MailchimpLists $api
	 * @param SingleList $list
	 */
	public function __construct(MailchimpLists $api, SingleList $list)
	{
		$this->api = $api;
		$this->list = $list;
	}
}
