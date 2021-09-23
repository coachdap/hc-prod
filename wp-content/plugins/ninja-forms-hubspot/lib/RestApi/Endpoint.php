<?php


namespace NFHubspot\EmailCRM\RestApi;

use NFHubspot\EmailCRM\RestApi\Contracts\EndpointContract;
use NFHubspot\EmailCRM\RestApi\Contracts\Request;
use NFHubspot\EmailCRM\RestApi\Contracts\RequestContract;
use NFHubspot\EmailCRM\RestApi\Contracts\ResponseContract;
use NFHubspot\EmailCRM\RestApi\Contracts\TokenContract;
use NFHubspot\EmailCRM\RestApi\Traits\ProvidesHttpMethod;

abstract class Endpoint implements EndpointContract
{
	use ProvidesHttpMethod;

	/**
	 * @var string
	 */
	protected $uri;

	/**
	 * @var array
	 */
	protected $args;

	/**
	 * @inheritDoc
	 */
	public function getUri(): string
	{
		return  $this->uri;
	}

	/**
	 * @inheritDoc
	 */
	public function setUri(string $uri): EndpointContract
	{
		$this->uri = $uri;
		return  $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getArgs(): array
	{
		return  $this->args;
	}

	/**
	 * @inheritDoc
	 */
	public function setArgs(array $args): EndpointContract
	{
		$this->args = $args;
		return  $this;
	}


	/**
	 * @inheritDoc
	 */
	public function getToken(RequestContract $request): string
	{
		$header = $request->getHeader('Authorization');
		if ($header && 0 === strpos($header, 'Bearer')) {
			return trim(substr($header, 7));
		}
		return  $header ? $header : '';
	}
}
