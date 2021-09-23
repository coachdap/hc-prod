<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use NFMailchimp\EmailCRM\Mailchimp\Contracts\MailchimpContract as Mailchimp;
use NFMailchimp\EmailCRM\Mailchimp\Entities\AudienceDefinition;

interface AudienceService
{
	/**
	 * Get the main Mailchimp module used by this class.
	 *
	 * @return Mailchimp
	 */
	public function getModule(): Mailchimp;

	/**
	 * Get an audience definition, given a list Id
	 *
	 * @param string $listId
	 * @param string $apiKey
	 * @return AudienceDefinition
	 */
	public function fromListId(string $listId, string $apiKey): AudienceDefinition;
}
