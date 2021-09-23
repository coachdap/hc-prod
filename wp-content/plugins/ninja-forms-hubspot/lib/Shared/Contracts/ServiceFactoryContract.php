<?php


namespace NFHubspot\EmailCRM\Shared\Contracts;

use NFHubspot\EmailCRM\Shared\Containers\ServiceFactoryContainer;

/**
 * Factory that can be provided by ServiceFactoryContainer
 */
interface ServiceFactoryContract
{

	/**
	 * Handle a request for this factory
	 *
	 * @param array $args Arguments for factory
	 * @param ServiceFactoryContainer $container Container that contains this factory
	 * @return mixed
	 */
	public function handle(array $args = [], ServiceFactoryContainer $container);
}
