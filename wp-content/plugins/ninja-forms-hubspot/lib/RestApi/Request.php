<?php


namespace NFHubspot\EmailCRM\RestApi;

use NFHubspot\EmailCRM\RestApi\Contracts\RequestContract;
use NFHubspot\EmailCRM\RestApi\Traits\ProvidesHttpHeaders;
use NFHubspot\EmailCRM\RestApi\Traits\ProvidesHttpMethod;
use NFHubspot\EmailCRM\RestApi\Traits\ProvidesRestParams;

class Request implements RequestContract
{

	use
		//get and set headers
		ProvidesHttpHeaders,
		//Http method getter/setter
		ProvidesHttpMethod,
		//Get and set params (query vars or body arguments)
		ProvidesRestParams;

	/**
	 * @param array $items
	 *
	 * @return RequestContract
	 */
	public static function fromArray(array $items = ['headers' => [], 'params' => [] ])
	{
		$obj = new static();
		if (! empty($items['headers'])) {
			foreach ($items['headers'] as $header => $value) {
				$obj->setHeader($header, $value);
			}
		}

		if (! empty($items['params'])) {
			$obj->setParams($items['params']);
		}
		return $obj;
	}
}
