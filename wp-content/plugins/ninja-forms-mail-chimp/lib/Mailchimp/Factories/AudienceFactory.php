<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use NFMailchimp\EmailCRM\Mailchimp\Actions\GetAudienceDefinitionData;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\MailchimpContract as Mailchimp;
use NFMailchimp\EmailCRM\Mailchimp\Entities\AudienceDefinition;
use NFMailchimp\EmailCRM\Mailchimp\Entities\SingleList;

class AudienceFactory implements AudienceService
{

	/** @var Mailchimp  */
	protected $module;
	public function __construct(Mailchimp $module)
	{
		$this->module = $module;
	}

	/**
	 * @return Mailchimp
	 */
	public function getModule(): Mailchimp
	{
		return  $this->module;
	}

	/** @inheritDoc */
	public function fromListId(string $listId, string $apiKey) : AudienceDefinition
	{
		/** @var MailchimpApiService $apiFactory */
		$apiFactory = $this
			->getModule()
			->make(MailchimpApiService::class);

		return (new GetAudienceDefinitionData(
			$apiFactory->listsApi($apiKey),
			(new SingleList())->setId($listId)
		))->handle();
	}
}
