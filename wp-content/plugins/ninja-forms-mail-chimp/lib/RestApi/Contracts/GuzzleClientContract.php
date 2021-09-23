<?php


namespace NFMailchimp\EmailCRM\RestApi\Contracts;

use GuzzleHttp\ClientInterface as Client;

/**
 * Contract for classes that wrap Guzzle HTTP clients
 */
interface GuzzleClientContract
{

	/**
	 * @return GuzzleClientContract
	 */
	public function getGuzzleClient() : Client;

	/**
	 * @param Client $client
	 * @return GuzzleClientContract
	 */
	public function setGuzzleClient(Client $client): GuzzleClientContract;
}
