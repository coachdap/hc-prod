<?php


namespace NFHubspot\EmailCRM\RestApi\Contracts;

use NFHubspot\EmailCRM\RestApi\Request;

/**
 * Contract for classes that send HTTP requests
 */
interface HttpClientContract
{
	/**
	 * Send request
	 *
	 * @param Request $request
	 * @param string $uri
	 * @return ResponseContract
	 */
	public function send(Request $request, string  $uri) : ResponseContract;
}
