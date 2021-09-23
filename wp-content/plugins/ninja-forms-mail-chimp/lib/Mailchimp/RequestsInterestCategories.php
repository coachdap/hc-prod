<?php


namespace NFMailchimp\EmailCRM\Mailchimp;

use NFMailchimp\EmailCRM\Mailchimp\Actions\GetInterestCategories;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetInterests;
use NFMailchimp\EmailCRM\Mailchimp\Entities\AudienceDefinition;

trait RequestsInterestCategories
{

	/**
	 * @var AudienceDefinition
	 */
	private $audienceDefinition;

	/**
	 * @return AudienceDefinition
	 */
	protected function getAudienceDefinition(): AudienceDefinition
	{
		return $this->audienceDefinition;
	}

	/**
	 * @param AudienceDefinition $audienceDefinition
	 * @return RequestsInterestCategories
	 */
	protected function setAudienceDefinition(AudienceDefinition $audienceDefinition)
	{
		$this->audienceDefinition = $audienceDefinition;
		return $this;
	}


	/**
	 * Adds interest categories retrieved through API to Audience Def
	 */
	protected function getInterestCategories()
	{
		$interestCategoriesAction = new GetInterestCategories($this->api);
		$interestCategories = $interestCategoriesAction->requestInterestCategories($this->listId);
		$this->audienceDefinition->addInterestCategories($interestCategories);
	}

	/**
	 * Iterate through interest categories and append interests from each category
	 */
	protected function addAllInterestCategories()
	{
		foreach ($this->audienceDefinition->interestCategories->getInterestCategories() as $interestCategory) {
			$interestCategoryId = $interestCategory->getId();
			$this->appendInterests($interestCategoryId);
		}
	}

	/**
	 * Add interests retrieved through API to Audience Definition
	 *
	 * @param $interestCategoryId
	 * @throws \Exception
	 */
	protected function appendInterests($interestCategoryId)
	{
		$interestsAction = new GetInterests($this->api, $this->list);
		$interests = $interestsAction->requestInterests($this->listId, $interestCategoryId);
		$this->getAudienceDefinition()->appendInterests($interests);
	}
}
