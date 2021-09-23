<?php


namespace NFMailchimp\EmailCRM\RestApi\Contracts;

use NFMailchimp\EmailCRM\RestApi\Request;

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
