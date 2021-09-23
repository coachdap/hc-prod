<?php


namespace NFMailchimp\EmailCRM\RestApi\Factories;

use NFMailchimp\EmailCRM\RestApi\Contracts\RequestContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\ResponseContract;
use NFMailchimp\EmailCRM\RestApi\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * This factory provides a bridge between the PSR-7 standard for HTTP messages that Guzzle uses, and our system.
 */
class Psr7
{
	/**
	 * Translate a PSR-7 request to our Response object
	 *
	 * @param ResponseInterface $response
	 * @return ResponseContract
	 */
	public function fromPsr7Response(ResponseInterface $response): ResponseContract
	{
		$_response = new Response();
		$headers = $response->getHeaders();
		if (!empty($headers)) {
			foreach ($headers as $key => $value) {
				if (is_array($value) && 1 === count($value)) {
					$_response->setHeader($key, $value[0]);
				} else {
					$_response->setHeader($key, $value);
				}
			}
		}
		$_response->setStatus($response->getStatusCode());
		$body = json_decode($response->getBody(), true);
		if (is_array($body)) {
			$_response->setData($body);
		}
		return $_response;
	}

	/**
	 * Translate our response to a PSR-7 response
	 *
	 * @param RequestContract $request
	 * @param string|null $uri
	 * @return \GuzzleHttp\Psr7\Request
	 */
	public function toPsr7Request(RequestContract $request, ?string $uri = null): \GuzzleHttp\Psr7\Request
	{
		return new \GuzzleHttp\Psr7\Request(
			$request->getHttpMethod(),
			$uri,
			$request->getHeaders(),
			json_encode($request->getParams())
		);
	}
}
