<?php


namespace NFMailchimp\EmailCRM\RestApi;

use NFMailchimp\EmailCRM\RestApi\Contracts\EndpointContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\HttpContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\RequestContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\ResponseContract;
use NFMailchimp\EmailCRM\Shared\Contracts\ArrayStore;

class CachedEndpoint implements EndpointContract
{

	/**
	 * Parameter that indicates if cache should be bypass or not
	 */
	const BYPASS_PARAM = 'bypassCache';

	/**
	 * @var ArrayStore
	 */
	protected $cache;

	/**
	 * @var EndpointContract
	 */
	protected $proxyEndpoint;


	/**
	 * CachedEndpoint constructor.
	 * @param EndpointContract $proxyEndpoint Endpoint to use for cache misses
	 * @param ArrayStore $cache Key/value cache store
	 */
	public function __construct(EndpointContract $proxyEndpoint, ArrayStore $cache)
	{
		$this->proxyEndpoint = $proxyEndpoint;
		$this->cache = $cache;
	}


	/**
	 * Handles request from cache or passes to proxy endpoint
	 *
	 * @param RequestContract $request
	 * @return ResponseContract
	 */
	public function handleRequest(RequestContract $request): ResponseContract
	{
		//Get cache key and check if cached
		$cacheKey = $this->cacheKey($request);

		$cachedData = $this->cache->getData();
		if (! $request->getParam(self::BYPASS_PARAM) && array_key_exists($cacheKey, $cachedData)) {
			return Response::fromArray($cachedData[$cacheKey]);
		}
		$response = $this->proxyEndpoint->handleRequest($request);
		if (2 === (int)substr($response->getStatus(), 0, 1) || 3 === (int)substr($response->getStatus(), 0, 1)) {
			$cachedData[$cacheKey] = [
				'data' => $response->getData(),
				'headers' => $response->getHeaders(),
				'status' => $response->getStatus(),
				'method' => $this->getHttpMethod()
			];
			$this->cache->saveData($cachedData);
		}
		return $response;
	}

	/**
	 * Determine cache key
	 *
	 * @param RequestContract $request
	 * @return string
	 */
	protected function cacheKey(RequestContract $request)
	{
		$keys = !empty($request->getParams()) ? array_keys($request->getParams()) : [];
		$cacheKey = $this->getHttpMethod();
		foreach ($keys as $key) {
			if (self::BYPASS_PARAM === $key) {
				//Allow for requests made when bypassing cache to be cached
				continue;
			}
			if ($request->getParam($key)) {
				$cacheKey .= $key. '-'.$request->getParam($key);
			}
		}
		return $cacheKey;
	}

	/** @inheritDoc */
	public function authorizeRequest(RequestContract $request): bool
	{
		return $this->proxyEndpoint->authorizeRequest($request);
	}

	/** @inheritDoc */
	public function getUri(): string
	{
		return $this->proxyEndpoint->getUri();
	}

	/**
	 * @inheritDoc
	 */
	public function getArgs(): array
	{
		return array_merge($this->proxyEndpoint->getArgs(), [
			self::BYPASS_PARAM => [
				'type' => 'boolean',
				'default' => false
			]
		]);
	}

	/**
	 * @inheritDoc
	 */
	public function getHttpMethod(): string
	{
		return $this->proxyEndpoint->getHttpMethod();
	}

	/**
	 * @inheritDoc
	 */
	public function setUri(string $uri): EndpointContract
	{
		return $this->proxyEndpoint->setUri($uri);
	}

	/**
	 * @inheritDoc
	 */
	public function setArgs(array $args): EndpointContract
	{
		return $this->proxyEndpoint->setArgs($args);
	}

	/**
	 * @inheritDoc
	 */
	public function setHttpMethod(string $httpMethod): HttpContract
	{
		return $this->proxyEndpoint->setHttpMethod($httpMethod);
	}

	/**
	 * @inheritDoc
	 */
	public function getToken(RequestContract $request): string
	{
		return $this->proxyEndpoint->getToken($request);
	}
}
