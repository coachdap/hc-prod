<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use NFMailchimp\EmailCRM\Mailchimp\Factories\ConstructSubscriberFactoryService;
use NFMailchimp\EmailCRM\Mailchimp\Actions\ConstructSubscriber;
use NFMailchimp\EmailCRM\Mailchimp\Entities\AudienceDefinition;

/**
 * Return a properly constructed ConstructSubscriber action
 */
class ConstructSubscriberFactory implements ConstructSubscriberFactoryService
{
	
	/** @inheritdoc */
	public function getConstructSubscriber(AudienceDefinition $audienceDefinition): ConstructSubscriber
	{
		
		return new ConstructSubscriber($audienceDefinition);
	}
}
