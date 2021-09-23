<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Factories;

use NFMailchimp\EmailCRM\Mailchimp\Actions\ConstructSubscriber;
use NFMailchimp\EmailCRM\Mailchimp\Entities\AudienceDefinition;

/**
 * Return a properly constructed ConstructSubscriber action
 */
interface ConstructSubscriberFactoryService
{
	
	/**
	 * Return new ConstructSubscriber object
	 * @param AudienceDefinition $audienceDefinition
	 * @return ConstructSubscriber
	 */
	public function getConstructSubscriber(AudienceDefinition $audienceDefinition): ConstructSubscriber;
}
