<?php


namespace NFMailchimp\EmailCRM\RestApi;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use NFMailchimp\EmailCRM\RestApi\Contracts\GuzzleClientContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\HttpClientContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\ResponseContract;
use NFMailchimp\EmailCRM\RestApi\Factories\Psr7;

/**
 * Guzzle-based HTTP client
 */
class HttpClient implements GuzzleClientContract, HttpClientContract
{

	/** @var Client */
	protected $guzzle;

	/** @var Psr7 */
	protected $factory;

	/**
	 * HttpClient constructor.
	 *
	 * @param Client $guzzle
	 * @param Psr7 $factory
	 */
	public function __construct(Client $guzzle, Psr7$factory)
	{
		$this->guzzle = $guzzle;
		$this->factory = $factory;
	}

	/**
	 * @inheritDoc
	 */
	public function send(Request $request, string $uri): ResponseContract
	{
		$request = $this->factory->toPsr7Request($request, $uri);
		$response = $this->guzzle->send($request, ['verify' => false]);
		return $this->factory->fromPsr7Response($response);
	}

	/**
	 * @inheritDoc
	 */
	public function getGuzzleClient(): ClientInterface
	{
		return $this->guzzle;
	}

	/**
	 * @inheritDoc
	 */
	public function setGuzzleClient(ClientInterface $client): GuzzleClientContract
	{
		$this->guzzle = $client;
		return $this;
	}
}
