<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Actions;

use Mailchimp\MailchimpLists;
use NFMailchimp\EmailCRM\Mailchimp\Actions\ListAction;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetMergeFields;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetInterestCategories;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetInterests;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetSegments;
use NFMailchimp\EmailCRM\Mailchimp\Entities\SingleList;
use NFMailchimp\EmailCRM\Mailchimp\Entities\AudienceDefinition;
use NFMailchimp\EmailCRM\Mailchimp\RequestsInterestCategories;

/**
 * Constructs Audience Definition with data retrieved through API
 *
 * @author stuar
 */
class GetAudienceDefinitionData extends ListAction
{

	use RequestsInterestCategories;

	/**
	 * List Id
	 * @var string
	 */
	protected $listId;


	/** @inheritDoc */
	public function __construct(MailchimpLists $api, SingleList $list)
	{
		parent::__construct($api, $list);
		$this->listId = $this->list->getId();
		$this->setAudienceDefinition(new AudienceDefinition());
	}

	/**
	 * Construct AudienceDefinition from retrieved data
	 * @return AudienceDefinition
	 */
	public function handle(): AudienceDefinition
	{
		$this->getAudienceDefinition()->addList($this->list);
		$this->getMergeFields();
		$this->getInterestCategories();
		$this->addAllInterestCategories();
		$this->getSegmentsViaRemoteApi();
		return $this->audienceDefinition;
	}

	/**
	 * Adds merge fields retrieved through API to Audience Def
	 */
	protected function getMergeFields()
	{
		$mergeFieldsAction = new GetMergeFields($this->api);
		$mergeFields = $mergeFieldsAction->requestMergeFields($this->list->getListId());
		$this->getAudienceDefinition()->addMergeFields($mergeFields);
	}

	/**
	 * Adds Tags retrieved through API to Audience Definition
	 */
	protected function getSegmentsViaRemoteApi()
	{
		$getSegmentsAction = new GetSegments($this->api);
		$segments = $getSegmentsAction->requestSegments($this->list->getListId());
		$this->getAudienceDefinition()->addTags($segments);
	}
}
