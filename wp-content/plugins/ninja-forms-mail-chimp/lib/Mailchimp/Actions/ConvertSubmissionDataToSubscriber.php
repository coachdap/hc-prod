<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Actions;

// Contracts
use NFMailchimp\EmailCRM\Mailchimp\Contracts\ConvertSubmissionDataToSubscriberContract;
use NFMailchimp\EmailCRM\Shared\Contracts\SubmissionDataContract;
// Actions
use NFMailchimp\EmailCRM\Mailchimp\Actions\ConstructSubscriber;
// Entities
use NFMailchimp\EmailCRM\Mailchimp\Entities\AudienceDefinition;
use NFMailchimp\EmailCRM\Mailchimp\Entities\MergeVar;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Segments;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Subscriber;

/**
 * Iterates through SubmissionData and AudienceDefinition to Construct Subscriber
 *
 */
class ConvertSubmissionDataToSubscriber implements ConvertSubmissionDataToSubscriberContract
{

	/**
	 *
	 * @var SubmissionDataContract
	 */
	protected $submissionData;

	/**
	 *
	 * @var ConstructSubscriber
	 */
	public $constructSubscriber;

	/**
	 *
	 * @var AudienceDefinition
	 */
	protected $audienceDefinition;

	public function __construct(
		SubmissionDataContract $submissionData,
		ConstructSubscriber $constructSubscriber
	) {
		$this->submissionData = $submissionData;
		$this->constructSubscriber = $constructSubscriber;
		$this->audienceDefinition = $this->constructSubscriber->getAudienceDefinition();

		$this->extractSubmissionData();
	}

	/**
	 * Extract SubmissionData to construct Subscriber
	 */
	protected function extractSubmissionData()
	{
		$this->addEmailAddress();
		$this->addStatus();
		$this->addMergeFields();
		$this->addInterests();
		$this->addTags();
	}

	/**
	 * Add email address
	 *
	 * Email address key is known from Standard Subscriber Field entity
	 */
	protected function addEmailAddress()
	{

		$emailAddress = $this->submissionData->getValue('email_address', '');
		$this->constructSubscriber->setEmailAddress($emailAddress);
	}

	/**
	 * Add status
	 *
	 * Required field; default value `subscribed` if not set
	 */
	protected function addStatus()
	{
		$status = $this->submissionData->getValue('status', 'subscribed');

		$this->constructSubscriber->setStatus($status);
	}

	/**
	 * Add MergeFields in Audience Definition, add any values from Submission Data
	 */
	protected function addMergeFields()
	{
		/** @var MergeVar $mergeField */
		$mergeFields = $this->audienceDefinition->mergeFields->getMergeVars();

		foreach ($mergeFields as $mergeField) {
			$mergeVarTag = $mergeField->getTag();

			$value = $this->submissionData->getValue($mergeVarTag, null);

			if (!is_null($value)) {
				$this->constructSubscriber->setMergeField($mergeVarTag, $value);
			}
		}
	}

	/**
	 * Iterate values in SubmissionData interests, add if allowed in AudienceDefinition
	 */
	protected function addInterests()
	{
		// get array keys of interest in the audience definition
		$allowedInterests = array_keys($this->audienceDefinition->interests->getInterests());
		// get all values in comma-delineated string, removing empty values and whitespace
		$values = array_map('trim', array_filter(explode(',', $this->submissionData->getValue('interests', []))));
		foreach ($values as $value) {
			if (in_array($value, $allowedInterests)) {
				$this->constructSubscriber->addInterest($value);
			}
		}
	}

	/**
	 * Iterate values in SubmissionData tags, add if allowed in AudienceDefinition
	 */
	protected function addTags()
	{
		/** @var Segments $tagSegments */
		// get array keys of interest in the audience definition
		$tagSegments = ($this->audienceDefinition->tags->getTags());
		// get all values in comma-delineated string, removing empty values and whitespace
		$values = array_map('trim', array_filter(explode(',', $this->submissionData->getValue('tags', ''))));

		if (! empty($values)) {
			foreach ($values as $value) {
				if ($tagSegments->hasSegment($value)) {
					$this->constructSubscriber->addTag($value);
				}
			}
		}
	}

	/**
	 * Get constructed subscriber
	 * @return Subscriber
	 */
	public function getSubscriber(): Subscriber
	{
		return $this->constructSubscriber->getSubscriber();
	}

	/** @inheritdoc */
	public function getRequestBody(): array
	{

		return $this->constructSubscriber->getRequestBody();
	}

	/** @inheritdoc */
	public function getEmailAddress(): string
	{
		return $this->constructSubscriber->getEmailAddress();
	}
}
