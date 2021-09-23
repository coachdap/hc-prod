<?php


namespace NFHubspot\EmailCRM\RestApi;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use NFHubspot\EmailCRM\RestApi\Contracts\GuzzleClientContract;
use NFHubspot\EmailCRM\RestApi\Contracts\HttpClientContract;
use NFHubspot\EmailCRM\RestApi\Contracts\ResponseContract;
use NFHubspot\EmailCRM\RestApi\Factories\Psr7;

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
