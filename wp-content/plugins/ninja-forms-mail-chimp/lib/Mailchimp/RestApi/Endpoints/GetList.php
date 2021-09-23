<?php


namespace NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints;

use NFMailchimp\EmailCRM\Mailchimp\RestApi\Responses\Response;
use NFMailchimp\EmailCRM\RestApi\Contracts\RequestContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\ResponseContract;

/**
 * Class GetList
 *
 * Endpoint to get one list from Mailchimp API
 */
class GetList extends Endpoint
{

	/** @inheritDoc */
	public function getHttpMethod(): string
	{
		return 'GET';
	}

	/** @inheritDoc */
	public function getArgs(): array
	{
		return [
			'listId' => [
				'type' => 'string',
				'required' => true,
			],
			'apiKey' => [
				'type' => 'string',
				'required' => true,
			]
		];
	}

	/** @inheritDoc */
	public function getUri(): string
	{
		return 'lists/' . $this->constructParameterUri('listId', 'alphanumeric');
	}

	/** @inheritDoc */
	public function handleRequest(RequestContract $request): ResponseContract
	{
		$listId = $request->getParam('listId');
		$client = $this->getListsClient($request->getParam('apiKey'));
		$action = new \NFMailchimp\EmailCRM\Mailchimp\Actions\GetList($client);
		try {
			$listEntity = $action->requestList($listId);
			return Response::fromEntity($listEntity);
		} catch (\Exception $exception) {
			$response = $this->constructExceptionResponse($exception, 'GetList');
			return $response;
		}
	}
}
