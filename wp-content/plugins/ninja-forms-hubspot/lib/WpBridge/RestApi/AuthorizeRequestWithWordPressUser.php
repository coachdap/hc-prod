<?php


namespace NFHubspot\EmailCRM\WpBridge\RestApi;

use NFHubspot\EmailCRM\RestApi\Contracts\AuthorizeRequestContract;
use NFHubspot\EmailCRM\RestApi\Contracts\RequestContract;

/**
 * Class AuthorizeRequestWithWordPressUser
 *
 * WordPress capability-based authorization check for routes
 */
class AuthorizeRequestWithWordPressUser implements AuthorizeRequestContract
{
	/**
	 * @var string
	 */
	protected $capability;

	/**
	 * AuthorizeRestRequest constructor.
	 * @param string $capability
	 */
	public function __construct(string $capability)
	{
		$this->capability = $capability;
	}

	/**
	 * @param RequestContract $request
	 * @return bool
	 */
	public function authorizeRequest(RequestContract $request): bool
	{
		return current_user_can($this->capability);
	}
}
